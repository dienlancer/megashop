<ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
    <li class="sidebar-toggler-wrapper hide">
        <div class="sidebar-toggler">
            <span></span>
        </div>
    </li>                                          
    <li class="nav-item  ">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="fa fa-folder-open-o" ></i>
            <span class="title">Quản lý nội dung</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">                                    
            <li class="nav-item  ">
                <a href="{!! route('admin.category-article.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Chủ đề bài viết</span>                                            
                </a>                                                                      
            </li>            
            <li class="nav-item  ">
                <a href="{!! route('admin.article.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Bài viết</span>                                            
                </a>                                                                      
            </li>           
        </ul>
    </li>
    <li class="nav-item  ">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="fa fa-folder-open-o" ></i>
            <span class="title">Sản phẩm</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">                                    
            <li class="nav-item  ">
                <a href="{!! route('admin.category-product.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Loại sản phẩm</span>                                            
                </a>                                                                      
            </li>
            <li class="nav-item  ">
                <a href="{!! route('admin.product.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Sản phẩm</span>                                            
                </a>                                                                      
            </li>
            <li class="nav-item  ">
                <a href="{!! route('admin.customer.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Khách hàng</span>                                            
                </a>                                                                      
            </li>
            <li class="nav-item  ">
                <a href="{!! route('admin.payment-method.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Phương thức thanh toán</span>                                            
                </a>                                                                      
            </li>
            <li class="nav-item  ">
                <a href="{!! route('admin.invoice.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Đơn hàng</span>                                            
                </a>                                                                      
            </li>
        </ul>
    </li>
    <li class="nav-item  ">
                <a href="{!! route('admin.menu-type.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Menu</span>                                            
                </a>                                                                      
    </li> 
    <li class="nav-item  ">
                <a href="{!! route('admin.module-item.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Module</span>                                            
                </a>                                                                      
    </li>     
    <li class="nav-item  ">
                <a href="{!! route('admin.media.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Media</span>                                            
                </a>                                                                      
    </li>      
    <li class="nav-item  ">
                <a href="{!! route('admin.setting-system.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Cấu hình</span>                                            
                </a>                                                                      
    </li>       
    <li class="nav-item  ">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="fa fa-folder-open-o" ></i>
            <span class="title">Quản lý người dùng</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">                                    
            <li class="nav-item  ">
                <a href="{!! route('admin.group-member.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Nhóm người dùng</span>                                            
                </a>                                                                      
            </li>
            <li class="nav-item  ">
                <a href="{!! route('admin.user.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Người dùng</span>                                            
                </a>                                                                      
            </li>
            <li class="nav-item  ">
                <a href="{!! route('admin.privilege.getList') !!}" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Nhóm quyền</span>                                            
                </a>                                                                      
            </li>
        </ul>
    </li>                                           
</ul>