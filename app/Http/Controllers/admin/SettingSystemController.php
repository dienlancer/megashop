<?php namespace App\Http\Controllers\admin;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SettingSystemModel;
use DB;
class SettingSystemController extends Controller {
  	var $_controller="setting-system";	
  	var $_title="Cấu hình";
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
    		$data=DB::select('call pro_getSettingSystem(?)',array(mb_strtolower($filter_search)));        
    		$data=convertToArray($data);		
    		$data=settingSystemConverter($data,$this->_controller);		    
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
              $arrRowData=SettingSystemModel::find((int)@$id)->toArray();                     
           break;
           case 'add':
              $title=$this->_title . " : Add new";
           break;     
        }    
        return view("admin.".$this->_controller.".form",compact("arrRowData","controller","task","title","icon"));
        } else{
          return view("admin.no-access");
        }     
        
    }
     public function save(Request $request){
          $id                   =   trim($request->id);        
          $fullname             =   trim($request->fullname);
          $alias                =   trim($request->alias);
          $article_perpage      =   trim($request->article_perpage);                    
          $product_perpage      =   trim($request->product_perpage);          
          $product_width        =   trim($request->product_width);          
          $product_height       =   trim($request->product_height);          
          $currency_unit        =   trim($request->currency_unit);          
          $smtp_host            =   trim($request->smtp_host);          
          $smtp_port            =   trim($request->smtp_port);          
          $encription           =   trim($request->encription);          
          $authentication       =   trim($request->authentication);          
          $smtp_username        =   trim($request->smtp_username);          
          $smtp_password        =   trim($request->smtp_password);          
          $email_from           =   trim($request->email_from);          
          $email_to             =   trim($request->email_to);          
          $from_name            =   trim($request->from_name);          
          $to_name              =   trim($request->to_name);          
          $contacted_phone      =   trim($request->contacted_phone);          
          $address              =   trim($request->address);          
          $website              =   trim($request->website);          
          $telephone            =   trim($request->telephone);          
          $opened_time          =   trim($request->opened_time);          
          $opened_date          =   trim($request->opened_date);          
          $contacted_name       =   trim($request->contacted_name);          
          $facebook_url         =   trim($request->facebook_url);          
          $twitter_url          =   trim($request->twitter_url);          
          $google_plus          =   trim($request->google_plus);          
          $youtube_url          =   trim($request->youtube_url);          
          $instagram_url        =   trim($request->instagram_url);   
          $pinterest_url        =   trim($request->pinterest_url);   
          $slogan_about         =   trim($request->slogan_about);   
          $map_url              =   trim($request->map_url);     
          $status               =   trim($request->status);        
          $sort_order           =   trim($request->sort_order);                  
          $data                 =   array();
          $info                 =   array();
          $error                =   array();
          $item                 =   null;
          $checked              =   1;                      
          if(empty($sort_order)){
             $checked = 0;
             $error["sort_order"]["type_msg"]   = "has-error";
             $error["sort_order"]["msg"]    = "Thiếu sắp xếp";
          }
          if((int)$status==-1){
             $checked = 0;
             $error["status"]["type_msg"]     = "has-error";
             $error["status"]["msg"]      = "Thiếu trạng thái";
          }                    
          if ($checked == 1) {    
                if(empty($id)){
                    $item         =   new SettingSystemModel;       
                    $item->created_at   = date("Y-m-d H:i:s",time());                             
                } else{
                    $item       = SettingSystemModel::find((int)@$id);                                           
                }        
                $item->fullname  =  $fullname;
                $item->alias = $alias;
                $item->article_perpage = $article_perpage;                                   
                $item->product_perpage = $product_perpage;                   
                $item->product_width = $product_width;                   
                $item->product_height = $product_height;                   
                $item->currency_unit = $currency_unit;                   
                $item->smtp_host = $smtp_host;                   
                $item->smtp_port = $smtp_port;                   
                $item->encription = $encription;                   
                $item->authentication = $authentication;                   
                $item->smtp_username = $smtp_username;                   
                $item->smtp_password = $smtp_password;                   
                $item->email_from = $email_from;                   
                $item->email_to = $email_to;                   
                $item->from_name = $from_name;                   
                $item->to_name = $to_name;                   
                $item->contacted_phone = $contacted_phone;                   
                $item->address = $address;                   
                $item->website = $website;                   
                $item->telephone = $telephone;                   
                $item->opened_time = $opened_time;                   
                $item->opened_date = $opened_date;                   
                $item->contacted_name = $contacted_name;                   
                $item->facebook_url = $facebook_url;                   
                $item->twitter_url = $twitter_url;                   
                $item->google_plus = $google_plus;                   
                $item->youtube_url = $youtube_url;                   
                $item->instagram_url = $instagram_url;                   
                $item->pinterest_url = $pinterest_url;                   
                $item->slogan_about = $slogan_about;                   
                $item->map_url = $map_url;                                   
                $item->sort_order       = (int)@$sort_order;
                $item->status           = (int)@$status;    
                $item->updated_at       = date("Y-m-d H:i:s",time());               
                $item->save();                    
                $info = array(
                  'type_msg'      => "has-success",
                  'msg'         => 'Lưu dữ liệu thành công',
                  "checked"       => 1,
                  "error"       => $error,
                  "id"          => $id
                );
            }else {
                    $info = array(
                      'type_msg'      => "has-error",
                      'msg'         => 'Dữ liệu nhập gặp sự cố',
                      "checked"       => 0,
                      "error"       => $error,
                      "id"        => ""
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
                  $item           =       SettingSystemModel::find((int)@$id);        
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
            $id                     =   (int)@$request->id;              
            $checked                =   1;
            $type_msg               =   "alert-success";
            $msg                    =   "Xóa dữ liệu thành công";                    
            if($checked == 1){
                $item = SettingSystemModel::find((int)@$id);
                $item->delete();                
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
          $msg                    =   "Cập nhật thành công";     
          if(empty($str_id)){
                    $checked                =   0;
                    $type_msg               =   "alert-warning";            
                    $msg                    =   "Vui lòng chọn ít nhất 1 phần tử";
          }
          if($checked==1){
              foreach ($arrID as $key => $value) {
                if(!empty($value)){
                  $item=SettingSystemModel::find($value);
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
            $msg                    =   "Xóa dữ liệu thành công";      
            $arrID                  =   explode(",", $str_id)  ;        
            if(empty($str_id)){
              $checked     =   0;
              $type_msg           =   "alert-warning";            
              $msg                =   "Vui lòng chọn ít nhất 1 phần tử";
            }
            if($checked == 1){                
                  $strID = implode(',',$arrID);   
                  $strID=substr($strID, 0,strlen($strID) - 1);
                  $sql = "DELETE FROM `setting_system` WHERE `id` IN  (".$strID.")";                                 
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
      public function sortOrder(Request $request){
            $sort_json              =   $request->sort_json;           
            $data_order             =   json_decode($sort_json);       
            $checked                =   1;
            $type_msg               =   "alert-success";
            $msg                    =   "Cập nhật thành công";      
            if(count($data_order) > 0){              
              foreach($data_order as $key => $value){       
              if(!empty($value)){
                $item=SettingSystemModel::find((int)$value->id);                
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
