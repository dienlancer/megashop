@extends("frontend.master")
@section("content")
<?php 
$setting=getSettingSystem();
$contacted_phone=$setting['contacted_phone'];
$email_to=$setting['email_to'];
$address=$setting['address'];
$to_name=$setting['to_name'];
$telephone=$setting['telephone'];
$website=$setting['website'];
$slogan_about=$setting['slogan_about'];
$opened_time=$setting['opened_time'];
$opened_date=$setting['opened_date'];
$contaced_name=$setting['contacted_name'];
$facebook_url=$setting['facebook_url'];
$twitter_url=$setting['twitter_url'];
$google_plus=$setting['google_plus'];
$youtube_url=$setting['youtube_url'];
$instagram_url=$setting['instagram_url'];
$pinterest_url=$setting['pinterest_url']; 
$map_url=$setting['map_url'];
// lấy sản phẩm nổi bật
$data_featured_product=getModuleByPosition('featured-product');    
// thiết bị vệ sinh
$data_toilet_equipment=getModuleByPosition('toilet-equipment');
// thiết bị bếp
$data_chicken_equipment=getModuleByPosition('chicken-equipment');
// nhà thông minh
$data_clever_house=getModuleByPosition('clever-house');
// lấy danh sách khách hàng
$data_customer=getModuleByPosition('customer');    
// tin mới
$data_hot_article=getModuleByPosition('hot-article');    
// đối tác
$data_partner=getModuleByPosition('partner');    
// slideshow
$data_slideshow=getModuleByPosition('slideshow');    
// banner trái
$data_banner_trai=getModuleByPosition('noi-that-sang-trong');    

if(count($data_slideshow) > 0){
	?>
	<div class="container">
		<div id="wrapper">
			<div class="slider-wrapper theme-default">
				<div id="slider" class="nivoSlider"> 
					<?php 
					for($i=0 ; $i < count($data_slideshow) ; $i++ ){
						$banner=asset('upload/'.$data_slideshow[$i]['image']);
						?>
						<img src="<?php echo $banner; ?>" data-thumb="<?php echo $banner; ?>" alt="" />     
						<?php
					} 
					?>

				</div>				
			</div>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('#slider').nivoSlider();
			});    
		</script>	
	</div>
	<?php
}
?>
<div class="hotline-bg">
	<div class="container">
		<div class="re-ship-phone">
			<div class="col-lg-3 no-padding">
				<div class="item">
					<span class="icon icon1">
					</span>
					<p class="des">
						<span>Tư vấn 24/7</span> Miễn phí
					</p>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="item">
					<span class="icon icon2">

					</span>
					<p class="des">
						Vận chuyển <span>miễn phí</span>
					</p>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="item">
					<span class="icon icon3">

					</span>
					<p class="des">
						Nhận hàng <span>Nhận tiền</span>
					</p>
				</div>
			</div>
			<div class="col-lg-3 no-padding">
				<div class="item">
					<span class="icon icon4">

					</span>
					<p class="des">
						Gọi ngay <span>096.302.7720</span>
					</p>
				</div>
			</div>
			<div class="clr"></div>
		</div>        
	</div>
	<div class="container thiet-bi-ve-sinh-cao-cap-banner">
		<div class="col-lg-8 no-padding"><img src="<?php echo asset('upload/t5.jpg'); ?>"></div>
		<div class="col-lg-4 no-padding-right"><img src="<?php echo asset('upload/t6.jpg'); ?>"></div>
	</div>
