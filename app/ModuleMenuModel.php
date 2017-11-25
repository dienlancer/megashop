<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleMenuModel extends Model {

	protected $table="module_menu";
	protected $fillable=["fullname","menu_type_id","position","created_at","status","updated_at"];		
}
