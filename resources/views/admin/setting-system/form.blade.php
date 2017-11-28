@extends("admin.master")
@section("content")
<?php 

$linkCancel             =   route('admin.'.$controller.'.getList');
$linkSave               =   route('admin.'.$controller.'.save');

$inputFullName          =   '<input type="text" class="form-control" name="fullname"    id="fullname"        value="'.@$arrRowData['fullname'].'">';  
$inputAlias             =   '<input type="text" class="form-control" name="alias"      id="alias"        value="'.@$arrRowData['alias'].'">';  
$inputArticlePerpage          =   '<input type="text" class="form-control" name="article_perpage"    id="article_perpage"        value="'.@$arrRowData['article_perpage'].'">';
$inputProductPerpage          =   '<input type="text" class="form-control" name="product_perpage"    id="product_perpage"        value="'.@$arrRowData['product_perpage'].'">';
$inputProductWidth          =   '<input type="text" class="form-control" name="product_width"    id="product_width"        value="'.@$arrRowData['product_width'].'">';    
$inputProductHeight          =   '<input type="text" class="form-control" name="product_height"    id="product_height"        value="'.@$arrRowData['product_height'].'">';   
$inputCurrencyUnit          =   '<input type="text" class="form-control" name="currency_unit"    id="currency_unit"        value="'.@$arrRowData['currency_unit'].'">';  
$inputSmtpHost          =   '<input type="text" class="form-control" name="smtp_host"    id="smtp_host"        value="'.@$arrRowData['smtp_host'].'">';  
$inputSmtpPort          =   '<input type="text" class="form-control" name="smtp_port"    id="smtp_port"        value="'.@$arrRowData['smtp_port'].'">';  
$inputEncription          =   '<input type="text" class="form-control" name="encription"    id="encription"        value="'.@$arrRowData['encription'].'">';  

$status                 =   (count($arrRowData) > 0) ? @$arrRowData['authentication'] : 1 ;
$arrStatus              =   array(-1 => '- Select status -', 1 => 'Publish', 0 => 'Unpublish');  
$ddlAuthentication              =   cmsSelectbox("authentication","authentication","form-control",$arrStatus,$status,"");


