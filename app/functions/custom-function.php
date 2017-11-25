<?php 
use App\SettingSystemModel;
use App\MenuModel;
use App\MenuTypeModel;
use App\ModuleItemModel;
use App\ProductModel;
use App\ArticleModel;
use App\CategoryProductModel;
use App\CategoryArticleModel;
function uploadImage($fileObj,$width,$height){        
  require_once base_path() . DS ."app".DS."scripts".DS."PhpThumb".DS."ThumbLib.inc.php";    
  $uploadDir = base_path() . DS ."resources".DS."upload";                    
  $fileName="";
  if($fileObj['tmp_name'] != null){                
    $fileName   = $fileObj['name'];
    @copy($fileObj['tmp_name'], $uploadDir . DS . $fileName);       
    $thumb = PhpThumbFactory::create($uploadDir . DS . $fileName);        
    $thumb->adaptiveResize($width, $height);
    $prefix = $width . 'x' . $height . '-';
    $veston = $uploadDir . DS . $prefix  . $fileName;       
    $thumb->save($veston);
  }   
}
function getSettingSystem(){        
    $alias='setting-system';
    $setting                   =   SettingSystemModel::whereRaw("trim(lower(alias)) = ?",[trim(mb_strtolower(@$alias))])->get()->toArray(); 
    return $setting[0];     
}
function getStringCategoryID($category_id,&$arrCategoryID,$model){
    $arrCategory=array();    
    switch ($model) {
      case 'category_article':
        $arrCategory=CategoryArticleModel::select("id")->where("parent_id","=",(int)@$category_id)->get()->toArray();    
        break;
      case 'category_product':
        $arrCategory=CategoryProductModel::select("id")->where("parent_id","=",(int)@$category_id)->get()->toArray();    
        break;              
    }    
    if(count($arrCategory) > 0){
      foreach ($arrCategory as $key => $value) {
        $arrCategoryID[]=$value["id"];
        getStringCategoryID((int)$value["id"],$arrCategoryID,$model);
      }
    }          
}
function wp_nav_menu($args){
    $theme_location=$args['theme_location'];
    $data_menu_type=MenuTypeModel::whereRaw("trim(lower(theme_location)) = ?",[trim(mb_strtolower($theme_location))])->select('id','fullname')->get()->toArray()[0];
    $data_menu=MenuModel::whereRaw('menu_type_id = ?',[(int)@$data_menu_type['id']])->orderBy('sort_order','asc')->get()->toArray();    
    $arr_menu=array();  
    if(count($data_menu) > 0){
        for ($i=0;$i<count($data_menu);$i++) {
            $menu=array();
            $menu=$data_menu[$i];
            $site_link='';
            if(!empty( $data_menu[$i]["site_link"] )){
              $site_link=$data_menu[$i]["site_link"].".html";
            }
            $menu["site_link"] =$site_link;            
            $data_child=MenuModel::whereRaw('parent_id = ?',[(int)$data_menu[$i]["id"]])->select('id')->get()->toArray();
            if(count($data_child) > 0){
              $menu["havechild"]=1;
            }else{
              $menu["havechild"]=0;
            }
            $arr_menu[]=$menu;
        }
    }
    $menu_str              =  "";      
    $lanDau                =  0;    
    mooMenuRecursive($arr_menu,0,$menu_str,$lanDau,url('/'),$args['alias'],$args['menu_id'],$args['menu_class'],$args['menu_li_actived'],$args['menu_item_has_children'],$args['link_before'],$args['link_after']);
    $menu_str = str_replace('<ul></ul>', '', $menu_str);
    $wrapper='';
    if(!empty($args['before_wrapper'])){
      if(!empty($args['before_title'])){
        $wrapper=$args['before_wrapper'].$args['before_title'].$data_menu_type['fullname'].$args['after_title'].$args['before_wrapper_ul'].$menu_str.$args['after_wrapper_ul'].$args['after_wrapper'];
      }else{
        $wrapper=$args['before_wrapper'].$args['before_wrapper_ul'].$menu_str.$args['after_wrapper_ul'].$args['after_wrapper'];
      }
    }    
    else{
      $wrapper=$menu_str;
    }
    echo $wrapper;
}
function mooMenuRecursive($source,$parent,&$menu_str,&$lanDau,$url,$alias,$menu_id,$menu_class,$menu_li_actived,$menu_item_has_children,$link_before,$link_after){
    if(count($source) > 0){          
            $menu_str .='<ul>';
            if($lanDau == 0){
                  $menu_str ='<ul id="'.$menu_id.'" class="'.$menu_class.'"  >';
            }                          
            foreach ($source as $key => $value) 
            {                  
                    if((int)$value["parent_id"]==(int)$parent)
                    {
                          $link=$url.$value["site_link"];
                          $class_activated=0;                          
                          if( strcmp(trim(mb_strtolower($value["alias"])),trim(mb_strtolower($alias)))   ==  0 ){
                              $class_activated=1;                              
                          }
                          $menuName='';                          
                          $fullname=$link_before . $value['fullname'] . $link_after;
                          if($class_activated==1){
                              $menuName = '<a href="'.$link.'" class="active" >' . $fullname . '</a>';
                          }else{
                              $menuName = '<a href="'.$link.'"  >' . $fullname . '</a>';
                          }                                                    
                          if((int)$value["havechild"]==1){
                              $li='';
                              if($class_activated==1){
                                  $li='<li class="'.$menu_item_has_children.' '.$menu_li_actived.'"  >'.$menuName;
                              }else{
                                  $li='<li class="'.$menu_item_has_children.'"  >'.$menuName;
                              }
                              $menu_str .=$li;                                
                          }
                          else{
                              $li='';
                              if($class_activated==1){
                                  $li='<li class="'.$menu_li_actived.'"  >'.$menuName;
                              }else{
                                  $li='<li   >'.$menuName;
                              }
                              $menu_str .=$li;                                
                          }              
                          unset($source[$key]);
                          $newParent=$value["id"];
                          $lanDau =$lanDau+1;
                          mooMenuRecursive($source,$newParent,$menu_str,$lanDau,$url,$alias,$menu_id,$menu_class,$menu_li_actived,$menu_item_has_children,$link_before,$link_after);
                          $menu_str .='</li>';
                    }
            }
            $menu_str .='</ul>'; 
    }
}
function fnPrice($value){
    $data = getSettingSystem();
    $language = $data["currency_unit"] ;
    $strCurrency="";
    switch ($language) {
      case "vi_VN":
        $strCurrency= number_format($value,0,",",".");
        break;
      case "en_US":
        $strCurrency= number_format($value,0,".",",");
        break;
    }
    return $strCurrency;
  }
  function getModuleByPosition($position){
    $data=array();
    $status=1;
    $module=ModuleItemModel::whereRaw('trim(lower(position)) = ? and status = ?',[mb_strtolower(trim(@$position)),(int)$status])->select('item_id','component','status')->get()->toArray();    
    if(count($module) > 0){
      $module=$module[0];
      $item_id=$module['item_id'];
      $component=$module['component'];
      $list=json_decode($item_id);            
      if(count($list) > 0){
        $list=convertToArray($list);
        foreach($list as $key => $value){
          $id=@$value['id'];
          $item=array();
          switch ($component) {
            case 'article':
              $item=ArticleModel::whereRaw('id = ? and status = ?',[(int)@$id,$status])->get()->toArray();
            break;          
            case 'product':            
              $item=ProductModel::whereRaw('id = ? and status = ?',[(int)@$id,$status])->get()->toArray();
            break;
          }            
          if(count($item) > 0){
            $data[]=$item[0];
          }                    
        }
      }
    }            
    return $data;
  }
function randomString($length = 5){
    $arrCharacter = array_merge(range('a','z'), range(0,9));
    $arrCharacter = implode($arrCharacter, '');
    $arrCharacter = str_shuffle($arrCharacter);
    $result   = substr($arrCharacter, 0, $length);
    return $result;
}

?>