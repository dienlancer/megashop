<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ModMenuTypeModel extends Model {

	protected $table="mod_menu_type";
	protected $fillable=["menu_id","module_id","module_type","created_at","status","updated_at"];		
}
