@extends("admin.master")
@section("content")
<?php 
$linkLoadDataArticle    =   route('admin.article.loadData');
$linkLoadDataProduct    =   route('admin.product.loadData');
$linkCancel             =   route('admin.'.$controller.'.getList');
$linkSave               =   route('admin.'.$controller.'.save');
$linkInsertArticle      =   route('admin.'.$controller.'.insertArticle');
$linkInsertProduct      =   route('admin.'.$controller.'.insertProduct');
$linkSortItems          =   route('admin.'.$controller.'.sortItems');
$linkGetItems           =   route('admin.'.$controller.'.getItems');
$inputFullName          =   '<input type="text" class="form-control" name="fullname"   id="fullname"       value="'.@$arrRowData['fullname'].'">'; 
$ddlCategoryArticle     =   cmsSelectboxCategory('category_article_id','category_article_id', 'form-control', $arrCategoryArticleRecursive, 0,"");
$ddlCategoryProduct     =   cmsSelectboxCategory('category_product_id','category_product_id', 'form-control', $arrCategoryProductRecursive, 0,"");
$inputPosition          =   '<input type="text" class="form-control" name="position"   id="position"       value="'.@$arrRowData['position'].'">'; 
$inputComponent         =   '<input type="hidden" class="form-control" name="component"   id="component"       value="'.@$arrRowData['component'].'">'; 
$status                 =   (count($arrRowData) > 0) ? @$arrRowData['status'] : 1 ;
$arrStatus              =   array(-1 => '- Select status -', 1 => 'Publish', 0 => 'Unpublish');  
$ddlStatus              =   cmsSelectbox("status","status","form-control",$arrStatus,$status,"");
$inputSortOrder         =   '<input type="text" class="form-control" name="sort_order" id="sort_order"     value="'.@$arrRowData['sort_order'].'">';
$id                     =   (count($arrRowData) > 0) ? @$arrRowData['id'] : "" ;
$inputID                =   '<input type="hidden" name="id" id="id" value="'.@$id.'" />'; 
$inputSortJson          =   '<input type="hidden" name="sort_json" id="sort_json" value=\''.@$arrRowData['item_id'].'\' />';
?>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="alert alert-success" id="alert" style="display: none">
                <strong>Success!</strong> 
            </div>
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
        <form class="form-horizontal" role="form" name="frm" enctype="multipart/form-data" >
            {{ csrf_field() }}         
            <?php echo $inputSortJson; ?>
            <?php echo $inputComponent; ?>                           
            <?php echo  $inputID; ?>        
            <div class="form-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label"><b>Tên module</b></label>
                        <div class="col-md-10">
                            <?php echo $inputFullName; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
                <div class="row">   
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label"><b>Vị trí trong theme</b></label>
                        <div class="col-md-10">
                            <?php echo $inputPosition; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div>      
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label"><b>Lấy dữ liệu từ</b></label>
                        <div class="col-md-10">
                            <button type="button" class="btn dark btn-outline sbold uppercase btn-article" data-toggle="modal" data-target="#modal-article">ARTICLE</button>
                            <button type="button" class="btn dark btn-outline sbold uppercase btn-product" data-toggle="modal" data-target="#modal-product">PRODUCT</button>
                            <span class="help-block"></span>
                        </div>
                    </div>   
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label"><b>List</b></label>
                        <div class="col-md-10 list">
                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl-item">
                                <thead>
                                    <tr>
                                        <th width="1%"><input type="checkbox" onclick="checkAllAgent(this)"  name="checkall-toggle"></th>                                        
                                        <th>Bài viết - Sản phẩm</th>   
                                        <th width="1%">Hình</th>                                                
                                        <th width="1%">Sắp xếp</th>                                                                                
                                        <th width="1%">Xóa</th>                
                                    </tr>
                                </thead>
                                <tbody>                                                
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
            </div>                      
        </form>
    </div>
</div>
<div class="modal fade category-modal" id="modal-article" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">  
          <b>BÀI VIẾT      </b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>
      <div class="modal-body">
        <form name="frm-article">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-4">
                    <div><b>CHỦ ĐỀ</b>  </div>
                    <div><?php echo $ddlCategoryArticle ; ?></div>
                </div>            
                <div class="col-md-4">
                    <div><b>TÊN BÀI VIẾT</b>  </div>
                    <div><input type="text" class="form-control" name="filter_search"          value=""></div>
                </div>            
                <div class="col-md-4">
                    <div>&nbsp;</div>
                    <div>
                        <button type="button" class="btn dark btn-outline sbold uppercase btn-product" onclick="getListArticle();">Tìm kiếm</button>
                        &nbsp;  
                        <button type="button" class="btn dark btn-outline sbold uppercase btn-product" onclick="insertArticle();">Thêm</button>                      
                    </div>                
                </div>                
            </div>   
            <div class="row margin-top-15">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl-article-module-item">
                        <thead>
                            <tr>
                                <th width="1%"><input type="checkbox" onclick="checkAllAgentArticle(this)"  name="checkall-toggle"></th>                
                                <th width="1%">ID</th>
                                <th>Bài viết</th>
                                <th>Alias</th>
                                <th width="1%">Hình</th>                                
                            </tr>
                        </thead>
                        <tbody>                                                
                        </tbody>
                    </table>
                </div>            
            </div>     
        </form>        
    </div>      
