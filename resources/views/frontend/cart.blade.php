<h3 class="page-title h-title">Giỏ hàng</h3>
<?php 
$setting=getSettingSystem();
$product_width=$setting['product_width'];
$product_height=$setting['product_height'];
$ssName="vmart";
$arrCart=array();
if(Session::has($ssName)){
    $ssCart=Session::get($ssName);
    $arrCart = @$ssCart["cart"];    
}      
if(count($arrCart) > 0){
	?>
	<form name="frm" method="post" action="">
<table id="com_product16" class="com_product16" cellpadding="0" cellspacing="0" width="100%">
	<thead>
	<tr>	
		<th>Sản phẩm</th>
		<th>Giá</th>
		<th>Số lượng</th>
		<th>Tổng giá</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
	<?php	
	$total_price=0;
	foreach ($arrCart as $key => $value) {	
		$product_id=$value["product_id"];      
        $product_name 			=	$value["product_name"];
        $product_code			=	$value["product_code"];
        $product_price 			=	$value["product_price"];        
        $product_image 			=  	asset('/upload/'.$product_width.'x'.$product_height.'-'.$value['product_image']) ;        
        $product_link 			= 	url($value['product_alias'].'.html');			
		$product_quantity		=	$value["product_quantity"];
		$product_price 			=	fnPrice($value["product_price"]);
		$product_total_price 	= 	fnPrice($value["product_total_price"]);
		$total_price+=(float)$value["product_total_price"];		
		$delete_cart			=	url("/xoa-gio-hang");
		$continue_link 			=	url('sofa.html');
		$delete_link 			=	url("/xoa/".$product_id);
		$checkout_link 			=	url("/thanh-toan");
	 	?>
	 	<tr>			
			<td class="com_product20"><a href="<?php echo $product_link ?>"><?php echo $product_name; ?></a></td>
			<td align="right" class="com_product21"><?php echo $product_price; ?></td>
			<td align="center" class="com_product22"><input type="text" onkeypress="return isNumberKey(event)" value="<?php echo $product_quantity; ?>" size="4" class="com_product19" name="quantity[<?php echo $product_id; ?>]">		
			</td>
			<td align="right" class="com_product23"><?php echo $product_total_price; ?></td>
			<td align="center" class="com_product24"><a href="<?php echo $delete_link; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
		</tr>
	 	<?php
	 } 
	?>					
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3">
				<a href="<?php echo $delete_cart; ?>" class="com_product28">Xóa giỏ hàng</a>
				<input type="submit" name="btn_update_cart" class="com_product25" value="Cập nhật" />							
				<a href="<?php echo $continue_link; ?>" class="com_product27">Tiếp tục mua hàng</a>
				<a href="<?php echo $checkout_link; ?>" class="com_product29">Thanh toán</a>
				<input type="hidden" name="action" value="update-cart" />
				{{ csrf_field() }}
			</td>			
			<td align="right"><?php echo fnPrice($total_price) ; ?></td>
			<td></td>
		</tr>
	</tfoot>
</table>
</form>
	<?php
}else{
	?>
	<table id="com_product16" class="com_product16" cellpadding="0" cellspacing="0" width="100%">
		<thead>
			<tr>					
				<th>Giỏ hàng rỗng</th>
			</tr>
		</thead>
	</table>
	<?php
}    
?>
