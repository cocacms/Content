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
use Module\AdminBase\Models\Ad;
use Module\Content\Models\FriendlyLink;

class FriendlyLinkController extends Controller
{

    /**
     * 列表页面
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function index()
    {
        return $this->view('friendlyLink.index',
            ['category'=>\dictionary('friendlyLink')]
        );
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function _list(Request $request)
    {
        $tag = $request->input('category','default');
        $data = FriendlyLink::where('tag','=',$tag)
            ->orderBy('order', 'asc')
            ->orderBy('id', 'asc')
            ->paginate($this->pageSize)
            ->toArray();

        return response()->json(success_json($data));
    }

    /**
     * 添加页面
     * @param Request $request
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function add(Request $request)
    {
        $category = $request->input('category','default');
        return $this->view('friendlyLink.add',['category'=>$category]);
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
        $fl = FriendlyLink::findOrFail($id);
        return $this->view('friendlyLink.edit',['friendlyLink'=>$fl]);
    }


    /**
     * 删除数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function del(Request $request){
        $data = $request->input('ids',array());
        try{
            FriendlyLink::destroy(array_values($data));

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
        $data = $request->only('tag','name','link','show','order');
        $data['show'] = is_null($data['show']) ? 0 : $data['show'];
        $data = array_value_not_null($data);
        try{
            if(is_null($id)){
                FriendlyLink::create($data);
            }else{
                $ad = FriendlyLink::findOrFail($id);
                $ad->fill($data);
                $ad->save();
            }
        }catch (QueryException $e){
            return response()->json(error_json($e->getMessage()));
        }

        return response()->json(success_json());
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
        $fl = FriendlyLink::findOrFail($id);
        try{
            $fl->order = $order;
            $fl->save();
        }catch (QueryException $e){
            return response()->json(error_json($e->getMessage()));
        }
        return response()->json(success_json());
    }

    /**
     * 修改显示隐藏
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeShow(Request $request)
    {
        $id = $request->input('id');
        $show = $request->input('show');
        $fl = FriendlyLink::findOrFail($id);
        try{
            $fl->show = $show;
            $fl->save();
        }catch (QueryException $e){
            return response()->json(error_json($e->getMessage()));
        }
        return response()->json(success_json());
    }
}