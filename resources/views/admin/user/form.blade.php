@extends("admin.master")
@section("content")
<?php 
$linkCancel             =   route('admin.'.$controller.'.getList');
$linkSave               =   route('admin.'.$controller.'.save');
$str_disabled           =   "";
if($task == "edit"){
    $str_disabled       =   "disabled";
}
$inputUsername          =   '<input type="text" class="form-control" name="username"  '.$str_disabled.'  id="username"       value="'.@$arrRowData['username'].'">'; 
$inputEmail             =   '<input type="text" class="form-control" name="email"       id="email"          value="'.@$arrRowData['email'].'">'; 
$inputPassword          =   '<input type="password" id="password" name="password" class="form-control" />';
$inputConfirmPassword   =   '<input type="password" id="confirm_password" name="confirm_password" class="form-control"  />';
$status                 =   (count($arrRowData) > 0) ? @$arrRowData['status'] : 1 ;
$arrStatus              =   array(-1 => '- Select status -', 1 => 'Publish', 0 => 'Unpublish');  
$ddlStatus              =   cmsSelectbox("status","status","form-control",$arrStatus,$status,"");
$inputFullName          =   '<input type="text" class="form-control" name="fullname"   id="fullname"        value="'.@$arrRowData['fullname'].'">'; 
$ddlGroupMember         =   cmsSelectboxCategory('group_member_id','group_member_id', 'form-control',@$arrGroupMember,@$arrRowData['group_member_id'],"");
$inputSortOrder         =   '<input type="text" class="form-control" name="sort_order" id="sort_order"     value="'.@$arrRowData['sort_order'].'">';
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
                        <label class="col-md-3 control-label"><b>Username</b></label>
                        <div class="col-md-9">
                            <?php echo $inputUsername; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>   
                    <div class="form-group col-md-6">
                        <label class="col-md-3 control-label"><b>Email</b></label>
                        <div class="col-md-9">
                            <?php echo $inputEmail; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div>      
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="col-md-3 control-label"><b>Password</b></label>
                        <div class="col-md-9">
                            <?php echo $inputPassword; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>   
                    <div class="form-group col-md-6">
                        <label class="col-md-3 control-label"><b>Password confirm</b></label>
                        <div class="col-md-9">
                            <?php echo $inputConfirmPassword; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div>       
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="col-md-3 control-label"><b>Name</b></label>
                        <div class="col-md-9">
                            <?php echo $inputFullName; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>   
                    <div class="form-group col-md-6">
                        <label class="col-md-3 control-label"><b>Group</b></label>
                        <div class="col-md-9">                            
                            <?php echo $ddlGroupMember; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div> 
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="col-md-3 control-label"><b>Sort order</b></label>
                        <div class="col-md-9">
                            <?php echo $inputSortOrder; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>   
                    <div class="form-group col-md-6">
                        <label class="col-md-3 control-label"><b>status</b></label>
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
        var username             =   $("#username");
        var email                =   $("#email");
        var fullname             =   $("#fullname");
        var password             =   $("#password");        
        var group_member_id      =   $("#group_member_id");
        var sort_order           =   $("#sort_order");
        var status               =   $("#status");
        
        $(username).closest('.form-group').removeClass("has-error");
        $(email).closest('.form-group').removeClass("has-error");
        $(fullname).closest('.form-group').removeClass("has-error");
        $(password).closest('.form-group').removeClass("has-error");
        $(group_member_id).closest('.form-group').removeClass("has-error");
        $(sort_order).closest('.form-group').removeClass("has-error");        
        $(status).closest('.form-group').removeClass("has-error");        

        $(username).closest('.form-group').find('span').empty().hide();
        $(email).closest('.form-group').find('span').empty().hide();
        $(fullname).closest('.form-group').find('span').empty().hide();
        $(password).closest('.form-group').find('span').empty().hide();
        $(group_member_id).closest('.form-group').find('span').empty().hide();
        $(status).closest('.form-group').find('span').empty().hide();        
        $(sort_order).closest('.form-group').find('span').empty().hide();        
    }

    function save(){
        var id=$("#id").val();        
        var username=$("#username").val();
        var email = $("#email").val();
        var password=$("#password").val();
        var confirm_password=$("#confirm_password").val();
        var status=$("#status").val();
        var fullname=$("#fullname").val();
        var group_member_id=$("#group_member_id").val();        
        var sort_order=$("#sort_order").val();        
        var token = $('input[name="_token"]').val();   
        resetErrorStatus();
        var dataItem={
            "id":id,
            "username":username,
            "email":email,
            "password":password,
            "confirm_password":confirm_password,
            "status":status,            
            "fullname":fullname,
            "group_member_id":group_member_id,                        
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
                    if(typeof data_error.username               != "undefined"){
                        $("#username").closest('.form-group').addClass(data_error.username.type_msg);
                        $("#username").closest('.form-group').find('span').text(data_error.username.msg);
                        $("#username").closest('.form-group').find('span').show();                        
                    }
                    if(typeof data_error.email               != "undefined"){
                        $("#email").closest('.form-group').addClass(data_error.email.type_msg);
                        $("#email").closest('.form-group').find('span').text(data_error.email.msg);
                        $("#email").closest('.form-group').find('span').show();                        
                    }
                    if(typeof data_error.fullname               != "undefined"){
                        $("#fullname").closest('.form-group').addClass(data_error.fullname.type_msg);
                        $("#fullname").closest('.form-group').find('span').text(data_error.fullname.msg);
                        $("#fullname").closest('.form-group').find('span').show();                        
                    }                    
                    if(typeof data_error.password                  != "undefined"){
                        $("#password").closest('.form-group').addClass(data_error.password.type_msg);
                        $("#password").closest('.form-group').find('span').text(data_error.password.msg);
                        $("#password").closest('.form-group').find('span').show();                       
                    }
                    if(typeof data_error.group_member_id               != "undefined"){
                        $("#group_member_id").closest('.form-group').addClass(data_error.group_member_id.type_msg);
                        $("#group_member_id").closest('.form-group').find('span').text(data_error.group_member_id.msg);
                        $("#group_member_id").closest('.form-group').find('span').show();                        
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