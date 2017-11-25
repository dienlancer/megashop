<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodModel extends Model {

	protected $table="payment_method";
	protected $fillable=["fullname","alias","content","sort_order","status","created_at","updated_at"];		
}
