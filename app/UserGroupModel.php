<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroupModel extends Model {

	protected $table="user_group";
	protected $fillable=["user_id","group_id","created_at","updated_at"];		
}
