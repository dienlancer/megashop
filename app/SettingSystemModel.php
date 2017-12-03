<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingSystemModel extends Model {

	protected $table="setting_system";
	protected $fillable=["fullname",
						"alias",
						"setting",
						"sort_order",
						"status",
						"created_at",
						"updated_at"];		
}
