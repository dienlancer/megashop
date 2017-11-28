<?php namespace App\Http\Controllers\frontend;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CategoryModel;
use App\CategoryArticleModel;
use App\CategoryProductModel;
use App\GroupModel;
use App\MenuModel;
use App\ArticleModel;
use App\PaginationModel;
use App\ProductModel;
use App\ModuleMenuModel;
use App\ModuleCustomModel;
use App\ModuleArticleModel;
use App\ModMenuTypeModel;
use App\User;
use App\UserGroupModel;
use App\CustomerModel;
use App\InvoiceModel;
use App\InvoiceDetailModel;
use App\BannerModel;
use App\ModuleItemModel;
use App\PaymentMethodModel;
use Session;
use DB;
class IndexController extends Controller {  
  var $_pageRange=4;
  var $_ssNameUser="vmuser";
  var $_ssNameCart="vmart";      
  public function getHome(){
    $component="trang-chu";               
    $alias="trang-chu";
    $meta_keyword="";
    $meta_description="";  
    return view("frontend.home",compact("component","meta_keyword","meta_description","alias"));
  }  
	public function index($alias)
      {                       
            $title="";
            $meta_keyword="";
            $meta_description="";            
            $filter_search="";                       
            $currentPage=1;                                          
            $totalItems=0;
            $totalItemsPerPage=0;
            $pageRange=0;      
            $currentPage=1;  
            $pagination ;
            $action="";
            $arrError=array();
            $arrData =array();   
            $flag = 1;                        
            $item=array();
            $items=array();
            $setting= getSettingSystem();     
            $category=array();  
            $component=$alias;
            $lst=array();
            $lstCategoryArticle=CategoryArticleModel::whereRaw("trim(lower(alias)) = ?",[trim(mb_strtolower($alias,'UTF-8'))])->get()->toArray();
            $lstCategoryProduct=CategoryProductModel::whereRaw("trim(lower(alias)) = ?",[trim(mb_strtolower($alias,'UTF-8'))])->get()->toArray();
            $lstArticle=ArticleModel::whereRaw("trim(lower(alias)) = ?",[trim(mb_strtolower($alias,'UTF-8'))])->get()->toArray();
            $lstProduct=ProductModel::whereRaw("trim(lower(alias)) = ?",[trim(mb_strtolower($alias,'UTF-8'))])->get()->toArray();
            if(count($lstCategoryArticle) > 0){
              $component='category-article';
            }
            if(count($lstCategoryProduct) > 0){
              $component='category-product';
            }
            if(count($lstArticle) > 0){
              $component='article';
            }
            if(count($lstProduct) > 0){
              $component='product';
            }
            switch ($component) {
              case 'category-article':
              $category_id=0;
              $arr_category=CategoryArticleModel::whereRaw("trim(lower(alias)) = ? and status = ?",[trim(mb_strtolower($alias,'UTF-8')),1])->get()->toArray();
              if(count($arr_category) > 0){
                  $category     = $arr_category[0];
                  $category_id    = $category['id'];
                  $str_category_id="";
                  $arr_category_id[]=$category_id;
                  getStringCategoryID($category_id,$arr_category_id,'category_article');                  
                  $str_category_id=implode("#;#", $arr_category_id);                  
                  $str_category_id="#".$str_category_id."#";                                    
                  if(!empty(@$_POST["filter_search"])){
                      $filter_search=@$_POST["filter_search"];
                  }                                
                  $data=DB::select('call pro_getArticleFrontend(?,?)',array(mb_strtolower($filter_search),$str_category_id));
                  $data=convertToArray($data);
                  $totalItems=count($data);
                  $totalItemsPerPage=(int)$setting['article_perpage']; 
                  $pageRange=$this->_pageRange;
                  if(!empty(@$_POST["filter_page"])){
                    $currentPage=@$_POST["filter_page"];
                  }       
                  $arrPagination=array(
                    "totalItems"=>$totalItems,
                    "totalItemsPerPage"=>$totalItemsPerPage,
                    "pageRange"=>$pageRange,
                    "currentPage"=>$currentPage   
                  );           
                  $pagination=new PaginationModel($arrPagination);
                  
                  $position   = ((int)@$arrPagination['currentPage']-1)*$totalItemsPerPage;
                  $data=DB::select('call pro_getArticleFrontendLimit(?,?,?,?)',array($filter_search,$str_category_id,$position,$totalItemsPerPage));      
                  $items=convertToArray($data);                  
              }              
              break;
              case 'article':
              $row=ArticleModel::whereRaw("trim(lower(alias)) = ? and status = ?",[trim(mb_strtolower($alias,'UTF-8')),1])->get()->toArray();              
              if(count($row) > 0){
                $item=$row[0];
              }         
              break;  
              case 'category-product':
              $category_id=0;
              $arr_category=CategoryProductModel::whereRaw("trim(lower(alias)) = ? and status = ?",[trim(mb_strtolower($alias,'UTF-8')),1])->get()->toArray();                            
              if(count($arr_category) > 0){
                  $category     = $arr_category[0];
                  $category_id    = $category['id'];
                  $str_category_id="";
                  $arr_category_id[]=$category_id;
                  getStringCategoryID($category_id,$arr_category_id,'category_product');                  
                  $str_category_id=implode("#;#", $arr_category_id);                  
                  $str_category_id="#".$str_category_id."#";                                    
                  if(!empty(@$_POST["filter_search"])){
                      $filter_search=@$_POST["filter_search"];
                  }                                
                  $data=DB::select('call pro_getProductFrontend(?,?)',array(mb_strtolower($filter_search),$str_category_id));
                  $data=convertToArray($data);

                  $totalItems=count($data);
                  $totalItemsPerPage=(int)$setting['product_perpage']; 
                  $pageRange=$this->_pageRange;
                  if(!empty(@$_POST["filter_page"])){
                    $currentPage=@$_POST["filter_page"];
                  }       
                  $arrPagination=array(
                    "totalItems"=>$totalItems,
                    "totalItemsPerPage"=>$totalItemsPerPage,
                    "pageRange"=>$pageRange,
                    "currentPage"=>$currentPage   
                  );           
                  $pagination=new PaginationModel($arrPagination);
                  
                  $position   = ((int)@$arrPagination['currentPage']-1)*$totalItemsPerPage;
                  $data=DB::select('call pro_getProductFrontendLimit(?,?,?,?)',array($filter_search,$str_category_id,$position,$totalItemsPerPage));                        
                  $items=convertToArray($data);                  
              }              
              break; 
              case 'product':
              $row=ProductModel::whereRaw("trim(lower(alias)) = ? and status = ?",[trim(mb_strtolower($alias,'UTF-8')),1])->get()->toArray();              
              if(count($row) > 0){
                $item=$row[0];
              }         
              break;                
             
            }         
            if(count($item) > 0){
                if(!empty($item['title'])){
                  $title=$item['title'];
                }                
                if(!empty($item['meta_keyword'])){
                  $meta_keyword=$item['meta_keyword'];
                }                
                if(!empty($item['meta_description'])){
                  $meta_description=$item['meta_description'];
                }                
            }
            if(count($category) > 0){
              if(!empty($category['title'])){
                  $title=$category['title'];
                }                
                if(!empty($category['meta_keyword'])){
                  $meta_keyword=$category['meta_keyword'];
                }                
                if(!empty($category['meta_description'])){
                  $meta_description=$category['meta_description'];
                }
            }           
            if(isset($_POST["action"])){
              $action=$_POST["action"];
              switch ($action) {
                case "add-cart"     :   $this->addCart();return redirect()->route('frontend.index.viewCart');            break;                  
              }
            }                 
            return view("frontend.index",compact("component","alias","title","meta_keyword","meta_description","item","items","category","pagination"));                 
      }
      function addCart(){          
          $product_id=(int)($_POST["product_id"]);
          $product_code=$_POST["product_code"];
          $product_name=$_POST["product_name"];
          $product_alias=$_POST["product_alias"];
          $product_image=$_POST["product_image"];
          $product_price=(float)($_POST["product_price"]);
          $product_quantity=(int)($_POST["product_quantity"]);          
          $ssCart=array();
          $arrCart=array();
          if(Session::has($this->_ssNameCart)){
            $ssCart=Session::get($this->_ssNameCart);
          }         
          $arrCart = @$ssCart["cart"];                   
          if($product_id > 0){            
              if(count($arrCart) == 0){
                $arrCart[$product_id]["product_quantity"] = $product_quantity;
              }
              else{
                    if(!isset($arrCart[$product_id])){
                      $arrCart[$product_id]["product_quantity"] = $product_quantity;                 
                    }                        
                    else{
                      $arrCart[$product_id]["product_quantity"] = $arrCart[$product_id]["product_quantity"] + $product_quantity;                  
                    }                               
              }
              $arrCart[$product_id]["product_id"]=$product_id;  
              $arrCart[$product_id]["product_code"]=$product_code;
              $arrCart[$product_id]["product_name"]=$product_name;
              $arrCart[$product_id]["product_alias"]=$product_alias;      
              $arrCart[$product_id]["product_image"]=$product_image;          
              $arrCart[$product_id]["product_price"]=$product_price;                      
              $product_quantity=(int)$arrCart[$product_id]["product_quantity"];
              $product_total_price=$product_price * $product_quantity;
              $arrCart[$product_id]["product_total_price"]=($product_total_price);
              $cart["cart"]=$arrCart;                    
              Session::put($this->_ssNameCart,$cart);                                        
          }    
      }
      public function viewCart(){   
        $component='gio-hang';
        $alias='sofa';                             
        if(isset($_POST["action"])){
            $action=$_POST["action"];
            switch ($action) {
              case "update-cart"     :  $this->updateCart();
              break;                  
            }
        }            
        return view("frontend.index",compact("component","alias"));
      }
      public function contact(){      
        $component="lien-he"; 
        $alias='lien-he';
        if(isset($_POST['btnSend']))     {
          $setting=getSettingSystem();    
          $fullname = @$_POST["fullname"];
          $email    = @$_POST['email'];   
          $phone    = @$_POST['phone'];
          $title    = @$_POST['title'];
          $address  = @$_POST['address'];
          $content  = @$_POST["content"];
          /* begin load config contact */
          $smtp_host      = @$setting['smtp_host'];
          $smtp_port      = @$setting['smtp_port'];
          $smtp_auth      = @$setting['smtp_auth'];
          $encription     = @$setting['encription'];
          $smtp_username  = @$setting['smtp_username'];
          $smtp_password  = @$setting['smtp_password'];
          $email_from     = @$setting['email_from'];
          $email_to       = @$setting['email_to'];
          $to_name        = @$setting['to_name'];
          /* end load config contact */
          $filePhpMailer=base_path("app".DS."scripts".DS."phpmailer".DS."PHPMailerAutoload.php")   ;

          require_once $filePhpMailer;    
          $strMsg="";
          $mail = new PHPMailer;        
          $mail->CharSet = "UTF-8";   
          $mail->isSMTP();             
          $mail->SMTPDebug = 2;
          $mail->Debugoutput = 'html';
          $mail->Host = @$smtp_host;
          $mail->Port = @$smtp_port;
          $mail->SMTPSecure = @$encription;
          $mail->SMTPAuth = true;
          $mail->Username = @$smtp_username;
          $mail->Password = @$smtp_password;
          $mail->setFrom(@$email_from, $fullname);
          $mail->addAddress(@$email_to, @$to_name);
          $mail->Subject = 'Khách hàng '. @$fullname . " - Số điện thoại : " . @$phone ;       
          $strContent=@$content . "\n\n" . " Điện thoại : " . @$phone; 
          $mail->Body=$strContent;   
          if ($mail->send()) {                
            echo '<script language="javascript" type="text/javascript">alert("Mail gửi thành công");</script>'; 
          }
          else{
            echo '<script language="javascript" type="text/javascript">alert("Mail gửi không thành công");</script>'; 
          }          
        }
        return view("frontend.contact",compact("component","alias"));          
      }
      