$inputSmtpUsername          =   '<input type="text" class="form-control" name="smtp_username"    id="smtp_username"        value="'.@$arrRowData['smtp_username'].'">';  
$inputSmtpPassword          =   '<input type="password" class="form-control" name="smtp_password"    id="smtp_password"        value="'.@$arrRowData['smtp_password'].'">';  
$inputEmailFrom          =   '<input type="text" class="form-control" name="email_from"    id="email_from"        value="'.@$arrRowData['email_from'].'">';$inputEmailTo          =   '<input type="text" class="form-control" name="email_to"    id="email_to"        value="'.@$arrRowData['email_to'].'">'; 
$inputFromName          =   '<input type="text" class="form-control" name="from_name"    id="from_name"        value="'.@$arrRowData['from_name'].'">';     
$inputToName          =   '<input type="text" class="form-control" name="to_name"    id="to_name"        value="'.@$arrRowData['to_name'].'" />';  
$inputContactPhone          =   '<input type="text" class="form-control" name="contacted_phone"    id="contacted_phone"        value="'.@$arrRowData['contacted_phone'].'">';  
$inputAddress          =   '<input type="text" class="form-control" name="address"    id="address"        value="'.@$arrRowData['address'].'">';  
$inputWebsite          =   '<input type="text" class="form-control" name="website"    id="website"        value="'.@$arrRowData['website'].'">';  
$inputTelephone          =   '<input type="text" class="form-control" name="telephone"    id="telephone"        value="'.@$arrRowData['telephone'].'">';  
$inputOpenedTime          =   '<input type="text" class="form-control" name="opened_time"    id="opened_time"        value="'.@$arrRowData['opened_time'].'">';  
$inputOpenedDate          =   '<input type="text" class="form-control" name="opened_date"    id="opened_date"        value="'.@$arrRowData['opened_date'].'">';  
$inputContactedName          =   '<input type="text" class="form-control" name="contacted_name"    id="contacted_name"        value="'.@$arrRowData['contacted_name'].'">';  
$inputFacebookUrl          =   '<input type="text" class="form-control" name="facebook_url"    id="facebook_url"        value="'.@$arrRowData['facebook_url'].'">';  
$inputTwitterUrl          =   '<input type="text" class="form-control" name="twitter_url"    id="twitter_url"        value="'.@$arrRowData['twitter_url'].'">';  
$inputGooglePlus          =   '<input type="text" class="form-control" name="google_plus"    id="google_plus"        value="'.@$arrRowData['google_plus'].'">';  
$inputYoutubeUrl          =   '<input type="text" class="form-control" name="youtube_url"    id="youtube_url"        value="'.@$arrRowData['youtube_url'].'">';  
$inputInstagramUrl          =   '<input type="text" class="form-control" name="instagram_url"    id="instagram_url"        value="'.@$arrRowData['instagram_url'].'">'; 
$inputPinterestUrl          =   '<input type="text" class="form-control" name="pinterest_url"    id="pinterest_url"        value="'.@$arrRowData['pinterest_url'].'">'; 
$inputSloganAbout          =   '<input type="text" class="form-control" name="slogan_about"    id="slogan_about"        value="'.@$arrRowData['slogan_about'].'">';   
$inputMapUrl           =   '<textarea id="map_url" name="map_url" rows="5" cols="100" class="form-control" >'.@$arrRowData['map_url'].'</textarea>'; 
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
                        <label class="col-md-3 control-label"><b>Số bài viết trên 1 trang</b></label>
                        <div class="col-md-9">
                            <?php echo $inputArticlePerpage; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>  
                </div>                
                <div class="row">  
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Số sản phẩm trên 1 trang</b></label>
                        <div class="col-md-9">
                            <?php echo $inputProductPerpage; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div>    
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Độ rộng hình sản phẩm</b></label>
                        <div class="col-md-9">
                            <?php echo $inputProductWidth; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>   
                </div>
                <div class="row">  
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Độ cao hình bài viết</b></label>
                        <div class="col-md-9">
                            <?php echo $inputProductHeight; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div>    
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Đơn vị tiền tệ</b></label>
                        <div class="col-md-9">
                            <?php echo $inputCurrencyUnit; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>   
                </div>
                <div class="row">  
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Smtp host</b></label>
                        <div class="col-md-9">
                            <?php echo $inputSmtpHost; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div>    
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Smtp port</b></label>
                        <div class="col-md-9">
                            <?php echo $inputSmtpPort; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>   
                </div>
                <div class="row">  
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Encription</b></label>
                        <div class="col-md-9">
                            <?php echo $inputEncription; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Smtp authication</b></label>
                        <div class="col-md-9">
                            <?php echo $ddlAuthentication; ?>
                            <span class="help-block"></span>
                        </div>
                    </div> 
                </div>
                <div class="row">    
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Smtp username</b></label>
                        <div class="col-md-9">
                            <?php echo $inputSmtpUsername; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Smtp password</b></label>
                        <div class="col-md-9">
                            <?php echo $inputSmtpPassword; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>  
                </div>
                <div class="row">   
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Email from</b></label>
                        <div class="col-md-9">
                            <?php echo $inputEmailFrom; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div>    
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Email to</b></label>
                        <div class="col-md-9">
                            <?php echo $inputEmailTo; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>  
                </div>
                <div class="row">   
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>From name</b></label>
                        <div class="col-md-9">
                            <?php echo $inputFromName; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div>    
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>To name</b></label>
                        <div class="col-md-9">
                            <?php echo $inputToName; ?>
                            <span class="help-block"></span>
                        </div>
                    </div> 
                </div>
                <div class="row">    
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Điện thoại liên lạc</b></label>
                        <div class="col-md-9">
                            <?php echo $inputContactPhone; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div>    
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Địa chỉ</b></label>
                        <div class="col-md-9">
                            <?php echo $inputAddress; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>  
                </div>
                <div class="row">   
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Website</b></label>
                        <div class="col-md-9">
                            <?php echo $inputWebsite; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div>    
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Telephone</b></label>
                        <div class="col-md-9">
                            <?php echo $inputTelephone; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>  
                </div>
                <div class="row">   
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Giờ mở cửa</b></label>
                        <div class="col-md-9">
                            <?php echo $inputOpenedTime; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div>    
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Ngày mở cửa</b></label>
                        <div class="col-md-9">
                            <?php echo $inputOpenedDate; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>   
                </div>
                <div class="row">  
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Contacted name</b></label>
                        <div class="col-md-9">
                            <?php echo $inputContactedName; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div>    
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Facebook url</b></label>
                        <div class="col-md-9">
                            <?php echo $inputFacebookUrl; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>   
                </div>
                <div class="row">  
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Twitter url</b></label>
                        <div class="col-md-9">
                            <?php echo $inputTwitterUrl; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div>    
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Google plus</b></label>
                        <div class="col-md-9">
                            <?php echo $inputGooglePlus; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>  
                </div>
                <div class="row">   
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Youtube url</b></label>
                        <div class="col-md-9">
                            <?php echo $inputYoutubeUrl; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div>    
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Instagram url</b></label>
                        <div class="col-md-9">
                            <?php echo $inputInstagramUrl; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>   
                </div>
                <div class="row">  
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Pinterest url</b></label>
                        <div class="col-md-9">
                            <?php echo $inputPinterestUrl; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>     
                </div>    
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Slogan</b></label>
                        <div class="col-md-9">
                            <?php echo $inputSloganAbout; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>  
                </div>
                <div class="row">   
                    <div class="form-group col-md-12">
                        <label class="col-md-3 control-label"><b>Map url</b></label>
                        <div class="col-md-9">
                            <?php echo $inputMapUrl; ?>
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
                                                                                                
            </div>                     
        </form>
    </div>
