<?php namespace App\Http\Controllers\admin;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\GroupMemberModel;
use App\UserGroupModel;
use DB;
use Hash;
use Sentinel;
class UserController extends Controller {
  	var $_controller="user";	
  	var $_title="Người dùng";
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
        $group_member_id=0;  
        if(!empty(@$request->filter_search)){      
          $filter_search=trim(@$request->filter_search) ;    
        }
        if(!empty(@$request->group_member_id)){
          $group_member_id=(int)@$request->group_member_id;
        }        
    		$data=DB::select('call pro_getUser(?,?)',array(mb_strtolower($filter_search),$group_member_id));
    		$data=convertToArray($data);		
    		$data=userConverter($data,$this->_controller);		    
    		return $data;
  	}	
    public function getForm($task,$id=""){     
        $controller=$this->_controller;     
        $title="";
        $icon=$this->_icon; 
        $arrRowData=array();
        $arrUserGroup=array();
        $arrPrivilege=getArrPrivilege();
        $requestControllerAction=$this->_controller."-form";  
        if(in_array($requestControllerAction, $arrPrivilege)){
          switch ($task) {
           case 'edit':
              $title=$this->_title . " : Update";
              $arrRowData=User::find((int)@$id)->toArray();  
           break;
           case 'add':
              $title=$this->_title . " : Add new";
           break;     
        }    
        $arrGroupMember=GroupMemberModel::select("id","fullname","created_at","updated_at")->get()->toArray();      
        return view("admin.".$this->_controller.".form",compact("arrRowData","arrGroupMember","controller","task","title","icon"));
        }else{
          return view("admin.no-access");
        }      
    }
     public function save(Request $request){
          $id 					        =		trim(@$request->id); 
          $username             =   trim(@$request->username);       
          $email 				        =		trim(@$request->email);
          $password             =   trim(@$request->password);
          $confirm_password     =   trim(@$request->confirm_password);
          $status               =   trim(@$request->status);          
          $fullname 					  = 	trim(@$request->fullname);    
          $image                =   trim(@$request->image);
          $image_hidden         =   trim(@$request->image_hidden);
          $group_member_id      =   trim(@$request->group_member_id);                      
          $sort_order           =   trim(@$request->sort_order);                          
          $data 		            =   array();
          $info 		            =   array();
          $error 		            =   array();
          $item		              =   null;
          $checked 	            =   1;                   
          if(empty($fullname)){
                 $checked = 0;
                 $error["fullname"]["type_msg"] = "has-error";
                 $error["fullname"]["msg"] = "Thiếu tên người dùng";
          }
          if(empty($group_member_id)){
                 $checked = 0;
                 $error["group_member_id"]["type_msg"] = "has-error";
                 $error["group_member_id"]["msg"] = "Thiếu nhóm người dùng";
          }
          if(empty($username)){
                 $checked = 0;
                 $error["username"]["type_msg"] = "has-error";
                 $error["username"]["msg"] = "Thiếu username";
          }else{
              $data=array();
              if (empty($id)) {
                $data=User::whereRaw("trim(lower(username)) = ?",[trim(mb_strtolower($username,'UTF-8'))])->get()->toArray();           
              }else{
                $data=User::whereRaw("trim(lower(username)) = ? and id != ?",[trim(mb_strtolower($username,'UTF-8')),(int)@$id])->get()->toArray();   
              }  
              if (count($data) > 0) {
                  $checked = 0;
                  $error["username"]["type_msg"] = "has-error";
                  $error["username"]["msg"] = "Username đã tồn tại";
              }       
          }
          if(empty($email)){
                 $checked = 0;
                 $error["email"]["type_msg"] = "has-error";
                 $error["email"]["msg"] = "Thiếu email";
          }else{
              $data=array();
              if (empty($id)) {
                $data=User::whereRaw("trim(lower(email)) = ?",[trim(mb_strtolower($email,'UTF-8'))])->get()->toArray();           
              }else{
                $data=User::whereRaw("trim(lower(email)) = ? and id != ?",[trim(mb_strtolower($email,'UTF-8')),(int)@$id])->get()->toArray();   
              }  
              if (count($data) > 0) {
                  $checked = 0;
                  $error["email"]["type_msg"] = "has-error";
                  $error["email"]["msg"] = "Email đã tồn tại";
              }       
          }
          $password         = trim(mb_strtolower($password));
          $confirm_password = trim(mb_strtolower($confirm_password));
          if(empty($id)){
              if(mb_strlen($password) < 6 ){
                  $checked = 0;
                  $error["password"]["type_msg"] = "has-error";
                  $error["password"]["msg"] = "Mật khẩu tối thiểu phải 6 ít tự";
              }else{
                  if(strcmp($password, $confirm_password) !=0 ){
                    $checked = 0;
                    $error["password"]["type_msg"] = "has-error";
                    $error["password"]["msg"] = "Xác nhận mật khẩu không trùng khớp";
                  }
              }     
          }else{
              if(!empty($password) || !empty($confirm_password)){
                  if(mb_strlen($password) < 6 ){
                    $checked = 0;
                    $error["password"]["type_msg"] = "has-error";
                    $error["password"]["msg"] = "Mật khẩu tối thiểu phải 6 ít tự";
                  }else{
                      if(strcmp($password, $confirm_password) !=0 ){
                        $checked = 0;
                        $error["password"]["type_msg"] = "has-error";
                        $error["password"]["msg"] = "Xác nhận mật khẩu không trùng khớp";
                      }
                  }        
              }     
          }
          if(empty($sort_order)){
             $checked = 0;
             $error["sort_order"]["type_msg"] 	= "has-error";
             $error["sort_order"]["msg"] 		= "Thiếu sắp xếp";
          }
          if((int)$status==-1){
             $checked = 0;
             $error["status"]["type_msg"] 		= "has-error";
             $error["status"]["msg"] 			= "Thiếu trạng thái";
          }
          if ($checked == 1) {   

                if(empty($id)){
                  $user=Sentinel::registerAndActivate($request->all());
                } else{
                    $item				=	User::find((int)@$id);        
                    $item->username         = $username;
                    $item->email            = $email;
                    if(!empty($password)){
                      $item->password         = Hash::make(trim($password));
                    }                                
                    $item->status            = (int)$status;
                    $item->fullname         = $fullname;   
                    $file_image=null;                       
                    if(!empty($image_hidden)){
                      $file_image =$image_hidden;          
                    }
                    if(!empty($image))  {
                      $file_image=$image;                                                
                    }
                    $item->image = $file_image ;                
                    if(!empty($group_member_id)){
                        $item->group_member_id            = (int)@$group_member_id;
                    }              
                    $item->sort_order       = (int)@$sort_order;                
                    $item->updated_at       = date("Y-m-d H:i:s",time());               
                    $item->save();                           		  		 	
                }                  
                $info = array(
                  'type_msg' 			=> "has-success",
                  'msg' 				=> 'Lưu dữ liệu thành công',
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
          public function changeStatus(Request $request){
                  $id             =       (int)$request->id;     
                  $checked                =   1;
                  $type_msg               =   "alert-success";
                  $msg                    =   "Cập nhật thành công";              
                  $status         =       (int)$request->status;
                  $item           =       User::find((int)@$id);        
                  $item->status   =       (int)@$status;
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
            $msg                    =   "Xóa thành công";                    
            if($checked == 1){
                $item = User::find((int)@$id);
                $item->delete();            
                $sql = "DELETE FROM `activations` WHERE `user_id` IN  (".$id.")";
                DB::statement($sql);    
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
          $arrID                  =   explode(",", $str_id)  ;
          $checked                =   1;
          $type_msg               =   "alert-success";
          $msg                    =   "Cập nhật thành công";     
          if(empty($str_id)){
                    $checked                =   0;
                    $type_msg               =   "alert-warning";            
                    $msg                    =   "Please choose at least one item to delete";
          }
          if($checked==1){
              foreach ($arrID as $key => $value) {
                if(!empty($value)){
                    $item=User::find((int)@$value);
                    $item->status=(int)@$status;
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
            $msg                    =   "Xóa thành công";      
            $arrID                  =   explode(",", $str_id)  ;        
            if(empty($str_id)){
              $checked              =   0;
              $type_msg             =   "alert-warning";            
              $msg                  =   "Please choose at least one item to delete";
            }
            if($checked == 1){                
                  $strID            = implode(',',$arrID);   
                  $strID            = substr($strID, 0,strlen($strID) - 1);
                  $sqlUser          = "DELETE FROM `users` WHERE `id` IN (".$strID.")";        
                  $sqlActivation    = "DELETE FROM `activations` WHERE `user_id` IN  (".$strID.")";
                  DB::statement($sqlUser);                      
                  DB::statement($sqlActivation);       
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
                  $item=User::find((int)@$value->id);                
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
      public function uploadFile(Request $request){           
          $uploadDir = base_path("upload");                 
          $fileObj=$_FILES["image"];          
          $fileName="";
          if($fileObj['tmp_name'] != null){                
            $fileName   = $fileObj['name'];
            @copy($fileObj['tmp_name'], $uploadDir . DS . $fileName);                   
          }   
        }
}
?>
