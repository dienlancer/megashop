@extends("admin.master")
@section("content")
<?php 
$linkGetArticleList		=	route('admin.'.$controller.'.getArticleList');
$ddlCategoryArticle     =   cmsSelectboxCategory('category_article_id','category_article_id', 'form-control', $arrCategoryArticleRecursive, 0,"");
$inputFilterSearch 		=	'<input type="text" class="form-control" name="filter_search"          value="">';
$inputMenuTypeId 		=	'<input type="hidden" class="form-control" id="menu_type_id" name="menu_type_id"          value="'.@$menu_type_id.'">';
?>
<form class="form-horizontal" role="form" name="frm">	
	{{ csrf_field() }}		
	<?php echo $inputMenuTypeId; ?>
	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="alert alert-success" id="alert" style="display: none">
				<strong>Success!</strong> 
			</div>
			<div class="caption font-dark">
				<i class="{{$icon}}"></i>
				<span class="caption-subject bold uppercase">{{$title}}</span>
			</div>     
		</div>
		<div class="row">
                <div class="col-md-4">
                    <div><b>Chủ đề</b>  </div>
                    <div><?php echo $ddlCategoryArticle ; ?></div>
                </div>            
                <div class="col-md-4">
                    <div><b>Bài viết</b>  </div>
                    <div><?php echo $inputFilterSearch; ?></div>
                </div>            
                <div class="col-md-4">
                    <div>&nbsp;</div>
                    <div>
                        <button type="button" class="btn dark btn-outline sbold uppercase btn-product" onclick="getListArticle();">Tìm kiếm</button>                                         
                    </div>                
                </div>                
        </div>   
		<div class="portlet-body">		
			<table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl-article-component">
				<thead>
					<tr>												
						<th>Bài viết</th>						
						<th width="1%">Hình</th>
						<th width="1%">Sắp xếp</th>              
					</tr>
				</thead>
				<tbody>                                                
				</tbody>
			</table>
		</div>
	</div>	
</form>
<script type="text/javascript" language="javascript">	
	function getListArticle() {    
        var token = $('form[name="frm"] > input[name="_token"]').val(); 
        var category_article_id=$('#category_article_id').val();
        var filter_search=$('form[name="frm"] input[name="filter_search"]').val();
        var menu_type_id = $('form[name="frm"] > input[name="menu_type_id"]').val(); 
        var dataItem={            
            '_token': token,
            'filter_search':filter_search,
            'category_article_id':category_article_id,
            'menu_type_id':menu_type_id            
        };
        $.ajax({
            url: '<?php echo $linkGetArticleList; ?>',
            type: 'POST', 
            data: dataItem,
            success: function (data, status, jqXHR) {       
            	vArticleComponentTable.clear().draw();                                   
                vArticleComponentTable.rows.add(data).draw();
                spinner.hide();
            },
            beforeSend  : function(jqXHR,setting){
                spinner.show();
            },
        });
    }   
    $(document).ready(function(){
        vArticleComponentTable.clear().draw();  
        getListArticle();      
    });   
</script>
@endsection()         

