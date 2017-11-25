<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PhotoModel extends Model {
	protected $table="photo";
	protected $fillable=["id","fullname","alias","album_id","image","status","sort_order","created_at","updated_at"];		
}
