<h3 class="page-title h-title">Xác nhận thanh toán</h3>
<?php
$setting=getSettingSystem();
$product_width=$setting['product_width'];
$product_height=$setting['product_height'];
     
$ssName="vmart";
$arrCart=array();
if(Session::has($ssName)){    
    $arrCart = @Session::get($ssName)["cart"];    
}     
if(count($arrCart) > 0){
    ?>
    <table id="com_product16" class="com_product16" cellpadding="0" cellspacing="0" width="100%">
    <thead>
    <tr>    
        <th align="center">Sản phẩm</th>
        <th width="20%"><center>Giá</center></th>
        <th  width="10%"><center>Số lượng</center></th>
        <th width="20%"><center>Tổng giá</center></th>        
    </tr>
    </thead>
    <tbody>
    <?php   
    $total_price=0;
    $total_quantity=0;
    foreach ($arrCart as $key => $value) {  
        $product_id=$value["product_id"];      
        $product_name=$value["product_name"];
        $product_code=$value["product_code"];
        $product_price=$value["product_price"];        
        $product_image=    url('/upload/'.$product_width."x".$product_height."-"). $value["product_image"] ;        
        $product_link= url($value['product_alias'].'.html');           
        $product_quantity=$value["product_quantity"];
        $product_price=fnPrice($value["product_price"]) ;
        $product_total_price=fnPrice($value["product_total_price"]) ;
        $total_price+=(float)$value["product_total_price"];  
        $total_quantity+=(float)$product_quantity;    
        ?>
        <tr>
            
            <td class="com_product20"><a href="<?php echo $product_link ?>"><?php echo $product_name; ?></a></td>
            <td class="com_product21" align="right"><?php echo $product_price; ?></td>
            <td align="center" class="com_product22"><?php echo $product_quantity; ?></td>
            <td class="com_product23" align="right"><?php echo $product_total_price; ?></td>            
        </tr>
        <?php
     } 
    ?>                  
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2">
                Tổng cộng
            </td>
            <td align="center"><?php echo $total_quantity; ?></td>
            <td align="right"><?php echo fnPrice($total_price) ; ?></td>
            
        </tr>
    </tfoot>
</table>
    <?php
}       
$msg="";
if(count($arrError) > 0){
        $msg .= '<ul class="comproduct33">';        
        foreach ($arrError as $key => $val){
            $msg .= '<li>' . $val . '</li>';
        }
        $msg .= '</ul>';
    }   
    echo $msg;
?>
<form method="post" name="frm">   
    <div class="col-md-6">
        <table id="com_product30" class="com_product30" border="0" width="100%" cellpadding="0" cellspacing="0">                   
            <tbody>        
                <tr>
                    <td align="right">Tài khoản</td>
                    <td><?php echo @$arrData["username"]; ?></td>        
                </tr>                           
                <tr>
                    <td align="right">Email</td>
                    <td><input type="text" name="email" value="<?php echo @$arrData["email"]; ?>" /></td>                   
                </tr>                     
                <tr>
                    <td align="right">Tên</td>
                    <td><input type="text" name="fullname" value="<?php echo @$arrData["fullname"]; ?>" /></td>            
                </tr>
                <tr>
                    <td align="right">Địa chỉ</td>
                    <td><input type="text" name="address" value="<?php echo @$arrData["address"]; ?>" /></td>            
                </tr>                
                <tr>
                    <td align="right">Phone</td>
                    <td><input type="text" name="phone" value="<?php echo @$arrData["phone"]; ?>" /></td>            
                </tr>
                <tr>
                    <td align="right">Mobile phone</td>
                    <td><input type="text" name="mobilephone" value="<?php echo @$arrData["mobilephone"]; ?>" /></td>            
                </tr>
                <tr>
                    <td align="right">Fax</td>
                    <td><input type="text" name="fax" value="<?php echo @$arrData["fax"]; ?>" /></td>            
                </tr>   
                <tr>           
                    <td></td>
                    <td class="com_product31" align="right">
                        <input name="btnChangeInfo" type="submit" class="com_product32" value="Cập nhật" />
                        <input type="hidden" name="id" value="<?php echo @$arrData["id"]; ?>" />
                        <input type="hidden" name="username" value="<?php echo @$arrData["username"]; ?>" />
                        <input type="hidden" name="quantity" value="<?php echo @$total_quantity; ?>" />
                        <input type="hidden" name="total_price" value="<?php echo @$total_price; ?>" />
                        <input type="hidden" name="action" value="finished-checkout" />                    
                        {{ csrf_field() }}                             
                    </td>                       
                </tr> 
            </tbody>    
        </table>
    </div>
    <div class="col-md-6">
        <table id="com_product30" class="com_product30" border="0" cellpadding="0" cellspacing="0">   
            <thead><tr><th>Hình thức thanh toán</th></tr></thead>     
            <tbody>        
                <tr>
                    <td align="left"><font color="red"><b><i>Vui lòng chọn một hình thức thanh toán *</i></b></font></td>                    
                </tr>                                               
                <tr>
                    <td>
                        <select id="payment_method" name="payment_method" onchange="changePaymentMethod(this.value);">
                            <?php 
                            for($i=0;$i<count($data_paymentmethod);$i++){
                                $id=$data_paymentmethod[$i]["id"];
                                $fullname=$data_paymentmethod[$i]["fullname"];
                                if((int)@$data["payment_method"] == (int)$id)
                                    echo '<option selected value="'.$id.'">'.$fullname.'</option>';                               
                                else
                                    echo '<option          value="'.$id.'">'.$fullname.'</option>';                               
                            }
                            ?>                                                    
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><span id="payment_method_content"></span></td>
                </tr>                
            </tbody>    
        </table>
    </div> 
    <div class="clr"></div>      
</form>
<script type="text/javascript" language="javascript">
    function changePaymentMethod(id)    {
      
    var token=$("form[name='frm']").find("input[type='hidden'][name='_token']").val();   
    var dataItem = {                 
                    "id"                    : id,           
                    "_token"                : token                            
                };
    $.ajax({
            url         : '<?php echo route('frontend.index.getPaymentmethod'); ?>',
            type        : "POST",
            data        : dataItem,           
            success     : function(data, status, jsXHR){                            
                            $("#payment_method_content").empty();
                            if(data != null){
                                $("#payment_method_content").append(data.content);
                            }                           
                        }
        });
}
</script>