<?php 
$setting= getSettingSystem();
?>
<form method="post" class="frm" name="frm">
	<input type="hidden" name="filter_page" value="1">         
    {{ csrf_field() }}
		<h3 class="page-title h-title"><?php echo $category['fullname']; ?></h3>
		<div class="box-post">
			<?php 		
			if(count($items) > 0){
				$k=1;
				$count=count($items);				
				for($i=0;$i<count($items);$i++){
					$id=$items[$i]['id'];			
					$permalink=url($items[$i]['alias'].'.html');
					$featureImg=asset('/upload/' .$items[$i]['image']);
					$fullname=$items[$i]['fullname'];
					$intro=$items[$i]['intro'];
					$content=$items[$i]['content'];
					?>
					<div class="col-md-4 box-article">
						<div class="box-article-img"><center><figure><a href="<?php echo $permalink; ?>"><img src="<?php echo $featureImg; ?>"></a></figure></center></div>
						<div class="box-article-title"><a href="<?php echo $permalink ?>"><?php echo $fullname; ?></a></div>
						<div class="margin-top-5"><b>Lượt xem :</b> 50</div>
						<div class="box-article-intro"><?php echo $intro; ?></div>                        
					</div>
					<?php
					if($k%3 ==0 || $k==$count){
						echo '<div class="clr"></div>';
					}
					$k++;
				}
			}			
			?>			
		</div>
		<?php 
		if(count($items) > 0){
			echo $pagination->showPagination();
		}  
		?>
</form>