<?php 
function categoryArticleConverter($data=array(),$controller){        
    $result = array();    
    if( count($data) > 0){
        for($i = 0 ;$i < count($data);$i++){
            $edited='<center><a href="'.route('admin.'.$controller.'.getForm',['edit',$data[$i]['id']]).'"><img src="'.asset("/public/admin/images/edit-icon.png").'" /></a></center>';
            $linkDelete=route('admin.category-article.deleteItem',[$data[$i]['id']]);
            $deleted='<center><a onclick="return xacnhanxoa(\'Bạn có chắc chắn muốn xóa ?\');" href="'.$linkDelete.'" ><img src="'.asset("/public/admin/images/delete-icon.png").'" /></a></center>';
            
            $kicked=0;
            if((int)$data[$i]["status"]==1){
                $kicked=0;
            }
            else{
                $kicked=1;
            }
            $status     = '<center>'.cmsStatus((int)$data[$i]["id"],(int)$data[$i]["status"],$kicked).'</center>';
            
            $sort_order = '<center><input name="sort_order['.$data[$i]['id'].']" type="text"  value="'.$data[$i]["sort_order"].'" size="3" style="text-align:center" /></center>';            
            $link_image="";
            $image="";
            if(!empty($data[$i]["image"])){
                $link_image=url("/upload/".$data[$i]["image"]);            
                $image = '<center><img src="'.$link_image.'" style="width:100%" /></center>';
            }          

            $result[$i] = array(
                'checked'                  =>   '<input type="checkbox"  name="cid[]" value="'.$data[$i]["id"].'" />',
                'is_checked'               =>   0,
                "id"                       =>   $data[$i]["id"],
                "fullname"                 =>   $data[$i]["fullname"],
                "parent_fullname"          =>   $data[$i]["parent_fullname"],
                "alias"                    =>   $data[$i]["alias"],
                "parent_id"                =>   $data[$i]["parent_id"],
                "image"                    =>   $image,
                "sort_order"               =>   $sort_order,
                "status"                   =>   $status,
                "created_at"               =>   datetimeConverterVn($data[$i]["created_at"]),
                "updated_at"               =>   datetimeConverterVn($data[$i]["updated_at"]),
                "edited"                   =>   $edited,
                "deleted"                  =>   $deleted
            );
        }
    }
    return $result;
}
function articleConverter($data=array(),$controller){        
    $result = array();
    
    if( count($data) > 0){
        for($i = 0 ;$i < count($data);$i++){
            $edited='<center><a href="'.route('admin.'.$controller.'.getForm',['edit',$data[$i]['id']]).'"><img src="'.asset("/public/admin/images/edit-icon.png").'" /></a></center>';
            $deleted='<center><a href="javascript:void(0)" onclick="deleteItem('.$data[$i]["id"].')"><img src="'.asset("/public/admin/images/delete-icon.png").'" /></a></center>';
            $kicked=0;
            if((int)$data[$i]["status"]==1){
                $kicked=0;
            }
            else{
                $kicked=1;
            }
            $status     = '<center>'.cmsStatus((int)$data[$i]["id"],(int)$data[$i]["status"],$kicked).'</center>';
            $sort_order = '<center><input name="sort_order" id="sort-order-'.$data[$i]["id"].'" sort_order_id="'.$data[$i]["id"].'" onkeyup="setSortOrder(this)" value="'.$data[$i]["sort_order"].'" size="3" style="text-align:center" /></center>';
            $link_image="";
            $image="";
            if(!empty($data[$i]["image"])){
                $link_image=url("/upload/".$data[$i]["image"]);            
                $image = '<center><img src="'.$link_image.'" style="width:100%" /></center>';
            }       
            $id=$data[$i]["id"];       
            $result[$i] = array(
                'checked'                  =>   '<input type="checkbox" onclick="checkWithListArticle(this)" name="cid" value="'.$data[$i]["is_checked"].'" />',
                'is_checked'               =>   0,
                "id"                       =>   $id,
                "fullname"                 =>   $data[$i]["fullname"],                
                "alias"                    =>   $data[$i]["alias"],                
                "image"                    =>   $image,
                "sort_order"               =>   $sort_order,
                "status"                   =>   $status,
                "created_at"               =>   datetimeConverterVn($data[$i]["created_at"]),
                "updated_at"               =>   datetimeConverterVn($data[$i]["updated_at"]),
                "edited"                   =>   $edited,
                "deleted"                  =>   $deleted
            );
        }
    }
    return $result;
}
function menuTypeConverter($data=array(),$controller){        
    $result = array();
    if( count($data) > 0){
        for($i = 0 ;$i < count($data);$i++){
            $edited='<center><a href="'.route('admin.'.$controller.'.getForm',['edit',$data[$i]['id']]).'"><img src="'.asset("/public/admin/images/edit-icon.png").'" /></a></center>';
            $deleted='<center><a href="javascript:void(0)" onclick="deleteItem('.$data[$i]["id"].')"><img src="'.asset("/public/admin/images/delete-icon.png").'" /></a></center>'; 
            $kicked=0;
            if((int)$data[$i]["status"]==1){
                $kicked=0;
            }
            else{
                $kicked=1;
            }
            $status     = '<center>'.cmsStatus((int)$data[$i]["id"],(int)$data[$i]["status"],$kicked).'</center>';           
            $entranced='<center><a href="'.route('admin.menu.getList',[$data[$i]['id']]).'"><img src="'.asset("/public/admin/images/entrance.png").'" /></a></center>';
            $sort_order = '<center><input name="sort_order" id="sort-order-'.$data[$i]["id"].'" sort_order_id="'.$data[$i]["id"].'" onkeyup="setSortOrder(this)" value="'.$data[$i]["sort_order"].'" size="3" style="text-align:center" /></center>';        
            $fullname =$data[$i]["fullname"];

            $result[$i] = array(
                'checked'                  =>   '<input type="checkbox" onclick="checkWithList(this)" name="cid" value="'.$data[$i]["is_checked"].'" />',
                'is_checked'               =>   0,
                "id"                       =>   $data[$i]["id"],
                "fullname"                 =>   $fullname,
                "theme_location"                 =>   $data[$i]["theme_location"],                                
                "sort_order"               =>   $sort_order,                               
                "created_at"               =>   datetimeConverterVn($data[$i]["created_at"]),
                "updated_at"               =>   datetimeConverterVn($data[$i]["updated_at"]),
                "entranced"                =>   $entranced,
                "status"                   =>   $status,
                "edited"                   =>   $edited,
                "deleted"                  =>   $deleted                
            );
        }
    }
    return $result;
}
function menuConverter($data=array(),$controller){        
    $result = array();

    if( count($data) > 0){
        for($i = 0 ;$i < count($data);$i++){            
            $alias='no-alias';
            if(!empty($data[$i]['alias'])){
                $alias=$data[$i]['alias'];
            }            
            $edited='<center><a href="'.route('admin.'.$controller.'.getForm',['edit',$data[$i]['menu_type_id'],$data[$i]['id'],$alias]).'"><img src="'.asset("/public/admin/images/edit-icon.png").'" /></a></center>';
            $linkDelete=route('admin.menu.deleteItem',[$data[$i]['id']]);
            $deleted='<center><a onclick="return xacnhanxoa(\'Bạn có chắc chắn muốn xóa ?\');" href="'.$linkDelete.'" ><img src="'.asset("/public/admin/images/delete-icon.png").'" /></a></center>';
            
            $kicked=0;
            if((int)$data[$i]["status"]==1){
                $kicked=0;
            }
            else{
                $kicked=1;
            }
            $status     = '<center>'.cmsStatus((int)$data[$i]["id"],(int)$data[$i]["status"],$kicked).'</center>';
            
            $sort_order = '<center><input name="sort_order['.$data[$i]['id'].']" type="text"  value="'.$data[$i]["sort_order"].'" size="3" style="text-align:center" /></center>';            
            $result[$i] = array(
                'checked'                  =>   '<input type="checkbox"  name="cid[]" value="'.$data[$i]["id"].'" />',
                'is_checked'               =>   0,
                "id"                       =>   $data[$i]["id"],
                "fullname"                 =>   $data[$i]["fullname"],
                "alias"                    =>   $data[$i]["alias"],
                "level"                    =>   $data[$i]["level"],                               
                "parent_id"                =>   $data[$i]["parent_id"],
                "parent_fullname"          =>   $data[$i]["parent_fullname"],                
                "menu_type_id"             =>   $data[$i]["menu_type_id"],                
                "level"                    =>   $data[$i]["level"],                
                "sort_order"               =>   $sort_order,
                "status"                   =>   $status,
                "created_at"               =>   datetimeConverterVn($data[$i]["created_at"]),
                "updated_at"               =>   datetimeConverterVn($data[$i]["updated_at"]),
                "edited"                   =>   $edited,
                "deleted"                  =>   $deleted
            );
        }
    }
    return $result;
}
function categoryProductConverter($data=array(),$controller){        
    $result = array();
    $setting= getSettingSystem();
    if( count($data) > 0){
        for($i = 0 ;$i < count($data);$i++){
            $edited='<center><a href="'.route('admin.'.$controller.'.getForm',['edit',$data[$i]['id']]).'"><img src="'.asset("/public/admin/images/edit-icon.png").'" /></a></center>';
            $linkDelete=route('admin.category-product.deleteItem',[$data[$i]['id']]);
            $deleted='<center><a onclick="return xacnhanxoa(\'Bạn có chắc chắn muốn xóa ?\');" href="'.$linkDelete.'" ><img src="'.asset("/public/admin/images/delete-icon.png").'" /></a></center>';
            
            $kicked=0;
            if((int)$data[$i]["status"]==1){
                $kicked=0;
            }
            else{
                $kicked=1;
            }
            $status     = '<center>'.cmsStatus((int)$data[$i]["id"],(int)$data[$i]["status"],$kicked).'</center>';
            
            $sort_order = '<center><input name="sort_order['.$data[$i]['id'].']" type="text"  value="'.$data[$i]["sort_order"].'" size="3" style="text-align:center" /></center>';            
            $link_image="";
            $image="";
            if(!empty($data[$i]["image"])){
                $link_image=url("/upload/" . $setting["product_width"] . "x" . $setting["product_height"] . "-".$data[$i]["image"]);            
                $image = '<center><img src="'.$link_image.'" style="width:100%" /></center>';
            }            
            $result[$i] = array(
                'checked'                  =>   '<input type="checkbox"  name="cid[]" value="'.$data[$i]["id"].'" />',
                'is_checked'               =>   0,
                "id"                       =>   $data[$i]["id"],
                "fullname"                 =>   $data[$i]["fullname"],
                "parent_fullname"          =>   $data[$i]["parent_fullname"],
                "alias"                    =>   $data[$i]["alias"],
                "parent_id"                =>   $data[$i]["parent_id"],
                "image"                    =>   $image,
                "sort_order"               =>   $sort_order,
                "status"                   =>   $status,
                "created_at"               =>   datetimeConverterVn($data[$i]["created_at"]),
                "updated_at"               =>   datetimeConverterVn($data[$i]["updated_at"]),
                "edited"                   =>   $edited,
                "deleted"                  =>   $deleted
            );
        }
    }
    return $result;
}
function productConverter($data=array(),$controller){        
    $result = array();
    $setting= getSettingSystem();
    if( count($data) > 0){
        for($i = 0 ;$i < count($data);$i++){
            $edited='<center><a href="'.route('admin.'.$controller.'.getForm',['edit',$data[$i]['id']]).'"><img src="'.asset("/public/admin/images/edit-icon.png").'" /></a></center>';
            $deleted='<center><a href="javascript:void(0)" onclick="deleteItem('.$data[$i]["id"].')"><img src="'.asset("/public/admin/images/delete-icon.png").'" /></a></center>';
            $kicked=0;
            if((int)$data[$i]["status"]==1){
                $kicked=0;
            }
            else{
                $kicked=1;
            }
            $status     = '<center>'.cmsStatus((int)$data[$i]["id"],(int)$data[$i]["status"],$kicked).'</center>';
            $sort_order = '<center><input name="sort_order" id="sort-order-'.$data[$i]["id"].'" sort_order_id="'.$data[$i]["id"].'" onkeyup="setSortOrder(this)" value="'.$data[$i]["sort_order"].'" size="3" style="text-align:center" /></center>';
            $link_image="";
            $image="";
            if(!empty($data[$i]["image"])){
                $link_image=url("/upload/" . $setting["product_width"] . "x" . $setting["product_height"] . "-".$data[$i]["image"]);            
                $image = '<center><img src="'.$link_image.'" style="width:100%" /></center>';
            }          
            $id=$data[$i]["id"];  
            $result[$i] = array(
                'checked'                  =>   '<input type="checkbox" onclick="checkWithListProduct(this)" name="cid" value="'.$data[$i]["is_checked"].'" />',
                'is_checked'               =>   0,
                "id"                       =>   $id,
                "code"                     =>   $data[$i]["code"],
                "fullname"                 =>   $data[$i]["fullname"],                
                "alias"                    =>   $data[$i]["alias"],                
                "image"                    =>   $image,
                "price"                    =>   number_format($data[$i]["price"],0,".",","),
                "sort_order"               =>   $sort_order,
                "status"                   =>   $status,
                "created_at"               =>   datetimeConverterVn($data[$i]["created_at"]),
                "updated_at"               =>   datetimeConverterVn($data[$i]["updated_at"]),
                "edited"                   =>   $edited,
                "deleted"                  =>   $deleted
            );
        }
    }
    return $result;
}
function moduleMenuConverter($data=array(),$controller){        
    $result = array();
    if( count($data) > 0){
        for($i = 0 ;$i < count($data);$i++){
            $edited='<center><a href="'.route('admin.'.$controller.'.getForm',['edit',$data[$i]['id']]).'"><img src="'.asset("/public/admin/images/edit-icon.png").'" /></a></center>';
            $deleted='<center><a href="javascript:void(0)" onclick="deleteItem('.$data[$i]["id"].')"><img src="'.asset("/public/admin/images/delete-icon.png").'" /></a></center>';
            $kicked=0;
            if((int)$data[$i]["status"]==1){
                $kicked=0;
            }
            else{
                $kicked=1;
            }
            $status     = '<center>'.cmsStatus((int)$data[$i]["id"],(int)$data[$i]["status"],$kicked).'</center>';
            $sort_order = '<center><input name="sort_order" id="sort-order-'.$data[$i]["id"].'" sort_order_id="'.$data[$i]["id"].'" onkeyup="setSortOrder(this)" value="'.$data[$i]["sort_order"].'" size="3" style="text-align:center" /></center>';                
            $result[$i] = array(
                'checked'                  =>   '<input type="checkbox" onclick="checkWithList(this)" name="cid" value="'.$data[$i]["is_checked"].'" />',
                'is_checked'               =>   0,
                "id"                       =>   $data[$i]["id"],
                "fullname"                 =>   $data[$i]["fullname"],         
                "position"                 =>   $data[$i]["position"],                                                    
                "sort_order"               =>   $sort_order,
                "status"                   =>   $status,
                "created_at"               =>   datetimeConverterVn($data[$i]["created_at"]),
                "updated_at"               =>   datetimeConverterVn($data[$i]["updated_at"]),
                "edited"                   =>   $edited,
                "deleted"                  =>   $deleted
            );
        }
    }
    return $result;
}
function moduleArticleConverter($data=array(),$controller){        
    $result = array();
    if( count($data) > 0){
        for($i = 0 ;$i < count($data);$i++){
            $edited='<center><a href="'.route('admin.'.$controller.'.getForm',['edit',$data[$i]['id']]).'"><img src="'.asset("/public/admin/images/edit-icon.png").'" /></a></center>';
            $deleted='<center><a href="javascript:void(0)" onclick="deleteItem('.$data[$i]["id"].')"><img src="'.asset("/public/admin/images/delete-icon.png").'" /></a></center>';
            $kicked=0;
            if((int)$data[$i]["status"]==1){
                $kicked=0;
            }
            else{
                $kicked=1;
            }
            $status     = '<center>'.cmsStatus((int)$data[$i]["id"],(int)$data[$i]["status"],$kicked).'</center>';
            $sort_order = '<center><input name="sort_order" id="sort-order-'.$data[$i]["id"].'" sort_order_id="'.$data[$i]["id"].'" onkeyup="setSortOrder(this)" value="'.$data[$i]["sort_order"].'" size="3" style="text-align:center" /></center>';                
            $result[$i] = array(
                'checked'                  =>   '<input type="checkbox" onclick="checkWithList(this)" name="cid" value="'.$data[$i]["is_checked"].'" />',
                'is_checked'               =>   0,
                "id"                       =>   $data[$i]["id"],
                "fullname"                 =>   $data[$i]["fullname"],         
                "position"                 =>   $data[$i]["position"],                                                    
                "sort_order"               =>   $sort_order,
                "status"                   =>   $status,
                "created_at"               =>   datetimeConverterVn($data[$i]["created_at"]),
                "updated_at"               =>   datetimeConverterVn($data[$i]["updated_at"]),
                "edited"                   =>   $edited,
                "deleted"                  =>   $deleted
            );
        }
    }
    return $result;
}
function moduleItemConverter($data=array(),$controller){        
    $result = array();
    if( count($data) > 0){
        for($i = 0 ;$i < count($data);$i++){
            $edited='<center><a href="'.route('admin.'.$controller.'.getForm',['edit',$data[$i]['id']]).'"><img src="'.asset("/public/admin/images/edit-icon.png").'" /></a></center>';
            $deleted='<center><a href="javascript:void(0)" onclick="deleteItem('.$data[$i]["id"].')"><img src="'.asset("/public/admin/images/delete-icon.png").'" /></a></center>';
            $kicked=0;
            if((int)$data[$i]["status"]==1){
                $kicked=0;
            }
            else{
                $kicked=1;
            }
            $status     = '<center>'.cmsStatus((int)$data[$i]["id"],(int)$data[$i]["status"],$kicked).'</center>';
            $sort_order = '<center><input name="sort_order" id="sort-order-'.$data[$i]["id"].'" sort_order_id="'.$data[$i]["id"].'" onkeyup="setSortOrder(this)" value="'.$data[$i]["sort_order"].'" size="3" style="text-align:center" /></center>';                
            $result[$i] = array(
                'checked'                  =>   '<input type="checkbox" onclick="checkWithList(this)" name="cid" value="'.$data[$i]["is_checked"].'" />',
                'is_checked'               =>   0,
                "id"                       =>   $data[$i]["id"],
                "fullname"                 =>   $data[$i]["fullname"],         
                "position"                 =>   $data[$i]["position"],                                                    
                "sort_order"               =>   $sort_order,
                "status"                   =>   $status,
                "created_at"               =>   datetimeConverterVn($data[$i]["created_at"]),
                "updated_at"               =>   datetimeConverterVn($data[$i]["updated_at"]),
                "edited"                   =>   $edited,
                "deleted"                  =>   $deleted
            );
        }
    }
    return $result;
}
function paymentMethodConverter($data=array(),$controller){        
    $result = array();
    if( count($data) > 0){
        for($i = 0 ;$i < count($data);$i++){
            $edited='<center><a href="'.route('admin.'.$controller.'.getForm',['edit',$data[$i]['id']]).'"><img src="'.asset("/public/admin/images/edit-icon.png").'" /></a></center>';
            $deleted='<center><a href="javascript:void(0)" onclick="deleteItem('.$data[$i]["id"].')"><img src="'.asset("/public/admin/images/delete-icon.png").'" /></a></center>';
            $kicked=0;
            if((int)$data[$i]["status"]==1){
                $kicked=0;
            }
            else{
                $kicked=1;
            }
            $status     = '<center>'.cmsStatus((int)$data[$i]["id"],(int)$data[$i]["status"],$kicked).'</center>';
            $sort_order = '<center><input name="sort_order" id="sort-order-'.$data[$i]["id"].'" sort_order_id="'.$data[$i]["id"].'" onkeyup="setSortOrder(this)" value="'.$data[$i]["sort_order"].'" size="3" style="text-align:center" /></center>';                
            $result[$i] = array(
                'checked'                  =>   '<input type="checkbox" onclick="checkWithList(this)" name="cid" value="'.$data[$i]["is_checked"].'" />',
                'is_checked'               =>   0,
                "id"                       =>   $data[$i]["id"],
                "fullname"                 =>   $data[$i]["fullname"],         
                "alias"                 =>   $data[$i]["alias"],                                                    
                "sort_order"               =>   $sort_order,
                "status"                   =>   $status,
                "created_at"               =>   datetimeConverterVn($data[$i]["created_at"]),
                "updated_at"               =>   datetimeConverterVn($data[$i]["updated_at"]),
                "edited"                   =>   $edited,
                "deleted"                  =>   $deleted
            );
        }
    }
    return $result;
}
function settingSystemConverter($data=array(),$controller){        
    $result = array();
    if( count($data) > 0){
        for($i = 0 ;$i < count($data);$i++){
            $edited='<center><a href="'.route('admin.'.$controller.'.getForm',['edit',$data[$i]['id']]).'"><img src="'.asset("/public/admin/images/edit-icon.png").'" /></a></center>';
            $deleted='<center><a href="javascript:void(0)" onclick="deleteItem('.$data[$i]["id"].')"><img src="'.asset("/public/admin/images/delete-icon.png").'" /></a></center>';
            $kicked=0;
            if((int)$data[$i]["status"]==1){
                $kicked=0;
            }
            else{
                $kicked=1;
            }
            $status     = '<center>'.cmsStatus((int)$data[$i]["id"],(int)$data[$i]["status"],$kicked).'</center>';
            $sort_order = '<center><input name="sort_order" id="sort-order-'.$data[$i]["id"].'" sort_order_id="'.$data[$i]["id"].'" onkeyup="setSortOrder(this)" value="'.$data[$i]["sort_order"].'" size="3" style="text-align:center" /></center>';                
            $result[$i] = array(
                'checked'                  =>   '<input type="checkbox" onclick="checkWithList(this)" name="cid" value="'.$data[$i]["is_checked"].'" />',
                'is_checked'               =>   0,
                "id"                       =>   $data[$i]["id"],
                "fullname"                 =>   $data[$i]["fullname"],         
                "alias"                 =>   $data[$i]["alias"],                                                    
                "sort_order"               =>   $sort_order,
                "status"                   =>   $status,
                "created_at"               =>   datetimeConverterVn($data[$i]["created_at"]),
                "updated_at"               =>   datetimeConverterVn($data[$i]["updated_at"]),
                "edited"                   =>   $edited,
                "deleted"                  =>   $deleted
            );
        }
    }
    return $result;
}
function bannerConverter($data=array(),$controller){        
    $result = array();
    if( count($data) > 0){
        for($i = 0 ;$i < count($data);$i++){
            $edited='<center><a href="'.route('admin.'.$controller.'.getForm',['edit',$data[$i]['id']]).'"><img src="'.asset("/public/admin/images/edit-icon.png").'" /></a></center>';
            $deleted='<center><a href="javascript:void(0)" onclick="deleteItem('.$data[$i]["id"].')"><img src="'.asset("/public/admin/images/delete-icon.png").'" /></a></center>';
            $kicked=0;
            if((int)$data[$i]["status"]==1){
                $kicked=0;
            }
            else{
                $kicked=1;
            }
            $status     = '<center>'.cmsStatus((int)$data[$i]["id"],(int)$data[$i]["status"],$kicked).'</center>';
            $sort_order = '<center><input name="sort_order" id="sort-order-'.$data[$i]["id"].'" sort_order_id="'.$data[$i]["id"].'" onkeyup="setSortOrder(this)" value="'.$data[$i]["sort_order"].'" size="3" style="text-align:center" /></center>';                
            $result[$i] = array(
                'checked'                  =>   '<input type="checkbox" onclick="checkWithList(this)" name="cid" value="'.$data[$i]["is_checked"].'" />',
                'is_checked'               =>   0,
                "id"                       =>   $data[$i]["id"],
                "fullname"                 =>   $data[$i]["fullname"],         
                "alias"                 =>   $data[$i]["alias"],                                                    
                "sort_order"               =>   $sort_order,
                "status"                   =>   $status,
                "created_at"               =>   datetimeConverterVn($data[$i]["created_at"]),
                "updated_at"               =>   datetimeConverterVn($data[$i]["updated_at"]),
                "edited"                   =>   $edited,
                "deleted"                  =>   $deleted
            );
        }
    }
    return $result;
}
function groupMemberConverter($data=array(),$controller){        
    $result = array();
    if( count($data) > 0){
        for($i = 0 ;$i < count($data);$i++){
            $edited='<center><a href="'.route('admin.'.$controller.'.getForm',['edit',$data[$i]['id']]).'"><img src="'.asset("/public/admin/images/edit-icon.png").'" /></a></center>';
            $deleted='<center><a href="javascript:void(0)" onclick="deleteItem('.$data[$i]["id"].')"><img src="'.asset("/public/admin/images/delete-icon.png").'" /></a></center>';            
            $sort_order = '<center><input name="sort_order" id="sort-order-'.$data[$i]["id"].'" sort_order_id="'.$data[$i]["id"].'" onkeyup="setSortOrder(this)" value="'.$data[$i]["sort_order"].'" size="3" style="text-align:center" /></center>';                        
            $result[$i] = array(
                'checked'                  =>   '<input type="checkbox" onclick="checkWithList(this)" name="cid" value="'.$data[$i]["is_checked"].'" />',
                'is_checked'               =>   0,
                "id"                       =>   $data[$i]["id"],
                "fullname"                 =>   $data[$i]["fullname"],                                                                
                "sort_order"               =>   $sort_order,                
                "created_at"               =>   datetimeConverterVn($data[$i]["created_at"]),
                "updated_at"               =>   datetimeConverterVn($data[$i]["updated_at"]),
                "edited"                   =>   $edited,
                "deleted"                  =>   $deleted
            );
        }
    }
    return $result;
}
function userConverter($data=array(),$controller){        
    $result = array();
    if( count($data) > 0){
        for($i = 0 ;$i < count($data);$i++){
            $edited='<center><a href="'.route('admin.'.$controller.'.getForm',['edit',$data[$i]['id']]).'"><img src="'.asset("/public/admin/images/edit-icon.png").'" /></a></center>';
            $deleted='<center><a href="javascript:void(0)" onclick="deleteItem('.$data[$i]["id"].')"><img src="'.asset("/public/admin/images/delete-icon.png").'" /></a></center>';            
            $sort_order = '<center><input name="sort_order" id="sort-order-'.$data[$i]["id"].'" sort_order_id="'.$data[$i]["id"].'" onkeyup="setSortOrder(this)" value="'.$data[$i]["sort_order"].'" size="3" style="text-align:center" /></center>';         
            $kicked=0;
            if((int)$data[$i]["status"]==1){
                $kicked=0;
            }
            else{
                $kicked=1;
            }
            $status     = '<center>'.cmsStatus((int)$data[$i]["id"],(int)$data[$i]["status"],$kicked).'</center>';   
            $result[$i] = array(
                'checked'                  =>   '<input type="checkbox" onclick="checkWithList(this)" name="cid" value="'.$data[$i]["is_checked"].'" />',
                'is_checked'               =>   0,
                "id"                       =>   $data[$i]["id"],
                "username"                 =>   $data[$i]["username"],                
                "email"                    =>   $data[$i]["email"],                
                "fullname"                 =>   $data[$i]["fullname"],      
                "group_member_name"        =>   $data[$i]["group_member_name"],          
                "status"                   =>   $status,
                "sort_order"               =>   $sort_order,                
                "created_at"               =>   datetimeConverterVn($data[$i]["created_at"]),
                "updated_at"               =>   datetimeConverterVn($data[$i]["updated_at"]),
                "edited"                   =>   $edited,
                "deleted"                  =>   $deleted
            );
        }
    }
    return $result;
}
function privilegeConverter($data=array(),$controller){        
    $result = array();
    if( count($data) > 0){
        for($i = 0 ;$i < count($data);$i++){
            $edited='<center><a href="'.route('admin.'.$controller.'.getForm',['edit',$data[$i]['id']]).'"><img src="'.asset("/public/admin/images/edit-icon.png").'" /></a></center>';
            $deleted='<center><a href="javascript:void(0)" onclick="deleteItem('.$data[$i]["id"].')"><img src="'.asset("/public/admin/images/delete-icon.png").'" /></a></center>';
            
            $sort_order = '<center><input name="sort_order" id="sort-order-'.$data[$i]["id"].'" sort_order_id="'.$data[$i]["id"].'" onkeyup="setSortOrder(this)" value="'.$data[$i]["sort_order"].'" size="3" style="text-align:center" /></center>';
            
            $result[$i] = array(
                'checked'                  =>   '<input type="checkbox" onclick="checkWithList(this)" name="cid" value="'.$data[$i]["is_checked"].'" />',
                'is_checked'               =>   0,
                "id"                       =>   $data[$i]["id"],
                "fullname"                 =>   $data[$i]["fullname"],
                "controller"               =>   $data[$i]["controller"],
                "action"                   =>   $data[$i]["action"]   ,                                   
                "sort_order"               =>   $sort_order,
                "created_at"               =>   datetimeConverterVn($data[$i]["created_at"]),
                "updated_at"               =>   datetimeConverterVn($data[$i]["updated_at"]),
                "edited"                   =>   $edited,
                "deleted"                  =>   $deleted
            );
        }
    }
    return $result;
}
function customerConverter($data=array(),$controller){        
    $result = array();
    if( count($data) > 0){
        for($i = 0 ;$i < count($data);$i++){
            $edited='<center><a href="'.route('admin.'.$controller.'.getForm',['edit',$data[$i]['id']]).'"><img src="'.asset("/public/admin/images/edit-icon.png").'" /></a></center>';
            $deleted='<center><a href="javascript:void(0)" onclick="deleteItem('.$data[$i]["id"].')"><img src="'.asset("/public/admin/images/delete-icon.png").'" /></a></center>';
            $kicked=0;
            if((int)$data[$i]["status"]==1){
                $kicked=0;
            }
            else{
                $kicked=1;
            }
            $status     = '<center>'.cmsStatus((int)$data[$i]["id"],(int)$data[$i]["status"],$kicked).'</center>';
            $sort_order = '<center><input name="sort_order" id="sort-order-'.$data[$i]["id"].'" sort_order_id="'.$data[$i]["id"].'" onkeyup="setSortOrder(this)" value="'.$data[$i]["sort_order"].'" size="3" style="text-align:center" /></center>';
                    
            $result[$i] = array(
                'checked'                  =>   '<input type="checkbox" onclick="checkWithList(this)" name="cid" value="'.$data[$i]["is_checked"].'" />',
                'is_checked'               =>   0,
                "id"                       =>   $data[$i]["id"],
                "username"                 =>   $data[$i]["username"],
                "email"                    =>   $data[$i]["email"],
                "fullname"                 =>   $data[$i]["fullname"],
                "address"                  =>   $data[$i]["address"],
                "phone"                    =>   $data[$i]["phone"],
                "mobilephone"              =>   $data[$i]["mobilephone"],
                "sort_order"               =>   $sort_order,
                "status"                   =>   $status,
                "created_at"               =>   datetimeConverterVn($data[$i]["created_at"]),
                "updated_at"               =>   datetimeConverterVn($data[$i]["updated_at"]),
                "edited"                   =>   $edited,
                "deleted"                  =>   $deleted
            );
        }
    }
    return $result;
}
function invoiceConverter($data=array(),$controller){        
    $result = array();
    if( count($data) > 0){
        for($i = 0 ;$i < count($data);$i++){
            $edited='<center><a href="'.route('admin.'.$controller.'.getForm',['edit',$data[$i]['id']]).'"><img src="'.asset("/public/admin/images/edit-icon.png").'" /></a></center>';
            $deleted='<center><a href="javascript:void(0)" onclick="deleteItem('.$data[$i]["id"].')"><img src="'.asset("/public/admin/images/delete-icon.png").'" /></a></center>';
            $kicked=0;
            if((int)$data[$i]["status"]==1){
                $kicked=0;
            }
            else{
                $kicked=1;
            }
            $status     = '<center>'.cmsStatus((int)$data[$i]["id"],(int)$data[$i]["status"],$kicked).'</center>';
            $sort_order = '<center><input name="sort_order" id="sort-order-'.$data[$i]["id"].'" sort_order_id="'.$data[$i]["id"].'" onkeyup="setSortOrder(this)" value="'.$data[$i]["sort_order"].'" size="3" style="text-align:center" /></center>';                
            $result[$i] = array(
                'checked'                  =>   '<input type="checkbox" onclick="checkWithList(this)" name="cid" value="'.$data[$i]["is_checked"].'" />',
                'is_checked'               =>   0,
                "id"                       =>   $data[$i]["id"],
                "code"                     =>   $data[$i]["code"],
                "username"                 =>   $data[$i]["username"],
                "email"                    =>   $data[$i]["email"],
                "fullname"                 =>   $data[$i]["fullname"],
                "address"                  =>   $data[$i]["address"],
                "phone"                    =>   $data[$i]["phone"],
                "mobilephone"              =>   $data[$i]["mobilephone"],
                "fax"                      =>   $data[$i]["fax"],
                "quantity"                 =>   $data[$i]["quantity"],
                "total_price"              =>   $data[$i]["total_price"],                
                "sort_order"               =>   $sort_order,
                "status"                   =>   $status,
                "created_at"               =>   datetimeConverterVn($data[$i]["created_at"]),
                "updated_at"               =>   datetimeConverterVn($data[$i]["updated_at"]),
                "edited"                   =>   $edited,
                "deleted"                  =>   $deleted
            );
        }
    }
    return $result;
}

