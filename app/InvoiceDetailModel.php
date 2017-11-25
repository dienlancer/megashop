<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetailModel extends Model {

	protected $table="invoice_detail";
	protected $fillable=["invoice_id","product_id","product_code","product_name","product_image","product_price","product_quantity","product_total_price","created_at","updated_at"];		
}
