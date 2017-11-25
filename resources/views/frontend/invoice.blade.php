<?php 
    $setting=getSettingSystem();     
    $product_width=$setting['product_width'];
    $product_height=$setting['product_height'];
?>
<h3 class="page-title h-title">Thông tin hóa đơn</h3>
<form action="" name="frm">
    {{ csrf_field() }}
    <table id="com_product16" class="com_product16" cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>    
                <th>Mã đơn hàng</th>
                <th>Ngày tạo</th>
                <th>Username</th>
                <th>Họ tên</th>
                <th>Điện thoại</th>
                <th>Mobile phone</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
                <th>Trạng thái giao hàng</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php     
            for ($i=0; $i < count($data); $i++) { 
                $id = $data[$i]["id"];
                $quantity=$data[$i]["quantity"];
                $total_price=($data[$i]["total_price"]) ;
                $code=$data[$i]["code"];
                $product_image=asset('/upload/'.$product_width . 'x'.$product_height.'-') ;          
                $status="";
                $show_invoice_detail_link=route('frontend.index.showInvoiceDetail');
                switch ((int)$data[$i]["status"]) {
                    case 1:
                    $status='<img src="'.asset('/public/frontend/images/active.png').'" />' ;
                    break;
                    case 0:
                    $status='<img src="'.asset('/public/frontend/images/inactive.png').'" />' ;
                    break;          
                }
                ?>
                <tr>
                    <td><?php echo $code; ?></td>
                    <td><?php echo datetimeConverterVn($data[$i]["created_at"]) ; ?></td>
                    <td><?php echo $data[$i]["username"]; ?></td>
                    <td><?php echo $data[$i]["fullname"]; ?></td>
                    <td><?php echo $data[$i]["phone"]; ?></td>
                    <td><?php echo $data[$i]["mobilephone"]; ?></td>
                    <td align="center"><?php echo $data[$i]["quantity"]; ?></td>
                    <td align="right"><?php echo fnPrice($data[$i]["total_price"]) ; ?></td>
                    <td align="center"><?php echo $status; ?></td>
                    <td align="center"><a  data-toggle="modal" data-target="#modal-history-invoice" class="cursorpointer" onclick="showLstInvoiceDetail('<?php echo $show_invoice_detail_link ; ?>','<?php echo $product_image ;  ?>',<?php echo $id; ?>,<?php echo $quantity ?>,'<?php echo $total_price; ?>');">Xem</a></td>
                </tr>
                <?php
            }
            ?>                              
        </tbody>    
    </table>
</form>
<div class="modal fade" id="modal-history-invoice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>
      <div class="modal-body">
        
      </div>      
    </div>
  </div>
</div>