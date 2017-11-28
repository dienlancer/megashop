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
$ssName="vmuser";
$arrUser=array();            
if(Session::has($ssName)){
  $arrUser=Session::get($ssName)["userInfo"];      
}         
$account_link=route("frontend.index.viewAccount");  
$logout_link=route("frontend.index.getLgout"); 
$security_link=route("frontend.index.viewSecurity"); 
$invoice_link=route("frontend.index.getInvoice");
$register_member_link=route("frontend.index.register");
$cart_link=route('frontend.index.viewCart');

$ssNameCart='vmart';
$quantity=0;
$arrCart=array();
              if(Session::has($ssNameCart)){    
                  $arrCart = @Session::get($ssNameCart)["cart"];    
              }         
              if(count($arrCart) > 0){
                foreach ($arrCart as $key => $value){
                  $quantity+=(int)$value['product_quantity'];              
                }
              }        
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">  
  <title><?php echo (!empty($title)) ? $title : $slogan_about; ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="keywords" content="<?php echo @$meta_keyword; ?>" />
  <meta name="description" content="<?php echo @$meta_description; ?>"/>
  <script src="{{ asset('public/frontend/js/jquery-3.2.1.js') }}"></script>
  <script src="{{ asset('public/frontend/js/bootstrap.js') }}"></script>
  <script src="{{ asset('public/frontend/js/ddsmoothmenu.js') }}"></script>
  <script src="{{ asset('public/frontend/js/jquery.fancybox.js') }}"></script>
  <script src="{{ asset('public/frontend/js/jquery.fancybox-buttons.js') }}"></script>
  <script src="{{ asset('public/frontend/js/jquery.fancybox-thumbs.js') }}"></script>
  <script src="{{ asset('public/frontend/js/jquery.fancybox-media.js') }}"></script>
  <script src="{{ asset('public/frontend/nivo-slider/jquery.nivo.slider.js') }}"></script>
  <script src="{{ asset('public/frontend/js/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('public/frontend/js/jquery.simplyscroll.min.js') }}"></script>
  <script src="{{ asset('public/frontend/js/jquery.bxslider.min.js') }}"></script>
  <script src="{{ asset('public/frontend/js/jquery.elevatezoom-3.0.8.min.js') }}"></script>
  <script src="{{ asset('public/frontend/js/accounting.min.js') }}"></script>
  <script src="{{ asset('public/frontend/js/custom.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('public/frontend/css/font-awesome.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/frontend/css/bootstrap.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/frontend/css/ddsmoothmenu.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/frontend/css/jquery.fancybox.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/frontend/css/jquery.fancybox-buttons.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/frontend/css/jquery.fancybox-thumbs.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/frontend/css/hover.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/frontend/css/pagination.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/frontend/css/jquerysctipttop.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/frontend/nivo-slider/themes/default/default.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/frontend/nivo-slider/themes/light/light.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/frontend/nivo-slider/themes/dark/dark.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/frontend/nivo-slider/themes/bar/bar.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/frontend/nivo-slider/nivo-slider.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/frontend/css/owl.carousel.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/frontend/css/jquery.simplyscroll.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/frontend/css/jquery.bxslider.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/frontend/css/dropdownmenu.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/frontend/css/tab.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/frontend/css/menu-horizontal-right.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/frontend/css/product.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/frontend/css/template.css') }}" />
  <link rel="stylesheet" href="{{ asset('public/frontend/css/custom.css') }}" />
  <script type="text/javascript" language="javascript">
    ddsmoothmenu.init({
      mainmenuid: "smoothmainmenu", 
      orientation: "h", 
      classname: "ddsmoothmenu",
      contentsource: "markup" 
    });    
    $(document).ready(function(){        
      $(window).bind("scroll", function() {                        
        if ($(window).scrollTop() > 104) {
         $("div.bg-header").addClass("fixed");
       }
       else {
         $("div.bg-header").removeClass("fixed");
       }
     });
    });
  </script>
