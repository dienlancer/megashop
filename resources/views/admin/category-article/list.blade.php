@extends("admin.master")
@section("content")
<?php 
$linkNew				=	route('admin.'.$controller.'.getForm',['add']);
$linkCancel				=	route('admin.'.$controller.'.getList');
$linkChangeStatus	=	route('admin.'.$controller.'.changeStatus');
$linkUpdateStatusToShow	=	route('admin.'.$controller.'.updateStatus',[1]);
$linkUpdateStatusToHide =	route('admin.'.$controller.'.updateStatus',[0]);
$linkTrash				=	route('admin.'.$controller.'.trash');
$linkSortOrder			=	route('admin.'.$controller.'.sortOrder');
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
							<a href="<?php echo $linkNew; ?>" class="btn green">Add new <i class="fa fa-plus"></i></a> 
							<a href="javascript:void(0)" onclick="javascript:submitForm('<?php echo $linkUpdateStatusToShow; ?>')" class="btn blue">Show <i class="fa fa-eye"></i></a> 
							<a href="javascript:void(0)" onclick="javascript:submitForm('<?php echo $linkUpdateStatusToHide; ?>')" class="btn yellow">Hide <i class="fa fa-eye-slash"></i></a> 
							<a href="javascript:void(0)" onclick="javascript:submitForm('<?php echo $linkSortOrder; ?>')" class="btn grey-cascade">Sort <i class="fa fa-sort"></i></a> 
							<a href="javascript:void(0)" onclick="javascript:trashForm('<?php echo $linkTrash; ?>')" class="btn red">Trash <i class="fa fa-trash"></i></a> 															
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
						<th>Fullname</th>
						<th>Alias</th>		
						<th width="1%">Parent</th>				
						<th width="1%">Image</th>
						<th width="1%">Sort</th>
						<th width="1%">Status</th>							
						<th width="1%">Edit</th>  
						<th width="1%">Delete</th>              
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
							$alias=$value['alias'];
							$image=$value['image'];
							$sort_order=$value['sort_order'];
							$status=$value['status'];
							$edited=$value['edited'];
							$deleted=$value['deleted'];
							?>
							<tr>
								<td><?php echo $checked; ?></td>                
								<td><?php echo $fullname; ?></td>
								<td><?php echo $alias; ?></td>		
								<td><?php echo $parent_fullname; ?></td>				
								<td><?php echo $image; ?></td>
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