</div>
<script type="text/javascript" language="javascript">
    function resetErrorStatus(){
        var id                   =   $("#id");
        var fullname             =   $("#fullname");
        var alias                =   $("#alias");        
        var content              =   $("#content");
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
        var article_perpage=$("#article_perpage").val();        
        var product_perpage=$("#product_perpage").val();
        var product_width=$("#product_width").val();
        var product_height=$("#product_height").val();
        var currency_unit=$("#currency_unit").val();
        var smtp_host=$("#smtp_host").val();
        var smtp_port=$("#smtp_port").val();
        var encription=$("#encription").val();
        var authentication=$("#authentication").val();
        var smtp_username=$("#smtp_username").val();
        var smtp_password=$("#smtp_password").val();
        var email_from=$("#email_from").val();
        var email_to=$("#email_to").val();
        var from_name=$("#from_name").val();
        var to_name=$("#to_name").val();
        var contacted_phone=$("#contacted_phone").val();
        var address=$("#address").val();
        var website=$("#website").val();
        var telephone=$("#telephone").val();
        var opened_time=$("#opened_time").val();
        var opened_date=$("#opened_date").val();
        var contacted_name=$("#contacted_name").val();
        var facebook_url=$("#facebook_url").val();
        var twitter_url=$("#twitter_url").val();
        var google_plus=$("#google_plus").val();
        var youtube_url=$("#youtube_url").val();
        var instagram_url=$("#instagram_url").val();
        var pinterest_url=$("#pinterest_url").val();
        var slogan_about=$("#slogan_about").val();
        var map_url=$("#map_url").val();               
        var status=$("#status").val();        
        var sort_order=$("#sort_order").val();        
        var token = $('input[name="_token"]').val();   
        resetErrorStatus();
        var dataItem={
            "id":id,
            "fullname":fullname,
            "alias":alias,  
            "article_perpage":article_perpage,            
            "product_perpage":product_perpage,
            "product_width":product_width,
            "product_height":product_height,
            "currency_unit":currency_unit,
            "smtp_host":smtp_host,
            "smtp_port":smtp_port,
            "encription":encription,
            "authentication":authentication,
            "smtp_username":smtp_username,
            "smtp_password":smtp_password,
            "email_from":email_from,
            "email_to":email_to,
            "from_name":from_name,
            "to_name":to_name,
            "contacted_phone":contacted_phone,
            "address":address,
            "website":website,
            "telephone":telephone,
            "opened_time":opened_time,
            "opened_date":opened_date,
            "contacted_name":contacted_name,
            "facebook_url":facebook_url,
            "twitter_url":twitter_url,
            "google_plus":google_plus,
            "youtube_url":youtube_url,
            "instagram_url":instagram_url,
            "pinterest_url":pinterest_url,
            "slogan_about":slogan_about,
            "map_url":map_url,               
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
</script>
@endsection()            