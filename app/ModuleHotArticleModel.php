<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleHotArticleModel extends Model {
	protected $table="module_hot_article";
	protected $fillable=["fullname","featured_article","related_article","position","created_at","status","updated_at"];		
}