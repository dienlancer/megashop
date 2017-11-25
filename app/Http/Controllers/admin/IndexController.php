<?php namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\CategoryArticleModel;
use DB;
class IndexController extends Controller {
	public function getForm(){	
		$filter_search="";
		$data=DB::select('call pro_getCategoryArticle(?)',array($filter_search));
		$parent_id=0;
		$categoryArticleRecursiveData=array();
		if(!empty($data))
			$parent_id=$data[0]->parent_id;		
		categoryArticleRecursive($data,$parent_id,"",$categoryArticleRecursiveData);		
		$category_article_data=categoryArticleConverter($categoryArticleRecursiveData);						
		return view("admin.index",compact("category_article_data"));	
	}	
}

