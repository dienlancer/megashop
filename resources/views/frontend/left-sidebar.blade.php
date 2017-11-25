<?php   
$setting=getSettingSystem();
switch ($component) {
    case 'category-article':
    case 'article':
    
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
                <div class="product-index">
                    <div class="col-lg-4 no-padding-right">
                        <center><figure><a href="<?php echo $permalink; ?>"><img src="<?php echo $featureImg; ?>"></a></figure></center>
                    </div>
                    <div class="col-lg-8 no-padding-right">
                        <div class="margin-top-15"><a href="<?php echo $permalink; ?>"><?php echo $fullname; ?></a></div>
                        <div class="product-index-status"><?php echo $str_price; ?></div>
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
