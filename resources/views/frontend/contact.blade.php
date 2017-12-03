@extends("frontend.master")
@section("content")
<?php 
$setting=getSettingSystem();
$email_to=$setting['email_to']['field_value'];
$address=$setting['address']['field_value'];
$to_name=$setting['to_name']['field_value'];
$telephone=$setting['telephone']['field_value'];
$website=$setting['website']['field_value'];
$slogan_about=$setting['slogan_about']['field_value'];
$facebook_url=$setting['facebook_url']['field_value'];
$twitter_url=$setting['twitter_url']['field_value'];
$google_plus=$setting['google_plus']['field_value'];
$youtube_url=$setting['youtube_url']['field_value'];
$instagram_url=$setting['instagram_url']['field_value'];
$pinterest_url=$setting['pinterest_url']['field_value']; 
$map_url=$setting['map_url']['field_value'];       
?>
<div class="container margin-top-15 margin-bottom-15 page-right">
	<h3 class="page-title h-title">Liên hệ</h3>
	<div class="padding-left-15 padding-right-15">
		<div class="margin-top-15">
			<div class="col-md-4 contact no-padding">
				<form method="post" name="frm" enctype="multipart/form-data">							
					{{ csrf_field() }}      
					<div class="margin-top-5"><input type="input" class="form-control" name="fullname" placeholder="Họ và tên"></div>
					<div class="margin-top-5"><input type="input" class="form-control" name="email" placeholder="Email"></div>
					<div class="margin-top-5"><input type="input" class="form-control" name="phone" placeholder="Điện thoại"></div>
					<div class="margin-top-5"><input type="input" class="form-control" name="title" placeholder="Chủ đề"></div>
					<div class="margin-top-5"><input type="input" class="form-control" name="address" placeholder="Địa chỉ"></div>
					<div class="margin-top-5"><textarea name="content" class="form-control" placeholder="Nội dung"></textarea></div>
					<div class="margin-top-5">
						<input type="submit" name="btnSend" class="btn btn-default" value="Gửi">					  
					</div>				
				</form>
			</div>
			<div class="col-md-8 contact-info no-padding-right">
				<div class="company-name"><?php echo $to_name; ?></div>
				<div class="contact-info-child"><?php echo $address; ?></div>
				<div class="contact-info-child">Website: <?php echo $website; ?></div>
				<div class="contact-info-child">E-mail: <?php echo $email_to; ?></div>
				<div class="contact-info-child">Tel: <font color="#D41010"><?php echo $telephone; ?></font></div>
			</div>
			<div class="clr"></div>
		</div>
		<div class="margin-top-15">
					<iframe src="<?php echo $map_url; ?>" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>	
	</div>
</div>
@endsection()               