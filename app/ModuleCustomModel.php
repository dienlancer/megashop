<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleCustomModel extends Model {

	protected $table="module_custom";
	protected $fillable=["fullname","content","standard_text","position","created_at","status","updated_at"];		
}
