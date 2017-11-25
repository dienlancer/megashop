<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupPrivilegeModel extends Model {

	protected $table="group_privilege";
	protected $fillable=["group_member_id","privilege_id","created_at","updated_at"];		
}
