
function showLstInvoiceDetail(ajaxurl,lnk_image,value,quantity,total_price){
		var id = value;						
		var dataObj = {					
					"id"		: id					
				};		
		$.ajax({
			url			: ajaxurl,
			type		: "GET",
			data		: dataObj,
			dataType	: "json",
			success		: function(data, status, jsXHR){							
							var thead='<thead><tr><th colspan="2">PRODUCT</th><th>PRICE</th><th>QTY</th><th>SUBTOTAL</th></tr></thead>';
							var tbody="<tbody>";		
							var tr="";	
							for(var i=0;i<data.length;i++){
								var product_image=lnk_image + data[i]["product_image"];
								var tdImage='<td align="center" class="com_product17"><img src='+product_image+' width="42" height="56" /></td>';
								var tdName='<td class="com_product20">'+data[i]["product_name"]+'</td>';
								var tdPrice='<td class="com_product21" align="right">'+accounting.formatMoney(data[i]["product_price"], "", 0, ".",",")+'</td>';
								var tdQty='<td align="center" class="com_product22" align="center">'+data[i]["product_quantity"]+'</td>';
								var tdTotalPrice='<td class="com_product23" align="right">'+accounting.formatMoney(data[i]["product_total_price"], "", 0, ".",",")+'</td>';	
								tr+='<tr>'+tdImage+tdName+tdPrice+tdQty+tdTotalPrice+'</tr>';							
							}
							tbody=tbody+tr+'</tbody>';
							var tfoot='<tfoot><tr><td colspan="3" align="center"><b>TOTAL</b></td><td align="center">'+quantity+'</td><td align="right">'+accounting.formatMoney(total_price, "", 0, ".",",")+'</td></tr></tfoot>';
							var str='<table border="0" class="com_product16" cellspacing="0" cellpadding="0" width="100%">'+thead+tbody+tfoot+'</table>';							
							$(".modal-body").empty();
							$(".modal-body").append(str);
						}
		});

	}

function changePage(page){
	$('input[name=filter_page]').val(page);$("form[name='frm']")[0].submit();}
function isNumberKey(evt){var hopLe=true;var charCode=(evt.which)?evt.which:event.keyCode;if(charCode>31&&(charCode<48||charCode>57))hopLe=false;return hopLe;}
function checkRegister() {
    var hopLe=true;
    var strMsg="";
    var fullname=document.getElementById("fullname").value;
    var phone=document.getElementById("phone").value;
    if(fullname=="") {
        hopLe=false;
        strMsg="Vui lòng điền tên";
    }
    if(phone=="") {
        hopLe=false;
        strMsg="Vui lòng điền điện thoại";
    }
    if(!hopLe)alert(strMsg);
    return hopLe;
}
function addToCart(product_id,ajaxurl){
	var id = product_id;		
	var dataObj = {		
		"id"		: id		
	};		
	$.ajax({
		url			: ajaxurl,
		type		: "GET",
		data		: dataObj,
		dataType	: "json",
		success		: function(data, status, jsXHR){
			var thong_bao='Sản phẩm đã được thêm vào trong <a href="'+data.permalink+'" class="comproduct49" >giỏ hàng</a> ';				
			$(".cart-total").empty();			
			$(".modal-body").empty();		
			$(".cart-total").text(data.quantity);			
			$(".modal-body").append(thong_bao);			
		}
	});
}