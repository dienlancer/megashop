<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model {
	protected $table="customer";
	protected $fillable=["username","password","email","name","address","phone","mobilephone","fax","status","sort_order","created_at","updated_at"];		
}