</div>
<div class="container main">
	<div class="header-title">
		<h4><span><font color="#3AB54A">Danh mục</font></span> sản phẩm</h4>               
	</div>
	<div class="margin-top-15 product-kemma">
		<div>
			<div class="cate-product-horizontal-right">
				<?php     
				$args = array(                         
					'menu_class'            => 'cateprodhorizontalright', 
					'menu_id'               => 'cate-prod-horizontal-right',                         
					'before_wrapper'        => '',
					'before_title'          => '',
					'after_title'           => '',
					'before_wrapper_ul'     =>  '',
                    'after_wrapper_ul'      =>  '',
					'after_wrapper'         => ''     ,
					'link_before'       	=> '<i class="fa fa-angle-double-right" aria-hidden="true"></i>&nbsp;&nbsp;', 
					'link_after'        	=> '<i class="fa fa-caret-down pull-right" aria-hidden="true"></i>',                                                        
					'theme_location'        => 'category-product-home' ,
					'menu_li_actived'       => 'current-menu-item',
					'menu_item_has_children'=> 'menu-item-has-children',
					'alias'                 => $alias
				);                    
				wp_nav_menu($args);
				?>                 
				<div class="clr"></div>
			</div>
			
				<?php 
                if(count($data_banner_trai)){
                	           	
                    for($i=0;$i<count($data_banner_trai);$i++){                           	                    
	                    $featureImg=asset('/upload/'.$data_banner_trai[$i]['image']);
	                    $page_url=$data_banner_trai[$i]['page_url'];
	                    ?><div class="margin-top-15"><a href="<?php echo $page_url; ?>" target='_blank'><img src="<?php echo $featureImg; ?>" /></a></div><?php 
                    }
                   
                }
            	?>            
		</div>
		<div>
			<?php 			
			if(count($data_featured_product) > 0){
				?>
<div class="product-sale-shop">
				<?php
				$k=1;									
					for($i=0;$i<count($data_featured_product);$i++){							
						$id=$data_featured_product[$i]['id'];			
						$permalink=url($data_featured_product[$i]['alias'].'.html');
						$featureImg=asset('/upload/'.$setting['product_width'].'x'.$setting['product_height'].'-'.$data_featured_product[$i]['image']);
						$fullname=$data_featured_product[$i]['fullname'];	
						$price=$data_featured_product[$i]['price'];
						$sale_price=$data_featured_product[$i]['sale_price'];
						$str_price='';
						$sale_price_des='';
						$regular_price='';
						if(!empty($price)){						
							$sale_price_des=fnPrice($price);								
						}
						if(!empty($sale_price)){				
							$regular_price ='<span class="price-regular">'.fnPrice($price).' đ</span>';										
							$sale_price_des=fnPrice($sale_price);						
						}
						$sale_price_des='<span class="price-sale">'.$sale_price_des. ' đ'.'</span>' ;					
						$str_price=$regular_price . '&nbsp;&nbsp;' . $sale_price_des ;				
						?>
						<div class="col-lg-3 no-padding-right">
							<div class="box-product">
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
									<center><?php echo $str_price; ?></center>								                    
								</div>							                     
							</div>           
						</div>		
						<?php
						if($k%4 ==0 || $k==count($data_featured_product)){
							echo '<div class="clr"></div>';
						}
						$k++;
					}				
				?>
			</div>
				<?php 

			}
			?>			
		</div>
		<div class="clr"></div>
	</div>
	<?php 
	if(count($data_toilet_equipment) > 0){
		?>
		<div class="header-title">
		<h4><span><font color="#3AB54A">Thiết bị</font></span> vệ sinh</h4>                          
	</div>
	<div class="margin-top-15">
		<script type="text/javascript" language="javascript">
			jQuery(document).ready(function(){
				jQuery(".owl-carousel-toilet-equipment").owlCarousel({
					autoplay:false,                    
					loop:true,
					margin:10,                        
					nav:true,                                            
					responsiveClass:true,
					responsive:{
						0:{
							items:1,
							nav:true
						},
						600:{
							items:1,
							nav:false
						},
						1000:{
							items:4,
							nav:true,
							loop:false
						}
					}
				})
			});                
		</script>
		<div class="owl-carousel owl-carousel-toilet-equipment owl-theme">
			<?php
			$k=1;							 
				for($i=0;$i<count($data_toilet_equipment);$i++){
					$id=$data_toilet_equipment[$i]['id'];			
					$permalink=url($data_toilet_equipment[$i]['alias'].'.html');
					$featureImg=asset('/upload/'.$setting['product_width'].'x'.$setting['product_height'].'-'.$data_toilet_equipment[$i]['image']);
					$fullname=$data_toilet_equipment[$i]['fullname'];	
					$price=$data_toilet_equipment[$i]['price'];
					$sale_price=$data_toilet_equipment[$i]['sale_price'];
					$str_price='';
					$sale_price_des='';
					$regular_price='';
					if(!empty($price)){						
						$sale_price_des=fnPrice($price);								
					}
					if(!empty($sale_price)){				
						$regular_price ='<span class="price-regular">'.fnPrice($price).' đ</span>';										
						$sale_price_des=fnPrice($sale_price);						
					}
					$sale_price_des='<span class="price-sale">'.$sale_price_des. ' đ'.'</span>' ;					
					$str_price=$regular_price . '&nbsp;&nbsp;' . $sale_price_des ;				
					?>
					<div>
						<div class="box-product">
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
								<center><?php echo $str_price; ?></center>								                    
							</div>							                     
						</div>           
					</div>				
					<?php
				}	
			?>		
		</div>
	</div>	
		<?php
	}
	if(count($data_chicken_equipment)){
		?>
<div class="header-title">
            <h4><span><font color="#3AB54A">Thiết bị</font></span> bếp</h4>                          
    </div>
    <div class="margin-top-15">
    	<script type="text/javascript" language="javascript">
    		jQuery(document).ready(function(){
    			jQuery(".owl-carousel-chicken-equipment").owlCarousel({
    				autoplay:false,                    
    				loop:true,
    				margin:10,                        
    				nav:true,                                            
    				responsiveClass:true,
    				responsive:{
    					0:{
    						items:1,
    						nav:true
    					},
    					600:{
    						items:1,
    						nav:false
    					},
    					1000:{
    						items:4,
    						nav:true,
    						loop:false
    					}
    				}
    			})
    		});                
    	</script>
    	<div class="owl-carousel owl-carousel-chicken-equipment owl-theme">
    		<?php
			$k=1;				
				for($i=0;$i<count($data_chicken_equipment);$i++){
					$id=$data_chicken_equipment[$i]['id'];			
					$permalink=url($data_chicken_equipment[$i]['alias'].'.html');
					$featureImg=asset('/upload/'.$setting['product_width'].'x'.$setting['product_height'].'-'.$data_chicken_equipment[$i]['image']);
					$fullname=$data_chicken_equipment[$i]['fullname'];	
					$price=$data_chicken_equipment[$i]['price'];
					$sale_price=$data_chicken_equipment[$i]['sale_price'];
					$str_price='';
					$sale_price_des='';
					$regular_price='';
					if(!empty($price)){						
						$sale_price_des=fnPrice($price);								
					}
					if(!empty($sale_price)){				
						$regular_price ='<span class="price-regular">'.fnPrice($price).' đ</span>';										
						$sale_price_des=fnPrice($sale_price);						
					}
					$sale_price_des='<span class="price-sale">'.$sale_price_des. ' đ'.'</span>' ;					
					$str_price=$regular_price . '&nbsp;&nbsp;' . $sale_price_des ;				
					?>
					<div>
						<div class="box-product">
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
								<center><?php echo $str_price; ?></center>								                    
							</div>							                     
						</div>           
					</div>				
					<?php
				}	
			?>		
    	</div>
    </div>
		<?php
	}
	?>		
