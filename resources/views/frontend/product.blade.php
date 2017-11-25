<?php 
$setting=getSettingSystem();
$contacted_phone=$setting['contacted_phone'];
$product_width=$setting['product_width'];
$product_height=$setting['product_height'];
if(count($item) > 0){
    $id=$item['id'];           
    $permalink=url($item['alias'].'.html');
    $featureImg=asset('/upload/'.$product_width.'x'.$product_height.'-'.$item['image']); 
    $largeImg=asset('/upload/'.$item['image']); 
    $fullname=$item['fullname'];   
    $price=fnPrice($item['price']).' đ';
    $sale_price=fnPrice($item['sale_price']). ' đ';
    $arrPicture=json_decode($item['child_image']);
    $arrPicture[]=$item['image'];    
    $intro=$item['intro'];
    $cart_price=0;
    if(!empty($item['price'])){
        $cart_price=$item['price'];
    }
    if(!empty($item['sale_price'])){
        $cart_price=$item['sale_price'];
    }
    ?>

            <h3 class="page-title h-title"><?php echo $fullname; ?></h3>
            <div class="box-product-detail">                
                <div>
                    <div class="col-lg-4 no-padding">
                        <div class="box-img" id="image-detail"><img id="zoom_img" src="<?php echo $featureImg; ?>" data-zoom-image="<?php echo $largeImg; ?>"></div>
                        <div class="thumbnails margin-top-5">
                            <script type="text/javascript" language="javascript">
                                jQuery(document).ready(function(){
                                    jQuery(".owl-carousel").owlCarousel({
                                        autoplay:true,
                                        loop:true,
                                        margin:2,
                                        nav:true,
                                        responsive:{
                                            1000:{
                                                items:3
                                            },
                                            600:{
                                                items:1
                                            } ,   
                                            300:{
                                                items:1
                                            }                             
                                        }
                                    })
                                });
                            </script> 
                            <section class="slider">
                                <div class="owl-carousel owl-theme">
                                    <?php 
                                    if(count($arrPicture) > 0){
                                        for($i=0;$i<count($arrPicture);$i++){                                            
                                            $small_thumbnail=asset('/upload/'.$product_width.'x'.$product_height.'-'.$arrPicture[$i]);    
                                            $large_thumbnail=asset('/upload/'.$arrPicture[$i]);                            
                                            ?>
                                            <div class="items">
                                                <div class="box-product-thumbnail">
                                                    <a href="javascript:void(0)" onclick="changeImage('<?php echo $small_thumbnail; ?>','<?php echo $large_thumbnail; ?>');"><img  src="<?php echo $small_thumbnail; ?>" width="<?php echo (int)$product_width/5; ?>" /></a>
                                                </div>                                                
                                            </div>
                                            <?php                                    
                                        }
                                    }                            
                                    ?>         
                                </div>
                            </section>                                                                           
                            <div class="clr"></div>
                        </div>
                    </div>
                    <div class="col-lg-8 no-padding-right">
                        <form action="" name="frm" method="POST">
                            {{ csrf_field() }}
                            <div class="product-detail">                            
                                <div class="product-regular-price"><b>Giá gốc:&nbsp;</b><span><font color="#F00"><?php echo $price; ?></font></span></div>
                                <div class="product-sale-price"><span class="sale-title">Giá khuyến mãi:&nbsp;</span><span class="sale-price"><?php echo $sale_price; ?></span></div>
                                <div class="product-view"><span class="sale-title">Lượt xem:&nbsp;</span><span class="sale-price">31</span></div>
                                <div class="product-hotline">Hotline: <?php echo $contacted_phone; ?></div>
                                <div class="product-detail-small"><?php echo $intro; ?></div>
                                <div>
                                    <div class="orderproduct">
                                        <input type="input" name="product_quantity" value="1" class="quantity" onkeypress="return isNumberKey(event)">
                                        <input type="submit" value="Mua hàng" class="add-to-cart h-title">
                                    </div>                                    
                                </div>
                            </div>
                            <input type="hidden" name="product_id"      value="<?php echo $id; ?>">
                            <input type="hidden" name="product_code"    value="<?php echo $item['code']; ?>">
                            <input type="hidden" name="product_name"    value="<?php echo $fullname; ?>">
                            <input type="hidden" name="product_alias"   value="<?php echo $item['alias']; ?>">
                            <input type="hidden" name="product_image"   value="<?php echo $item['image']; ?>">
                            <input type="hidden" name="product_price"   value="<?php echo $cart_price; ?>">
                            <input type="hidden" name="action"          value="add-cart" /> 
                            </form>                        
                    </div>
                    <div class="clr"></div>
                </div>                    
            </div>
            <div class="box-product-detail">
                <div class="information">
                    <div class="information-pane h-title">Thông tin chi tiết</div>
                    <div class="clr"></div>
                    <div class="information-bg">
                      <?php echo $item['detail']; ?>
                    </div>
                </div>                
            </div>              
<script type="text/javascript" language="javascript">
       function changeImage(small_thumbnail,large_thumbnail){    
        var image_detail=jQuery("#image-detail");
        var imghtml='<img id="zoom_img" src="'+small_thumbnail+'" data-zoom-image="'+large_thumbnail+'">';        
        jQuery(image_detail).empty();
        jQuery(image_detail).append(imghtml);
        jQuery('#zoom_img').elevateZoom({
            zoomType: "inner",
            cursor: "crosshair",
            zoomWindowFadeIn: 500,
            zoomWindowFadeOut: 750
        });
    }
</script>
<script language="javascript" type="text/javascript">
    jQuery('#zoom_img').elevateZoom({
        zoomType: "inner",
        cursor: "crosshair",
        zoomWindowFadeIn: 500,
        zoomWindowFadeOut: 750
    });
</script>  
    <?php
}
?>
