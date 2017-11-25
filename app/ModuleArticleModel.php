<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleArticleModel extends Model {
	protected $table="module_article";
	protected $fillable=["fullname","article_id","position","status","created_at","updated_at"];		
}