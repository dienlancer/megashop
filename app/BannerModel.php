<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BannerModel extends Model {

	protected $table="banner";
	protected $fillable=["fullname","alias","picture","sort_order","status","created_at","updated_at"];		
}
