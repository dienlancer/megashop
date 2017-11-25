<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PrivilegeModel extends Model {

	protected $table="privilege";
	protected $fillable=["fullname","controller","action","sort_order","created_at","updated_at"];		
}
