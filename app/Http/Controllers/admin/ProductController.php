<?php namespace App\Http\Controllers\admin;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CategoryArticleModel;
use App\CategoryProductModel;
use App\ArticleModel;
use App\ProductModel;
use App\ProductCategoryModel;
use DB;
class ProductController extends Controller {
  	var $_controller="product";	
  	var $_title="Sản phẩm";
  	var $_icon="icon-settings font-dark";
  	public function getList(){		
    		$controller=$this->_controller;	
    		$task="list";
    		$title=$this->_title;
    		$icon=$this->_icon;		
        $arrCategoryProduct=CategoryProductModel::select("id","fullname","parent_id")->orderBy("sort_order","asc")->get()->toArray();
        $arrCategoryProductRecursive=array();              
        categoryProductRecursiveForm($arrCategoryProduct ,0,"",$arrCategoryProductRecursive)  ;      
    		
        $arrPrivilege=getArrPrivilege();
        $requestControllerAction=$this->_controller."-list";         
        if(in_array($requestControllerAction,$arrPrivilege)){
          return view("admin.".$this->_controller.".list",compact("controller","task","title","icon","arrCategoryProductRecursive")); 
        }
        else{
          return view("admin.no-access");
        }
  	}	
  	public function loadData(Request $request){
    		$filter_search="";    
        $category_product_id=0;  
        if(!empty(@$request->filter_search)){      
          $filter_search=trim(mb_strtolower(@$request->filter_search)) ;   
        }
        if(!empty(@$request->category_product_id)){
          $category_product_id=(int)@$request->category_product_id;
        }
        /* begin lấy chuỗi ID */
        $arrCategoryProductID=array();
        $strCategoryProductID="";
        $arrCategoryProductID[]=$category_product_id;
        getStringCategoryID($category_product_id,$arrCategoryProductID,'category_product');      
        $strCategoryProductID=implode("#;#", $arrCategoryProductID);    
        $strCategoryProductID="#".$strCategoryProductID."#";    
        /* end lấy chuỗi ID */
    		$data=DB::select('call pro_getProduct(?,?)',array( mb_strtolower($filter_search) ,$strCategoryProductID));
    		$data=convertToArray($data);		
    		$data=productConverter($data,$this->_controller);		    
    		return $data;
  	}	
    public function getForm($task,$id=""){     
        $controller=$this->_controller;     
        $title="";
        $icon=$this->_icon; 
        $arrRowData=array();
        $arrProductCategory=array();
        $arrPrivilege=getArrPrivilege();
        $requestControllerAction=$this->_controller."-form";  
        if(in_array($requestControllerAction, $arrPrivilege)){
          switch ($task) {
           case 'edit':
              $title=$this->_title . " : Update";
              $arrRowData=ProductModel::find((int)@$id)->toArray();       
              $arrProductCategory=ProductCategoryModel::whereRaw("product_id = ?",[(int)@$id])->get()->toArray();
           break;
           case 'add':
              $title=$this->_title . " : Add new";
           break;     
        }    
        $arrCategoryProduct=CategoryProductModel::select("id","fullname","alias","parent_id","image","sort_order","status","created_at","updated_at")->orderBy("sort_order","asc")->get()->toArray();        
        $arrCategoryProductRecursive=array();
        categoryProductRecursiveForm($arrCategoryProduct ,0,"",$arrCategoryProductRecursive)   ;      
        return view("admin.".$this->_controller.".form",compact("arrCategoryProductRecursive","arrRowData","arrProductCategory","controller","task","title","icon"));
        }else{
            return view("admin.no-access");
        }
        
    }
        public function save(Request $request){
            $id 					        =		trim($request->id);      
            $code                 =   trim($request->code);  
            $fullname 				    =		trim($request->fullname);          
            $alias                =   trim($request->alias);
            $title                =   trim($request->title);
        $meta_keyword         =   trim($request->meta_keyword);
        $meta_description     =   trim($request->meta_description);
            $image                =   trim($request->image);
            $status               =   trim($request->status);
            $price                =   trim($request->price);   
            $sale_price                =   trim($request->sale_price);                    
            $detail               =   trim($request->detail);
            $intro               =   trim($request->intro);
            $image_hidden         =   trim($request->image_hidden);  
            $child_image          =   trim($request->child_image);        
            $child_image_hidden   =   trim($request->child_image_hidden);                    
            $sort_order           =   trim($request->sort_order);          
            $category_product_id	=		($request->category_product_id);            
            $data 		            =   array();
            $info 		            =   array();
            $error 		            =   array();
            $item		              =   null;
            $checked 	            =   1;        
            if(empty($code)){
                 $checked = 0;
                 $error["code"]["type_msg"] = "has-error";
                 $error["code"]["msg"] = "Thiếu mã sản phẩm";
            }else{
                $data=array();
                if (empty($id)) {
                  $data=ProductModel::whereRaw("trim(lower(code)) = ?",[trim(mb_strtolower($code,'UTF-8'))])->get()->toArray();           
                }else{
                  $data=ProductModel::whereRaw("trim(lower(code)) = ? and id != ?",[trim(mb_strtolower($code,'UTF-8')),(int)@$id])->get()->toArray();   
                }  
                if (count($data) > 0) {
                  $checked = 0;
                  $error["code"]["type_msg"] = "has-error";
                  $error["code"]["msg"] = "Mã sản phẩm đã tồn tại";
                }       
            }      
            if(empty($fullname)){
               $checked = 0;
               $error["fullname"]["type_msg"] = "has-error";
               $error["fullname"]["msg"] = "Thiếu tên sản phẩm";
           }else{
                $data=array();
                if (empty($id)) {
                  $data=ProductModel::whereRaw("trim(lower(fullname)) = ?",[trim(mb_strtolower($fullname,'UTF-8'))])->get()->toArray();	        	
                }else{
                  $data=ProductModel::whereRaw("trim(lower(fullname)) = ? and id != ?",[trim(mb_strtolower($fullname,'UTF-8')),(int)@$id])->get()->toArray();		
                }  
                if (count($data) > 0) {
                  $checked = 0;
                  $error["fullname"]["type_msg"] = "has-error";
                  $error["fullname"]["msg"] = "Tên sản phẩm đã tồn tại";
                }      	
            }          
      if(empty($alias)){
            $checked = 0;
            $error["alias"]["type_msg"] = "has-error";
            $error["alias"]["msg"] = "Thiếu alias";
      }else{
            $dataCategoryArticle=array();
              $dataCategoryProduct=array();
              $dataArticle=array();
              $dataProduct=array();
             if (empty($id)) {
              $dataCategoryArticle=CategoryArticleModel::whereRaw("trim(lower(alias)) = ?",[trim(mb_strtolower($alias,'UTF-8'))])->get()->toArray();
              $dataCategoryProduct=CategoryProductModel::whereRaw("trim(lower(alias)) = ?",[trim(mb_strtolower($alias,'UTF-8'))])->get()->toArray();
              $dataArticle=ArticleModel::whereRaw("trim(lower(alias)) = ?",[trim(mb_strtolower($alias,'UTF-8'))])->get()->toArray();
              $dataProduct=ProductModel::whereRaw("trim(lower(alias)) = ?",[trim(mb_strtolower($alias,'UTF-8'))])->get()->toArray();
            }else{
              $dataProduct=ProductModel::whereRaw("trim(lower(alias)) = ? and id != ?",[trim(mb_strtolower($alias,'UTF-8')),(int)@$id])->get()->toArray();    
            }  
            if (count($dataCategoryArticle) > 0) {
              $checked = 0;
              $error["alias"]["type_msg"]   = "has-error";
              $error["alias"]["msg"]      = "Alias đã tồn tại";
            }
            if (count($dataCategoryProduct) > 0) {
              $checked = 0;
              $error["alias"]["type_msg"]   = "has-error";
              $error["alias"]["msg"]      = "Alias đã tồn tại";
            }
            if (count($dataArticle) > 0) {
              $checked = 0;
              $error["alias"]["type_msg"]   = "has-error";
              $error["alias"]["msg"]      = "Alias đã tồn tại";
            }
            if (count($dataProduct) > 0) {
              $checked = 0;
              $error["alias"]["type_msg"]   = "has-error";
              $error["alias"]["msg"]      = "Alias đã tồn tại";
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
                $item 				= 	new ProductModel;       
                $item->created_at 	=	date("Y-m-d H:i:s",time());        
                if(!empty($image)){
                  $item->image    =   trim($image) ;  
                }				
          } else{
                $item				=	ProductModel::find((int)@$id);   
                $file_image=null;                       
                if(!empty($image_hidden)){
                  $file_image =$image_hidden;          
                }
                if(!empty($image))  {
                  $file_image=$image;                                                
                }
                $item->image = $file_image ;            		  		 	
          }  
          $item->code         = $code;
          $item->fullname 		=	$fullname;                
          $item->alias 			  =	$alias;  
          $item->title            = $title;
        $item->meta_keyword     = $meta_keyword;
        $item->meta_description = $meta_description;                  
          $item->status       = (int)$status;    
          $item->price        = (int)$price;
          $item->sale_price   = (int)$sale_price;
          $item->detail       = $detail;       
          $item->intro        = $intro;                                           
          $item->sort_order 	=	(int)$sort_order;                
          $item->updated_at 	=	date("Y-m-d H:i:s",time());  
          // begin upload product child image  
          $arrImage=array();              
          if(!empty($child_image)){
            $arrChildImage=explode(',', $child_image);
            if(count($arrChildImage) > 0){
              for($i=0;$i<count($arrChildImage);$i++){
                $arrImage[]=$arrChildImage[$i];
              }
            }
          }
          if(!empty($child_image_hidden)){
            $arrChildImageHidden=explode(',', $child_image_hidden);
            if(count($arrChildImageHidden) > 0){
              for($i=0;$i<count($arrChildImageHidden);$i++){
                $arrImage[]=$arrChildImageHidden[$i];
              }
            }
          }
          $item->child_image=null;
          if(count($arrImage) > 0){
            $item->child_image=json_encode($arrImage);  
          }
          // end upload product child image  	        	
          $item->save();  	
          if(count(@$category_product_id) > 0){                            
              $arrProductCategory=ProductCategoryModel::whereRaw("product_id = ?",[@$item->id])->select("category_product_id")->get()->toArray();
              $arrCategoryProductID=array();
              foreach ($arrProductCategory as $key => $value) {
                $arrCategoryProductID[]=$value["category_product_id"];
              }
              $selected=@$category_product_id;
              sort($selected);
              sort($arrCategoryProductID);         
              $resultCompare=0;
              if($selected == $arrCategoryProductID){
                $resultCompare=1;       
              }
              if($resultCompare==0){
                ProductCategoryModel::whereRaw("product_id = ?",[(int)@$item->id])->delete();  
                foreach ($selected as $key => $value) {
                  $category_product_id=$value;
                  $productCategory=new ProductCategoryModel;
                  $productCategory->product_id=(int)@$item->id;
                  $productCategory->category_product_id=(int)$category_product_id;            
                  $productCategory->save();
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
                  $msg                    =   "Cập nhật thành công";              
                  $status         =       (int)$request->status;
                  $item           =       ProductModel::find((int)@$id);        
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
              $item = ProductModel::find((int)@$id);
                $item->delete();
                ProductCategoryModel::whereRaw("product_id = ?",[(int)$id])->delete();
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
                    $item=ProductModel::find($value);
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
                  $sqlDeleteproduct = "DELETE FROM `product` WHERE `id` IN  (".$strID.")";       
                  $sqlDeleteproductCategory = "DELETE FROM `product_category` WHERE `product_id` IN (".$strID.")";                
                  DB::statement($sqlDeleteproduct);
                  DB::statement($sqlDeleteproductCategory);           
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
                  $item=ProductModel::find((int)$value->id);                
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
      $setting= getSettingSystem();
      uploadImage($_FILES["image"],$setting['product_width'],$setting['product_height']);
    }
}
?>
