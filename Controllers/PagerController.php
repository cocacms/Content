<?php
/**
 * Coca-Admin is a general modular web framework developed based on Laravel 5.4 .
 * Author:     Rojer
 * Mail:       rojerchen@qq.com
 * Git:        https://github.com/rojer95/CocaAdmin
 * QQ Group:   647229346
 */

namespace Module\Content\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use Module\AdminBase\Facades\CategoryFacade;
use Module\Content\Models\Pager;

class PagerController extends Controller
{
    public function __construct(Filesystem $file)
    {
        parent::__construct();
        $this->file = $file;
    }

    private $file;
    /**
     * 列表页面
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function index()
    {
        return $this->view('pager.index');
    }

    /**
     * 获取列表数据
     * @return \Illuminate\Http\JsonResponse
     */
    public function _list()
    {
        $data = Pager::paginate($this->pageSize)->toArray();
        $data['data'] = collect($data['data'])->map(function ($item){
            $item['content'] = str_limit(strip_tags(base64_decode($item['content'])),100);
            return $item;
        });

        return response()->json(success_json($data));
    }

    /**
     * 修改提交
     * @param null $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function submit($id =  null, Request $request)
    {
        if (is_null($id)){
            $pager = new Pager();
        }else{
            $pager = Pager::findOrFail($id);
        }
        $input = $request->only('name','tag','content','keyword','description','template','category_id');
        $input['additional'] = array_values($request->input('additional',[]));
        $content = [];
        foreach ($input['additional'] as $contentItem){
            if (!empty($contentItem['k'])){
                $content[$contentItem['k']] = $contentItem['v'];
            }
        }
        $input['additional'] = serialize($content);
        $pager->name = $input['name'];
        $pager->tag = $input['tag'];
        $pager->content = base64_encode($input['content']);
        $pager->additional = $input['additional'];
        $pager->keyword = $input['keyword'];
        $pager->description = $input['description'];
        $pager->template = $input['template'];
        $pager->category_id = $input['category_id'];

        try{
            if($pager->save()){
                return response()->json(success_json());
            }
        }catch (QueryException $exception){
            switch ($exception->getCode()){
                case '23000':
                    return response()->json(error_json('标识已经存在'));
                    break;
                default:
                    return response()->json(error_json($exception->getMessage()));
            }
        }
        return response()->json(error_json());
    }



    /**
     * 添加页面
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function add()
    {
        $templates = $this->getTemplateList();
        $category = CategoryFacade::buildTree();
        return $this->view('pager.add',[
            'templates'=>$templates,
            'category'=>$category
        ]);
    }

    /**
     * 添加数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAdd(Request $request)
    {
        return $this->submit(null,$request);
    }

    /**
     * 编辑页面
     * @param $id
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function edit($id)
    {
        $pager = Pager::findOrFail($id);
        $content = unserialize($pager->additional);
        $newContent = [];
        foreach ($content as $k => $v){
            $newContent[] = [
                'k'=>$k,
                'v'=>$v
            ];
        }
        $pager->additional = $newContent;
        $pager->content = $pager->content == null ? '' : base64_decode($pager->content);

        $templates = $this->getTemplateList();
        $category = CategoryFacade::buildTree();
        return $this->view('pager.edit',[
            'pager'=>$pager,
            'templates'=>$templates,
            'category'=>$category
        ]);
    }

    /**
     * 编辑数据
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEdit($id, Request $request)
    {
        return $this->submit($id,$request);
    }

    /**
     * 删除数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function del(Request $request){
        $data = $request->input('ids',array());
        try{
            Pager::destroy(array_values($data));

        }catch (\Exception $e){
            return response()->json(error_json($e->getMessage()));
        }
        return response()->json(success_json());
    }


    public function show($tag)
    {
        $pager = Pager::where('tag','=',$tag);
        $pager->template = $pager->template ? $pager->template : 'default';
        return $this->view('pager.template.'.$pager->template);
    }

    private function getTemplateList(){
        $data = [];
        $base_dir = module_path('Content','views'.DIRECTORY_SEPARATOR.'pager'.DIRECTORY_SEPARATOR.'template');
        $current_dir = opendir($base_dir);
        while(($file = readdir($current_dir)) !== false) {
            if ( $file != '.' && $file != '..')
            {
                $cur_path = $base_dir .DIRECTORY_SEPARATOR.$file;
                if ( ! is_dir ( $cur_path ))
                {
                    $data[] = str_replace('.blade.php','',$file) ;
                }
            }
        }
        closedir($current_dir);

        return $data;
    }

}