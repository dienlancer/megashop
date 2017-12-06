<?php   
$setting=getSettingSystem();
$product_width = $setting['product_width']['field_value'];
$product_height = $setting['product_height']['field_value'];
switch ($component) {
    case 'category-article':
    case 'article':
    case 'tim-kiem':
    
        $args = array(                         
            'menu_class'            => 'categoryarticlemenu', 
            'menu_id'               => 'category-article-menu',                         
            'before_wrapper'        => '<div id="module-common-5" class="category-col-left">',
            'before_title'          => '<h3 class="page-title-left h-title">',
            'after_title'           => '</h3>',
            'before_wrapper_ul'     =>  '<div>',
            'after_wrapper_ul'      =>  '</div>',
            'after_wrapper'         => '</div>'     ,
            'link_before'           => '<i class="fa fa-angle-double-right" aria-hidden="true"></i>&nbsp;&nbsp;', 
            'link_after'            => '',                                                                    
            'theme_location'        => 'category-article' ,
            'menu_li_actived'       => 'current-menu-item',
            'menu_item_has_children'=> 'menu-item-has-children',
            'alias'                 => $alias
        );                    
        wp_nav_menu($args);
        $data_featured_article=getModuleByPosition('article','featured-article-leftside');    
?>
        <div id="module-item-15" class="category-col-left margin-top-15">
            <h3 class="page-title-left h-title">Bài viết nổi bật</h3>  
            <?php 
            for($i=0;$i<count($data_featured_article);$i++){
                $id=$data_featured_article[$i]['id'];           
                $permalink=url($data_featured_article[$i]['alias'].'.html');
                $featureImg=asset('/upload/'.$data_featured_article[$i]['image']);
                $fullname=$data_featured_article[$i]['fullname'];
                $intro=$data_featured_article[$i]['intro'];
                $content=$data_featured_article[$i]['content'];
                ?>
                <div class="product-index">
                    <div class="col-lg-4 no-padding">
                        <center><figure><a href="<?php echo $permalink; ?>"><img src="<?php echo $featureImg; ?>"></a></figure></center>
                    </div>
                    <div class="col-lg-8 no-padding-right">
                        <div class="margin-top-15"><a href="<?php echo $permalink; ?>"><?php echo $fullname; ?></a></div>                          
                    </div>
                    <div class="clr"></div>
                </div>      
                <?php
            }
            ?>
            <div class="clr"></div>                                         
        </div>                                            
<?php
        break;
    case 'category-product':
    case 'product':    
    case 'gio-hang':      
    case 'dang-nhap-thanh-toan':
    case 'dang-ky':
    case 'tai-khoan':
    case 'dang-nhap':
    case 'bao-mat':
    case 'xac-nhan-thanh-toan':
    case 'hoan-tat-thanh-toan':
    case 'hoa-don':
        $args = array(                         
            'menu_class'            => 'categoryproductmenu', 
            'menu_id'               => 'category-product-menu',                         
            'before_wrapper'        => '<div class="category-col-left">',
            'before_title'          => '<h3 class="page-title-left h-title">',
            'after_title'           => '</h3>',
            'before_wrapper_ul'     =>  '<div>',
            'after_wrapper_ul'      =>  '</div>',
            'after_wrapper'         => '</div>'     ,
            'link_before'           => '<i class="fa fa-angle-double-right" aria-hidden="true"></i>&nbsp;&nbsp;', 
            'link_after'            => '',                                                                    
            'theme_location'        => 'category-product' ,
            'menu_li_actived'       => 'current-menu-item',
            'menu_item_has_children'=> 'menu-item-has-children',
            'alias'                 => $alias
        );                    
        wp_nav_menu($args);  
        $data_featured_product=getModuleByPosition('product','featured-product-leftside');        
        ?>
        <div class="category-col-left">
            <h3 class="page-title-left h-title">Sản phẩm nổi bật</h3>
            <?php 
            for($i=0;$i<count($data_featured_product);$i++){
                $id=$data_featured_product[$i]['id'];           
                        $permalink=url($data_featured_product[$i]['alias'].'.html');
                        $featureImg=asset('/upload/'.$product_width.'x'.$product_height.'-'.$data_featured_product[$i]['image']);
                        $fullname=$data_featured_product[$i]['fullname'];   
                        $price=$data_featured_product[$i]['price'];
                        $sale_price=$data_featured_product[$i]['sale_price'];
                        $html_price='';                      
                        if((int)($sale_price) > 0){             
                            $price ='<span class="price-regular">'.fnPrice($price).'</span>';
                            $sale_price='<span class="price-sale">'.fnPrice($sale_price).'</span>' ;                  
                            $html_price=$price . '&nbsp;&nbsp;' . $sale_price ;              
                        }else{
                            $price='<span class="price-sale">'.fnPrice($price).'</span>' ;    
                            $html_price=$price;      
                        }              
                ?>
                <div class="product-index">
                    <div class="col-lg-4 no-padding-right">
                        <center><figure><a href="<?php echo $permalink; ?>"><img src="<?php echo $featureImg; ?>"></a></figure></center>
                    </div>
                    <div class="col-lg-8 no-padding-right">
                        <div class="margin-top-15"><a href="<?php echo $permalink; ?>"><?php echo $fullname; ?></a></div>
                        <div class="product-index-status"><?php echo $html_price; ?></div>
                    </div>
                    <div class="clr"></div>
                </div>
                <?php
            }
            ?>            
        </div>
        <?php
    break;
}
