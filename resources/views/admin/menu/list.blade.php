@extends("admin.master")
@section("content")
<?php 
$linkNew				=	route('admin.'.$controller.'.getComponentForm',[@$menu_type_id]);
$linkCancel				=	route('admin.'.$controller.'.getList',@$menu_type_id);
$linkChangeStatus		=	route('admin.'.$controller.'.changeStatus');
$linkUpdateStatusToShow	=	route('admin.'.$controller.'.updateStatus',[1,@$menu_type_id]);
$linkUpdateStatusToHide =	route('admin.'.$controller.'.updateStatus',[0,@$menu_type_id]);
$linkTrash				=	route('admin.'.$controller.'.trash',[@$menu_type_id]);
$linkSortOrder			=	route('admin.'.$controller.'.sortOrder',[@$menu_type_id]);
?>
<form class="form-horizontal" role="form" method="POST" name="frm" class="frm"  >
	<input type="hidden" name="filter_page" value="1">     	
	{{ csrf_field() }}    		
	<div class="portlet light bordered">
		<div class="portlet-title">
			@if(Session::has("message"))
			<div class="alert <?php echo Session::get("message")['type_msg'] ?>" id="alert" >
				<strong>
				 	<?php 
                            	echo Session::get("message")['msg'];
                            ?>
				</strong> 
			</div>                                                                              
            @endif			
			<div class="caption font-dark">
				<i class="{{$icon}}"></i>
				<span class="caption-subject bold uppercase">{{$title}}</span>
			</div>     
			<div class="actions">
				<div class="table-toolbar">
					<div class="row">
						<div class="col-md-12">						
							<a href="<?php echo $linkNew; ?>" class="btn green">Thêm mới <i class="fa fa-plus"></i></a> 
							<a href="javascript:void(0)" onclick="javascript:submitForm('<?php echo $linkUpdateStatusToShow; ?>')" class="btn blue">Hiển thị <i class="fa fa-eye"></i></a> 
							<a href="javascript:void(0)" onclick="javascript:submitForm('<?php echo $linkUpdateStatusToHide; ?>')" class="btn yellow">Ẩn <i class="fa fa-eye-slash"></i></a> 
							<a href="javascript:void(0)" onclick="javascript:submitForm('<?php echo $linkSortOrder; ?>')" class="btn grey-cascade">Sắp xếp <i class="fa fa-sort"></i></a> 
							<a href="javascript:void(0)" onclick="javascript:trashForm('<?php echo $linkTrash; ?>')" class="btn red">Xóa <i class="fa fa-trash"></i></a> 															
						</div>                                                
					</div>
				</div>    
			</div>                                 
		</div>
		<div class="portlet-body">		
			<table class="table table-bordered table-recursive">
				<thead>
					<tr>
						<th width="1%"><input type="checkbox" name="checkall-toggle"></th>           
						<th>Menu</th>
						
						<th>Menu cha</th>				
						
						<th width="10%">Sắp xếp</th>
						<th width="10%">Trạng thái</th>							
						<th width="1%">Sửa</th>  
						<th width="1%">Xóa</th>                     
					</tr>
				</thead>
				<tbody> 
				<?php 
					if(count($data) > 0){
						foreach($data as $key => $value){
							$checked=$value['checked'];
							$id=$value['id'];
							$fullname=$value['fullname'];							
							$parent_fullname=$value['parent_fullname'];
							
							
							$sort_order=$value['sort_order'];
							$status=$value['status'];
							$edited=$value['edited'];
							$deleted=$value['deleted'];
							?>
							<tr>
								<td><?php echo $checked; ?></td>                
								<td><?php echo $fullname; ?></td>
								
								<td><?php echo $parent_fullname; ?></td>				
								
								<td><?php echo $sort_order; ?></td>
								<td><?php echo $status; ?></td>							
								<td><?php echo $edited; ?></td>  
								<td><?php echo $deleted; ?></td>          
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
<script type="text/javascript" language="javascript">
	function changeStatus(id,status){		
		var token = $("form[name='frm']").find("input[name='_token']").val();   
		var dataItem={   
			'id':id,
			'status':status,         
			'_token': token
		};
		$.ajax({
			url: '<?php echo $linkChangeStatus; ?>',
			type: 'POST',     
			data: dataItem,
			success: function (data, status, jqXHR) {   							   		
				var element     = 'a#status-' + data['id'];
                    var classRemove = 'publish';
                    var classAdd    = 'unpublish';
                    if(parseInt(data['status']) ==1){
                        classRemove = 'unpublish';
                        classAdd    = 'publish';
                    }
                    $(element).attr('onclick',data['link']);
                    $(element + ' span').removeClass(classRemove).addClass(classAdd);
                    spinner.hide();
			},
			beforeSend  : function(jqXHR,setting){
				spinner.show();
			},
		});		
		$("input[name='checkall-toggle']").prop("checked",false);
	}
</script>
@endsection()         

