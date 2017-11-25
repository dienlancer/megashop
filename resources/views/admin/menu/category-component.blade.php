@extends("admin.master")
@section("content")
<form class="form-horizontal" role="form" method="POST" name="frm" class="frm"  >
	<input type="hidden" name="filter_page" value="1">     	
	{{ csrf_field() }}    		
	<div class="portlet light bordered">
		<div class="portlet-title">			
			<div class="caption font-dark">
				<i class="{{$icon}}"></i>
				<span class="caption-subject bold uppercase">{{$title}}</span>
			</div>     
			<div class="actions">
				<div class="table-toolbar">
					<div class="row">
						<div class="col-md-12">						
																					
						</div>                                                
					</div>
				</div>    
			</div>                                 
		</div>
		<div class="portlet-body">		
			<table class="table table-bordered table-recursive">
				<thead>
					<tr>						         
						<th>Chủ đề - Loại sản phẩm</th>						
						<th width="30%">Bậc cha</th>				
						<th width="1%">Image</th>
						<th width="1%">Sắp xếp</th>												
					</tr>
				</thead>
				<tbody> 
				<?php 
					if(count($data) > 0){
						foreach($data as $key => $value){														
							$fullname=$value['fullname'];							
							$parent_fullname=$value['parent_fullname'];							
							$image=$value['image'];
							$sort_order=$value['sort_order'];							
							?>
							<tr>								
								<td><?php echo $fullname; ?></td>								
								<td><?php echo $parent_fullname; ?></td>				
								<td><?php echo $image; ?></td>
								<td><?php echo $sort_order; ?></td>								
							</tr>
							<?php
						}
					}
				?>				                                               
				</tbody>
			</table>	
			<?php echo $pagination->showPagination();?>		
		</div>
	</div>
</form>
@endsection()         

