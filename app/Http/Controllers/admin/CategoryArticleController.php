<?php namespace App\Http\Controllers\admin;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CategoryArticleModel;
use App\SettingSystemModel;
use App\ArticleModel;
use App\ArticleCategoryModel;
use App\PaginationModel;
use DB;
class CategoryArticleController extends Controller {
    	var $_controller="category-article";	
    	var $_title="Category Article";
    	var $_icon="icon-settings font-dark";
      var $_totalItemsPerPage=9999;    
      var $_pageRange=10;
    	public function getList(){		
    		$controller=$this->_controller;	
    		$task="list";
    		$title=$this->_title;
    		$icon=$this->_icon;	
        $currentPage=1; 	
        $filter_search="";
        if(!empty(@$_POST["filter_search"])){
          $filter_search=@$_POST["filter_search"];        
        }        
        $data=DB::select('call pro_getCategoryArticle(?)',array(mb_strtolower($filter_search)));
        $totalItems=count($data);
        $totalItemsPerPage=$this->_totalItemsPerPage;       
        $pageRange=$this->_pageRange;
        if(!empty(@$_POST["filter_page"])){
          $currentPage=(int)@$_POST["filter_page"];    
        }            
        $arrPagination=array(
          "totalItems"=>$totalItems,
          "totalItemsPerPage"=>$totalItemsPerPage,
          "pageRange"=>$pageRange,
          "currentPage"=>$currentPage 
        );
        $pagination=new PaginationModel($arrPagination);
        $position = (@$arrPagination['currentPage']-1)*$totalItemsPerPage;
        $data=array();
        if($totalItemsPerPage > 0){
            $data=DB::select('call pro_getCategoryArticleLimit(?,?,?)',array($filter_search,$position,$totalItemsPerPage));
        }        
        $data=convertToArray($data);
        $data=categoryArticleConverter($data,$this->_controller);   
        $data_recursive=array();
        categoryArticleRecursive($data,0,null,$data_recursive);          
        $data=$data_recursive; 
    		return view("admin.".$this->_controller.".list",compact("controller","task","title","icon",'data','pagination','filter_search'));	
    	}	
    	
