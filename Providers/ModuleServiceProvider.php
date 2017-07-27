<?php
namespace Module\Content\Providers;
use Illuminate\Support\ServiceProvider;
use Module\AdminBase\Facades\CategoryFacade;
use Module\Content\Models\ArticleCategory;


class ModuleServiceProvider extends ServiceProvider
{
    public function boot(){
        CategoryFacade::registerUpdatedHook('article',function ($category){

            $o = ArticleCategory::where('category_id','=',$category->id)
                ->update(['category_tag' => $category->tag]);
        });
    }

    public function register(){

    }

}