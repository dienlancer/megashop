<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleItemModel extends Model {
	protected $table="module_item";
	protected $fillable=["fullname","item_id","position","component","status","created_at","updated_at"];		
}