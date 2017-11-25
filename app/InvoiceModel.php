<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceModel extends Model {

	protected $table="invoice";
	protected $fillable=["code","customer_id","username","email","fullname","address","phone","mobilephone","fax","quantity","total_price","status","sort_order","created_at","updated_at"];		
}
