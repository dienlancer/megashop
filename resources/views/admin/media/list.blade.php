@extends("admin.master")
@section("content")
<?php 
$linkNew			=	route('admin.'.$controller.'.getForm',['add']);
$linkCancel			=	route('admin.'.$controller.'.getList');
$linkLoadData		=	route('admin.'.$controller.'.loadData');
$linkTrash			=	route('admin.'.$controller.'.trash');
$linkDelete			=	route('admin.'.$controller.'.deleteItem');
?>
<form class="form-horizontal" role="form" method="POST" action="{{ $linkTrash }}">	
	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="alert alert-success" id="alert" style="display: none">
				<strong>Success!</strong> 
			</div>
			<div class="caption font-dark">
				<i class="{{$icon}}"></i>
				<span class="caption-subject bold uppercase">{{$title}}</span>
			</div>     
			<div class="actions">
				<div class="table-toolbar">
					<div class="row">
						<div class="col-md-12">						
							<a href="<?php echo $linkNew; ?>" class="btn green">Thêm mới <i class="fa fa-plus"></i></a> 			
							<button onclick="return xacnhanxoa();" type="submit" class="btn red">Xóa<i class="fa fa-trash"></i></button>							
							{{ csrf_field() }}							  								
							<input type="hidden" name="json_id" value="" />
						</div>                                                
					</div>
				</div>    
			</div>                                 
		</div>
		<div class="portlet-body">		
			<?php 
			if(count($arrData) > 0){
				$i=1;
				for ($j=0;$j < count($arrData);$j++) {
					$name=$arrData[$j];					
					$pathFile=base_path("upload/".$name); 					
					$is_file=0;
					if(is_file($pathFile)){
                        $is_file=1;
                    }                    
					?>
					<div class="box-ads">
						<div>
							<center>
								<?php 
								if($is_file==1){
									?>
									<img src="<?php echo url("/public/admin/images/file-icon.png") ?>" />
									<?php
								}else{
									?>
									<img src="<?php echo url("/public/admin/images/folder-icon.png") ?>" />       
									<?php
								}
								?>								
							</center>
						</div>	
						<div class="rowmedia">
							<div class="col-sm-6">
								<center><a href="javascript:void(0)" onclick="deleteItem('<?php echo $name; ?>')" ><img src="<?php echo url('public/admin/images/delete-icon.png'); ?>"></a></center>
							</div>
							<div class="col-sm-6"><center><input type="checkbox" name="cid[]"  value="<?php echo $name; ?>" /></center></div>
							<div class="clr"></div>					
						</div>		
						<div class="title-media"><center><?php echo $name; ?></center></div>		 					
					</div>
					<?php
					if($i%6==0){
						echo '<div class="clr"></div>';
					}                                
                    $i++;
				}
			}
			?>			
		</div>		
	</div>	
</form>
<script type="text/javascript" language="javascript">		
	function deleteItem(id){		
		var xac_nhan = 0;
		var msg="Bạn có muốn xóa ?";
		if(window.confirm(msg)){ 
			xac_nhan = 1;
		}
		if(xac_nhan  == 0)
			return 0;
		var token 	 = $('input[name="_token"]').val();   
		var dataItem ={   
			'id':id,			
			'_token': token
		};
		$.ajax({
			url: '<?php echo $linkDelete; ?>',
			type: 'POST', 			             
			data: dataItem,
			success: function (data, status, jqXHR) {  
				window.location.href = "<?php echo $linkCancel; ?>";
				spinner.hide();
			},
			beforeSend  : function(jqXHR,setting){
				spinner.show();
			},
		});
		$("input[name='checkall-toggle']").prop("checked",false);
	}	
	function xacnhanxoa(){
		var xac_nhan = false;
		var msg="Bạn có muốn xóa ?";
		if(window.confirm(msg)){ 
			xac_nhan = true;
		}
		return xac_nhan;
	}
</script>
@endsection()         

