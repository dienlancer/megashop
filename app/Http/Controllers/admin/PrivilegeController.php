<?php namespace App\Http\Controllers\admin;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PrivilegeModel;
use App\GroupPrivilegeModel;
use DB;
class PrivilegeController extends Controller {
  	var $_controller="privilege";	
  	var $_title="Nhóm quyền";
  	var $_icon="icon-settings font-dark";
  	public function getList(){		
    		$controller=$this->_controller;	
    		$task="list";
    		$title=$this->_title;
    		$icon=$this->_icon;		
    		
        $arrPrivilege=getArrPrivilege();
        $requestControllerAction=$this->_controller."-list";         
        if(in_array($requestControllerAction,$arrPrivilege)){
          return view("admin.".$this->_controller.".list",compact("controller","task","title","icon")); 
        }
        else{
          return view("admin.no-access");
        }
  	}	    
  	public function loadData(Request $request){
    		$filter_search="";            
        if(!empty(@$request->filter_search)){      
          $filter_search=trim(@$request->filter_search) ;    
        }             
    		$data=DB::select('call pro_getPrivilege(?)',array(mb_strtolower($filter_search)));
    		$data=convertToArray($data);		
    		$data=privilegeConverter($data,$this->_controller);		    
    		return $data;
  	}	
    public function getForm($task,$id=""){     
        $controller=$this->_controller;     
        $title="";
        $icon=$this->_icon; 
        $arrRowData=array();
        $arrPrivilege=getArrPrivilege();
        $requestControllerAction=$this->_controller."-form";  
        if(in_array($requestControllerAction, $arrPrivilege)){
          switch ($task) {
           case 'edit':
              $title=$this->_title . " : Update";
              $arrRowData=PrivilegeModel::find((int)@$id)->toArray();      
           break;
           case 'add':
              $title=$this->_title . " : Add new";
           break;     
        }    
        return view("admin.".$this->_controller.".form",compact("arrRowData","controller","task","title","icon"));
        }else{
          return view("admin.no-access");
        }
        
    }
     public function save(Request $request){
          $id 					        =		trim($request->id);        
          $fullname 				    =		trim($request->fullname);
          $controller           =   trim($request->controller);
          $action 					    = 	trim($request->action);          
          $sort_order           =   trim($request->sort_order);                    
          $data 		            =   array();
          $info 		            =   array();
          $error 		            =   array();
          $item		              =   null;
          $checked 	            =   1;              
          if(empty($fullname)){
                 $checked = 0;
                 $error["fullname"]["type_msg"] = "has-error";
                 $error["fullname"]["msg"] = "Thiếu tên nhóm quyền";
          }else{
              $data=array();
              if (empty($id)) {
                $data=PrivilegeModel::whereRaw("trim(lower(fullname)) = ?",[trim(mb_strtolower($fullname,'UTF-8'))])->get()->toArray();	        	
              }else{
                $data=PrivilegeModel::whereRaw("trim(lower(fullname)) = ? and id != ?",[trim(mb_strtolower($fullname,'UTF-8')),(int)@$id])->get()->toArray();		
              }  
              if (count($data) > 0) {
                  $checked = 0;
                  $error["fullname"]["type_msg"] = "has-error";
                  $error["fullname"]["msg"] = "Tên nhóm quyền đã tồn tại";
              }      	
          }          
          if(empty($sort_order)){
             $checked = 0;
             $error["sort_order"]["type_msg"] 	= "has-error";
             $error["sort_order"]["msg"] 		= "Thiếu sắp xếp";
          }          
          if ($checked == 1) {    
                if(empty($id)){
                    $item 				    = 	new PrivilegeModel;       
                    $item->created_at =	  date("Y-m-d H:i:s",time());                            
                } else{
                    $item				      =	  PrivilegeModel::find((int)@$id);                            		  		 	
                }  
                $item->fullname 		  =	$fullname;
                $item->controller     = $controller;
                $item->action 			  =	$action;
                $item->sort_order     = (int)$sort_order;                
                $item->updated_at 		=	date("Y-m-d H:i:s",time());    	        	
                $item->save();  	                
                $info = array(
                  'type_msg' 			=> "has-success",
                  'msg' 				=> 'Lưu thành công',
                  "checked" 			=> 1,
                  "error" 			=> $error,
                  "id"    			=> $id
                );
            }else {
                    $info = array(
                      'type_msg' 			=> "has-error",
                      'msg' 				=> 'Dữ liệu nhập gặp sự cố',
                      "checked" 			=> 0,
                      "error" 			=> $error,
                      "id"				=> ""
                    );
            }        		 			       
            return $info;       
    }
          
        
      public function deleteItem(Request $request){
            $id                     =   (int)$request->id;              
            $checked                =   1;
            $type_msg               =   "alert-success";
            $msg                    =   "Xóa thành công";                    
            if($checked == 1){
              $item = PrivilegeModel::find($id);
              $item->delete();
              GroupPrivilegeModel::whereRaw("privilege_id = ?",[(int)@$id])->delete();      
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
            $msg                    =   "Xóa thành công";      
            $arrID                  =   explode(",", $str_id)  ;        
            if(empty($str_id)){
              $checked     =   0;
              $type_msg           =   "alert-warning";            
              $msg                =   "Vui lòng chọn ít nhất 1 phần tử";
            }
            if($checked == 1){                
                  $strID = implode(',',$arrID);   
                  $strID=substr($strID, 0,strlen($strID) - 1);
                  $sqlDeletePrivilege = "DELETE FROM `privilege` WHERE `id` IN (".$strID.")";       
                  $sqlDeleteGroupPrivilege = "DELETE FROM `group_privilege` WHERE `privilege_id` IN (".$strID.")";        
                  DB::statement($sqlDeletePrivilege);
                  DB::statement($sqlDeleteGroupPrivilege);
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
            $msg                    =   "Cập nhật thành công";      
            if(count($data_order) > 0){              
              foreach($data_order as $key => $value){      
                if(!empty($value)){
                  $item=PrivilegeModel::find((int)@$value->id);                
                $item->sort_order=(int)@$value->sort_order;                         
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