</div>
<div class="register-mail-bg margin-top-15">
	<div class="container">            
		<div class="col-lg-12 no-padding">
			<h3 class="subscribe-label">
				<span>Đăng ký nhận</span>&nbsp;<span class="tu-van-mien-phi">tư vấn miễn phí</span>
			</h3>
			<div class="mail-subscribe">Bạn là khách hàng , lớn hay nhỏ, và muốn chúng tôi phục vụ , xin vui lòng gửi cho chúng tôi một</div>
			<div class="mail-subscribe">email để support@megashop.com</div>
			<div class="box-register-email margin-top-5">              
				<div class="subscribe-email">
					<form action="#" method="post" name="mc-embedded-subscribe-form" target="_blank">
						<input type="email" value="" placeholder="Email của bạn" name="EMAIL" id="mail" aria-label="general.newsletter_form.newsletter_email">
						<button name="subscribe" id="subscribe">Gửi ngay</button>
					</form>
				</div>                                                                  
			</div>
		</div>
		<div class="clr"></div>
	</div>
</div>
<?php 
if(count($data_clever_house) > 0){
	?>
	<div class="cleverhouse padding-bottom-15">
	<div class="container">
		<div class="header-title">
			<h4><span><font color="#3AB54A">Nhà</font></span> thông minh</h4>                          
		</div>
		<div class="margin-top-15">
			<script type="text/javascript" language="javascript">
				jQuery(document).ready(function(){
					jQuery(".owl-carousel-clever-house").owlCarousel({
						autoplay:false,                    
						loop:true,
						margin:10,                        
						nav:true,                                            
						responsiveClass:true,
						responsive:{
							0:{
								items:1,
								nav:true
							},
							600:{
								items:1,
								nav:false
							},
							1000:{
								items:4,
								nav:true,
								loop:false
							}
						}
					})
				});                
			</script>
			<div class="owl-carousel owl-carousel-clever-house owl-theme">
				<?php
				$k=1;							 
					for($i=0;$i<count($data_clever_house);$i++){
						$id=$data_clever_house[$i]['id'];			
						$permalink=url($data_clever_house[$i]['alias'].'.html');
						$featureImg=asset('/upload/'.$setting['product_width'].'x'.$setting['product_height'].'-'.$data_clever_house[$i]['image']);
						$fullname=$data_clever_house[$i]['fullname'];	
						$price=$data_clever_house[$i]['price'];
						$sale_price=$data_clever_house[$i]['sale_price'];
						$str_price='';
						$sale_price_des='';
						$regular_price='';
						if(!empty($price)){						
							$sale_price_des=fnPrice($price);								
						}
						if(!empty($sale_price)){				
							$regular_price ='<span class="price-regular">'.fnPrice($price).' đ</span>';										
							$sale_price_des=fnPrice($sale_price);						
						}
						$sale_price_des='<span class="price-sale">'.$sale_price_des. ' đ'.'</span>' ;					
						$str_price=$regular_price . '&nbsp;&nbsp;' . $sale_price_des ;				
						?>
						<div>
							<div class="box-product">
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
									<center><?php echo $str_price; ?></center>								                    
								</div>							                     
							</div>           
						</div>				
						<?php
					}				
				?>		
			</div>
		</div>
	</div>
</div>    
	<?php
}
if(count($data_customer) > 0){
	?>
	<div class="twitter">
	<div class="container">
		<script type="text/javascript" language="javascript">
			jQuery(document).ready(function(){
				jQuery(".owl-carousel-customer").owlCarousel({
					autoplay:false,                    
					loop:true,
					margin:10,                        
					nav:true,                                            
					responsiveClass:true,
					responsive:{
						0:{
							items:1,
							nav:true
						},
						600:{
							items:1,
							nav:false
						},
						1000:{
							items:1,
							nav:true,
							loop:false
						}
					}
				})
			});                
		</script>
		<div class="owl-carousel owl-carousel-customer owl-theme">
			<?php 
			for($i=0;$i<count($data_customer);$i++){
					$id=$data_customer[$i]['id'];			
					$permalink=url($data_customer[$i]['alias'].'.html');
					$featureImg=asset('/upload/'.$data_customer[$i]['image']);
					$fullname=$data_customer[$i]['fullname'];
					$intro=$data_customer[$i]['intro'];
					$content=$data_customer[$i]['content'];
					?>
					<div class="user-info-blog-comment">
						<div class="user-comment-info">
							<div class="col-xs-4 no-padding"><img src="<?php echo $featureImg; ?>" /></div>
							<div class="col-xs-8 no-padding-right">
								<div><?php echo $fullname; ?></div>
								<div><?php echo $intro; ?></div>
							</div>
							<div class="clr"></div>
						</div>
						<div class="comment margin-top-15">
							<?php echo $content; ?>
						</div>
					</div> 		
					<?php
				}
			?>			
		</div>
	</div>
</div>
	<?php 
}
?>

