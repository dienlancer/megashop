<?php namespace App\Http\Controllers\admin;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BannerModel;
use DB;
class BannerController extends Controller {
  	var $_controller="banner";	
  	var $_title="Banner";
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
    		$data=DB::select('call pro_getBanner(?)',array(mb_strtolower($filter_search)));        
    		$data=convertToArray($data);		
    		$data=BannerConverter($data,$this->_controller);		    
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
              $arrRowData=BannerModel::find((int)@$id)->toArray();                     
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
          $image                =   trim($request->image);
          $image_hidden         =   trim($request->image_hidden);      
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
                    $item         =   new BannerModel;       
                    $item->created_at   = date("Y-m-d H:i:s",time());        
                    if(!empty($image)){
                      $item->image    =   trim($image) ;  
                    }       
                } else{
                    $item       = BannerModel::find((int)@$id);   
                    $file_image=null;                       
                    if(!empty($image_hidden)){
                      $file_image =$image_hidden;          
                    }
                    if(!empty($image))  {
                      $file_image=$image;                                                
                    }
                    $item->image = $file_image ;                        
                }       
                $item->fullname  =  $fullname;
                $item->alias = $alias;                      
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
                      'msg'         => 'Lưu dữ liệu thất bại',
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
                  $item           =       BannerModel::find((int)@$id);        
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
            $msg                    =   "Xóa thành công";                    
            if($checked == 1){
                $item = BannerModel::find((int)@$id);
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
                    $msg                    =   "Vui lòng chọn ít nhất một phần tử để xóa";
          }
          if($checked==1){
              foreach ($arrID as $key => $value) {
                if(!empty($value)){
                  $item=BannerModel::find($value);
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
            $msg                    =   "Xóa thành công";      
            $arrID                  =   explode(",", $str_id)  ;        
            if(empty($str_id)){
              $checked     =   0;
              $type_msg           =   "alert-warning";            
              $msg                =   "Vui lòng chọn ít nhất một phần tử để xóa";
            }
            if($checked == 1){                
                  $strID = implode(',',$arrID);   
                  $strID=substr($strID, 0,strlen($strID) - 1);
                  $sql = "DELETE FROM `banner` WHERE `id` IN  (".$strID.")";                                 
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
                $item=BannerModel::find((int)$value->id);                
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
