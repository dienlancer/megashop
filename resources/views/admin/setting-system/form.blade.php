@extends("admin.master")
@section("content")
<?php 

$linkCancel             =   route('admin.'.$controller.'.getList');
$linkSave               =   route('admin.'.$controller.'.save');
$inputFullName          =   '<input type="text" class="form-control" name="fullname"    id="fullname"           value="'.@$arrRowData['fullname'].'">';  
$inputAlias             =   '<input type="text" class="form-control" name="alias"       id="alias"              value="'.@$arrRowData['alias'].'">';  
$data                   =   array();
if(count(@$arrRowData) > 0){
    if(!empty(@$arrRowData)){
        $data                   =   json_decode(@$arrRowData['setting']);
        $data = convertToArray($data);
    }
}
$status                 =   (count($arrRowData) > 0) ? @$arrRowData['status'] : 1 ;
$arrStatus              =   array(-1 => '- Select status -', 1 => 'Publish', 0 => 'Unpublish');  
$ddlStatus              =   cmsSelectbox("status","status","form-control",$arrStatus,$status,"");
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
                    <button onclick="save()" class="btn purple">Lưu <i class="fa fa-floppy-o"></i></button> 
                    <a href="<?php echo $linkCancel; ?>" class="btn green">Thoát <i class="fa fa-ban"></i></a>                    </div>                                                
                </div>
            </div>    
        </div>
    </div>
    <div class="portlet-body form">
        <form class="form-horizontal" role="form" name="frm" enctype="multipart/form-data">
            {{ csrf_field() }}                                  
            <?php echo  $inputID; ?>          
            <div class="form-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Cấu hình</b></label>
                        <div class="col-md-9">
                            <?php echo $inputFullName; ?>
                            <span class="help-block"></span>
                        </div>
                    </div> 
                </div>
                <div class="row">  
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Alias</b></label>
                        <div class="col-md-9">
                            <?php echo $inputAlias; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div>      
                <div class="row">                    
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Sắp xếp</b></label>
                        <div class="col-md-9">
                            <?php echo $inputSortOrder; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>   
                </div>
                <div class="row">  
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Trạng thái</b></label>
                        <div class="col-md-9">                            
                            <?php echo $ddlStatus; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div>    
                <div class="row">
                    <div class="form-group col-md-12">
                        <table class="table table-bordered table-recursive setting-system">
                            <thead>
                                <tr>
                                    <th width="20%">Tên field</th>
                                    <th width="20%">Mã field</th>                                    
                                    <th>Giá trị</th>
                                    <th width="1%"></th>                                
                                </tr>
                            </thead>                            
                            <tbody>
                                <?php 
                                if(count($data) > 0){
                                    for($i=0;$i<count($data);$i++){
                                        $field_name=$data[$i]['field_name'];
                                        $field_code=$data[$i]['field_code'];
                                        $field_value=$data[$i]['field_value'];
                                        ?>
                                        <tr>
                                    <td><input type="text" name="field_name" value="<?php echo $field_name; ?>" class="form-control"></td>
                                    <td><input type="text" name="field_code" value="<?php echo $field_code; ?>" class="form-control"></td>                                    
                                    <td><input type="text" name="field_value" value="<?php echo $field_value; ?>" class="form-control"></td>
                                    <td class="tdcmd"><center><a href="javascript:void(0);"><img src="<?php echo asset('public/admin/images/add.png'); ?>" onclick="addRow(this);" /></a></center></td>                         
                                </tr>
                                        <?php                                        
                                    }
                                }
                                ?>                                
                            </tbody>                            
                        </table>
                    </div> 
                </div>                                                                                                                
            </div>                     
        </form>
    </div>
</div>
<script type="text/javascript" language="javascript">
    function resetErrorStatus(){
        var id                   =   $("#id");
        var fullname             =   $("#fullname");
        var alias                =   $("#alias");                
        var sort_order           =   $("#sort_order");
        var status               =   $("#status");
        
        $(fullname).closest('.form-group').removeClass("has-error"); 
        $(alias).closest('.form-group').removeClass("has-error");        
        $(sort_order).closest('.form-group').removeClass("has-error");
        $(status).closest('.form-group').removeClass("has-error");        

        $(fullname).closest('.form-group').find('span').empty().hide();        
        $(alias).closest('.form-group').find('span').empty().hide();        
        $(sort_order).closest('.form-group').find('span').empty().hide();
        $(status).closest('.form-group').find('span').empty().hide();        
    }   
    function save(){
        var id=$("#id").val();        
        var fullname=$("#fullname").val();
        var alias=$("#alias").val();        
        var status=$("#status").val();        
        var sort_order=$("#sort_order").val();        
        var token = $('input[name="_token"]').val();   
        var tbody=$(".setting-system > tbody")[0];
        var rows=tbody.rows;
        var setting=new Array(rows.length);
        for(var i=0 ; i < rows.length ; i++){
            var field_name=$(rows[i].cells[0]).find('input[name="field_name"]').val();
            var field_code=$(rows[i].cells[1]).find('input[name="field_code"]').val();
            var field_value=$(rows[i].cells[2]).find('input[name="field_value"]').val();
            var row={
                'field_name':field_name,
                'field_code':field_code,
                'field_value':field_value
            };
            setting[i]=row;
        }        
        resetErrorStatus();
        var dataItem={
            "id":id,
            "fullname":fullname,
            "setting":JSON.stringify(setting),
            "alias":alias,              
            "status":status,        
            "sort_order":sort_order,                      
            "_token": token
        };
        console.log(dataItem);
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
                    if(typeof data_error.alias               != "undefined"){
                        $("#alias").closest('.form-group').addClass(data_error.alias.type_msg);
                        $("#alias").closest('.form-group').find('span').text(data_error.alias.msg);
                        $("#alias").closest('.form-group').find('span').show();                        
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
    function addRow(control) {
        var tbody=$(control).closest("tbody")[0];
        var currRow = tbody.rows[tbody.rows.length - 1];
        var cloneRow = currRow.cloneNode(true);
        tbody.appendChild(cloneRow);
        reIndex();
    }
    function removeRow(control) {
        var tbody=$(control).closest("tbody")[0];
        var tr=$(control).closest("tr")[0];
        var index = $(tr).index();         
        tbody.deleteRow(index);
        reIndex();
    }    
    function reIndex() {            
        var tbody=$(".setting-system > tbody")[0];
        var tdcmd = $(tbody).find("td.tdcmd");                    
        for (var i = 0; i < tdcmd.length - 1; i++) {                
            $(tdcmd[i]).html('<center><a href="javascript:void(0)"  onclick="removeRow(this);"><img  src="<?php echo asset("public/admin/images/delete-icon.png"); ?>" /></a></center>');
        }
        $(tdcmd[tdcmd.length - 1]).html('<center><a href="javascript:void(0)"  onclick="addRow(this);"><img  src="<?php echo asset("public/admin/images/add.png"); ?>" /></a></center>');
    }
    $(document).ready(function(){
        reIndex();
    });
</script>
@endsection()            