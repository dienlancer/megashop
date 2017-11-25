<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleCategoryModel extends Model {

	protected $table="article_category";
	protected $fillable=["article_id","category_article_id","created_at","updated_at"];		
}