</head>
<body>
  <header class="relative header">
    <div class="top-header">
      <div class="container">
        <div class="col-lg-2 no-padding"><font color="#ffffff">Tư vấn 24/7:</font>&nbsp;<font color="#bbb"><?php echo $contacted_phone; ?></font></div>
        <div class="col-lg-6 no-padding"><font color="#ffffff">Địa chỉ:</font>&nbsp;<font color="#bbb"><?php echo $address; ?></font></div>
        <div class="col-lg-4 no-padding">
          <div class="col-lg-9 no-padding">
            <ul class="top-user">
              <?php                                                              
              if( count($arrUser) == 0 ){
                ?>
                <li><a href="<?php echo $register_member_link; ?>" class="header-action-item"><i class="fa fa-unlock" aria-hidden="true"></i>&nbsp;Đăng ký</a></li>
                <li><a href="<?php echo $account_link; ?>" class="header-action-item"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;Đăng nhập</a></li>
                <?php
              }else{                                     
                ?>
                <li><a class="header-action-item" href="<?php echo $account_link; ?>"><?php echo $arrUser["username"]; ?></a></li>
                <li><a class="header-action-item" href="<?php echo $security_link; ?>">Đổi mật khẩu</a></li>                                
                <li><a class="header-action-item" href="<?php echo $invoice_link; ?>">Invoice</a></li>
                <li><a class="header-action-item" href="<?php echo $logout_link; ?>">Logout</a></li>
                <?php                                     
              }
              ?>       
            </ul> 
          </div>                    
          <div class="col-lg-3 no-padding">
            <div class="mini-cart dropdown box-cart cart hidden-xs">
              <a href="<?php echo $cart_link; ?>" >
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;Giỏ hàng
                <span class="cart-total"><?php echo $quantity; ?></span>
              </a>                            
            </div>
          </div>
          <div class="clr"></div>             
        </div>       
      </div>
    </div>
    <div class="bg-header">
    <div class="container">        
        <div class="menu">
            <div class="col-lg-3 no-padding">                
                <center><a href="<?php echo url('/'); ?>">                
                    <img src="<?php echo asset('upload/logo-megashop.png');?>" />
                </a></center>
            </div>
            <div class="col-lg-6 no-padding">                                                
                     <?php     
                    $args = array(                         
                        'menu_class'            => 'mainmenu', 
                        'menu_id'               => 'main-menu',                         
                        'before_wrapper'        => '<div id="smoothmainmenu" class="ddsmoothmenu">',
                        'before_title'          => '',
                        'after_title'           => '',
                        'before_wrapper_ul'     =>  '',
                        'after_wrapper_ul'      =>  '',
                        'after_wrapper'         => '</div>'     ,
                        'link_before'           => '', 
                        'link_after'            => '',                                                                    
                        'theme_location'        => 'main-menu' ,
                        'menu_li_actived'       => 'current-menu-item',
                        'menu_item_has_children'=> 'menu-item-has-children',
                        'alias'                 => $alias
                    );                    
                    wp_nav_menu($args);
                    ?>                                      
            </div>
            <div class="col-lg-3 no-padding">
                <div class="desktop-box-search">                    
                    <div class="box-search">
                        <form action="#" method="get">
                            <input type="text" name="q" autocomplete="off" placeholder="Tìm kiếm sản phẩm" value="">
                            <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </form>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                </div>       
            </div>      
            <div class="clr"></div>      
        </div>      
    </div>    
</div>   
<div class="mobilemenu">
        <div class="container">
            <div>
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>                   
                        </div>
                        <div id="navbar" class="navbar-collapse collapse">
                          <?php     
                          $args = array(                         
                            'menu_class'            => 'nav navbar-nav', 
                            'menu_id'               => 'mobile-menu',                         
                            'before_wrapper'        => '',
                            'before_title'          => '',
                            'after_title'           => '',
                            'before_wrapper_ul'     =>  '',
                            'after_wrapper_ul'      =>  '',
                            'after_wrapper'         => ''     ,
                            'link_before'           => '', 
                            'link_after'            => '',                                                                    
                            'theme_location'        => 'mobile-menu' ,
                            'menu_li_actived'       => 'current-menu-item',
                            'menu_item_has_children'=> 'menu-item-has-children',
                            'alias'                 => $alias
                          );                 
                          wp_nav_menu($args);
                          ?>             
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>    
  </header>