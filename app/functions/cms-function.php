<?php
function cmsStatus($id,$statusValue,$kicked){
  $strStatus = ($statusValue == 0) ? 'unpublish' : 'publish';
  $xhtml    = '<a class="jgrid" id="status-'.$id.'" href="javascript:void(0)" onclick="changeStatus('.$id.','.$kicked.');">
  <span class="state '.$strStatus.'"></span>
  </a>';
  return $xhtml;
}

function cmsSelectbox($id="",$name = "",$class="",$arrValue=array(), $keySelect = "",$disabled){
  $xhtml = '<select id="'.$id.'" name="'.$name.'" class="'.$class.'" '.$disabled.' >';
  foreach($arrValue as $key => $value){
    if($key == $keySelect ){
      $xhtml .= '<option selected="selected" value = "'.$key.'">'.$value.'</option>';
    }else{
      $xhtml .= '<option value = "'.$key.'">'.$value.'</option>';
    }
  }
  $xhtml .= '</select>';
  return $xhtml;
}
function cmsSelectboxCategory($id,$name, $class, $arrValue, $val = 0,$disabled){   
  $xhtml = '<select id="'.$id.'" name="'.$name.'" class="'.$class.'" '.$disabled.'  >';
  $xhtml .= '<option value = "">--Select a category--</option>';
  foreach($arrValue as $key => $value){
    if((int)$value["id"] == (int)$val){
      $xhtml .= '<option selected="selected" value = "'.$value["id"].'">'.$value["fullname"].'</option>';
    }else{
      $xhtml .= '<option value = "'.$value["id"].'">'.$value["fullname"].'</option>';
    }
  }
  $xhtml .= '</select>';
  return $xhtml;
}
function cmsSelectboxCategoryArticleMultiple($id,$name, $class, $arrValue, $arrValueSelected,$disabled){
    $xhtml = '<select size="20" id="'.$id.'" name="'.$name.'" class="'.$class.'" '.$disabled.' multiple="multiple" >';
    $xhtml .= '<option value = "">--Chọn danh mục--</option>';
    foreach($arrValue as $key => $value){
      $id=$value["id"];
      $name=$value["fullname"];     
      $strOption='<option value="'.$id.'">'.$name.'</option>';
      if(!empty($arrValueSelected)){
          foreach($arrValueSelected as $key_1 => $value_1) {
              if((int)$id == (int)$value_1["category_article_id"]){
                $strOption = str_replace('<option', '<option selected="selected" ', $strOption);
              }
          }
      }      
      $xhtml .=$strOption;
    }
    $xhtml .= '</select>';
    return $xhtml;
  }
  function cmsSelectboxCategoryProductMultiple($id,$name, $class, $arrValue, $arrValueSelected,$disabled){
    $xhtml = '<select size="20" id="'.$id.'" name="'.$name.'" class="'.$class.'" '.$disabled.' multiple="multiple" >';
    $xhtml .= '<option value = "">--Chọn danh mục--</option>';
    foreach($arrValue as $key => $value){
      $id=$value["id"];
      $name=$value["fullname"];     
      $strOption='<option value="'.$id.'">'.$name.'</option>';
      if(!empty($arrValueSelected)){
          foreach($arrValueSelected as $key_1 => $value_1) {
              if((int)$id == (int)$value_1["category_product_id"]){
                $strOption = str_replace('<option', '<option selected="selected" ', $strOption);
              }
          }
      }      
      $xhtml .=$strOption;
    }
    $xhtml .= '</select>';
    return $xhtml;
  }
function cmsSelectboxMenuMultiple($id,$name, $class, $arrValue, $arrValueSelected,$disabled){
  $xhtml = '<select size="20" id="'.$id.'" name="'.$name.'" class="'.$class.'" '.$disabled.' multiple="multiple" >';
  $xhtml .= '<option value = "">--Chọn danh mục--</option>';
  foreach($arrValue as $key => $value){
    $id=$value["id"];
    $name=$value["fullname"];     
    $strOption='<option value="'.$id.'">'.$name.'</option>';
    if(!empty($arrValueSelected)){
      foreach($arrValueSelected as $key_1 => $value_1) {
        if((int)$id == (int)$value_1["menu_id"]){
          $strOption = str_replace('<option', '<option selected="selected" ', $strOption);
        }
      }
    }      
    $xhtml .=$strOption;
  }
  $xhtml .= '</select>';
  return $xhtml;
}  
function cmsSelectboxGroupMultiple($id,$name, $class, $arrValue, $arrValueSelected,$disabled){
  $xhtml = '<select size="20" id="'.$id.'" name="'.$name.'" class="'.$class.'" '.$disabled.' multiple="multiple" >';
  $xhtml .= '<option value = "">--Chọn danh mục--</option>';
  foreach($arrValue as $key => $value){
    $id=$value["id"];
    $name=$value["fullname"];     
    $strOption='<option value="'.$id.'">'.$name.'</option>';
    if(!empty($arrValueSelected)){
      foreach($arrValueSelected as $key_1 => $value_1) {
        if((int)$id == (int)$value_1["group_id"]){
          $strOption = str_replace('<option', '<option selected="selected" ', $strOption);
        }
      }
    }      
    $xhtml .=$strOption;
  }
  $xhtml .= '</select>';
  return $xhtml;
}
function cmsSelectboxGroupPrivilegeMultiple($id,$name, $class, $arrValue, $arrValueSelected,$disabled){
  $xhtml = '<select size="20" id="'.$id.'" name="'.$name.'" class="'.$class.'" '.$disabled.' multiple="multiple" >';
  $xhtml .= '<option value = "">--Chọn danh mục--</option>';
  foreach($arrValue as $key => $value){
    $id=$value["id"];
    $name=$value["fullname"];     
    $strOption='<option value="'.$id.'">'.$name.'</option>';
    if(!empty($arrValueSelected)){
      foreach($arrValueSelected as $key_1 => $value_1) {
        if((int)$id == (int)$value_1["privilege_id"]){
          $strOption = str_replace('<option', '<option selected="selected" ', $strOption);
        }
      }
    }      
    $xhtml .=$strOption;
  }
  $xhtml .= '</select>';
  return $xhtml;
}
?>