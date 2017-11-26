<?php namespace App\Http\Controllers\admin;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ModuleItemModel;
use App\MenuTypeModel;
use App\MenuModel;
use App\CategoryArticleModel;
use App\CategoryProductModel;
use App\ArticleModel;
use App\ProductModel;
use DB;
class ModuleItemController extends Controller {
  	var $_controller="module-item";	
  	var $_title="Module";
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
    		$data=DB::select('call pro_getModuleItem(?)',array(mb_strtolower($filter_search)));        
    		$data=convertToArray($data);		
    		$data=moduleItemConverter($data,$this->_controller);		    
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
       $arrRowData=ModuleItemModel::find(@$id)->toArray();  
       break;
       case 'add':
       $title=$this->_title . " : Add new";
       break;     
     }    
     $arrCategoryArticle=CategoryArticleModel::select("id","fullname","parent_id")->orderBy("sort_order","asc")->get()->toArray();
     $arrCategoryProduct=CategoryProductModel::select("id","fullname","parent_id")->orderBy("sort_order","asc")->get()->toArray();
     $arrCategoryArticleRecursive=array();      
     $arrCategoryProductRecursive=array();      
     categoryArticleRecursiveForm($arrCategoryArticle ,0,"",$arrCategoryArticleRecursive)  ;    
     categoryProductRecursiveForm($arrCategoryProduct ,0,"",$arrCategoryProductRecursive)  ;         
     return view("admin.".$this->_controller.".form",compact("arrRowData","controller","task","title","icon","arrCategoryArticleRecursive","arrCategoryProductRecursive"));
        } else{
          return view("admin.no-access");
        } 
      
   }
     public function save(Request $request){
          $id 					        =		trim($request->id);        
          $fullname 				    =		trim($request->fullname);
          $item_id              =   trim($request->item_id);                    
          $position 					  = 	trim($request->position);
          $component            =   trim($request->component);  
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
                 $error["fullname"]["msg"] = "Thiếu tên module";
          }else{
              $data=array();
              if (empty($id)) {
                $data=ModuleItemModel::whereRaw("trim(lower(fullname)) = ?",[trim(mb_strtolower($fullname,'UTF-8'))])->get()->toArray();	        	
              }else{
                $data=ModuleItemModel::whereRaw("trim(lower(fullname)) = ? and id != ?",[trim(mb_strtolower($fullname,'UTF-8')),(int)@$id])->get()->toArray();		
              }  
              if (count($data) > 0) {
                  $checked = 0;
                  $error["fullname"]["type_msg"] = "has-error";
                  $error["fullname"]["msg"] = "Tên module đã tồn tại";
              }      	
          } 
          if(empty($item_id)){
             $checked = 0;
             $error["item_id"]["type_msg"]   = "has-error";
             $error["item_id"]["msg"]    = "Thiếu sắp xếp dữ liệu danh sách";
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
                    $item 				      = 	new ModuleItemModel;       
                    $item->created_at 	=	date("Y-m-d H:i:s",time());                            
                } else{
                    $item				        =	ModuleItemModel::find((int)@$id);                        		 
                }  
                $item->fullname 		    =	$fullname;
                $item->item_id          = $item_id;

                $item->position 		    =	$position;  
                $item->component        = $component;  
                $item->status           = (int)$status;                  
                $item->sort_order 	    =	(int)$sort_order;                
                $item->updated_at 	    =	date("Y-m-d H:i:s",time());    	        	
                $item->save();  	                
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
                  $item           =       ModuleItemModel::find((int)@$id);        
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
            $msg                    =   "Xóa thành công";                    
            if($checked == 1){
              $item = ModuleItemModel::find((int)@$id);
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
                    $msg                    =   "Please choose at least one item to delete";
          }
          if($checked==1){
              foreach ($arrID as $key => $value) {
                if(!empty($value)){
                  $item=ModuleItemModel::find($value);
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
              $msg                =   "Please choose at least one item to delete";
            }
            if($checked == 1){                
                  $strID = implode(',',$arrID);   
                  $strID=substr($strID, 0,strlen($strID) - 1);
                  $sql = "DELETE FROM `module_item` WHERE `id` IN  (".$strID.")";                      
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
                $item=ModuleItemModel::find((int)$value->id);                
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
      public function insertArticle(Request $request){
        $str_id                 =   $request->str_id;  
        $str_id=substr($str_id, 0,strlen($str_id) - 1);     
        $sql = 'select 0 AS is_checked , id , fullname , image , sort_order from article where id in ('.$str_id.')';   
        $data=DB::select($sql);       
        $data=convertToArray($data);    
        $data=itemArticleConverter($data,$this->_controller);        
        return $data;
      } 
      public function insertProduct(Request $request){
        $str_id                 =   $request->str_id;  
        $str_id=substr($str_id, 0,strlen($str_id) - 1);     
        $sql = 'select 0 AS is_checked , id , fullname , image , sort_order from product where id in ('.$str_id.')';   
        $data=DB::select($sql);       
        $data=convertToArray($data);    
        $data=itemProductConverter($data,$this->_controller);        
        return $data;
      } 
      public function sortItems(Request $request){
        $data=array();
        $data_sort=$request->data_sort;
        $data=json_decode($data_sort);
        $data=convertToArray($data);    
        $data_1=array();     
        $data_3=array();   
        foreach ($data as $key => $value) {
          $item=array( 
                        'id'=>$value['id'],
                        'sort_order'=>$value['sort_order_text']
                      );
          $data_1[]=$item;
        }
        $data_1=get_field_data_array($data_1,'sort_order');        
        $data_2=get_field_data_array($data,'sort_order_text');        
        ksort($data_1);        
        ksort($data_2); 
        foreach ($data_2 as $key => $value) {
          $sort_input='<center><input name="sort_order" id="sort-order-'.$value['id'].'" sort_order_id="'.$value['id'].'" value="'.$value['sort_order_text'].'" size="3" style="text-align:center"></center>';
          $item=array(
              'checked'=>$value['checked'],
              'deleted'=>$value['deleted'],
              'fullname'=>$value['fullname'],
              'id'=>(int)$value['id'],
              'image'=>$value['image'],
              'is_checked'=>(int)$value['is_checked'],
              'sort_order'=>$sort_input
          ); 
          $data_3[]=$item;   
        }  
        $data_2=$data_3;        
        $data_1=convertToSourceArray($data_1);        
        $dataReturn=array(
            'data_1'=>$data_1,
            'data_2'=>$data_2
        );     
        return $dataReturn;
      }
      public function getItems(Request $request){
        $id=$request->id;
        $arrRowData=ModuleItemModel::find(@$id)->toArray();  
        $item_id=$arrRowData['item_id'];
        $component=$arrRowData['component'];        
        $list=json_decode($item_id);
        $data=array();
        $row=array();        
        if(count($list) > 0){
          $list=convertToArray($list);
          foreach ($list as $key => $value) {
          $sort_order=(int)@$value['sort_order'];          
          switch ($component) {
            case 'article':
              $row=ArticleModel::whereRaw('id = ?',[(int)@$value['id']])->select('id','fullname','image')->get()->toArray()[0];
            break;          
            case 'product':            
              $row=ProductModel::whereRaw('id = ?',[(int)@$value['id']])->select('id','fullname','image')->get()->toArray()[0];
            break;
          } 
          $item=array(
            'is_checked'=>0,
            'id'=>$row['id'],
            'fullname'=>$row['fullname'],
            'image'=>$row['image'],
            'sort_order'=>$sort_order
          );
          $data[]=$item;
        }  
        switch ($component) {
         case 'article':
            $data=itemArticleConverter($data,$this->_controller);
         break;                       
         case 'product':  
            $data=itemProductConverter($data,$this->_controller);       
         break;
       }             
        }
        
       return $data;
      }
}
?>