<div class="cleverhouse padding-bottom-15">
	<div class="container">
		<?php 
		if(count($data_hot_article)){
			?>
			<div class="header-title">
			<h4><span><font color="#3AB54A">Tin</font></span>&nbsp;mới</h4>                          
		</div>
		<div class="margin-top-15">
			<?php 
			for($i=0;$i<count($data_hot_article);$i++){
				$id=$data_hot_article[$i]['id'];			
				$permalink=url($data_hot_article[$i]['alias'].'.html');
				$featureImg=asset('/upload/'.$data_hot_article[$i]['image']);
				$fullname=$data_hot_article[$i]['fullname'];
				$intro=$data_hot_article[$i]['intro'];
				$content=$data_hot_article[$i]['content'];
				?>
				<div class="col-lg-3">
					<div class="relative">
						<a href="<?php echo $permalink; ?>"><img src="<?php echo $featureImg; ?>"></a>
						<div class="hot-news-title">

						</div>
					</div>
				</div>
				<?php
			}
			?>
			<div class="clr"></div>
		</div>
			<?php 
		}
		if(count($data_partner) > 0){
			?>
			<div class="header-title">
			<h4><span><font color="#3AB54A">Đối</font></span>&nbsp;tác</h4>                          
		</div>
		<div class="margin-top-15">
			<script type="text/javascript" language="javascript">
				jQuery(document).ready(function(){
					jQuery(".owl-carousel-partner").owlCarousel({
						autoplay:false,                    
						loop:true,
						margin:10,                        
						nav:true,                                            
						responsiveClass:true,
						responsive:{
							0:{
								items:1,
								nav:true
							},
							600:{
								items:1,
								nav:false
							},
							1000:{
								items:6,
								nav:true,
								loop:false
							}
						}
					})
				});                
			</script>
			<div class="owl-carousel owl-carousel-partner owl-theme">
				<?php 
				for($i=0;$i<count($data_partner);$i++){
					$id=$data_partner[$i]['id'];			
					$permalink=url($data_partner[$i]['alias'].'.html');
					$featureImg=asset('/upload/'.$data_partner[$i]['image']);
					$fullname=$data_partner[$i]['fullname'];
					$intro=$data_partner[$i]['intro'];
					$content=$data_partner[$i]['content'];
					?>					
						<div>
							<img src="<?php echo $featureImg; ?>">							
						</div>				
					<?php
				}
				?>
			</div>
		</div>
			<?php
		}
		?>		
		
	</div>
