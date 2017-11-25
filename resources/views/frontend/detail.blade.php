@extends("frontend.master")

@section("content")

<?php  

$strImage= url('/upload/product') ;

$strImageChildren= url('/upload/product/'.WIDTH.'x'.HEIGHT.'-') ;

 $detail=$item[0];

$arrChildImage=json_decode($detail["image_child"]);



?>

<form name="frm" class="frm" action="" method="post">    

    <input type="hidden" name="_token" value="{!! csrf_token() !!}" />

    <input type="hidden" name="filter_page" value="1">

    <div>

    	        <div class="thumbnail-image">

    	        	<div >

    	        		<?php 

    	        		if(!empty($arrChildImage)) {

    	        			?>

    	        			@foreach($arrChildImage as $key => $value)    	        		

    	        		<div class="small-image"><img src="{!! $strImageChildren  . $value !!}" width="60" height="80" /></div>

    	        		@endforeach    	        		    	        	

    	        			<?php

    	        		}

    	        		?>    	        		

    	        	</div>

    	        </div>

                <div class="large-image">

                    <img src="{!! $strImage . DS . $detail['image'] !!}" width="350" height="450" />

                </div>

                <div class="product-detail">

                	<h1 class="title-product-detail">{!! $detail["name"] !!}</h1>

                	<div class="item-code margin-top-15">Item code : {!! $detail["code"] !!}</div>

                	<div class="write-review margin-top-15">

                		<span class="star-icon"><i class="fa fa-star-o" aria-hidden="true"></i>

                		<i class="fa fa-star-o" aria-hidden="true"></i>

                		<i class="fa fa-star-o" aria-hidden="true"></i>

                		<i class="fa fa-star-o" aria-hidden="true"></i>                		</span>                		

                		<a href="javascript:void(0)" class="comment-act">Viết lời bình</a>                		

                		<a href="/topic/tbshowonline/" rel="nofollow" class="share-act">Chia sẻ ảnh sẽ nhận được 15 coupon &gt;&gt;</a>

                	</div>

                	<table cellpadding="0" cellpadding="0" class="tbl-size-color" border="0">

                		<tr>

                			<td><span class="size-text">Giá :</span></td>

                			<td><span class="price-remove">{!! fnPrice($detail["main_price"]) !!}</span></td>

                		</tr>

                		<tr>

                			<td><span class="size-text">Giá giảm :</span></td>

                			<td><span class="price-appear">{!! fnPrice($detail["price"]) !!}</span></td>

                		</tr>

                		<tr>

                			<td><span class="size-text">Color :</span></td>

                			<td><select name="ddlColor" class="form-control selected-size">

                			<option value="">Chọn màu</option>

                			<option value="Do">Đỏ</option>

                			<option value="Xanh">Xanh</option>

                			<option value="Xam">Xám</option>

                		</select></td>

                		</tr>

                		<tr>

                			<td><span class="size-text">Size :</span> </td>

                			<td><select name="ddlSize" class="form-control selected-size">

                			<option value="">Chọn kích thước</option>

                			<option value="M">M</option>

                			<option value="L">L</option>

                			<option value="XL">XL</option>

                		</select></td>

                		</tr>

                		<tr>

                			<td><span class="size-text">Color :</span></td>

                			<td>

                				<div class="xdspan in_block">

                                    <input type="hidden" id="minNum" value="1">

                                    <a class="minus-num" href="javascript:UpdateQuantity(-1);" rel="nofollow"><i class="fa fa-minus" aria-hidden="true"></i></a>

                                    <input class="quannum" type="text"  maxlength="5" value="1" onkeypress="return isNumberKey(event)" />

                                    <a class="add-num" href="javascript:UpdateQuantity(1);" rel="nofollow"><i class="fa fa-plus" aria-hidden="true"></i></a>

                                </div>   

                			</td>

                		</tr>

                		<tr>

                			<td></td>

                			<td><input type="submit" name="btnAddToCart" value="Thêm vào giỏ hàng" class="btn-add-to-cart" /></td>

                		</tr>                		

                	</table>                 	        

                </div>

    </div> 

</form>

@endsection()               