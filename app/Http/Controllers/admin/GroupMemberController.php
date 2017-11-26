<?php namespace App\Http\Controllers\admin;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\GroupMemberModel;
use App\GroupPrivilegeModel;
use App\PrivilegeModel;
use App\User;
use App\UserGroupModel;
use DB;
class GroupMemberController extends Controller {
    	var $_controller="group-member";	
    	var $_title="Nhóm người dùng";
    	var $_icon="icon-settings font-dark";
      var $_pageAccessDenied="no-access";
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
          return view("admin.".$this->_pageAccessDenied);
        }
    	}	
    	public function loadData(Request $request){
      		$filter_search="";
      		$data=DB::select('call pro_getGroupMember(?)',array(mb_strtolower($filter_search)));      		
      		$data=convertToArray($data);    
          $data=groupMemberConverter($data,$this->_controller);         		
          return $data;
    	}    	
      public function getForm($task,$id=""){		 
          $controller=$this->_controller;			
          $title="";
          $icon=$this->_icon; 
          $arrRowData=array();
          $arrGroupPrivilege=array();
          $arrPrivilege=getArrPrivilege();
        $requestControllerAction=$this->_controller."-form";  
        if(in_array($requestControllerAction, $arrPrivilege)){
            switch ($task) {
            case 'edit':
                $title=$this->_title . " : Update";
                $arrRowData=GroupMemberModel::find((int)@$id)->toArray();      
                $arrGroupPrivilege=GroupPrivilegeModel::whereRaw("group_member_id = ?",[(int)@$id])->get()->toArray();
            break;
            case 'add':
                $title=$this->_title . " : Add new";
            break;      
         }             
         $arrPrivilege=PrivilegeModel::select("id","fullname","controller","action","sort_order","created_at","updated_at")->orderBy("controller","asc")->orderBy("sort_order","asc")->get()->toArray();  
          return view("admin.".$this->_controller.".form",compact("arrRowData","arrPrivilege","arrGroupPrivilege","controller","task","title","icon"));
        }else{
          return view("admin.no-access");
        }
          
     }
    public function save(Request $request){
        $id 					           =	trim($request->id)	;        
        $fullname 				       =	trim($request->fullname)	;              
        $sort_order 			       =	trim($request->sort_order);   
        $privilege_id            =  $request->privilege_id;

        $data 		               =  array();
        $info 		               =  array();
        $error 		               =  array();
        $item		                 =  null;
        $checked 	= 1;              
        if(empty($fullname)){
           $checked = 0;
           $error["fullname"]["type_msg"] = "has-error";
           $error["fullname"]["msg"] = "Thiếu tên nhóm người dùng";
        }else{
            $data=array();
             if (empty($id)) {
                $data=GroupMemberModel::whereRaw("trim(lower(fullname)) = ?",[trim(mb_strtolower($fullname,'UTF-8'))])->get()->toArray();	        	
            }else{
              $data=GroupMemberModel::whereRaw("trim(lower(fullname)) = ? and id != ?",[trim(mb_strtolower($fullname,'UTF-8')),(int)@$id])->get()->toArray();		
            }  
            if (count($data) > 0) {
              $checked = 0;
              $error["fullname"]["type_msg"] = "has-error";
              $error["fullname"]["msg"] = "Tên nhóm người dùng đã tồn tại";
            }      	
        }        
        if(empty($sort_order)){
             $checked = 0;
             $error["sort_order"]["type_msg"] 	= "has-error";
             $error["sort_order"]["msg"] 		= "Thiếu sắp xếp";
        }
        
        if ($checked == 1) {    
             if(empty($id)){
              $item 				= 	new GroupMemberModel;       
              $item->created_at 	=	date("Y-m-d H:i:s",time());                      
        } else{
              $item				=	GroupMemberModel::find((int)@$id);                            
        }  
        $item->fullname 		=	$fullname;            
        $item->sort_order 	=	(int)$sort_order;     
        $item->updated_at 	=	date("Y-m-d H:i:s",time());    	        	
        $item->save();  	
        if(count($privilege_id) > 0){
            $arrGroupPrivilege=GroupPrivilegeModel::whereRaw("group_member_id = ?",[(int)@$item->id])->select("privilege_id")->get()->toArray();            
            $arrGroupPrivilegeID=array();
            foreach ($arrGroupPrivilege as $key => $value) {
              $arrGroupPrivilegeID[]=$value["privilege_id"];
            }
            $selected=@$privilege_id;
            sort($selected);
            sort($arrGroupPrivilegeID);        
            $resultCompare=0;
            if($selected == $arrGroupPrivilegeID){
                $resultCompare=1;       
            }
            if($resultCompare==0){
              GroupPrivilegeModel::whereRaw("group_member_id = ?",[(int)@$item->id])->delete();  
              foreach ($selected as $key => $value) {
                $privilege_id=$value;
                $groupPrivilege=new GroupPrivilegeModel;
                $groupPrivilege->group_member_id=(int)@$item->id;
                $groupPrivilege->privilege_id=(int)@$privilege_id;  
                $groupPrivilege->created_at=date("Y-m-d H:i:s",time());
                $groupPrivilege->updated_at=date("Y-m-d H:i:s",time());  
                $groupPrivilege->save();
              }
            }       
        }
        $info = array(
          'type_msg' 			=> "has-success",
          'msg' 				  => 'Lưu dữ liệu thành công',
          "checked" 			=> 1,
          "error" 			  => $error,
          "id"    			  => $id
        );
      } else {
            $info = array(
              'type_msg' 	=> "has-error",
              'msg' 			=> 'Nhập dữ liệu có sự cố',
              "checked" 	=> 0,
              "error" 		=> $error,
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
            $data                   =   User::whereRaw("group_member_id = ?",[(int)@$id])->get()->toArray();    
            if(count($data) > 0){
                $checked     =   0;
                $type_msg           =   "alert-warning";            
                $msg                =   "Không thể xóa";            
            }           
            if($checked == 1){
                $item = GroupMemberModel::find((int)@$id);
                $item->delete();
                GroupPrivilegeModel::whereRaw("group_member_id = ?",[(int)@$id])->delete();
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
            }else{
              foreach ($arrID as $key => $value) {
                if(!empty($value)){
                  $data                   =   User::whereRaw("group_member_id = ?",[(int)@$value])->get()->toArray();                         
                  if(count($data) > 0){
                    $checked     =   0;
                    $type_msg           =   "alert-warning";            
                    $msg                =   "Không thể xóa";
                  }                  
                }                
              }
            }
            if($checked == 1){                
              $strID = implode(',',$arrID);       
              $strID = substr($strID, 0,strlen($strID) - 1);            
              $sqlDeleteGroupMember = "DELETE FROM `group_member` WHERE `id` IN (".$strID.")";        
              $sqlDeleteGroupPrivilege = "DELETE FROM `group_privilege` WHERE `group_member_id` IN (".$strID.")";       
              DB::statement($sqlDeleteGroupMember);
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
                $item=GroupMemberModel::find((int)@$value->id);                
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
