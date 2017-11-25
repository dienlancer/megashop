<?php namespace App\Http\Controllers\admin;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class MediaController extends Controller {	
	var $_controller="media";	
  	var $_title="Media";
  	var $_icon="icon-settings font-dark";
	public function getList(){			
		$strDirUpload=base_path()."/upload";
		$arrData = scandir($strDirUpload);		
		$controller=$this->_controller;	
		$task="list";
		$title=$this->_title;
		$icon=$this->_icon;		
		return view("admin.".$this->_controller.".list",compact("arrData","controller","task","title","icon"));
	}	

	public function getForm($task){		 
		$controller=$this->_controller;	
		$title=$this->_title . " : Add new";
		$icon=$this->_icon; 				
		return view("admin.".$this->_controller.".form",compact("controller","task","title","icon"));
	}

	public function save(){		
		$data 		            =   array();
        $info 		            =   array();
        $error 		            =   array();
        $item		            =   null;
        $checked 	            =   1;          		
		$lstFile				=	$_FILES["media_file"];		
		$arrName 				= 	$lstFile["name"];    
		$arrTmpName 			=	$lstFile["tmp_name"];       		
		foreach ($arrName as $key => $value) {      
         	if(!empty($value)){
	          	$fileName   = $value;
	          	@copy($arrTmpName[$key], base_path("upload/".$fileName) );  
        	}       
      	}
      	return redirect()->route("admin.".$this->_controller.".getList");
	}
	
	public function trash(){	
		$checked                =   1;
	    $type_msg               =   "alert-success";
	    $msg                    =   "Delete successfully";   								
		$arrID=@$_POST["cid"];
		if(count($arrID) == 0){
			$checked=0;
		}
		if($checked==1){				
			foreach ($arrID as $key => $value) {
				if(!empty($value)){
					$pathFile=base_path("upload/".$value);
			 		if(file_exists($pathFile)){
						unlink($pathFile);
					}	
				}			 	
	 		}			 
		}	
		return redirect()->route("admin.".$this->_controller.".getList");						
	}	
	public function deleteItem(Request $request){
		$id                     =   $request->id;              
	    $checked                =   1;
	    $type_msg               =   "alert-success";
	    $msg                    =   "Delete successfully";   
	    $pathFile 				= 	base_path("upload/".$id);	
	    if(!file_exists($pathFile)){
			$checked=0;
		}			         	    
	    if($checked == 1){
	        unlink($pathFile);
	    }          
	    $info = array(
	       'checked'           => $checked,
	       'type_msg'          => $type_msg,                
	       'msg'               => $msg,                    
	    );
	    return $info;
	}
}

