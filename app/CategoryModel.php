<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model {

	protected $table="category";
	protected $fillable=["fullname","alias","image","status","parent_id","sort_order","created_at","updated_at"];		
}
