<?php namespace App\Http\Controllers\admin;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CategoryArticleModel;
use App\CategoryProductModel;
use App\ArticleModel;
use App\ProductModel;
use App\ArticleCategoryModel;
use DB;
class ArticleController extends Controller {
  	var $_controller="article";	
  	var $_title="Bài viết";
  	var $_icon="icon-settings font-dark";    
  	public function getList(){		
    		$controller=$this->_controller;	
    		$task="list";
    		$title=$this->_title;
    		$icon=$this->_icon;		
        $arrCategoryArticle=CategoryArticleModel::select("id","fullname","parent_id")->orderBy("sort_order","asc")->get()->toArray();
        $arrCategoryArticleRecursive=array();              
        categoryArticleRecursiveForm($arrCategoryArticle ,0,"",$arrCategoryArticleRecursive)  ;          
        $arrPrivilege=getArrPrivilege();
        $requestControllerAction=$this->_controller."-list";         
        if(in_array($requestControllerAction,$arrPrivilege)){
          return view("admin.".$this->_controller.".list",compact("controller","task","title","icon","arrCategoryArticleRecursive")); 
        }
        else{
          return view("admin.no-access");
        }
  	}	    
  	public function loadData(Request $request){
    		$filter_search="";    
        $category_article_id=0;  
        if(!empty(@$request->filter_search)){      
          $filter_search=trim(@$request->filter_search) ;    
        }
        if(!empty(@$request->category_article_id)){
          $category_article_id=(int)@$request->category_article_id;
        }
        /* begin lấy chuỗi ID */
        $arrCategoryArticleID=array();
        $strCategoryArticleID="";
        $arrCategoryArticleID[]=$category_article_id;        
        getStringCategoryID($category_article_id,$arrCategoryArticleID,'category_article');                    
        $strCategoryArticleID=implode("#;#", $arrCategoryArticleID);    
        $strCategoryArticleID="#".$strCategoryArticleID."#";    
        /* end lấy chuỗi ID */        
    		$data=DB::select('call pro_getArticle(?,?)',array(mb_strtolower($filter_search,'UTF-8'),$strCategoryArticleID));        
    		$data=convertToArray($data);		
    		$data=articleConverter($data,$this->_controller);		         
    		return $data;
  	}	
    public function getForm($task,$id=""){     
        $controller=$this->_controller;     
        $title="";
        $icon=$this->_icon; 
        $arrRowData=array();
        $arrArticleCategory=array();
        $arrPrivilege=getArrPrivilege();
        $requestControllerAction=$this->_controller."-form";  
        if(in_array($requestControllerAction, $arrPrivilege)){
          switch ($task) {
           case 'edit':
              $title=$this->_title . " : Update";
              $arrRowData=ArticleModel::find((int)@$id)->toArray();       
              $arrArticleCategory=ArticleCategoryModel::whereRaw("article_id = ?",[(int)@$id])->get()->toArray();
           break;
           case 'add':
              $title=$this->_title . " : Add new";
           break;     
        }    
        $arrCategoryArticle=CategoryArticleModel::select("id","fullname","alias","parent_id","image","sort_order","status","created_at","updated_at")->orderBy("sort_order","asc")->get()->toArray();        
        $arrCategoryArticleRecursive=array();
        categoryArticleRecursiveForm($arrCategoryArticle ,0,"",$arrCategoryArticleRecursive)   ;      
        return view("admin.".$this->_controller.".form",compact("arrCategoryArticleRecursive","arrRowData","arrArticleCategory","controller","task","title","icon"));
        }else{
          return view("admin.no-access");
        }        
    }
     public function save(Request $request){
          $id 					        =		trim($request->id);        
          $fullname 				    =		trim($request->fullname);
          $title                =   trim($request->title);
          $alias 					      = 	trim($request->alias);
          $image                =   trim($request->image);
          $image_hidden         =   trim($request->image_hidden);
          $intro                =   trim($request->intro);
          $content              =   trim($request->content);
          $page_url             =   trim($request->page_url);
          $description          =   trim($request->description);
          $meta_keyword         =   trim($request->meta_keyword);
          $meta_description     =   trim($request->meta_description);
          $sort_order           =   trim($request->sort_order);
          $status               =   trim($request->status);
          $category_article_id	=		$request->category_article_id;            
          $data 		            =   array();
          $info 		            =   array();
          $error 		            =   array();
          $item		              =   null;
          $checked 	            =   1;              
          if(empty($fullname)){
                 $checked = 0;
                 $error["fullname"]["type_msg"] = "has-error";
                 $error["fullname"]["msg"] = "Thiếu tên bài viết";
          }else{
              $data=array();
              if (empty($id)) {
                $data=ArticleModel::whereRaw("trim(lower(fullname)) = ?",[trim(mb_strtolower($fullname,'UTF-8'))])->get()->toArray();	        	
              }else{
                $data=ArticleModel::whereRaw("trim(lower(fullname)) = ? and id != ?",[trim(mb_strtolower($fullname,'UTF-8')),(int)@$id])->get()->toArray();		
              }  
              if (count($data) > 0) {
                  $checked = 0;
                  $error["fullname"]["type_msg"] = "has-error";
                  $error["fullname"]["msg"] = "Bài viết đã tồn tại";
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
              $dataArticle=ArticleModel::whereRaw("trim(lower(alias)) = ? and id != ?",[trim(mb_strtolower($alias,'UTF-8')),(int)@$id])->get()->toArray();    
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
             $error["sort_order"]["msg"] 		= "Thiếu sắp xếp";
          }
          if((int)$status==-1){
             $checked = 0;
             $error["status"]["type_msg"] 		= "has-error";
             $error["status"]["msg"] 			= "Thiếu trạng thái";
          }
          if ($checked == 1) {    
                if(empty($id)){
                    $item 				= 	new ArticleModel;       
                    $item->created_at 	=	date("Y-m-d H:i:s",time());        
                    if(!empty($image)){
                      $item->image    =   trim($image) ;  
                    }				
                } else{
                    $item				=	ArticleModel::find((int)@$id);   
                    $file_image=null;                       
                    if(!empty($image_hidden)){
                      $file_image =$image_hidden;          
                    }
                    if(!empty($image))  {
                      $file_image=$image;                                                
                    }
                    $item->image = $file_image ;            		  		 	
                }  
                $item->fullname 		    =	$fullname;
                $item->title            = $title;
                $item->alias 			      =	$alias;
                $item->intro            = $intro;
                $item->content          = $content;
                $item->page_url         = $page_url;
                $item->description      = $description;
                $item->meta_keyword     = $meta_keyword;
                $item->meta_description = $meta_description;           
                $item->sort_order 		  =	(int)$sort_order;
                $item->status 			    =	(int)$status;    
                $item->updated_at 		  =	date("Y-m-d H:i:s",time());    	        	
                $item->save();  	
                if(count(@$category_article_id)>0){                            
                    $arrArticleCategory=ArticleCategoryModel::whereRaw("article_id = ?",[(int)@$item->id])->select("category_article_id")->get()->toArray();
                    $arrCategoryArticleID=array();
                    foreach ($arrArticleCategory as $key => $value) {
                        $arrCategoryArticleID[]=$value["category_article_id"];
                    }
                    $selected=@$category_article_id;
                    sort($selected);
                    sort($arrCategoryArticleID);         
                    $resultCompare=0;
                    if($selected == $arrCategoryArticleID){
                      $resultCompare=1;       
                    }
                    if($resultCompare==0){
                          ArticleCategoryModel::whereRaw("article_id = ?",[(int)@$item->id])->delete();  
                          foreach ($selected as $key => $value) {
                            $category_article_id=$value;
                            $articleCategory=new ArticleCategoryModel;
                            $articleCategory->article_id=(int)@$item->id;
                            $articleCategory->category_article_id=(int)@$category_article_id;            
                            $articleCategory->save();
                          }
                    }       
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
                      'msg' 				=> 'Lưu dữ liệu thất bại',
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
                  $item           =       ArticleModel::find((int)@$id);        
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
              $item = ArticleModel::find((int)@$id);
                $item->delete();
                ArticleCategoryModel::whereRaw("article_id = ?",[(int)$id])->delete();
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
                    $item=ArticleModel::find($value);
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
                  $sqlDeleteArticle = "DELETE FROM `article` WHERE `id` IN  (".$strID.")";       
                  $sqlDeleteArticleCategory = "DELETE FROM `article_category` WHERE `article_id` IN (".$strID.")";                
                  DB::statement($sqlDeleteArticle);
                  DB::statement($sqlDeleteArticleCategory);           
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
                  $item=ArticleModel::find((int)@$value->id);                
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