      public function getForm($task,$id=""){		 
          $controller=$this->_controller;			
          $title="";
          $icon=$this->_icon; 
          $arrRowData=array();                     
          switch ($task) {
            case 'edit':
                $title=$this->_title . " : Update";
                $arrRowData=CategoryArticleModel::find((int)@$id)->toArray();			 
            break;
            case 'add':
                $title=$this->_title . " : Add new";
            break;			
         }		         
         $arrCategoryArticle=CategoryArticleModel::select("id","fullname","parent_id")->where("id","!=",(int)$id)->orderBy("sort_order","asc")->get()->toArray();
         $arrCategoryArticleRecursive=array();			
         categoryArticleRecursiveForm($arrCategoryArticle ,0,"",$arrCategoryArticleRecursive)	 ;			
         return view("admin.".$this->_controller.".form",compact("arrCategoryArticleRecursive","arrRowData","controller","task","title","icon"));	
     }
    public function save(Request $request){
        $id 					           =	trim($request->id)	;        
        $fullname 				       =	trim($request->fullname)	;
        $alias 					         = 	trim($request->alias);
        $title                =   trim($request->title);
        $meta_keyword         =   trim($request->meta_keyword);
        $meta_description     =   trim($request->meta_description);
        $category_article_id	   =	trim($request->category_article_id);
        $image                   =  trim($request->image);
        $image_hidden            =  trim($request->image_hidden);
        $sort_order 			       =	trim($request->sort_order);
        $status 				         =  trim($request->status);
        $data 		               =  array();
        $info 		               =  array();
        $error 		               =  array();
        $item		                 =  null;
        $checked 	= 1;              
        if(empty($fullname)){
           $checked = 0;
           $error["fullname"]["type_msg"] = "has-error";
           $error["fullname"]["msg"] = "Fullname is required";
        }else{
            $data=array();
             if (empty($id)) {
                $data=CategoryArticleModel::whereRaw("trim(lower(fullname)) = ?",[trim(mb_strtolower($fullname,'UTF-8'))])->get()->toArray();	        	
            }else{
              $data=CategoryArticleModel::whereRaw("trim(lower(fullname)) = ? and id != ?",[trim(mb_strtolower($fullname,'UTF-8')),(int)@$id])->get()->toArray();		
            }  
            if (count($data) > 0) {
              $checked = 0;
              $error["fullname"]["type_msg"] = "has-error";
              $error["fullname"]["msg"] = "Fullname is existed in system";
            }      	
        }
        if(empty($alias)){
             $checked = 0;
             $error["alias"]["type_msg"] = "has-error";
             $error["alias"]["msg"] = "Alias is required";
        }else{
              $data=array();
             if (empty($id)) {
              $data=CategoryArticleModel::whereRaw("trim(lower(alias)) = ?",[trim(mb_strtolower($alias,'UTF-8'))])->get()->toArray();	        	
            }else{
              $data=CategoryArticleModel::whereRaw("trim(lower(alias)) = ? and id != ?",[trim(mb_strtolower($alias,'UTF-8')),(int)@$id])->get()->toArray();		
            }  
            if (count($data) > 0) {
              $checked = 0;
              $error["alias"]["type_msg"] 	= "has-error";
              $error["alias"]["msg"] 			= "Alias is existed in system";
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
              $item 				= 	new CategoryArticleModel;       
              $item->created_at 	=	date("Y-m-d H:i:s",time());        
              if(!empty($image)){
                $item->image    =   trim($image) ;  
              }				
        } else{
              $item				=	CategoryArticleModel::find((int)@$id);   
              $file_image=null;                       
              if(!empty($image_hidden)){
                $file_image =$image_hidden;          
              }
              if(!empty($image))  {
                $file_image=$image;                                                
              }
              $item->image = $file_image ;                 
        }  
        $item->fullname 		=	$fullname;
        $item->alias 			  =	$alias;
        $item->title            = $title;
        $item->meta_keyword     = $meta_keyword;
        $item->meta_description = $meta_description;           
        $item->parent_id 		=	(int)$category_article_id;            
        $item->sort_order 	=	(int)$sort_order;
        $item->status 			=	(int)$status;    
        $item->updated_at 	=	date("Y-m-d H:i:s",time());    	        	
        $item->save();  	
        $info = array(
          'type_msg' 			=> "has-success",
          'msg' 				=> 'Save data successfully',
          "checked" 			=> 1,
          "error" 			=> $error,
          "id"    			=> $id
        );
      } else {
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
            $status         =       (int)$request->status;
            
            $item=CategoryArticleModel::find($id);
            $trangThai=0;
            if($status==0){
              $trangThai=1;
            }
            else{
              $trangThai=0;
            }
            $item->status=$status;
            $item->save();
            $result = array(
                        'id'      => $id, 
                        'status'  => $status, 
                        'link'    => 'javascript:changeStatus('.$id.','.$trangThai.');'
                    );
            return $result;   
      }
      public function deleteImage(Request $request){
          $id                     =   (int)$request->id;              
          $checked                =   1;
          $type_msg               =   "alert-success";
          $msg                    =   "Delete successfully";            
        
          if($checked == 1){
              $item = CategoryArticleModel::find((int)@$id);
              $item->image     = null;      
              $item->save();  
          }          
          $info = array(
            'checked'           => $checked,
            'type_msg'          => $type_msg,                
            'msg'               => $msg,                    
          );
          return $info;
      }
      public function deleteItem($id){           
            $checked                =   1;
            $type_msg               =   "alert-success";
            $msg                    =   "Delete successfully";                        
            $data                   =   CategoryArticleModel::whereRaw("parent_id = ?",[(int)@$id])->get()->toArray();  
            if(count($data) > 0){
                $checked     =   0;
                $type_msg           =   "alert-warning";            
                $msg                =   "Cannot delete this item";            
            }
            $data                   =   ArticleCategoryModel::whereRaw("category_article_id = ?",[(int)@$id])->get()->toArray();              
            if(count($data) > 0){
                $checked     =   0;
                $type_msg           =   "alert-warning";            
                $msg                =   "Cannot delete this item";            
            }
            if($checked == 1){
                $item               =   CategoryArticleModel::find((int)@$id);
                $item->delete();            
            }        
             return redirect()->route("admin.".$this->_controller.".getList")->with(["message"=>array("type_msg"=>$type_msg,"msg"=>$msg)]); 
      }
      public function updateStatus(Request $request,$status){        
        $arrID=$request->cid;
         $type_msg               =   "alert-success";
          $msg                    =   "Update successfully";    
          $checked                =   1; 
        if(count($arrID)==0){
          $checked                =   0;
                    $type_msg               =   "alert-warning";            
                    $msg                    =   "Please choose at least one item to update";
        }
        if($checked==1){
          foreach ($arrID as $key => $value) {
          $item=CategoryArticleModel::find($value);
          $item->status=$status;
          $item->save();    
        }
        }        
        return redirect()->route("admin.".$this->_controller.".getList")->with(["message"=>array("type_msg"=>$type_msg,"msg"=>$msg)]); 
      }
      public function trash(Request $request){            
          $arrID                 =   $request->cid;             
            $checked                =   1;
            $type_msg               =   "alert-success";
            $msg                    =   "Delete successfully";      
            $arrID                 =   $request->cid;   
            if(count($arrID)==0){
              $checked     =   0;
              $type_msg           =   "alert-warning";            
              $msg                =   "Please choose at least one item to delete";
            }else{
              foreach ($arrID as $key => $value) {
                if(!empty($value)){
                  $data                   =   CategoryArticleModel::whereRaw("parent_id = ?",[(int)@$value])->get()->toArray();                    
                  if(count($data) > 0){
                    $checked     =   0;
                    $type_msg           =   "alert-warning";            
                    $msg                =   "Cannot delete this item";
                  }
                  $data                   =   ArticleCategoryModel::whereRaw("category_article_id = ?",[(int)@$value])->get()->toArray();                     
                  if(count($data) > 0){
                    $checked     =   0;
                    $type_msg           =   "alert-warning";            
                    $msg                =   "Cannot delete this item"; 
                  }
                }                
              }
            }
            if($checked == 1){                
              $strID = implode(',',$arrID);                     
              $sql = "DELETE FROM `category_article` WHERE `id` IN (".$strID.")";                 
              DB::statement($sql);    
            }
            return redirect()->route("admin.".$this->_controller.".getList")->with(["message"=>array("type_msg"=>$type_msg,"msg"=>$msg)]); 
    }
    public function sortOrder(Request $request){
      $checked                =   1;
      $type_msg               =   "alert-success";
      $msg                    =   "Sort successfully"; 
      $arrOrder=array();
      $arrOrder=$request->sort_order;  
      if(count($arrOrder) == 0){
        $checked     =   0;
        $type_msg           =   "alert-warning";            
        $msg                =   "Please choose at least one item to sort";
      }
      if($checked==1){        
        foreach($arrOrder as $id => $value){                    
          $item=CategoryArticleModel::find($id);
          $item->sort_order=(int)$value;            
          $item->save();            
        }     
      }    
      return redirect()->route("admin.".$this->_controller.".getList")->with(["message"=>array("type_msg"=>$type_msg,"msg"=>$msg)]); 
    }
    public function uploadFile(Request $request){           
          $uploadDir = base_path() . DS ."resources".DS."upload";                 
          $fileObj=$_FILES["image"];          
          $fileName="";
          if($fileObj['tmp_name'] != null){                
            $fileName   = $fileObj['name'];
            @copy($fileObj['tmp_name'], $uploadDir . DS . $fileName);                   
          }   
        }
}
?>
