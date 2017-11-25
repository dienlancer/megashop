<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleModel extends Model {

	protected $table="article";
	protected $fillable=["fullname","title","alias","image","intro","content","page_url","description","meta_keyword","meta_description","sort_order","status","created_at","updated_at"];		
}
