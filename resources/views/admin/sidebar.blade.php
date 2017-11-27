<?php 
$li_content_management='';
$li_category_article='';
$li_article='';

$li_product_management='';
$li_category_product='';
$li_product='';
$li_customer='';
$li_payment_method='';
$li_invoice='';

$li_menu_type='';
$li_module_item='';

$li_setting_system='';

$li_phan_quyen='';
$li_group_member='';
$li_user='';
$li_privilege='';
switch ($controller) {
    case 'category-article':  
        $li_category_article='active open';
        $li_content_management='active open';
        break;   
    case 'article': 
        $li_article='active open';
        $li_content_management='active open';
        break;
    case 'category-product':  
        $li_category_product='active open';
        $li_product_management='active open';
        break;   
    case 'product': 
        $li_product='active open';
        $li_product_management='active open';
        break;
    case 'customer': 
        $li_customer='active open';
        $li_product_management='active open';
        break;
    case 'payment-method':     
        $li_payment_method='active open';
        $li_product_management='active open';
        break;
    case 'invoice':        
        $li_invoice='active open';
        $li_product_management='active open';
        break; 
    case 'menu-type':
        $li_menu_type='active open';
        break;  
    case 'module-item':
        $li_module_item='active open';
        break;
    case 'setting-system':
        $li_setting_system='active open';
        break; 
    case 'group-member':
        $li_group_member='active open';
        $li_phan_quyen='active open';
        break;  
    case 'user':
        $li_user='active open';
        $li_phan_quyen='active open';
        break;
    case 'privilege':
        $li_privilege='active open';
        $li_phan_quyen='active open';
        break;       
}
?>
<ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
    <li class="sidebar-toggler-wrapper hide">
        <div class="sidebar-toggler">
            <span></span>
        </div>
    </li>                                          
    <li class="nav-item <?php echo $li_content_management; ?>">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="fa fa-folder-open-o" ></i>
            <span class="title">Quản lý nội dung</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">                                    
            <li class="nav-item  <?php echo $li_category_article; ?>">
                <a href="{!! route('admin.category-article.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Chủ đề bài viết</span>                                            
                </a>                                                                      
            </li>            
            <li class="nav-item  <?php echo $li_article; ?>">
                <a href="{!! route('admin.article.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Bài viết</span>                                            
                </a>                                                                      
            </li>           
        </ul>
    </li>
    <li class="nav-item  <?php echo $li_product_management; ?>">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="fa fa-folder-open-o" ></i>
            <span class="title">Sản phẩm</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">                                    
            <li class="nav-item  <?php echo $li_category_product; ?>">
                <a href="{!! route('admin.category-product.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Loại sản phẩm</span>                                            
                </a>                                                                      
            </li>
            <li class="nav-item  <?php echo $li_product; ?>">
                <a href="{!! route('admin.product.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Sản phẩm</span>                                            
                </a>                                                                      
            </li>
            <li class="nav-item  <?php echo $li_customer; ?>">
                <a href="{!! route('admin.customer.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Khách hàng</span>                                            
                </a>                                                                      
            </li>
            <li class="nav-item <?php echo $li_payment_method; ?> ">
                <a href="{!! route('admin.payment-method.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Phương thức thanh toán</span>                                            
                </a>                                                                      
            </li>
            <li class="nav-item  <?php echo $li_invoice; ?>">
                <a href="{!! route('admin.invoice.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Đơn hàng</span>                                            
                </a>                                                                      
            </li>
        </ul>
    </li>
    <li class="nav-item  <?php echo $li_menu_type; ?>">
                <a href="{!! route('admin.menu-type.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Menu</span>                                            
                </a>                                                                      
    </li> 
    <li class="nav-item  <?php echo $li_module_item; ?>">
                <a href="{!! route('admin.module-item.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Module</span>                                            
                </a>                                                                      
    </li>     
    
    <li class="nav-item  <?php echo $li_setting_system; ?>">
                <a href="{!! route('admin.setting-system.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Cấu hình</span>                                            
                </a>                                                                      
    </li>       
    <li class="nav-item  <?php echo $li_phan_quyen ?>">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="fa fa-folder-open-o" ></i>
            <span class="title">Quản lý người dùng</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">                                    
            <li class="nav-item  <?php echo $li_group_member; ?>">
                <a href="{!! route('admin.group-member.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Nhóm người dùng</span>                                            
                </a>                                                                      
            </li>
            <li class="nav-item  <?php echo $li_user; ?>">
                <a href="{!! route('admin.user.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Người dùng</span>                                            
                </a>                                                                      
            </li>
            <li class="nav-item  <?php echo $li_privilege; ?>">
                <a href="{!! route('admin.privilege.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Nhóm quyền</span>                                            
                </a>                                                                      
            </li>
        </ul>
    </li>                                           
</ul>