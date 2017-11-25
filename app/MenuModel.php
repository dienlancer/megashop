<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model {

	protected $table="menu";
	protected $fillable=["fullname","alias","parent_id","menu_type_id","level","sort_order","status","created_at","updated_at"];		
}
