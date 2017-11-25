
    <h3 class="page-title h-title">Đổi mật khẩu</h3>
    <?php
$msg="";
if(count($arrError)>0){
        $msg .= '<ul class="comproduct33">';        
        foreach ($arrError as $key => $val){
            $msg .= '<li>' . $val . '</li>';
        }
        $msg .= '</ul>';
        echo $msg;   
    }        
        
?>
<form method="post" name="frm">    
    <table id="com_product30" class="com_product30" border="0" width="40%" cellpadding="0" cellspacing="0">                   
        <tbody>        
            <tr>
                <td align="right">Tài khoản</td>
                <td><?php echo @$arrData["username"]; ?></td>        
            </tr>                           
            <tr>
                <td align="right">Mật khẩu</td>
                <td><input type="password" name="password" /></td>        
            </tr>
            <tr>
                <td align="right">Xác nhận mật khẩu</td>
                <td><input type="password" name="password_confirm" /></td>        
            </tr>   
            <tr>           
                <td></td>
                <td class="com_product31" align="right">
                    <input name="btnChangeInfo" type="submit" class="com_product32" value="Cập nhật" />
                    <input type="hidden" name="id" value="<?php echo @$arrData["id"]; ?>" />
                    <input type="hidden" name="username" value="<?php echo @$arrData["username"]; ?>" />
                    <input type="hidden" name="action" value="change-password" />                    
                    {{ csrf_field() }}                           
                </td>                       
            </tr> 
        </tbody>    
    </table>
</form>
