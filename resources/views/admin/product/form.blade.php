@extends("admin.master")
@section("content")
<?php 
$linkCancel             =   route('admin.'.$controller.'.getList');
$linkSave               =   route('admin.'.$controller.'.save');
$linkUploadFile         =   route('admin.'.$controller.'.uploadFile');
$inputCode              =   '<input type="text" class="form-control" name="code"   id="code"       value="'.@$arrRowData['code'].'">'; 
$inputFullName          =   '<input type="text" class="form-control" name="fullname"   id="fullname"       value="'.@$arrRowData['fullname'].'">';
$inputAlias             =   '<input type="text" class="form-control" name="alias"      id="alias"          value="'.@$arrRowData['alias'].'">'; 
$inputTitle             =   '<textarea id="title" name="title" rows="2" cols="100" class="form-control" >'.@$arrRowData['title'].'</textarea>'; 
$inputMetakeyword             =   '<textarea id="meta_keyword" name="meta_keyword" rows="2" cols="100" class="form-control" >'.@$arrRowData['meta_keyword'].'</textarea>'; 
$inputMetadescription             =   '<textarea id="meta_description" name="meta_description" rows="2" cols="100" class="form-control" >'.@$arrRowData['meta_description'].'</textarea>'; 
$inputPrice             =   '<input type="text" class="form-control" name="price"   id="price"       value="'.@$arrRowData['price'].'">';
$inputSalePrice             =   '<input type="text" class="form-control" name="sale_price"   id="sale_price"       value="'.@$arrRowData['sale_price'].'">';
$status                 =   (count($arrRowData) > 0) ? @$arrRowData['status'] : 1 ;
$arrStatus              =   array(-1 => '- Select status -', 1 => 'Publish', 0 => 'Unpublish');  
$ddlStatus              =   cmsSelectbox("status","status","form-control",$arrStatus,$status,"");
$inputPrice             =   '<input type="text" class="form-control" name="price"   id="price"       value="'.@$arrRowData['price'].'">';
$inputIntro            =   '<textarea id="intro" name="intro" rows="5" cols="100" class="form-control" >'.@$arrRowData['intro'].'</textarea>'; 
$inputDetail            =   '<textarea id="detail" name="detail" rows="5" cols="100" class="form-control" >'.@$arrRowData['detail'].'</textarea>'; 
$inputSortOrder         =   '<input type="text" class="form-control" name="sort_order" id="sort_order"     value="'.@$arrRowData['sort_order'].'">';
$ddlCategoryProduct     =   cmsSelectboxCategoryProductMultiple("category_product_id","category_product_id[]", 'form-control', @$arrCategoryProductRecursive, @$arrProductCategory,"");
$id                     =   (count($arrRowData) > 0) ? @$arrRowData['id'] : "" ;
$inputID                =   '<input type="hidden" name="id" id="id" value="'.@$id.'" />'; 
$picture                =   "";
$strImage               =   "";
$setting= getSettingSystem();
if(count($arrRowData > 0)){
    if(!empty(@$arrRowData["image"])){
        $picture        =   '<div class="col-sm-6"><center>&nbsp;<img src="'.url("/upload/" . $setting["product_width"] . "x" . $setting["product_height"] . "-".@$arrRowData["image"]).'" style="width:100%" />&nbsp;</center></div><div class="col-sm-6"><a href="javascript:void(0);" onclick="deleteImage();"><img src="'.url('public/admin/images/delete-icon.png').'"/></a></div>';                        
        $strImage       =   @$arrRowData["image"];
    }        
}   
$inputPictureHidden     =   '<input type="hidden" name="image_hidden" id="image_hidden" value="'.@$strImage.'" />';
$strTr="";
$str_child_image="";
if(count($arrRowData) > 0){
    $arrProductChildImage=json_decode(@$arrRowData['child_image']);    
    if(count($arrProductChildImage) > 0){
        foreach ($arrProductChildImage as $key => $value) {
            $strTr .= '<tr>';
            $strTr .= '<td align="center" valign="middle"><img src="'.url("/upload/" . $setting["product_width"] . "x" . $setting["product_height"] . "-".@$value).'" width="'.((int)$setting["product_width"]/6).'" /><input type="hidden" name="product_child_image_hidden[]" value="'.$value.'" /></td>';      
            $strTr .= '<td align="center" valign="middle" class="tdcmd"><a href="javascript:void(0)"  onclick="removeRow(this);"><img src="'.url("/public/admin/images/delete-icon.png").'" /></a></td>';
            $strTr .='</tr>';
        }
        $str_child_image=implode(',',$arrProductChildImage);
    }    
}   
$inputChildPictureHidden     =   '<input type="hidden" name="image_child_hidden" id="image_child_hidden" value="'.@$str_child_image.'" />';
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
        <form class="form-horizontal" name="frm" role="form" enctype="multipart/form-data">
            {{ csrf_field() }}          
                <?php 
                    echo $inputPictureHidden; 
                    echo $inputChildPictureHidden;
                    echo $inputID;
                ?>                     
            <div class="form-body">                
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label"><b>Sản phẩm</b></label>
                        <div class="col-md-10">
                            <?php echo $inputFullName; ?>
                            <span class="help-block"></span>
                        </div>
                    </div> 
                </div>
                <div class="row">  
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label"><b>Alias</b></label>
                        <div class="col-md-10">
                            <?php echo $inputAlias; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div>      
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label"><b>Mã sản phẩm</b></label>
                        <div class="col-md-10">
                            <?php echo $inputCode; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>  
                </div>
                <div class="row"> 
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label"><b>Giá</b></label>
                        <div class="col-md-10">
                            <?php echo $inputPrice; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>      
                </div>    
                <div class="row"> 
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label"><b>Giá khuyến mãi</b></label>
                        <div class="col-md-10">
                            <?php echo $inputSalePrice; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>      
                </div>    
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label"><b>Loại sản phẩm</b></label>
                        <div class="col-md-10">
                            <?php echo $ddlCategoryProduct; ?>
                            <span class="help-block"></span>
                        </div>
                    </div> 
                </div>
                <div class="row">                      
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label"><b>Hình</b></label>
                        <div class="col-md-4">
                            <input type="file" id="image" name="image"  />   
                            <div id="picture-area"><?php echo $picture; ?>                      </div>
                            <div class="clr"></div>
                                                
                        </div>
                        <div class="col-md-6">
                            <table class="table-image" id="table-image" border="0" cellpadding="0" cellspacing="0" border="1" width="100%">
                                <thead>
                                    <tr>                                    
                                        <th><center>Thumbnails</center></th>                                  
                                        <th width="1%" ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo $strTr; ?>
                                    <tr>                                    
                                        <td align="center" valign="middle"><input type="file" name="product_child_image[]"></td>
                                        <td align="center" valign="middle" class="tdcmd"><a href="javascript:void(0)"  onclick="addRow(this);"><img  src=" <?php echo url("/public/admin/images/add.png"); ?>" /></a></td>
                                    </tr>
                                </tbody>
                            </table>    
                        </div>
                    </div>     
                </div>       
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label"><b>Sắp xếp</b></label>
                        <div class="col-md-10">
                            <?php echo $inputSortOrder; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>   
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label"><b>Trạng thái</b></label>
                        <div class="col-md-10">                            
                            <?php echo $ddlStatus; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div> 
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label"><b>Tiêu đề</b></label>
                        <div class="col-md-10">
                            <?php echo $inputTitle; ?>
                            <span class="help-block"></span>
                        </div>
                    </div> 
                </div>
                <div class="row">  
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label"><b>Meta keyword</b></label>
                        <div class="col-md-10">
                            <?php echo $inputMetakeyword; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label"><b>Meta description</b></label>
                        <div class="col-md-10">                            
                            <?php echo $inputMetadescription; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>   
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label"><b>Giới thiệu</b></label>
                        <div class="col-md-10">                            
                            <?php echo $inputIntro; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div> 
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label"><b>Chi tiết</b></label>
                        <div class="col-md-10">                            
                            <?php echo $inputDetail; ?>
                            <span class="help-block"></span>
                            <script type="text/javascript" language="javascript">
                                CKEDITOR.replace('detail',{
                                   height:300
                               });
                           </script>
                           <span class="help-block"></span>
                       </div>
                   </div>                       
                </div>                                                               
            </div>                   
        </form>
    </div>
