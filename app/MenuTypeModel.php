<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuTypeModel extends Model {

	protected $table="menu_type";
	protected $fillable=["fullname","theme_location","status","sort_order","created_at","updated_at"];		
}
