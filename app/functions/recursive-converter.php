<?php 
function categoryArticleRecursive($data ,$parent=null,$str="--",&$arrRecursiveMenu){
  foreach ($data as $key => $val) {
    $checked=isset($val["checked"]) ? $val["checked"] : 0 ;
    $is_checked=$val["is_checked"];
    $id=$val["id"];
    $fullname=$val["fullname"];
    $parent_fullname=$val["parent_fullname"];
    $alias=$val["alias"];    
    $parent_id=$val["parent_id"];  
    $image=$val["image"];
    $sort_order=$val["sort_order"];
    $status=$val["status"];
    $created_at=$val["created_at"];
    $updated_at=$val["updated_at"];
    $edited=isset($val["edited"]) ? $val["edited"] : "" ;
    $deleted=isset($val["deleted"]) ? $val["deleted"] : "" ;
    if((int)$val["parent_id"] == (int)$parent) {
      $arrRecursiveMenu[$key]["checked"]=$checked;
      $arrRecursiveMenu[$key]["is_checked"]=$is_checked;
      $arrRecursiveMenu[$key]["id"]=$id;
      $arrRecursiveMenu[$key]["fullname"]=$str . $fullname;    
      $arrRecursiveMenu[$key]["parent_fullname"]=$parent_fullname;
      $arrRecursiveMenu[$key]["alias"]=$alias;      
      $arrRecursiveMenu[$key]["parent_id"]=$parent_id;      		
      $arrRecursiveMenu[$key]["image"]=$image;      
      $arrRecursiveMenu[$key]["sort_order"]=$sort_order;
      $arrRecursiveMenu[$key]["status"]=$status;
      $arrRecursiveMenu[$key]["created_at"]=$created_at;
      $arrRecursiveMenu[$key]["updated_at"]=$updated_at;
      $arrRecursiveMenu[$key]["edited"]=$edited;
      $arrRecursiveMenu[$key]["deleted"]=$deleted;
      categoryArticleRecursive($data,$id,$str."|________",$arrRecursiveMenu);
    }
  }  
}
function categoryArticleRecursiveForm($data ,$parent=null,$str="--",&$arrRecursiveMenu){
  foreach ($data as $key => $val) {    
    $id=$val["id"];
    $fullname=$val["fullname"];  
    $parent_id=$val["parent_id"];    
    if((int)$val["parent_id"] == (int)$parent) {          
          $arrRecursiveMenu[$key]["id"]=$id;
          $arrRecursiveMenu[$key]["fullname"]=$str . $fullname;              
          $arrRecursiveMenu[$key]["parent_id"]=$parent_id;                  
          categoryArticleRecursiveForm($data,$id,$str."--------",$arrRecursiveMenu);
    }
  }  
}
function menuRecursive($data ,$parent=null,$str="--",&$arrRecursiveMenu){
  foreach ($data as $key => $val) {
    $checked=isset($val["checked"]) ? $val["checked"] : 0 ;
    $is_checked=$val["is_checked"];
    $id=$val["id"];
    $fullname=$val["fullname"];
    $alias=$val["alias"];
    $parent_id=$val["parent_id"];  
    $parent_fullname=$val["parent_fullname"];
    $menu_type_id=$val["menu_type_id"];        
    $level=$val["level"];            
    $sort_order=$val["sort_order"];
    $status=$val["status"];
    $created_at=$val["created_at"];
    $updated_at=$val["updated_at"];
    $edited=isset($val["edited"]) ? $val["edited"] : "" ;
    $deleted=isset($val["deleted"]) ? $val["deleted"] : "" ;
    if((int)$val["parent_id"] == (int)$parent) {
          $arrRecursiveMenu[$key]["checked"]=$checked;
          $arrRecursiveMenu[$key]["is_checked"]=$is_checked;
          $arrRecursiveMenu[$key]["id"]=$id;
          $arrRecursiveMenu[$key]["fullname"]=$str . $fullname;             
          $arrRecursiveMenu[$key]["alias"]=$alias;             
          $arrRecursiveMenu[$key]["parent_id"]=$parent_id;
          $arrRecursiveMenu[$key]["parent_fullname"]=$parent_fullname; 
          $arrRecursiveMenu[$key]["menu_type_id"]=$menu_type_id;                            
          $arrRecursiveMenu[$key]["level"]=$level;                                      
          $arrRecursiveMenu[$key]["sort_order"]=$sort_order;
          $arrRecursiveMenu[$key]["status"]=$status;
          $arrRecursiveMenu[$key]["created_at"]=$created_at;
          $arrRecursiveMenu[$key]["updated_at"]=$updated_at;
          $arrRecursiveMenu[$key]["edited"]=$edited;
          $arrRecursiveMenu[$key]["deleted"]=$deleted;
          menuRecursive($data,$id,$str."|________",$arrRecursiveMenu);
    }
  }  
}
function menuRecursiveForm($data ,$parent=null,$str="--",&$arrRecursiveMenu){
  foreach ($data as $key => $val) {
    
    $id=$val["id"];
    $fullname=$val["fullname"];        
    if((int)$val["parent_id"] == (int)$parent) {          
          $arrRecursiveMenu[$key]["id"]=$id;
          $arrRecursiveMenu[$key]["fullname"]=$str . $fullname;              
          menuRecursiveForm($data,$id,$str."--------",$arrRecursiveMenu);
    }
  }  
}
function categoryProductRecursive($data ,$parent=0,$str="--",&$arrRecursiveMenu){
  foreach ($data as $key => $val) {
    $checked=isset($val["checked"]) ? $val["checked"] : 0 ;
    $is_checked=$val["is_checked"];
    $id=$val["id"];
    $fullname=$val["fullname"];
    $parent_fullname=$val["parent_fullname"];
    $alias=$val["alias"];    
    $parent_id=$val["parent_id"];  
    $image=$val["image"];
    $sort_order=$val["sort_order"];
    $status=$val["status"];
    $created_at=$val["created_at"];
    $updated_at=$val["updated_at"];
    $edited=isset($val["edited"]) ? $val["edited"] : "" ;
    $deleted=isset($val["deleted"]) ? $val["deleted"] : "" ;    
    if((int)$val["parent_id"] == (int)$parent) {      
          $arrRecursiveMenu[$key]["checked"]=$checked;
          $arrRecursiveMenu[$key]["is_checked"]=$is_checked;
          $arrRecursiveMenu[$key]["id"]=$id;
          $arrRecursiveMenu[$key]["fullname"]=$str . $fullname;    
          $arrRecursiveMenu[$key]["parent_fullname"]=$parent_fullname;
          $arrRecursiveMenu[$key]["alias"]=$alias;      
          $arrRecursiveMenu[$key]["parent_id"]=$parent_id;          
          $arrRecursiveMenu[$key]["image"]=$image;      
          $arrRecursiveMenu[$key]["sort_order"]=$sort_order;
          $arrRecursiveMenu[$key]["status"]=$status;
          $arrRecursiveMenu[$key]["created_at"]=$created_at;
          $arrRecursiveMenu[$key]["updated_at"]=$updated_at;
          $arrRecursiveMenu[$key]["edited"]=$edited;
          $arrRecursiveMenu[$key]["deleted"]=$deleted;
          categoryProductRecursive($data,$id,$str."|________",$arrRecursiveMenu);
    }
  }  
}
function categoryProductRecursiveForm($data ,$parent=0,$str="--",&$arrRecursiveMenu){
  foreach ($data as $key => $val) {    
    $id=$val["id"];
    $fullname=$val["fullname"];  
    $parent_id=$val["parent_id"];    
    if((int)$val["parent_id"] == (int)$parent) {          
          $arrRecursiveMenu[$key]["id"]=$id;
          $arrRecursiveMenu[$key]["fullname"]=$str . $fullname;              
          $arrRecursiveMenu[$key]["parent_id"]=$parent_id;                  
          categoryProductRecursiveForm($data,$id,$str."--------",$arrRecursiveMenu);
    }
  }  
}
?>