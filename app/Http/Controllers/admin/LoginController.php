<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sentinel;
class LoginController extends Controller
{
    public function login(Request $request){                
        if(count( $request->all() )>0){            
            Sentinel::authenticate($request->all());
            if(Sentinel::check()){
                $status=Sentinel::getUser()->status;            
                if((int)$status==1){
                    return redirect()->route('admin.category-article.getList');  
                }else{                
                    return view('admin.login');
                }            
            }else{
                return view('admin.login');
            }      
        }else{            
            return view('admin.login');
        }        
    }   
    public function logout(){
         Sentinel::logout();
         return redirect()->route('admin.login');
    }
}
