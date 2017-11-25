<?php namespace App\Http\Controllers\admin;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ModuleMenuModel;
use App\MenuTypeModel;
use App\MenuModel;
use App\ModMenuTypeModel;
use DB;
class ModuleMenuController extends Controller {
  	var $_controller="module-menu";	
  	var $_title="Module Menu";
  	var $_icon="icon-settings font-dark";
  	public function getList(){		
    		$controller=$this->_controller;	
    		$task="list";
    		$title=$this->_title;
    		$icon=$this->_icon;		
    		return view("admin.".$this->_controller.".list",compact("controller","task","title","icon"));	
  	}	    
  	public function loadData(Request $request){
    		$filter_search="";            
        if(!empty(@$request->filter_search)){      
          $filter_search=trim(@$request->filter_search) ;    
        }                
    		$data=DB::select('call pro_getModuleMenu(?)',array(mb_strtolower($filter_search)));
    		$data=convertToArray($data);		
    		$data=moduleMenuConverter($data,$this->_controller);		    
    		return $data;
  	}	
    public function getForm($task,$id=""){     
        $controller=$this->_controller;     
        $title="";
        $icon=$this->_icon; 
        $arrRowData=array();
        $arrModMenuType=array();
        switch ($task) {
           case 'edit':
              $title=$this->_title . " : Update";
             $arrRowData=ModuleMenuModel::find(@$id)->toArray();  

      $arrModMenuType=ModMenuTypeModel::whereRaw("module_id = ? and trim(lower(module_type)) = ?",[(int)@$id,trim(mb_strtolower($this->_controller,'UTF-8'))])->get()->toArray();      

           break;
           case 'add':
              $title=$this->_title . " : Add new";
           break;     
        }    
        $arrMenuType=MenuTypeModel::select("id","fullname","sort_order","created_at","updated_at")->get()->toArray();

    $arrMenu=MenuModel::select("id","fullname","alias","site_link","parent_id","menu_type_id","level","sort_order","status","created_at","updated_at")->orderBy("sort_order","asc")->get()->toArray();  

    $arrMenuRecursive=array();

    menuRecursiveForm($arrMenu ,0,"",$arrMenuRecursive)  ;

    return view("admin.".$this->_controller.".form",compact("arrMenuRecursive","arrRowData","arrModMenuType","arrMenuType","controller","task","title","icon"));
    }
     public function save(Request $request){
          $id 					        =		trim($request->id);        
          $fullname 				    =		trim($request->fullname);
          $menu_type_id         =   (int)$request->menu_type_id;
          $menu_id              =   $request->menu_id;
          $position 					  = 	trim($request->position);  
          $status               =   trim($request->status);        
          $sort_order           =   trim($request->sort_order);                  
          $data 		            =   array();
          $info 		            =   array();
          $error 		            =   array();
          $item		              =   null;
          $checked 	            =   1;              
          if(empty($fullname)){
                 $checked = 0;
                 $error["fullname"]["type_msg"] = "has-error";
                 $error["fullname"]["msg"] = "Fullname is required";
          }else{
              $data=array();
              if (empty($id)) {
                $data=ModuleMenuModel::whereRaw("trim(lower(fullname)) = ?",[trim(mb_strtolower($fullname,'UTF-8'))])->get()->toArray();	        	
              }else{
                $data=ModuleMenuModel::whereRaw("trim(lower(fullname)) = ? and id != ?",[trim(mb_strtolower($fullname,'UTF-8')),(int)@$id])->get()->toArray();		
              }  
              if (count($data) > 0) {
                  $checked = 0;
                  $error["fullname"]["type_msg"] = "has-error";
                  $error["fullname"]["msg"] = "Fullname is existed in system";
              }      	
          }          
          if(empty($sort_order)){
             $checked = 0;
             $error["sort_order"]["type_msg"] 	= "has-error";
             $error["sort_order"]["msg"] 		= "Sort order is required";
          }
          if((int)$status==-1){
             $checked = 0;
             $error["status"]["type_msg"] 		= "has-error";
             $error["status"]["msg"] 			= "Status is required";
          }
          if ($checked == 1) {    
                if(empty($id)){
                    $item 				  = 	new ModuleMenuModel;       
                    $item->created_at 	=	date("Y-m-d H:i:s",time());                            
                } else{
                    $item				    =	ModuleMenuModel::find((int)@$id);                        		 
                }  
                $item->fullname 		=	$fullname;
                $item->menu_type_id = (int)$menu_type_id;
                $item->position 		=	$position;  
                $item->status       = (int)$status;                  
                $item->sort_order 	=	(int)$sort_order;                
                $item->updated_at 	=	date("Y-m-d H:i:s",time());    	        	
                $item->save();  	
                if(count(@$menu_id) > 0){                         
                    $arrModMenuType=ModMenuTypeModel::whereRaw("module_id = ? and module_type",[@$item->id,trim(mb_strtolower(@$this->_controller,'UTF-8'))])->get()->toArray();
                    $arrMenuID=array();
                    foreach ($arrModMenuType as $key => $value) {
                        $arrMenuID[]=$value["menu_id"];
                    }
                    $selected=@$menu_id;
                    sort($selected);
                    sort($arrMenuID);
                    $resultCompare=0;
                    if($selected == $arrMenuID){
                          $resultCompare=1;       
                    }
                    if($resultCompare==0){
                          ModMenuTypeModel::whereRaw("module_id = ? and module_type = ?",[(int)@$item->id,trim(mb_strtolower($this->_controller,'UTF-8'))])->delete();   
                          foreach ($selected as $key => $value) {
                            $menuid=$value;
                            $modMenuType=new ModMenuTypeModel;
                            $modMenuType->menu_id=(int)@$menuid;
                            $modMenuType->module_id=(int)@$item->id;
                            $modMenuType->module_type=$this->_controller;                  
                            $modMenuType->save();
                          }
                    }   
                }
                $info = array(
                  'type_msg' 			=> "has-success",
                  'msg' 				=> 'Save data successfully',
                  "checked" 			=> 1,
                  "error" 			=> $error,
                  "id"    			=> $id
                );
            }else {
                    $info = array(
                      'type_msg' 			=> "has-error",
                      'msg' 				=> 'Input data has some warning',
                      "checked" 			=> 0,
                      "error" 			=> $error,
                      "id"				=> ""
                    );
            }        		 			       
            return $info;       
    }
          public function changeStatus(Request $request){
                  $id             =       (int)$request->id;     
                  $checked                =   1;
                  $type_msg               =   "alert-success";
                  $msg                    =   "Update successfully";              
                  $status         =       (int)$request->status;
                  $item           =       ModuleMenuModel::find((int)@$id);        
                  $item->status   =       $status;
                  $item->save();
                  $data                   =   $this->loadData($request);
                  $info = array(
                    'checked'           => $checked,
                    'type_msg'          => $type_msg,                
                    'msg'               => $msg,                
                    'data'              => $data
                  );
                  return $info;
          }
        
