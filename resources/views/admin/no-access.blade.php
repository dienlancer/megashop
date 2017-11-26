@extends("admin.master")

@section("content")
<div class="alert alert-danger" >


        <?php 

                                $strMessage = cmsMessage(array("class"=>"error","content"=>"Không có quyền truy cập"));

                                echo $strMessage;  

                            ?>    


    </div>

@endsection()         