<?php 
if(count($item) > 0){
	$fullname=$item['fullname'];
	$intro=$item['intro'];
	$content=$item['content'];
	?>

		<h3 class="page-title h-title"><?php echo $fullname; ?></h3>
		<div class="page-single">
			<div><h4 class="single-excerpt"><?php echo $intro; ?></h4></div>
			<div class="margin-top-15"><?php echo $content; ?>
			</div>          
		</div>                        		

	<?php	
}
?>