      public function deleteAll(){          
          if(Session::has($this->_ssNameCart)){
            Session::forget($this->_ssNameCart);
          }                   
          return redirect()->route('frontend.index.viewCart'); 
      }
      public function delete($id){          
          $ssCart=array();
          $arrCart=array();
          if(Session::has($this->_ssNameCart)){
                $ssCart=Session::get($this->_ssNameCart);
          }         
          $arrCart = @$ssCart["cart"];      
          unset($arrCart[$id]);    
          $cart["cart"]=$arrCart;                    
          Session::put($this->_ssNameCart,$cart);             
          return redirect()->route('frontend.index.viewCart'); 
      }
      public function register(){
        $component="dang-ky";
        $alias="dang-nhap";            
        $action="";
        $arrError=array();
        $arrData =array();   
        $flag = 1;               
        if(isset($_POST["action"])){                          
          $arrData =$_POST;                    
          $email=(trim($_POST["email"])) ;
          $username=(trim($_POST["username"])) ;
          $password=(trim($_POST["password"])) ;
          $password_confirm=(trim($_POST["password_confirm"])) ;

          if(mb_strlen($username) < 6){
            $arrError["username"] = 'Username phải có độ dài lớn hơn hoặc bằng 6 ký tự';
            $arrData["username"] = ""; 
            $flag = 0;
          }else{
            $arrCustomer=CustomerModel::whereRaw("trim(lower(username)) = ?",[mb_strtolower($username,'UTF-8')])->get()->toArray();
            if(count($arrCustomer) > 0){
              $arrError["username"] = 'Username đã tồn tại';
              $arrData["username"] = ""; 
              $flag = 0;
            }  
          }

          if(mb_strlen($password) < 6){
            $arrError["password"] = 'Password phải có độ dài lớn hơn hoặc bằng 6 ký tự';
            $arrData["password"] = "";
            $arrData["password_confirm"] = ""; 
            $flag = 0;
          }else{
            if(strcmp(mb_strtolower($password,'UTF-8') , mb_strtolower($password_confirm,'UTF-8')) != 0 ){
              $arrError["password_confirm"] = 'PasswordConfirm does not matched Password';
              $arrData["password_confirm"] = "";   
              $flag = 0;
            }
          }              

          if(!preg_match("#^[a-z][a-z0-9_\.]{4,31}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$#", mb_strtolower($email,'UTF-8')   )){
            $arrError["email"] = 'Email is invalid';
            $arrData["email"] = '';
            $flag = 0;
          }else{
            $arrCustomer=CustomerModel::whereRaw("trim(lower(email)) = ?",[mb_strtolower($email,'UTF-8')])->get()->toArray();
            if(count($arrCustomer) > 0){
              $arrError["email"] = 'Email đã tồn tại';
              $arrData["email"] = ""; 
              $flag = 0;
            }
          }          
                            
          if($flag==1){
            $item               =   new CustomerModel;
            $item->username     =   trim($_POST["username"]);
            $item->password     =   md5(trim($_POST["password"])) ;
            $item->email        =   trim($_POST["email"]);
            $item->fullname     =   trim($_POST["fullname"]);
            $item->address      =   trim($_POST["address"]);
            $item->phone        =   trim($_POST["phone"]);
            $item->mobilephone  =   trim($_POST["mobilephone"]);
            $item->fax          =   trim($_POST["fax"]); 
            $item->status       =   1;  
            $item->sort_order   =   1;  
            $item->created_at   =   date("Y-m-d H:i:s",time());
            $item->updated_at   =   date("Y-m-d H:i:s",time());
            $item->save(); 
            $arrCustomer        =   CustomerModel::whereRaw("trim(lower(username)) = ?",[trim(mb_strtolower($username,'UTF-8'))])->get()->toArray()[0];
            $arrUser["userInfo"]=array("username" => $arrCustomer["username"],"id"=>$arrCustomer["id"]);                                            
            Session::put($this->_ssNameUser,$arrUser);    
            return redirect()->route('frontend.index.viewAccount');                                  
          }              
        }
        return view("frontend.index",compact("component","alias","arrError","arrData"));
      }
      public function login(){   
        $component="dang-nhap";
        $alias="dang-nhap";           
        $action="";
        $arrError=array();
        $arrData =array();   
        $arrUser=array();        
        $flag = 1;           
        $id=0;                
        if(isset($_POST["action"])){              
          $username=trim(@$_POST["username"]);   
          $password=md5(trim(@$_POST["password"]));
          $arrCustomer=CustomerModel::whereRaw("trim(lower(username)) = ? and trim(lower(password)) = ?",[mb_strtolower($username,'UTF-8'),trim(mb_strtolower($password))])->get()->toArray()  ;

          if(count($arrCustomer) > 0){
            $arrUser["userInfo"]=array("username" => $arrCustomer[0]["username"],"id"=>$arrCustomer[0]["id"]);                                          
            Session::put($this->_ssNameUser,$arrUser);  
            return redirect()->route('frontend.index.viewAccount'); 
          }else{
            $arrError["dang-nhap"]="Đăng nhập sai username và password";
          }
        }        
        if(Session::has($this->_ssNameUser)){                
          $arrUser = Session::get($this->_ssNameUser)["userInfo"];    
        }   
        if(count($arrUser) > 0){
          return redirect()->route("frontend.index.viewAccount"); 
        }
        return view("frontend.index",compact("component","alias","arrError"));                
      }
      public function viewSecurity(){
            $component="bao-mat";
            $alias="dang-nhap";            
            $action="";
            $arrError=array();
            $arrData =array();   
            $arrUser=array();
            $flag = 1;               
            $id=0;                        
            if(Session::has($this->_ssNameUser)){                
                $arrUser = Session::get($this->_ssNameUser)["userInfo"];    
            }   
            if(empty($arrUser)){
              return redirect()->route("frontend.index.login"); 
            }
              $arrData=CustomerModel::find((int)$arrUser["id"])->toArray();    
              $id=(int)$arrData["id"];
              if(isset($_POST["action"])){              
                $arrData =$_POST;                     
                $password=trim($_POST["password"]) ;
                $password_confirm=trim($_POST["password_confirm"]) ;                
                if(mb_strlen($password) < 6){
                  $arrError["password"] = 'Độ dài mật khẩu phải lớn hơn hoặc bằng 6';
                  $arrData["password"] = "";
                  $arrData["password_confirm"] = ""; 
                  $flag = 0;
                }
                if(strcmp(mb_strtolower($password),mb_strtolower($password_confirm))!=0){
                  $arrError["password_confirm"] = 'PasswordConfirm is not matched Password';
                  $arrData["password_confirm"] = "";   
                  $flag = 0;
                }    
                if($flag==1){
                    $item=CustomerModel::find($id);                         
                    $item->password=md5($_POST["password"]) ;
                    $item->save();                                                             
                }              
              }             
              return view("frontend.index",compact("component","alias","arrError","arrData"));                           
      }
      public function getLgout(){        
        $arrUser=array();            
        if(Session::has($this->_ssNameUser)){
          $arrUser=Session::get($this->_ssNameUser)["userInfo"]; 
          Session::forget($this->_ssNameUser);      
        }    
        return redirect()->route('frontend.index.login'); 
      }
      public function viewAccount(){
        $component="tai-khoan";
        $alias="dang-nhap";            
        $action="";            
        $flag = 1;               
        $arrUser=array();
        $arrData=array();
        $arrError=array();
        $id=0;                    
        if(Session::has($this->_ssNameUser)){                
          $arrUser = Session::get($this->_ssNameUser)["userInfo"];    
        }   
        if(count($arrUser)==0){
          return redirect()->route("frontend.index.login"); 
        }
        $arrData=CustomerModel::find((int)$arrUser["id"])->toArray();    
        $id=(int)$arrData["id"];                
        if(isset($_POST["action"])){              
          $arrData =$_POST;                       
          $email=trim($_POST["email"]) ;                     
          if(!preg_match("#^[a-z][a-z0-9_\.]{4,31}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$#",mb_strtolower($email)  )){
            $arrError["email"] = 'Email is invalid';
            $arrData["email"] = '';
            $flag = 0;
          }else{
            $arrRow=CustomerModel::whereRaw("trim(lower(email)) = ? and id != ? ",[mb_strtolower($email,'UTF-8'),(int)$id])->get()->toArray();
            if(count($arrRow)>0){
              $arrError["email"] = 'Email đã tồn tại';
              $arrData["email"] = ""; 
              $flag = 0;
            }  
          }                            
          if($flag==1){
            $item=CustomerModel::find($id);                         
            $item->email        =   trim($_POST["email"]);
            $item->fullname     =   trim($_POST["fullname"]);
            $item->address      =   trim($_POST["address"]);
            $item->phone        =   trim($_POST["phone"]);
            $item->mobilephone  =   trim($_POST["mobilephone"]);
            $item->fax          =   trim($_POST["fax"]);                    
            $item->updated_at   =   date("Y-m-d H:i:s",time());
            $item->save();                                                             
          }              
        }                
        return view("frontend.index",compact("component","alias","arrError","arrData"));                                    
      }
      public function checkout(){          
          $arrUser=array(); 
          $link="";       
          if(Session::has($this->_ssNameUser)){                
              $arrUser = Session::get($this->_ssNameUser)["userInfo"];    
          }   
          if(count($arrUser) > 0){
              $link="frontend.index.confirmCheckout";
          }else{
              $link="frontend.index.loginCheckout";
          }
          return redirect()->route($link); 
      }
      public function confirmCheckout(){
        $component="xac-nhan-thanh-toan";
            $alias="dang-nhap";            
            $action="";
            $arrError=array();
            $arrData =array();
            $arrUser=array();              
            $flag = 1;               
            $id=0;            
            if(Session::has($this->_ssNameUser)){                
                $arrUser = Session::get($this->_ssNameUser)["userInfo"];    
            }   
            if(count($arrUser) == 0){
              return redirect()->route("frontend.index.loginCheckout");               
            }                
            $arrCart=array();
            if(Session::has($this->_ssNameCart)){
              $arrCart=Session::get($this->_ssNameCart)["cart"];
            } 
            if(count($arrCart) == 0){
              return redirect()->route("frontend.index.viewCart");   
            }      
              $arrData=CustomerModel::find((int)$arrUser["id"])->toArray();    
              $id=(int)$arrData["id"];
              if(isset($_POST["action"])){              
                  $arrData =$_POST;                   
                  $email=strtolower(trim($_POST["email"])) ;   
                  $payment_method=trim($_POST['payment_method']);                                 
                  if(!preg_match("#^[a-z][a-z0-9_\.]{4,31}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$#",$email )){
                    $arrError["email"] = 'Email is invalid';
                    $arrData["email"] = '';
                    $flag = 0;
                  }else{
                    $arrRowData=CustomerModel::whereRaw("trim(lower(email)) = ? and id != ? ",[trim(mb_strtolower($email,'UTF-8')),(int)$id])->get()->toArray();
                  if(count($arrRowData) > 0){
                    $arrError["email"] = 'Email đã tồn tại';
                    $arrData["email"] = ""; 
                    $flag = 0;
                  }
                  }
                  if((int)$payment_method==0){
                      $arrError["payment_method"] = 'Xin vui lòng chọn 1 phương thức thanh toán';                      
                      $flag = 0;
                  }                                    
                  if($flag==1){                    
                      $item = new InvoiceModel;
                      $item->code=randomString(20);
                      $item->customer_id  =$id;
                      $item->username  =$arrData["username"];
                      $item->email=$_POST["email"];
                      $item->fullname=$_POST["fullname"];
                      $item->address=$_POST["address"];
                      $item->phone=$_POST["phone"];
                      $item->mobilephone=$_POST["mobilephone"];
                      $item->fax=$_POST["fax"];  
                      $item->payment_method_id=(int)$payment_method;
                      $item->quantity=(int)$_POST["quantity"];
                      $item->total_price=(float)$_POST["total_price"];
                      $item->status=0;  
                      $item->sort_order=1;
                      $item->created_at=date("Y-m-d H:i:s",time());
                      $item->updated_at=date("Y-m-d H:i:s",time());
                      $item->save();                           
                      $arrCart=array();
                      if(Session::has($this->_ssNameCart)){
                        $arrCart=Session::get($this->_ssNameCart)["cart"];
                      }         
                      if(count($arrCart) > 0){
                        foreach ($arrCart as $key => $value) {
                          $invoice_id=$item->id;
                          $product_id=$value["product_id"];    
                          $product_code=$value["product_code"];  
                          $product_name=$value["product_name"];                                                    
                          $product_image=   $value["product_image"] ;        
                          $product_price=$value["product_price"];                                  
                          $product_quantity=$value["product_quantity"];                         
                          $product_total_price=$value["product_total_price"];
                          $itemInvoiceDetail=new InvoiceDetailModel;                          
                          $itemInvoiceDetail->invoice_id=$invoice_id;
                          $itemInvoiceDetail->product_id=$product_id;
                          $itemInvoiceDetail->product_code=$product_code;
                          $itemInvoiceDetail->product_name=$product_name;
                          $itemInvoiceDetail->product_image=$product_image;
                          $itemInvoiceDetail->product_price=$product_price;
                          $itemInvoiceDetail->product_quantity=$product_quantity;
                          $itemInvoiceDetail->product_total_price=$product_total_price;
                          $itemInvoiceDetail->created_at=date("Y-m-d H:i:s",time());
                          $itemInvoiceDetail->updated_at=date("Y-m-d H:i:s",time());
                          $itemInvoiceDetail->save();
                        }
                      }                           
                      if(Session::has($this->_ssNameCart)){
                        Session::forget($this->_ssNameCart);
                      }                   
                      $component="hoan-tat-thanh-toan";                      
                  }                         
              }
              $data_paymentmethod=PaymentMethodModel::whereRaw('status = 1')->get()->toArray();
              $data_paymentmethod[]=array(
                                              'id'=>0,
                                              'fullname'=>null,
                                              'alias'=>null,
                                              'content'=>null,
                                              'sort_order'=>1,
                                              'status'=>1,

                                        );
              return view("frontend.index",compact("component","alias","arrError","arrData","data_paymentmethod"));                 
      }      
      public function loginCheckout(){
            $component="dang-nhap-thanh-toan";
            $alias="dang-nhap";            
            $action="";
            $arrError=array();
            $arrData =array();   
            $flag = 1;   
            $arrUser=array();
            $arrCustomer=array();                            
            $arrCart=array();
            if(Session::has($this->_ssNameCart)){
              $arrCart=Session::get($this->_ssNameCart)["cart"];
            } 
            if(count($arrCart)==0){
              return redirect()->route("frontend.index.viewCart");   
            }       
            if(isset($_POST["action"])){
              $action=$_POST["action"];
              switch ($action) {
                case "register-checkout": 
                  $arrData =$_POST;           
                  $username=(trim($_POST["username"])) ;         
                  $password=(trim($_POST["password"])) ;
                  $password_confirm=(trim($_POST["password_confirm"])) ;
                  $email=(trim($_POST["email"])) ;                  

                  if(mb_strlen($username) < 6){
                    $arrError["username"] = 'Username phải có độ dài lớn hơn hoặc bằng 6 ký tự';
                    $arrData["username"] = ""; 
                    $flag = 0;
                  }else{
                    $arrCustomer=CustomerModel::whereRaw("trim(lower(username)) = ?",[mb_strtolower($username,'UTF-8')])->get()->toArray();
                    if(count($arrCustomer) > 0){
                      $arrError["username"] = 'Username đã tồn tại';
                      $arrData["username"] = ""; 
                      $flag = 0;
                    }  
                  }

                  if(mb_strlen($password) < 6){
                    $arrError["password"] = 'Password phải có độ dài lớn hơn hoặc bằng 6 ký tự';
                    $arrData["password"] = "";
                    $arrData["password_confirm"] = ""; 
                    $flag = 0;
                  }else{
                    if(strcmp(mb_strtolower($password,'UTF-8') , mb_strtolower($password_confirm,'UTF-8')) != 0 ){
                      $arrError["password_confirm"] = 'PasswordConfirm does not matched Password';
                      $arrData["password_confirm"] = "";   
                      $flag = 0;
                    }
                  }              

                  if(!preg_match("#^[a-z][a-z0-9_\.]{4,31}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$#", mb_strtolower($email,'UTF-8')   )){
                    $arrError["email"] = 'Email is invalid';
                    $arrData["email"] = '';
                    $flag = 0;
                  }else{
                    $arrCustomer=CustomerModel::whereRaw("trim(lower(email)) = ?",[mb_strtolower($email,'UTF-8')])->get()->toArray();
                    if(count($arrCustomer) > 0){
                      $arrError["email"] = 'Email đã tồn tại';
                      $arrData["email"] = ""; 
                      $flag = 0;
                    }
                  }                   
                  if($flag==1){
                      $item               =   new CustomerModel;
                      $item->username     =   trim($_POST["username"]);
                      $item->password     =   md5(trim($_POST["password"])) ;
                      $item->email        =   trim($_POST["email"]);
                      $item->fullname     =   trim($_POST["fullname"]);
                      $item->address      =   trim($_POST["address"]);
                      $item->phone        =   trim($_POST["phone"]);
                      $item->mobilephone  =   trim($_POST["mobilephone"]);
                      $item->fax          =   trim($_POST["fax"]); 
                      $item->status       =   1;  
                      $item->sort_order   =   1;  
                      $item->created_at   =   date("Y-m-d H:i:s",time());
                      $item->updated_at   =   date("Y-m-d H:i:s",time());
                      $item->save(); 
                      $arrCustomer        =   CustomerModel::whereRaw("trim(lower(username)) = ?",[trim(mb_strtolower($username,'UTF-8'))])->get()->toArray()[0];
                      $arrUser["userInfo"]=array("username" => $arrCustomer["username"],"id"=>$arrCustomer["id"]);                                                    
                      Session::put($this->_ssNameUser,$arrUser);   
                      return redirect()->route('frontend.index.confirmCheckout');                        
                  }                               
                  break;
                case "login-checkout":
                  $username=trim(@$_POST["username"]);   
                  $password=md5(@$_POST["password"]);              
                  $arrCustomer=CustomerModel::whereRaw("trim(lower(username)) = ? and trim(lower(password)) = ?",[trim(mb_strtolower($username,'UTF-8')),trim(mb_strtolower($password,'UTF-8'))])->get()->toArray()  ;                  
                  if(count($arrCustomer) > 0){
                    $arrUser["userInfo"]=array("username" => $arrCustomer[0]["username"],"id"=>$arrCustomer[0]["id"]);                                                  
                    Session::put($this->_ssNameUser,$arrUser);  
                    return redirect()->route('frontend.index.confirmCheckout'); 
                  }else{
                    $arrError["dang-nhap"]="Đăng nhập sai username và password";
                  }                   
                  break;                
              }
            }            
            return view("frontend.index",compact("component","alias","arrError","arrData"));  
      }
      public function getInvoice(){
        $component="hoa-don";
        $alias="dang-nhap";        
        $action="";
        $arrError=array();
        $arrData =array();   
        $arrUser=array();
        $arrCustomer=array();
        $flag = 1;                 
        $id=0;                
        if(Session::has($this->_ssNameUser)){                
                $arrUser = Session::get($this->_ssNameUser)["userInfo"];    
        }   
        if(count($arrUser)==0){
          return redirect()->route("frontend.index.login");               
        }else{
          $id=$arrUser["id"];
        }  
        $data=InvoiceModel::whereRaw("customer_id = ?",(int)@$id)->get()->toArray();
        return view("frontend.index",compact("component","arrError","arrData","data","alias"));
      }
      public function updateCart(){   
              $arrQTY=$_POST["quantity"];                 
              $ssCart=array();
              $arrCart=array();
              if(Session::has($this->_ssNameCart)){
                $ssCart=Session::get($this->_ssNameCart);
              }         
              $arrCart = @$ssCart["cart"];   
              if(count($arrCart) > 0){
                foreach ($arrCart as $key => $value) {    
                    $product_quantity=(int)$arrQTY[$key];
                    $product_price = (float)$arrCart[$key]["product_price"];
                    $product_total_price=$product_quantity * $product_price;
                    $arrCart[$key]["product_quantity"]=$product_quantity;
                    $arrCart[$key]["product_total_price"]=$product_total_price;
                }
                foreach ($arrCart as $key => $value) {
                  $product_quantity=(int)$arrCart[$key]["product_quantity"];
                  if($product_quantity==0){
                    unset($arrCart[$key]);
                  }
                }
              }              
              $cart["cart"]=$arrCart;                    
              Session::put($this->_ssNameCart,$cart);                   
              if(count($arrCart)==0){
                Session::forget($this->_ssNameCart);              
              }                  
      }
      public function addToCart(){
          $id=$_GET['id'];                          
          $data=ProductModel::find((int)$id);          
          $product_id=(int)($data['id']);
          $product_code=$data["code"];
          $product_name=$data["fullname"];
          $product_alias=$data["alias"];
          $product_image=$data["image"];
          $price=(float)($data["price"]);
          $sale_price=(float)($data["sale_price"]);
          $product_price=$price;
          if(!empty($sale_price)){
            $product_price=$sale_price;
          }
          $product_quantity=1;   
          $quantity=0;       
          $ssCart=array();
          $arrCart=array();
          if(Session::has($this->_ssNameCart)){
            $ssCart=Session::get($this->_ssNameCart);
          }         
          $arrCart = @$ssCart["cart"];                   
          if($product_id > 0){            
              if(count($arrCart) == 0){
                $arrCart[$product_id]["product_quantity"] = $product_quantity;
              }
              else{
                    if(!isset($arrCart[$product_id])){
                      $arrCart[$product_id]["product_quantity"] = $product_quantity;                 
                    }                        
                    else{
                      $arrCart[$product_id]["product_quantity"] = $arrCart[$product_id]["product_quantity"] + $product_quantity;                  
                    }                               
              }
              $arrCart[$product_id]["product_id"]=$product_id;  
              $arrCart[$product_id]["product_code"]=$product_code;
              $arrCart[$product_id]["product_name"]=$product_name;
              $arrCart[$product_id]["product_alias"]=$product_alias;      
              $arrCart[$product_id]["product_image"]=$product_image;          
              $arrCart[$product_id]["product_price"]=$product_price;                      
              $product_quantity=(int)$arrCart[$product_id]["product_quantity"];
              $product_total_price=$product_price * $product_quantity;
              $arrCart[$product_id]["product_total_price"]=($product_total_price);
              $cart["cart"]=$arrCart;                    
              Session::put($this->_ssNameCart,$cart);    
              $arrCart=array();
              if(Session::has($this->_ssNameCart)){    
                  $arrCart = @Session::get($this->_ssNameCart)["cart"];    
              }         
              if(count($arrCart) > 0){
                foreach ($arrCart as $key => $value){
                  $quantity+=(int)$value['product_quantity'];              
                }
              }                                                        
          }    
          $dataReturn=array(
                            'quantity'=>$quantity,
                            'permalink'=>route('frontend.index.viewCart')
                          );
        return $dataReturn;
      } 
      public function showInvoiceDetail(){
        $id=$_GET['id'];        
        $data=array();
        $data=InvoiceDetailModel::whereRaw('invoice_id = ?',[(int)$id])->get()->toArray();  
        return $data; 
      }
      public function getPaymentmethod(Request $request){
         $id=$request->id;
         $data=array();
         $data=PaymentMethodModel::find((int)@$id);        
         return $data;
      }
}







