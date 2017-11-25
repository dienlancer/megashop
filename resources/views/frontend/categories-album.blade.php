<?php 

$strImage= url('/upload/'.WIDTH."x".HEIGHT."-") ;

?>

<h3 class="h_1 title-article">{!! $name !!}</h3>

		<hr />

		<?php 

		$i=1; 

		if(!empty($arrCategoryArticle)){			

			foreach ($arrCategoryArticle as $key => $value) {

			?>

				<div class="col-md-4">

					<div >

						<figure><a href="{!! url('/hoat-dong/'.$value['alias'].'.html') !!}"><img src="<?php echo $strImage . $value['image'] ?>"  /></a></figure>

					</div>

					<div class="item-row-title-category-article"><a class="a_1" href="{!! url('/hoat-dong/'.$value['alias'].'.html') !!}">{!! $value['name'] !!}</a></div>

				</div>			

				<?php			

				if($i%3==0)

	                echo '<div class="clr"></div>';

	            $i++;

			}

		}		

		?>	

