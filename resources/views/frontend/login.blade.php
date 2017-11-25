
    <h3 class="page-title h-title">Đăng nhập</h3>
    <?php
    $msg="";
    if(count($arrError) > 0){
        $msg .= '<ul class="comproduct33">';        
        foreach ($arrError as $key => $val){
            $msg .= '<li>' . $val . '</li>';
        }
        $msg .= '</ul>';
        echo $msg;   
    }            
    ?>
    <form method="post" name="frm" action="">    
        <table id="com_product30" class="com_product30" border="0" width="40%" cellpadding="0" cellspacing="0">                   
            <tbody>        
                <tr>
                    <td align="right">Tài khoản</td>
                    <td><input type="text" name="username" /></td>        
                </tr>       
                <tr>
                    <td align="right">Mật khẩu</td>
                    <td><input type="password" name="password" /></td>        
                </tr>            
                <tr>           
                    <td></td>
                    <td class="com_product31" align="right">
                        <input name="btnRegisterMember" type="submit" class="com_product32" />
                        <input type="hidden" name="action" value="login" />
                        {{ csrf_field() }}                              
                    </td>                      
                </tr> 
            </tbody>    
        </table>
    </form>

