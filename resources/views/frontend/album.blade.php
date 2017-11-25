<?php 

$strImage= url('/upload'); 

$strThumbnail= url('/upload/'.WIDTH."x".HEIGHT."-") ;

?>

<h3 class="h_1 title-article">{!! $name !!}</h3>

		<hr />

		<?php 

		$i=1; 

		if(!empty($arrArticle)){			

			foreach ($arrArticle as $key => $value) {

			?>

				<div class="col-md-4">

					<div >

						<figure><a class="fancybox-effects-d" href="<?php echo $strImage . DS . $value['image'] ?>"><img src="<?php echo $strThumbnail . $value['image'] ?>"  /></a></figure>

					</div>					

				</div>			

				<?php			

				if($i%3==0)

	                echo '<div class="clr"></div>';

	            $i++;

			}

		}		

		?>	

