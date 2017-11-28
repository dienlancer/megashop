var vCategoryArticleTable   =   null;
var vArticleTable           =   null;
var vArticleModuleItemTable           =   null;
var vProductModuleItemTable           =   null;
var vMenuTypeTable          =   null;
var vMenuTable              =   null;
var vCategoryProductTable   =   null;
var vProductTable           =   null;
var vModuleMenuTable        =   null;
var vModuleArticleTable     =   null;
var vModuleItemTable        =   null;
var vGroupMemberTable       =   null;
var vUserTable              =   null;
var vPrivilegeTable         =   null;
var vCustomerTable          =   null;
var vInvoiceTable           =   null;
var vPaymentMethodTable     =   null;
var vBannerTable            =   null;
var vSettingSystemTable     =   null;
var vItemTable     =   null;
var vArticleComponentTable = null;
var vProductComponentTable = null;
var basicTable = function () {
    var initCategoryArticleTable = function () {
        vCategoryArticleTable = $('#tbl-category-article').DataTable({
            columns: [                
                { data: "checked"            },
                { data: "fullname"      },
                { data: "alias"         },
                { data: "parent_fullname"     },
                { data: "image"         },
                { data: "sort_order"    },
                { data: "status"        },                            
                { data: "edited"    },         
                { data: "deleted"    },                
            ]
        });        
    };
    var initItemTable = function () {
        vItemTable = $('#tbl-item').DataTable({
            columns: [                
                { data: "checked"            },                
                { data: "fullname"      },    
                { data: "image"      },               
                { data: "sort_order"    },               
                { data: "deleted"    },                
            ]
        });        
    };
    var initArticleComponentTable = function () {
        vArticleComponentTable = $('#tbl-article-component').DataTable({
            columns: [                                
                { data: "fullname"      },    
                { data: "image"      },               
                { data: "sort_order"    },                               
            ]
        });        
    };
    var initProductComponentTable = function () {
        vProductComponentTable = $('#tbl-product-component').DataTable({
            columns: [                            
                { data: "fullname"      },    
                { data: "image"      },               
                { data: "sort_order"    },                               
            ]
        });        
    };
    var initArticleTable = function () {
        vArticleTable = $('#tbl-article').DataTable({
            columns: [                
                { data: "checked"            },                
                { data: "fullname"      },
                { data: "alias"      },
                { data: "image"         },
                { data: "sort_order"    },
                { data: "status"        },                                
                { data: "edited"    },         
                { data: "deleted"    },                
            ]
        });        
    };
    var initArticleModuleItemTable = function () {
        vArticleModuleItemTable = $('#tbl-article-module-item').DataTable({
            columns: [                
                { data: "checked"            },                
                { data: "fullname"      },
                { data: "alias"      },
                { data: "image"         },                                            
            ]
        });        
    };
    var initProductModuleItemTable = function () {
        vProductModuleItemTable = $('#tbl-product-module-item').DataTable({
            columns: [                
                { data: "checked"            },               
                { data: "fullname"      },
                { data: "alias"      },
                { data: "image"         },                                            
            ]
        });        
    };
    var initMenuTypeTable = function () {
        vMenuTypeTable = $('#tbl-menu-type').DataTable({
            columns: [                
                { data: "checked"            },
                { data: "fullname"      },   
                { data: "theme_location"      },               
                { data: "sort_order"    },                                                
                { data: "entranced"    },
                { data: "status"    }, 
                { data: "edited"    },         
                { data: "deleted"    },                
            ]
        });        
    };
    var initMenuTable = function () {
        vMenuTable = $('#tbl-menu').DataTable({
            columns: [                
                { data: "checked"       },
                { data: "fullname"      },      
                { data: "level"         },         
                { data: "sort_order"    },   
                { data: "status"        },                                        
                { data: "edited"        },         
                { data: "deleted"       },                
            ]
        });        
    };
    var initCategoryProductTable = function () {
        vCategoryProductTable = $('#tbl-category-product').DataTable({
            columns: [                
                { data: "checked"            },
                { data: "fullname"      },
                { data: "alias"         },
                { data: "parent_fullname"     },
                { data: "image"         },
                { data: "sort_order"    },
                { data: "status"        },                            
                { data: "edited"    },         
                { data: "deleted"    },                
            ]
        });        
    };
    var initProductTable = function () {
        vProductTable = $('#tbl-product').DataTable({
            columns: [                
                { data: "checked"       },                
                { data: "fullname"      },
                { data: "alias"         },
                { data: "image"         },
                { data: "sort_order"    },
                { data: "status"        },                                
                { data: "edited"        },         
                { data: "deleted"       },                
            ]
        });        
    };
    var initModuleMenuTable = function () {
        vModuleMenuTable = $('#tbl-module-menu').DataTable({
            columns: [                
                { data: "checked"       },
                { data: "fullname"      },
                { data: "position"      },                
                { data: "sort_order"    },
                { data: "status"        },                                
                { data: "edited"        },         
                { data: "deleted"       },                
            ]
        });        
    };
    var initModuleArticleTable = function () {
        vModuleArticleTable = $('#tbl-module-article').DataTable({
            columns: [                
                { data: "checked"       },
                { data: "fullname"      },
                { data: "position"      },                
                { data: "sort_order"    },
                { data: "status"        },                                
                { data: "edited"        },         
                { data: "deleted"       },                
            ]
        });        
    };
    var initModuleItemTable = function () {
        vModuleItemTable = $('#tbl-module-item').DataTable({
            columns: [                
                { data: "checked"       },
                { data: "fullname"      },
                { data: "position"      },                
                { data: "sort_order"    },
                { data: "status"        },                                
                { data: "edited"        },         
                { data: "deleted"       },                
            ]
        });        
    };
    var initPaymentMethodTable = function () {
        vPaymentMethodTable = $('#tbl-payment-method').DataTable({
            columns: [                
                { data: "checked"       },
                { data: "fullname"      },
                { data: "alias"         },                
                { data: "sort_order"    },
                { data: "status"        },                                
                { data: "edited"        },         
                { data: "deleted"       },                
            ]
        });        
    };
    var initSettingSystemTable = function () {
        vSettingSystemTable = $('#tbl-setting-system').DataTable({
            columns: [                
                { data: "checked"       },
                { data: "fullname"      },
                { data: "alias"         },                
                { data: "sort_order"    },
                { data: "status"        },                                
                { data: "edited"        },         
                { data: "deleted"       },                
            ]
        });        
    };
    var initBannerTable = function () {
        vBannerTable = $('#tbl-banner').DataTable({
            columns: [                
                { data: "checked"       },
                { data: "fullname"      },
                { data: "alias"         },                
                { data: "sort_order"    },
                { data: "status"        },                                
                { data: "edited"        },         
                { data: "deleted"       },                
            ]
        });        
    };
    var initGroupMemberTable = function () {
        vGroupMemberTable = $('#tbl-group-member').DataTable({
            columns: [                
                { data: "checked"            },
                { data: "fullname"      },               
                { data: "sort_order"    },                      
                { data: "edited"    },         
                { data: "deleted"    },                
            ]
        });        
    };
    var initUserTable = function () {
        vUserTable = $('#tbl-user').DataTable({
            columns: [                
                { data: "checked"       },
                { data: "username"      },
                { data: "fullname"      },   
                { data: "group_member_name" },            
                { data: "sort_order"    },  
                { data: "status"        },                      
                { data: "edited"        },         
                { data: "deleted"       },                
            ]
        });        
    };
    var initUserTable = function () {
        vUserTable = $('#tbl-user').DataTable({
            columns: [                
                { data: "checked"       },
                { data: "username"      },
                { data: "fullname"      },   
                { data: "group_member_name" },            
                { data: "sort_order"    },  
                { data: "status"        },                      
                { data: "edited"        },         
                { data: "deleted"       },                
            ]
        });        
    };
    var initPrivilegeTable = function () {
        vPrivilegeTable = $('#tbl-privilege').DataTable({
            columns: [                
                { data: "checked"       },               
                { data: "fullname"      },   
                { data: "controller"    },     
                { data: "action"        },            
                { data: "sort_order"    },                  
                { data: "edited"        },         
                { data: "deleted"       },                
            ]
        });        
    };
    var initCustomerTable = function () {
        vCustomerTable = $('#tbl-customer').DataTable({
            columns: [                
                { data: "checked"       },               
                { data: "username"      },   
                { data: "email"         },     
                { data: "fullname"      },            
                { data: "mobilephone"   },            
                { data: "sort_order"    },
                { data: "status"        },                  
                { data: "edited"        },         
                { data: "deleted"       },                
            ]
        });        
    };
    var initInvoiceTable = function () {
        vInvoiceTable = $('#tbl-invoice').DataTable({
            columns: [                
                { data: "checked"       },               
                { data: "code"      },
                { data: "username"      },   
                { data: "email"         },     
                { data: "fullname"      },            
                { data: "mobilephone"   },            
                { data: "sort_order"    },
                { data: "status"        },                  
                { data: "edited"        },         
                { data: "deleted"       },                
            ]
        });        
    };
    return {
        init: function () {
            if (!jQuery().dataTable)
                return;        
            initCategoryArticleTable();  
            initCategoryProductTable();  
            initArticleTable();
            initProductTable();
            initMenuTypeTable();
            initMenuTable();
            initModuleMenuTable();
            initModuleArticleTable();
            initGroupMemberTable();
            initUserTable();
            initPrivilegeTable();
            initCustomerTable();
            initInvoiceTable();
            initModuleItemTable();
            initPaymentMethodTable();
            initBannerTable();
            initSettingSystemTable();
            initArticleModuleItemTable();
            initProductModuleItemTable();
            initItemTable();
            initArticleComponentTable();
            initProductComponentTable();
        }
    };
}();
