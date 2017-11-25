<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategoryModel extends Model {

	protected $table="product_category";
	protected $fillable=["product_id","category_product_id","created_at","updated_at"];		
}