function itemArticleConverter($data=array(),$controller){        
    $result = array();
    $setting= getSettingSystem();
    if( count($data) > 0){
        for($i = 0 ;$i < count($data);$i++){            
            $deleted='<center><a href="javascript:void(0)" onclick="deleteItem(this)"><img src="'.asset("/public/admin/images/delete-icon.png").'" /></a></center>';            
            $sort_order = '<center><input name="sort_order" id="sort-order-'.$data[$i]["id"].'" sort_order_id="'.$data[$i]["id"].'"  value="'.$data[$i]["sort_order"].'" size="3" style="text-align:center" /></center>';            
            $id=$data[$i]["id"]; 
            $image="";
            if(!empty($data[$i]["image"])){
                $link_image=url("/upload/".$data[$i]["image"]);            
                $image = '<center><img src="'.$link_image.'" style="width:100%" /></center>';
            }         
            $result[$i] = array(
                'checked'                  =>   '<input type="checkbox" onclick="checkWithList(this)" name="cid" value="'.$data[$i]["is_checked"].'" />',
                'is_checked'               =>   0,
                "id"                       =>   $id,
                "fullname"                 =>   $data[$i]["fullname"],     
                "image"                    =>   $image,                                             
                "sort_order"               =>   $sort_order,                                            
                "deleted"                  =>   $deleted
            );
        }
    }
    return $result;
}
function itemProductConverter($data=array(),$controller){        
    $result = array();
    $setting= getSettingSystem();
    if( count($data) > 0){
        for($i = 0 ;$i < count($data);$i++){            
            $deleted='<center><a href="javascript:void(0)" onclick="deleteItem(this)"><img src="'.asset("/public/admin/images/delete-icon.png").'" /></a></center>';            
            $sort_order = '<center><input name="sort_order" id="sort-order-'.$data[$i]["id"].'" sort_order_id="'.$data[$i]["id"].'"  value="'.$data[$i]["sort_order"].'" size="3" style="text-align:center" /></center>';            
            $id=$data[$i]["id"]; 
            $image="";
            if(!empty($data[$i]["image"])){
                $link_image=url("/upload/" . $setting["product_width"] . "x" . $setting["product_height"] . "-".$data[$i]["image"]);            
                $image = '<center><img src="'.$link_image.'" style="width:100%" /></center>';
            }          
            $result[$i] = array(
                'checked'                  =>   '<input type="checkbox" onclick="checkWithList(this)" name="cid" value="'.$data[$i]["is_checked"].'" />',
                'is_checked'               =>   0,
                "id"                       =>   $id,
                "fullname"                 =>   $data[$i]["fullname"],     
                "image"                    =>   $image,                                             
                "sort_order"               =>   $sort_order,                                            
                "deleted"                  =>   $deleted
            );
        }
    }
    return $result;
}
function categoryArticleComponentConverter($data=array(),$controller,$menu_type_id){        
    $result = array();    
    $setting= getSettingSystem();
    if( count($data) > 0){
        for($i = 0 ;$i < count($data);$i++){
            $edited='';
            $linkDelete='';
            $deleted='';
            
            $kicked=0;
            if((int)$data[$i]["status"]==1){
                $kicked=0;
            }
            else{
                $kicked=1;
            }
            $status     = '';
            
            $sort_order = '<center>'.$data[$i]["sort_order"].'</center>';            
            $link_image="";
            $image="";
            if(!empty($data[$i]["image"])){
                $link_image=url("/upload/".$data[$i]["image"]);            
                $image = '<center><img src="'.$link_image.'" style="width:100%" /></center>';
            }          
            $linkMenu=route('admin.menu.getForm',['add',$menu_type_id,0,$data[$i]["alias"]]);
            $fullname='<a href="'.$linkMenu.'">'.$data[$i]['fullname'].'</a>';
            $result[$i] = array(
                'checked'                  =>   '<input type="checkbox"  name="cid[]" value="'.$data[$i]["id"].'" />',
                'is_checked'               =>   0,
                "id"                       =>   $data[$i]["id"],
                "fullname"                 =>   $fullname,
                "parent_fullname"          =>   $data[$i]["parent_fullname"],
                "alias"                    =>   $data[$i]["alias"],
                "parent_id"                =>   $data[$i]["parent_id"],
                "image"                    =>   $image,
                "sort_order"               =>   $sort_order,
                "status"                   =>   $status,
                "created_at"               =>   datetimeConverterVn($data[$i]["created_at"]),
                "updated_at"               =>   datetimeConverterVn($data[$i]["updated_at"]),
                "edited"                   =>   $edited,
                "deleted"                  =>   $deleted
            );
        }
    }
    return $result;
}
function categoryProductComponentConverter($data=array(),$controller,$menu_type_id){        
    $result = array();    
    $setting= getSettingSystem();
    if( count($data) > 0){
        for($i = 0 ;$i < count($data);$i++){
            $edited='';
            $linkDelete='';
            $deleted='';
            
            $kicked=0;
            if((int)$data[$i]["status"]==1){
                $kicked=0;
            }
            else{
                $kicked=1;
            }
            $status     = '';
            
            $sort_order = '<center>'.$data[$i]["sort_order"].'</center>';            
            $link_image="";
            $image="";
            if(!empty($data[$i]["image"])){
                $link_image=url("/upload/" . $setting["product_width"] . "x" . $setting["product_height"] . "-".$data[$i]["image"]);            
                $image = '<center><img src="'.$link_image.'" style="width:100%" /></center>';
            }         
            $linkMenu=route('admin.menu.getForm',['add',$menu_type_id,0,$data[$i]["alias"]]);
            $fullname='<a href="'.$linkMenu.'">'.$data[$i]['fullname'].'</a>';
            $result[$i] = array(
                'checked'                  =>   '<input type="checkbox"  name="cid[]" value="'.$data[$i]["id"].'" />',
                'is_checked'               =>   0,
                "id"                       =>   $data[$i]["id"],
                "fullname"                 =>   $fullname,
                "parent_fullname"          =>   $data[$i]["parent_fullname"],
                "alias"                    =>   $data[$i]["alias"],
                "parent_id"                =>   $data[$i]["parent_id"],
                "image"                    =>   $image,
                "sort_order"               =>   $sort_order,
                "status"                   =>   $status,
                "created_at"               =>   datetimeConverterVn($data[$i]["created_at"]),
                "updated_at"               =>   datetimeConverterVn($data[$i]["updated_at"]),
                "edited"                   =>   $edited,
                "deleted"                  =>   $deleted
            );
        }
    }
    return $result;
}
function articleComponentConverter($data=array(),$controller,$menu_type_id){        
    $result = array();
    $setting= getSettingSystem();
    if( count($data) > 0){
        for($i = 0 ;$i < count($data);$i++){            
            $sort_order = '<center>'.$data[$i]["sort_order"].'</center>';
            $link_image="";
            $image="";
            if(!empty($data[$i]["image"])){
                $link_image=url("/upload/".$data[$i]["image"]);            
                $image = '<center><img src="'.$link_image.'" style="width:100%" /></center>';
            }       
            $id=$data[$i]["id"];       
            $linkMenu=route('admin.menu.getForm',['add',$menu_type_id,0,$data[$i]["alias"]]);
            $fullname='<a href="'.$linkMenu.'">'.$data[$i]['fullname'].'</a>';
            $result[$i] = array(                
                "id"                       =>   $id,
                "fullname"                 =>   $fullname,                                
                "image"                    =>   $image,
                "sort_order"               =>   $sort_order,                
            );
        }
    }
    return $result;
}
function productComponentConverter($data=array(),$controller,$menu_type_id){        
    $result = array();
    $setting= getSettingSystem();
    if( count($data) > 0){
        for($i = 0 ;$i < count($data);$i++){            
            $sort_order = '<center>'.$data[$i]["sort_order"].'</center>';
            $link_image="";
            $image="";
            if(!empty($data[$i]["image"])){
                $link_image=url("/upload/" . $setting["product_width"] . "x" . $setting["product_height"] . "-".$data[$i]["image"]);            
                $image = '<center><img src="'.$link_image.'" style="width:100%" /></center>';
            }           
            $id=$data[$i]["id"];       
            $linkMenu=route('admin.menu.getForm',['add',$menu_type_id,0,$data[$i]["alias"]]);
            $fullname='<a href="'.$linkMenu.'">'.$data[$i]['fullname'].'</a>';
            $result[$i] = array(                
                "id"                       =>   $id,
                "fullname"                 =>   $fullname,                                
                "image"                    =>   $image,
                "sort_order"               =>   $sort_order,                
            );
        }
    }
    return $result;
}
function convertToArray($stdArray){
    $newArr=array();
    foreach($stdArray as $key => $value)
        $newArr[$key] = (array) $value;    
    return $newArr;
}
function get_field_data_array($array,$idField = null)
    {
        $_out = array();

        if (is_array($array)) {
            if ($idField == null) {
                foreach ($array as $value) {
                    $_out[] = $value;
                }
            } else {
                foreach ($array as $value) {
                    $_out[$value[$idField]] = $value;
                }
            }
            return $_out;
        } else {
            return false;
        }
    }
function convertToSourceArray($data=array()){
    $source=array();
    foreach ($data as $key => $value) {
        $source[]=$value;
    }
    return $source;
}
?>