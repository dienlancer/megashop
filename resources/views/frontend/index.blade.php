@extends("frontend.master")
@section("content")
<div class="container margin-top-15 margin-bottom-15">
  <div class="col-lg-3 no-padding page-left">@include("frontend.left-sidebar")</div>
  <div class="col-lg-9 no-padding-right col-right">
    <div class="page-right padding-bottom-15">
      <?php
      switch ($component) {      
        case "category-article":                                                
        ?>@include("frontend.category-article")<?php
        break;             
        case "article":                                                
        ?>@include("frontend.article")<?php
        break; 
        case "lien-he":                                                
        ?>@include("frontend.contact")<?php
        break; 
        case "category-product":                                                
        ?>@include("frontend.category-product")<?php
        break; 
        case "product":                                                
        ?>@include("frontend.product")<?php
        break;
        case "gio-hang":                                                
        ?>@include("frontend.cart")<?php
        break; 
        case "dang-ky":                                                
        ?>@include("frontend.register")<?php
        break;
        case "tai-khoan":                                                
        ?>@include("frontend.account")<?php
        break;
        case "dang-nhap":                                                
        ?>@include("frontend.login")<?php
        break;
        case "bao-mat":                                                
        ?>@include("frontend.security")<?php
        break;
        case "xac-nhan-thanh-toan":                                                
        ?>@include("frontend.confirm-checkout")<?php
        break;
        case "dang-nhap-thanh-toan":                                                
        ?>@include("frontend.login-checkout")<?php
        break;
        case "hoan-tat-thanh-toan":                                                
        ?>@include("frontend.finished-checkout")<?php
        break;
        case "hoa-don":                                                
        ?>@include("frontend.invoice")<?php
        break;                                                                        
      }
      ?>
    </div>
  </div>
</div>  
@endsection()               