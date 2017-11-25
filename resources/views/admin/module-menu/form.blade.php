@extends("admin.master")
@section("content")
<?php 
$linkCancel             =   route('admin.'.$controller.'.getList');
$linkSave               =   route('admin.'.$controller.'.save');
$inputFullName          =   '<input type="text" class="form-control" name="fullname"   id="fullname"       value="'.@$arrRowData['fullname'].'">'; 
$ddlMenuType            =   cmsSelectboxCategory('menu_type_id','menu_type_id', 'form-control',$arrMenuType,@$arrRowData['menu_type_id'],"");
$inputPosition          =   '<input type="text" class="form-control" name="position"   id="position"       value="'.@$arrRowData['position'].'">'; 
$status                 =   (count($arrRowData) > 0) ? @$arrRowData['status'] : 1 ;
$arrStatus              =   array(-1 => '- Select status -', 1 => 'Publish', 0 => 'Unpublish');  
$ddlStatus              =   cmsSelectbox("status","status","form-control",$arrStatus,$status,"");
$inputSortOrder         =   '<input type="text" class="form-control" name="sort_order" id="sort_order"     value="'.@$arrRowData['sort_order'].'">';
$ddlMenu                =   cmsSelectboxMenuMultiple('menu_id','menu_id[]', 'form-control',@$arrMenuRecursive,@$arrModMenuType,"");
$id                     =   (count($arrRowData) > 0) ? @$arrRowData['id'] : "" ;
$inputID                =   '<input type="hidden" name="id" id="id" value="'.@$id.'" />'; 
?>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="{{$icon}}"></i>
            <span class="caption-subject font-dark sbold uppercase">{{$title}}</span>
        </div>
        <div class="actions">
           <div class="table-toolbar">
            <div class="row">
                <div class="col-md-12">
                    <button onclick="save()" class="btn purple">Save new <i class="fa fa-floppy-o"></i></button> 
                    <a href="<?php echo $linkCancel; ?>" class="btn green">Cancel <i class="fa fa-ban"></i></a>                    </div>                                                
                </div>
            </div>    
        </div>
    </div>
    <div class="portlet-body form">
        <form class="form-horizontal" role="form" enctype="multipart/form-data">
            <div class="form-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="col-md-3 control-label"><b>Name</b></label>
                        <div class="col-md-9">
                            <?php echo $inputFullName; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>   
                    <div class="form-group col-md-6">
                        <label class="col-md-3 control-label"><b>Position</b></label>
                        <div class="col-md-9">
                            <?php echo $inputPosition; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div>      
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="col-md-3 control-label"><b>MenuType</b></label>
                        <div class="col-md-9">
                            <?php echo $ddlMenuType; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>   
                    <div class="form-group col-md-6">
                        <label class="col-md-3 control-label"><b>Menu</b></label>
                        <div class="col-md-9">
                            <?php echo $ddlMenu; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>   
                </div>       
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="col-md-3 control-label"><b>Sort</b></label>
                        <div class="col-md-9">
                            <?php echo $inputSortOrder; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>   
                    <div class="form-group col-md-6">
                        <label class="col-md-3 control-label"><b>Status</b></label>
                        <div class="col-md-9">                            
                            <?php echo $ddlStatus; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div>                                                              
            </div>  
            <div class="form-actions noborder">
                {{ csrf_field() }}                                        
                <?php echo  $inputID; ?>                      
            </div>                  
        </form>
    </div>
</div>
<script type="text/javascript" language="javascript">
    function resetErrorStatus(){
        var id                   =   $("#id");
        var fullname             =   $("#fullname");        
        var sort_order           =   $("#sort_order");
        var status               =   $("#status");
        
        $(fullname).closest('.form-group').removeClass("has-error");        
        $(sort_order).closest('.form-group').removeClass("has-error");
        $(status).closest('.form-group').removeClass("has-error");        

        $(fullname).closest('.form-group').find('span').empty().hide();        
        $(sort_order).closest('.form-group').find('span').empty().hide();
        $(status).closest('.form-group').find('span').empty().hide();        
    }   
    function save(){
        var id=$("#id").val();        
        var fullname=$("#fullname").val();
        var menu_type_id=$("#menu_type_id").val();        
        var menu_id=$("#menu_id").val();
        var position=$("#position").val();    
        var status=$("#status").val();        
        var sort_order=$("#sort_order").val();        
        var token = $('input[name="_token"]').val();   
        resetErrorStatus();
        var dataItem={
            "id":id,
            "fullname":fullname,
            "menu_type_id":menu_type_id,
            "menu_id":menu_id,
            "position":position,    
            "status":status,        
            "sort_order":sort_order,            
            "_token": token
        };
        $.ajax({
            url: '<?php echo $linkSave; ?>',
            type: 'POST',
            data: dataItem,
            async: false,
            success: function (data) {
                if(data.checked==true){
                    window.location.href = "<?php echo $linkCancel; ?>";
                }else{
                    var data_error=data.error;
                    if(typeof data_error.fullname               != "undefined"){
                        $("#fullname").closest('.form-group').addClass(data_error.fullname.type_msg);
                        $("#fullname").closest('.form-group').find('span').text(data_error.fullname.msg);
                        $("#fullname").closest('.form-group').find('span').show();                        
                    }                    
                    if(typeof data_error.sort_order               != "undefined"){
                        $("#sort_order").closest('.form-group').addClass(data_error.sort_order.type_msg);
                        $("#sort_order").closest('.form-group').find('span').text(data_error.sort_order.msg);
                        $("#sort_order").closest('.form-group').find('span').show();                        
                    }
                    if(typeof data_error.status               != "undefined"){
                        $("#status").closest('.form-group').addClass(data_error.status.type_msg);
                        $("#status").closest('.form-group').find('span').text(data_error.status.msg);
                        $("#status").closest('.form-group').find('span').show();

                    }                    
                }
                spinner.hide();
            },
            error : function (data){
                spinner.hide();
            },
            beforeSend  : function(jqXHR,setting){
                spinner.show();
            },
        });
    }
</script>
@endsection()            