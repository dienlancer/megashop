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