</div>
<script type="text/javascript" language="javascript">
    function resetErrorStatus(){
        var id                   =   $("#id");
        var code                 =   $("#code");
        var fullname             =   $("#fullname");
        var alias                =   $("#alias");        
        var sort_order           =   $("#sort_order");
        var status               =   $("#status");
        
        $(code).closest('.form-group').removeClass("has-error");
        $(fullname).closest('.form-group').removeClass("has-error");        
        $(alias).closest('.form-group').removeClass("has-error");
        $(sort_order).closest('.form-group').removeClass("has-error");
        $(status).closest('.form-group').removeClass("has-error");        

        $(code).closest('.form-group').find('span').empty().hide();
        $(fullname).closest('.form-group').find('span').empty().hide();        
        $(alias).closest('.form-group').find('span').empty().hide();
        $(sort_order).closest('.form-group').find('span').empty().hide();
        $(status).closest('.form-group').find('span').empty().hide();        
    }

    function uploadFileImport(ctrl_image){    
        var token = $('input[name="_token"]').val();       
        var image=ctrl_image;        
        var file_upload=$(image).get(0);
        var files = file_upload.files;
        var file  = files[0];    
        var formdata = new FormData();
        formdata.append("image", file);
        formdata.append("_token", token);
        var ajax = new XMLHttpRequest();        
        ajax.addEventListener("load",  false);        
        ajax.open("POST", "<?php echo $linkUploadFile; ?>");
        ajax.send(formdata);    
    }
    function deleteImage(){
        var xac_nhan = 0;
        var msg="Bạn có muốn xóa ?";
        if(window.confirm(msg)){ 
            xac_nhan = 1;
        }
        if(xac_nhan  == 0){
            return 0;
        }
        $("#picture-area").empty();
        $("input[name='image_hidden']").val("");        
    }
    function save(){
        var id=$("#id").val();        
        var code = $("#code").val();
        var fullname=$("#fullname").val();        
        var alias=$("#alias").val();
        var title=$("#title").val();
        var meta_keyword=$("#meta_keyword").val();
        var meta_description=$("#meta_description").val();
        var category_product_id=$("#category_product_id").val();
        var image = $("#image").val();
        if (image != ''){
            image = image.substr(image.lastIndexOf('\\') + 1);       
        }
        var child_image_ctrl=$("#table-image > tbody").find("input[type='file']");
        var child_image='';
        if(child_image_ctrl.length > 0){
            var arr_child_image=new Array(child_image_ctrl.length);
            for(var i=0;i<child_image_ctrl.length;i++){
                var str_img=$(child_image_ctrl[i]).val();
                str_img = str_img.substr(str_img.lastIndexOf('\\') + 1);       
                arr_child_image[i]=str_img;
            }              
            child_image=arr_child_image.toString();          
        }    
        var image_child_hidden=$("#image_child_hidden").val();
        var image_hidden=$("#image_hidden").val(); 
        var status=$("#status").val();             
        var price=$("#price").val();
        var sale_price=$("#sale_price").val();
        var intro=$("#intro").val(); 
        var detail=CKEDITOR.instances['detail'].getData();        
        var sort_order=$("#sort_order").val();        
        var token = $('input[name="_token"]').val();   
        resetErrorStatus();
        var dataItem={
            "id":id,
            "code":code,
            "fullname":fullname,            
            "alias":alias,
            "title":title,
            "meta_keyword":meta_keyword,
            "meta_description":meta_description,
            "image":image,
            "status":status,                     
            "price":price,
            "sale_price":sale_price,
            "intro":intro,
            "detail":detail,
            "category_product_id":category_product_id,            
            "image_hidden":image_hidden,
            "child_image":child_image,
            "child_image_hidden":image_child_hidden,
            "sort_order":sort_order,
            "status":status,
            "_token": token
        };
        $.ajax({
            url: '<?php echo $linkSave; ?>',
            type: 'POST',
            data: dataItem,
            async: false,
            success: function (data) {
                if(data.checked==true){
                    uploadFileImport($("#image"));                    
                    if(child_image_ctrl.length > 0){
                        for(var i=0;i<child_image_ctrl.length;i++){
                            uploadFileImport(child_image_ctrl[i]);
                        }
                    }                    
                    window.location.href = "<?php echo $linkCancel; ?>";
                }else{
                    var data_error=data.error;
                    if(typeof data_error.code               != "undefined"){
                        $("#code").closest('.form-group').addClass(data_error.code.type_msg);
                        $("#code").closest('.form-group').find('span').text(data_error.code.msg);
                        $("#code").closest('.form-group').find('span').show();                        
                    }   
                    if(typeof data_error.fullname               != "undefined"){
                        $("#fullname").closest('.form-group').addClass(data_error.fullname.type_msg);
                        $("#fullname").closest('.form-group').find('span').text(data_error.fullname.msg);
                        $("#fullname").closest('.form-group').find('span').show();                        
                    }                    
                    if(typeof data_error.alias                  != "undefined"){
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

            var tbody=jQuery(control).closest("tbody")[0];

            var currRow = tbody.rows[tbody.rows.length - 1];

            var cloneRow = currRow.cloneNode(true);

            tbody.appendChild(cloneRow);

            reIndex();

        }

        function removeRow(control) {

            var tbody=jQuery(control).closest("tbody")[0];

            var tr=jQuery(control).closest("tr")[0];
            var image=$(tr).find("input[type='hidden']").val();            
            var image_child_hidden=$("#image_child_hidden").val()            
            var arrImageChild=image_child_hidden.split(',');
            var index=arrImageChild.indexOf(image);
            if (index > -1) {
                arrImageChild.splice(index, 1);
            }
            var str=arrImageChild.toString();
            $("#image_child_hidden").val(str);

            var index = jQuery(tr).index();         

            tbody.deleteRow(index);

            reIndex();

        }

        function reIndex() {            

            var tbody=jQuery(".table-image > tbody")[0];

            var tdcmd = jQuery(tbody).find("td.tdcmd");                    

            for (var i = 0; i < tdcmd.length - 1; i++) {                

               jQuery(tdcmd[i]).html('<a href="javascript:void(0)"  onclick="removeRow(this);"><img  src="<?php echo url("/public/admin/images/delete-icon.png"); ?>" /></a>');

            }

            jQuery(tdcmd[tdcmd.length - 1]).html('<a href="javascript:void(0)"  onclick="addRow(this);"><img  src="<?php echo url("/public/admin/images/add.png"); ?>" /></a>');

        }
</script>
@endsection()            