</div>
</div>
</div>
<div class="modal fade category-modal" id="modal-product" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">  
          <b>SẢN PHẨM      </b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>
      <div class="modal-body">
        <form name="frm-product">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-4">
                    <div><b>LOẠI SẢN PHẨM</b>  </div>
                    <div><?php echo $ddlCategoryProduct ; ?></div>
                </div>            
                <div class="col-md-4">
                    <div><b>SẢN PHẨM</b>  </div>
                    <div><input type="text" class="form-control" name="filter_search"          value=""></div>
                </div>            
                <div class="col-md-4">
                    <div>&nbsp;</div>
                    <div>
                        <button type="button" class="btn dark btn-outline sbold uppercase btn-product" onclick="getListProduct();">Tìm kiếm</button>
                        &nbsp;  
                        <button type="button" class="btn dark btn-outline sbold uppercase btn-article" onclick="insertProduct();">Thêm</button>
                    </div>                
                </div>
            </div>   
            <div class="row margin-top-15">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl-product-module-item">
                        <thead>
                            <tr>
                                <th width="1%"><input type="checkbox" onclick="checkAllAgentProduct(this)"  name="checkall-toggle"></th>                
                                <th width="1%">ID</th>
                                <th>Sản phẩm</th>
                                <th>Alias</th>
                                <th width="1%">Hình</th>                                
                                
                            </tr>
                        </thead>
                        <tbody>                                                
                        </tbody>
                    </table>
                </div>            
            </div>     
        </form>        
    </div>      