</div>
<div class="relative megashop-map">
	<iframe src="<?php echo $map_url; ?>" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
	<div class="map">
		<div>
			<div class="col-xs-2 no-padding"><center><img src="<?php echo asset('/upload/icon_shop.png'); ?>" /></center></div>
			<div class="col-xs-10 no-padding-right">
				<div class="shop-name">MEGASHOP</div>
				<div class="slogan-title">Nội thất hiện đại</div>
			</div>
			<div class="clr"></div>
		</div>
		<div class="address-phone-email">
			<div class="col-xs-2 no-padding"><div class="icon"><center><i class="fa fa-map-marker"></i></center></div></div>
			<div class="col-xs-10 no-padding-right"><?php echo $address; ?></div>
			<div class="clr"></div>
		</div>
		<div class="address-phone-email">
			<div class="col-xs-2 no-padding"><div class="icon"><center><i class="fa fa-envelope-o"></i></center></div></div>
			<div class="col-xs-10 no-padding-right phone-email-padding">Phone:
				<?php echo $contacted_phone; ?></div>
				<div class="clr"></div>
			</div>
			<div class="address-phone-email">
				<div class="col-xs-2 no-padding"><div class="icon"><center><i class="fa fa-phone"></i></center></div></div>
				<div class="col-xs-10 no-padding-right phone-email-padding">Email:
					<?php echo $email_to; ?></div>
					<div class="clr"></div>
				</div>
			</div>
		</div>  
		<div class="cleverhouse padding-bottom-15 padding-top-15">
			<div class="container">
				<div class="col-lg-4 no-padding">
					<div>
						<div class="col-lg-3 no-padding"><center><span class="follow-us">Follow us</span></center></div>
						<div class="col-lg-9 no-padding">
							<div class="warasocial"><ul class="social-block ">
								<li class="facebook"><a class="_blank" href="<?php echo $facebook_url; ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
								<li class="twitter"><a class="_blank" href="<?php echo $twitter_url; ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
								<li class="rss"><a class="_blank" href="#" target="_blank"><i class="fa fa-rss"></i></a></li>
								<li class="google_plus"><a class="_blank" href="<?php echo $google_plus; ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
								<li class="pinterest"><a class="_blank" href="<?php echo $pinterest_url; ?>" target="_blank"><i class="fa fa-pinterest"></i></a></li>
							</ul></div>                        
						</div>
					</div>
				</div>
				<div class="col-lg-8 no-padding-right">
					<div class="menu-bottom">
						<?php     
						$args = array(                         
							'menu_class'            => 'bottommenu', 
							'menu_id'               => 'bottom-menu',                         
							'before_wrapper'        => '',
							'before_title'          => '',
							'after_title'           => '',
							'before_wrapper_ul'     =>  '',
                        	'after_wrapper_ul'      =>  '',
							'after_wrapper'         => ''     ,
							'link_before'       	=> '', 
							'link_after'        	=> '',                                                        
							'theme_location'        => 'menu-bottom-content' ,
							'menu_li_actived'       => 'current-menu-item',
							'menu_item_has_children'=> 'menu-item-has-children',
							'alias'                 => $alias
						);                    
						wp_nav_menu($args);
						?>                 
						<div class="clr"></div>
					</div>
				</div>
			</div>
		</div>		 
@endsection()               