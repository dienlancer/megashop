@extends("admin.master")
@section("content")
<?php 
$linkCategoryArticleComponent           =   route('admin.'.$controller.'.getCategoryArticleComponent',[@$menu_type_id]);
$linkCategoryProductComponent           =   route('admin.'.$controller.'.getCategoryProductComponent',[@$menu_type_id]);
$linkArticleComponent                   =   route('admin.'.$controller.'.getArticleComponent',[@$menu_type_id]);
$linkProductComponent                   =   route('admin.'.$controller.'.getProductComponent',[@$menu_type_id]);
$linkGetForm                            =   route('admin.'.$controller.'.getForm',['add',@$menu_type_id,0,'no-alias']);
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
                </div>                                                
            </div>
        </div>    
    </div>
</div>
    <div class="portlet-body form">
        <form class="form-horizontal" role="form" enctype="multipart/form-data">
            <div class="form-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <center><a class="btn dark btn-outline sbold uppercase btn-component" href="<?php echo $linkCategoryArticleComponent; ?>">CHỦ ĐỀ</a></center>
                    </div>   
                    <div class="form-group col-md-6">
                        <center><a class="btn dark btn-outline sbold uppercase btn-component" href="<?php echo $linkCategoryProductComponent; ?>">LOẠI SẢN PHẨM</a></center>
                    </div>   
                </div> 
                <div class="row">
                    <div class="form-group col-md-6">
                        <center><a class="btn dark btn-outline sbold uppercase btn-component" href="<?php echo $linkArticleComponent; ?>">BÀI VIẾT</a></center> 
                    </div>   
                    <div class="form-group col-md-6">
                        <center><a class="btn dark btn-outline sbold uppercase btn-component" href="<?php echo $linkProductComponent; ?>">SẢN PHẨM</a></center> 
                    </div>   
                </div>  
                <div class="row">
                    <div class="form-group col-md-6">
                        <center><a class="btn dark btn-outline sbold uppercase btn-component" href="<?php echo $linkGetForm; ?>">LINK TÙY BIẾN</a></center> 
                    </div>   
                    <div class="form-group col-md-6">
                        
                    </div>   
                </div>                                                                  
            </div>  
            <div class="form-actions noborder">
                                
            </div>                  
        </form>
    </div>
</div>
@endsection()            