</div>
</div>
</div>
<script type="text/javascript" language="javascript">
    function checkWithList(this_checkbox){
        var dr = vItemTable.row( $(this_checkbox).closest('tr') ).data();               
        if(parseInt(dr['is_checked']) == 0){
            dr['checked'] ='<input type="checkbox" checked onclick="checkWithList(this)" name="cid" />';
            dr['is_checked'] = 1;
        }else{
            dr['checked'] ='<input type="checkbox" onclick="checkWithList(this)" name="cid" />';
            dr['is_checked'] = 0;
        }
        vItemTable.row( $(this_checkbox).closest('tr') ).data(dr);
    }   
    function checkWithListArticle(this_checkbox){
        var dr = vArticleModuleItemTable.row( $(this_checkbox).closest('tr') ).data();            
        if(parseInt(dr['is_checked']) == 0){
            dr['checked'] ='<input type="checkbox" checked onclick="checkWithListArticle(this)" name="cid" />';
            dr['is_checked'] = 1;
        }else{
            dr['checked'] ='<input type="checkbox" onclick="checkWithListArticle(this)" name="cid" />';
            dr['is_checked'] = 0;
        }
        vArticleModuleItemTable.row( $(this_checkbox).closest('tr') ).data(dr);
    }   
    function checkWithListProduct(this_checkbox){
        var dr = vProductModuleItemTable.row( $(this_checkbox).closest('tr') ).data();            
        if(parseInt(dr['is_checked']) == 0){
            dr['checked'] ='<input type="checkbox" checked onclick="checkWithListProduct(this)" name="cid" />';
            dr['is_checked'] = 1;
        }else{
            dr['checked'] ='<input type="checkbox" onclick="checkWithListProduct(this)" name="cid" />';
            dr['is_checked'] = 0;
        }
        vProductModuleItemTable.row( $(this_checkbox).closest('tr') ).data(dr);
    }   
    function getListArticle() {    
        var token = $('form[name="frm-article"] > input[name="_token"]').val(); 
        var category_article_id=$('#category_article_id').val();
        var filter_search=$('form[name="frm-article"] input[name="filter_search"]').val();
        var dataItem={            
            '_token': token,
            'filter_search':filter_search,
            'category_article_id':category_article_id            
        };
        $.ajax({
            url: '<?php echo $linkLoadDataArticle; ?>',
            type: 'POST', 
            data: dataItem,
            success: function (data, status, jqXHR) {                  
                
                vArticleModuleItemTable.clear().draw();
                vArticleModuleItemTable.rows.add(data).draw();
                spinner.hide();
            },
            beforeSend  : function(jqXHR,setting){
                spinner.show();
            },
        });
    }      
    function getListProduct() {    
        var token = $('form[name="frm-product"] > input[name="_token"]').val(); 
        var category_product_id=$('#category_product_id').val();
        var filter_search=$('form[name="frm-product"] input[name="filter_search"]').val();
        var dataItem={            
            '_token': token,
            'filter_search':filter_search,
            'category_product_id':category_product_id        
        };
        $.ajax({
            url: '<?php echo $linkLoadDataProduct; ?>',
            type: 'POST', 
            data: dataItem,
            success: function (data, status, jqXHR) {                                  
                vProductModuleItemTable.clear().draw();
                vProductModuleItemTable.rows.add(data).draw();
                spinner.hide();
            },
            beforeSend  : function(jqXHR,setting){
                spinner.show();
            },
        });
    }     
    function insertArticle(){
        var dt      =   vArticleModuleItemTable.data();        
        var str_id  =   "";     
        for(var i=0;i<dt.length;i++){
            var dr=dt[i];
            if(dr.is_checked==1){
                var id=(dr.id).replace('<center>','');
                id=id.replace('</center>','');
                str_id +=id+",";      
            }
        }
        
        if(str_id == ''){
            alert('Vui lòng chọn ít nhất một phần tử');    
        }else{
            var token = $('form[name="frm-article"] > input[name="_token"]').val(); 
            var dataItem ={   
                'str_id':str_id,    
                '_token': token
            };      
            $.ajax({
                url: '<?php echo $linkInsertArticle; ?>',
                type: 'POST',                        
                data: dataItem,
                success: function (data, status, jqXHR) {   
                    var dataItemTable=vItemTable.data();
                    if(dataItemTable.length > 0){
                        var result=1;   
                        for(var j=0;j<data.length;j++){                                                                             
                            for(var k=0;k<dataItemTable.length;k++){                                                                
                                if(parseInt(data[j].id) == parseInt(dataItemTable[k]['id'])){
                                    result=0;                                       
                                }                    
                            }                            
                        }
                        if(result==1){                                
                            vItemTable.rows.add(data).draw();
                        }else{
                            alert('Item is existed');
                        }
                    }else{
                        vItemTable.rows.add(data).draw();
                    }
                    spinner.hide();
                    $('#component').val('article');
                    $('#modal-article').modal('hide');                  
                },
                beforeSend  : function(jqXHR,setting){
                    spinner.show();
                },
            });
        }             
    }
    function insertProduct(){
        var dt      =   vProductModuleItemTable.data();        
        var str_id  =   "";     
        for(var i=0;i<dt.length;i++){
            var dr=dt[i];
            if(dr.is_checked==1){
                var id=(dr.id).replace('<center>','');
                id=id.replace('</center>','');
                str_id +=id+",";      
            }
        }        
        if(str_id == ''){
            alert('Vui lòng chọn ít nhất một phần tử');    
        }else{
            var token = $('form[name="frm-product"] > input[name="_token"]').val(); 
            var dataItem ={   
                'str_id':str_id,    
                '_token': token
            };      
            $.ajax({
                url: '<?php echo $linkInsertProduct; ?>',
                type: 'POST',                        
                data: dataItem,
                success: function (data, status, jqXHR) { 
                    var dataItemTable=vItemTable.data();
                    if(dataItemTable.length > 0){
                        var result=1;   
                        for(var j=0;j<data.length;j++){                                                                             
                            for(var k=0;k<dataItemTable.length;k++){                                                                
                                if(parseInt(data[j].id) == parseInt(dataItemTable[k]['id'])){
                                    result=0;                                       
                                }                    
                            }                            
                        }
                        if(result==1){                                
                            vItemTable.rows.add(data).draw();
                        }else{
                            alert('Item is existed');
                        }
                    }else{
                        vItemTable.rows.add(data).draw();
                    }
                    spinner.hide();
                    $('#component').val('product');
                    $('#modal-product').modal('hide');                  
                },
                beforeSend  : function(jqXHR,setting){
                    spinner.show();
                },
            });
        }             
    }
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
        var item_id=$('#sort_json').val();

        var menu_id=$("#menu_id").val();
        var position=$("#position").val();          
        var component=$('#component').val();
        var status=$("#status").val();        
        var sort_order=$("#sort_order").val();        
        var token = $('form[name="frm"] > input[name="_token"]').val(); 
        resetErrorStatus();
        var dataItem={
            "id":id,
            "fullname":fullname,
            "item_id":item_id,
            "menu_id":menu_id,
            "position":position,    
            "component":component,
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
                    if(typeof data_error.item_id               != "undefined"){
                        alert(data_error.item_id.msg);
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
    function sort(){
        var tbody=$('div.list > div.dataTables_wrapper > div.table-scrollable > table > tbody');        
        var rows=tbody[0].rows;
        var classname= $(rows[0].cells[0]).attr('class');        
        if(classname == 'dataTables_empty'){
            alert('Vui lòng chọn ít nhất một phần tử');
            return false;
        }
        var data=new Array(rows.length);
        for(var i=0;i<rows.length;i++){
            var row=rows[i];
            var cell_sort_order=row.cells[3];
            var input_sort_order=$(cell_sort_order).find('input[name="sort_order"]');
            var id=parseInt($(input_sort_order).attr('sort_order_id')) ;
            var sort_order_text=$(input_sort_order).val();
            var fullname=$(row.cells[1]).text();
            var image=$(row.cells[2]).html();
            var checked=$(row.cells[0]).html();
            var deleted=$(row.cells[4]).html();
            var sort_order=$(row.cells[3]).html();
            var item={
                'checked':checked,
                'is_checked':0,
                'id':id,
                'fullname':fullname,
                'image':image,
                'sort_order':sort_order,
                'sort_order_text':sort_order_text,
                'deleted':deleted
            };                        
            data[i]=item;
        }
        var data_sort=JSON.stringify(data);
        var token = $('form[name="frm"] > input[name="_token"]').val(); 
        var dataItem={
            'data_sort' : data_sort,
            "_token": token
        };
        $.ajax({
            url: '<?php echo $linkSortItems; ?>',
            type: 'POST',                        
            data: dataItem,
            success: function (data, status, jqXHR) {                   
                vItemTable.clear().draw();
                vItemTable.rows.add(data.data_2).draw();                
                $('form[name="frm"] > input[name="sort_json"]').empty();
                $('form[name="frm"] > input[name="sort_json"]').val(JSON.stringify(data.data_1));
                spinner.hide();                
            },
            beforeSend  : function(jqXHR,setting){
                spinner.show();
            },
        });  
    }
    function trash(){
        var xac_nhan = 0;
        var msg="Bạn có muốn xóa ?";
        if(window.confirm(msg)){ 
            xac_nhan = 1;
        }
        if(xac_nhan  == 0){
            return false;   
        }        
        var tbody=$('div.list > div.dataTables_wrapper > div.table-scrollable > table > tbody');        
        var rows=tbody[0].rows;
        var classname= $(rows[0].cells[0]).attr('class');        
        if(classname == 'dataTables_empty'){
            alert('Vui lòng chọn ít nhất một phần tử');
            return false;
        }
        for(var i=0;i<rows.length;i++){
            var row=rows[i];
            var input_checkbox=$(row.cells[0]).find('input[type="checkbox"][name="cid"]');
            if($(input_checkbox).is(':checked')){                
                vItemTable.row(row).remove().draw();        
            }                        
        }       
        $("form[name='frm'] > input[name='checkall-toggle']").prop("checked",false);
    }    
    function deleteItem(ctrl){
        var xac_nhan = 0;
        var msg="Bạn có muốn xóa ?";
        if(window.confirm(msg)){ 
            xac_nhan = 1;
        }
        if(xac_nhan  == 0){
            return false;   
        }
        var tr=$(ctrl).closest('tr');
        vItemTable.row(tr).remove().draw();        
    }
    function getItems(){
        var id          =   $('form[name="frm"] > input[name="id"]').val();        
        var token       =   $('form[name="frm"] > input[name="_token"]').val(); 
        var dataItem={
            'id' : id,            
            '_token': token
        };
        $.ajax({
            url: '<?php echo $linkGetItems; ?>',
            type: 'POST',                        
            data: dataItem,
            success: function (data, status, jqXHR) {  
                if(data.length > 0){
                    vItemTable.clear().draw();
                    vItemTable.rows.add(data).draw();                                
                }                                 
                spinner.hide();                
            },
            beforeSend  : function(jqXHR,setting){
                spinner.show();
            },
        });  
    }
    $(document).ready(function(){
        vItemTable.clear().draw();
        var sort_button='<div class="sort-button"><a href="javascript:void(0)" onclick="sort();" class="btn dark btn-outline sbold uppercase">Sort <i class="fa fa-sort"></i></a></div>';
        var trash_button='<div class="sort-button"><a href="javascript:void(0)" onclick="trash();" class="btn dark btn-outline sbold uppercase">Trash <i class="fa fa-trash"></i></a></div>';
        $('div.list > div.dataTables_wrapper > div:first-child > div:nth-child(2)').append(sort_button);
        $('div.list > div.dataTables_wrapper > div:first-child > div:nth-child(2)').append(trash_button);
        getListArticle();
        getListProduct();
        getItems();
    });
</script>
@endsection()            