<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryArticleModel extends Model {

	protected $table="category_article";
	protected $fillable=["fullname","alias","title","meta_keyword","meta_description","parent_id","image","sort_order","status","created_at","updated_at"];		
}
