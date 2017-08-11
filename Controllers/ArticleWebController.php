<?php

namespace Module\Content\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Module\AdminBase\Facades\CategoryFacade;
use Module\AdminBase\Models\Category;
use Module\Content\Models\Article;

class ArticleWebController extends Controller
{
    public function _list($ids = null)
    {
//        $this->pageSize = 1;

        $categoryId = $ids;
        $data = null;
        if (is_null($categoryId)){
            $categoryId = CategoryFacade::getIds('article',true);
        }else{
            $categoryId = explode('-',$categoryId);
        }
        Session::flash('article_category_from',$categoryId);
        $allIds = [];
        foreach ($categoryId as $_id){
            $_categoryIds = CategoryFacade::getIdsById($_id,true);
            $allIds = array_merge($allIds,$_categoryIds);
        }
        $allIds = array_unique($allIds);
        $data = DB::table('article_categories')
            ->select('articles.*','members.username')
            ->leftJoin('articles', 'articles.id', '=', 'article_categories.article_id')
            ->leftJoin('members', 'articles.member_id', '=', 'members.id')
            ->orderBy('articles.order', 'asc')
            ->orderBy('articles.id', 'asc')
            ->where('articles.status','<>',Article::STATUS_HIDE)
            ->whereIn('article_categories.category_id',$allIds)
            ->whereNull('articles.deleted_at')
            ->whereNotNull('articles.id')
            ->distinct()
            ->paginate($this->pageSize,['articles.id']);

        $categories = Category::whereIn('id',$categoryId)->get();

        $pager = $data;
        $data = $data->toArray();
        $data = collect($data['data'])->map(function ($item){
            if (!is_array($item)) $item = (array)$item;
            $item['content'] = base64_decode($item['content']);
            $item['pic'] = asset($item['pic']);
            if (isset($item['member']) && is_array($item['member'])){
                $item['username'] =$item['member']['username'] ;
            }
            return $item;
        })->toArray();
        return $this->view('article.web.list',
            ['data'=>$data,'pager'=>$pager,'categories' => $categories ]
        );

    }

    public function detail($id)
    {
        $categories = null;
        if (Session::has('article_category_from')){
            $article_category_from = Session::get('article_category_from');
            if(is_array($article_category_from)){
                $categories = Category::whereIn('id',$article_category_from)->get();
            }else{
                $categories = [];
            }
        }
        $article = Article::where('id','=',$id)
            ->with('categories','member')->firstOrFail();
        $article->content = base64_decode($article->content);
        Article::where('id','=',$id)->increment('click_count');
        return $this->view('article.web.default',
            ['pager'=>$article,'categories' => $categories]);
    }
}