      public function deleteItem(Request $request){
            $id                     =   (int)$request->id;              
            $checked                =   1;
            $type_msg               =   "alert-success";
            $msg                    =   "Delete successfully";                    
            if($checked == 1){
              $item = ModuleMenuModel::find((int)@$id);
              $item->delete();
              ModMenuTypeModel::whereRaw("module_id = ? and module_type = ?",[(int)$id,trim(mb_strtolower($this->_controller,'UTF-8'))])->delete();
            }        
            $data                   =   $this->loadData($request);
            $info = array(
              'checked'           => $checked,
              'type_msg'          => $type_msg,                
              'msg'               => $msg,                
              'data'              => $data
            );
            return $info;
      }
      public function updateStatus(Request $request){
          $str_id                 =   $request->str_id;   
          $status                 =   $request->status;  
          $arrID                 =   explode(",", $str_id)  ;          
          $checked                =   1;
          $type_msg               =   "alert-success";
          $msg                    =   "Update successfully";     
          if(empty($str_id)){
                    $checked                =   0;
                    $type_msg               =   "alert-warning";            
                    $msg                    =   "Please choose at least one item to delete";
          }
          if($checked==1){
              foreach ($arrID as $key => $value) {
                if(!empty($value)){
                  $item=ModuleMenuModel::find($value);
                $item->status=$status;
                $item->save();    
                }                
              }
          }                 
          $data                   =   $this->loadData($request);
          $info = array(
            'checked'           => $checked,
            'type_msg'          => $type_msg,                
            'msg'               => $msg,                
            'data'              => $data
          );
          return $info;
      }
      public function trash(Request $request){
            $str_id                 =   $request->str_id;   
            $checked                =   1;
            $type_msg               =   "alert-success";
            $msg                    =   "Delete successfully";      
            $arrID                  =   explode(",", $str_id)  ;        
            if(empty($str_id)){
              $checked     =   0;
              $type_msg           =   "alert-warning";            
              $msg                =   "Please choose at least one item to delete";
            }
            if($checked == 1){                
                  $strID = implode(',',$arrID);   
                  $strID=substr($strID, 0,strlen($strID) - 1);
                  $sqlDeleteModuleMenu = "DELETE FROM `module_menu` WHERE `id` IN  (".$strID.")";       
                  $sqlDeleteModMenuType = "DELETE FROM `mod_menu_type` WHERE `module_id` IN (".$strID.") and `module_type` = '".trim(mb_strtolower($this->_controller,'UTF-8'))."' ";                
                  DB::statement($sqlDeleteModuleMenu);
                  DB::statement($sqlDeleteModMenuType);           
            }
            $data                   =   $this->loadData($request);
            $info = array(
              'checked'           => $checked,
              'type_msg'          => $type_msg,                
              'msg'               => $msg,                
              'data'              => $data
            );
            return $info;
      }
      public function sortOrder(Request $request){
            $sort_json              =   $request->sort_json;           
            $data_order             =   json_decode($sort_json);       
            $checked                =   1;
            $type_msg               =   "alert-success";
            $msg                    =   "Update successfully";      
            if(count($data_order) > 0){              
              foreach($data_order as $key => $value){       
              if(!empty($value)){
                $item=ModuleMenuModel::find((int)$value->id);                
                $item->sort_order=(int)$value->sort_order;                         
                $item->save();                      
              }                                                 
              }           
            }        
            $data                   =   $this->loadData($request);
            $info = array(
              'checked'           => $checked,
              'type_msg'          => $type_msg,                
              'msg'               => $msg,                
              'data'              => $data
            );
            return $info;
      }
  
}
?>
