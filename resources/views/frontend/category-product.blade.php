<?php 
$setting=getSettingSystem();     
$product_width = $setting['product_width']['field_value'];
$product_height = $setting['product_height']['field_value'];
?>
<form method="post" class="frm" name="frm">
	<input type="hidden" name="filter_page" value="1">         
    {{ csrf_field() }}
		<h3 class="page-title h-title"><?php echo $category['fullname']; ?></h3>
		<div>
			<?php 		
			if(count($items) > 0){			
					$k=1;									
					for($i=0;$i<count($items);$i++){							
						$id=$items[$i]['id'];			
						$permalink=url($items[$i]['alias'].'.html');
						$featureImg=asset('/upload/'.$product_width.'x'.$product_height.'-'.$items[$i]['image']);
						$fullname=$items[$i]['fullname'];	
						$price=$items[$i]['price'];
						$sale_price=$items[$i]['sale_price'];
						$html_price='';						
						if((int)($sale_price) > 0){				
							$price ='<span class="price-regular">'.fnPrice($price).'</span>';
							$sale_price='<span class="price-sale">'.fnPrice($sale_price). '</span>' ;					
							$html_price=$price . '&nbsp;&nbsp;' . $sale_price ;				
						}else{
							$price='<span class="price-sale">'.fnPrice($price). '</span>' ;	
							$html_price=$price;		
						}		
						?>
						<div class="col-lg-3">
							<div class="box-product margin-top-15">
								<div class="product-img"><center><figure><a href="<?php echo $permalink; ?>"><img src="<?php echo $featureImg; ?>" alt="" /></a></figure></center>
									<div class="box-product-add-to-cart">
										<div class="them-vao-gio-hang">
											<a href="javascript:void(0)" data-toggle="modal" data-target="#modal-alert-add-cart" onclick="addToCart(<?php echo $id; ?>,'<?php echo route('frontend.index.addToCart'); ?>');" ><i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;Thêm vào giỏ</a>									
										</div>
									</div>								
								</div>								
								<div class="box-product-title"><a href="<?php echo $permalink; ?>"><?php echo $fullname; ?></a></div>
								<div class="box-product-star">								
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>								
								</div>
								<div class="box-product-general-price margin-top-5">
									<center><?php echo $html_price; ?></center>								                    
								</div>							                     
							</div>           
						</div>		
						<?php
						if($k%4 ==0 || $k==count($items)){
							echo '<div class="clr"></div>';
						}
						$k++;
					}					
				}	
			?>			
		</div>
		<?php 
		if(count($items) > 0){
			echo $pagination->showPagination();
		}  
		?>
</form>