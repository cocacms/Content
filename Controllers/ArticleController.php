<?php

namespace Module\Content\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Module\AdminBase\Facades\CategoryFacade;
use Module\AdminBase\Models\Category;
use Module\Content\Models\Article;
use Module\Content\Models\ArticleCategory;

class ArticleController extends Controller
{
    protected $categoryRoot = 'article';
    /**
     * 列表页面
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function index()
    {
        $category = CategoryFacade::buildTree($this->categoryRoot,true);
        return $this->view('article.index',['category'=> $category ]);
    }

    /**
     * 获取列表数据
     * @return \Illuminate\Http\JsonResponse
     */
    public function _list(Request $request)
    {
        $categoryId = $request->input('category',null);
        $data = null;
        if (is_null($categoryId)){
            $data = Article::orderBy('order', 'asc')
                ->orderBy('id', 'asc')
                ->with('member')
                ->paginate($this->pageSize);
        }else{
            $data = DB::table('article_categories')
                ->select('articles.*','members.username')
                ->leftJoin('articles', 'articles.id', '=', 'article_categories.article_id')
                ->leftJoin('members', 'articles.member_id', '=', 'members.id')
                ->orderBy('articles.order', 'asc')
                ->orderBy('articles.id', 'asc')
                ->where('article_categories.category_id','=',$categoryId)
                ->whereNull('articles.deleted_at')
                ->paginate($this->pageSize);

        }
        $data = $data->toArray();
        $data['data'] = collect($data['data'])->map(function ($item){
            if (!is_array($item)) $item = (array)$item;
            $item['content'] = base64_decode($item['content']);
            $item['pic'] = asset($item['pic']);
            if (isset($item['member']) && is_array($item['member'])){
                $item['username'] =$item['member']['username'] ;
            }
            return $item;
        })->toArray();
        return response()->json(success_json($data));
    }

    /**
     * 添加页面
     * @param Request $request
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function add(Request $request)
    {
        $category = CategoryFacade::buildTree($this->categoryRoot,true);
        $category[0] = [
            'name' => '请选择添加分类 不选择则不进行分类直接存入根目录',
            'tname' => '不分类',
            'id' => null
        ];
        $currentCategory = $request->input('category','default');
        return $this->view('article.add',[
            'currentCategory'=>$currentCategory,
            'category'=> $category
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
        $article = Article::findOrFail($id);
        $article->content = base64_decode($article->content);
        $article->pic = $article->pic;

        $category = CategoryFacade::buildTree($this->categoryRoot,true);
        $category[0] = [
            'name' => '请选择添加分类 不选择则不进行分类直接存入根目录',
            'tname' => '不分类',
            'id' => null
        ];

        return $this->view('article.edit',[
            'article'=>$article,
            'category'=> $category

        ]);
    }


    /**
     * 删除数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function del(Request $request){
        $data = $request->input('ids',array());
        try{
            Article::destroy(array_values($data));
        }catch (\Exception $e){
            return response()->json(error_json($e->getMessage()));
        }
        return response()->json(success_json());
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
     * 数据修改提交
     * @param null $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function submit($id =  null, Request $request)
    {
        $data = $request->only('title','keyword','source','excerpt','content','recommended','order','status','push_time','pic','click_count','author');
        if (is_null($data['excerpt']) && !is_null($data['content'])){
            $data['excerpt'] = str_limit(strip_tags($data['content']),120);
        }
        $data['content'] = base64_encode($data['content']);
        $data['recommended'] = is_null($data['recommended']) ? 0 : $data['recommended'];

        $data = array_value_not_null($data);
        $data['member_id'] = Auth::user()->id;

        try{
            if(is_null($id)){
                $article = Article::create($data);
            }else{
                $article = Article::findOrFail($id);
                $article->fill($data);
                $article->save();
            }
            $this->saveCategory($article,$request);
        }catch (QueryException $e){
            return response()->json(error_json($e->getMessage()));
        }

        return response()->json(success_json());
    }

    private function saveCategory($article,$request)
    {
        $categories = $request->input('categories',[]);
        if (count($categories) > 0){
            $categories = Category::whereIn('id',$categories)->get();
        }else{
            $categories = Category::where('tag','=',$this->categoryRoot)->get();
        }

        $data = [];
        foreach ($categories as $category){
            $data[] = [
                'article_id'=>$article->id,
                'category_id'=>$category->id,
                'category_tag'=>$category->tag
            ];
        }

        DB::beginTransaction();
        try{
            ArticleCategory::where('article_id','=',$article->id)->delete();
            ArticleCategory::insert($data);
        }catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    /**
     * 修改顺序
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeOrder(Request $request)
    {
        $id = $request->input('id');
        $order = $request->input('order');
        $article = Article::findOrFail($id);
        try{
            $article->order = $order;
            $article->save();
        }catch (QueryException $e){
            return response()->json(error_json($e->getMessage()));
        }
        return response()->json(success_json());
    }

    /**
     * 修改状态
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        $article = Article::findOrFail($id);
        try{
            $article->status = $status;
            $article->save();
        }catch (QueryException $e){
            return response()->json(error_json($e->getMessage()));
        }
        return response()->json(success_json());
    }

    /**
     * 修改推荐
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeRecommend(Request $request)
    {
        $id = $request->input('id');
        $recommended = $request->input('recommended');
        $article = Article::findOrFail($id);
        try{
            $article->recommended = $recommended;
            $article->save();
        }catch (QueryException $e){
            return response()->json(error_json($e->getMessage()));
        }
        return response()->json(success_json());
    }
}
