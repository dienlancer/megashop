@extends("admin.master")
@section("content")
<?php 
$linkCancel             =   route('admin.'.$controller.'.getList');
$linkSave               =   route('admin.'.$controller.'.save');
?>
<form class="form-horizontal" method="post" action="{!! $linkSave !!}" name="frm" role="form" enctype="multipart/form-data">
    {{ csrf_field() }}                                  
                
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="{{$icon}}"></i>
            <span class="caption-subject font-dark sbold uppercase">{{$title}}</span>
        </div>
        <div class="actions">
           <div class="table-toolbar">
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn purple">Lưu <i class="fa fa-floppy-o"></i></button> 
                    <a href="<?php echo $linkCancel; ?>" class="btn green">Thoát <i class="fa fa-ban"></i></a>                    </div>                                                
                </div>
            </div>    
        </div>
    </div>
    <div class="portlet-body form">        
            <fieldset class="adminform">
                    <legend>Details</legend>
                        <table class="table-image" id="table-image" border="0" cellpadding="0" cellspacing="0" border="1">
                            <thead>
                                <tr>                                    
                                    <th>File</th>                                  
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>                                    
                                    <td align="center" valign="middle"><input type="file" name="media_file[]"></td>
                                    <td align="center" valign="middle" class="tdcmd"><a href="javascript:void(0)"  onclick="addRow(this);"><img class="img_media_file" src=" <?php echo url("/public/admin/images/add.png"); ?>" /></a></td>
                                </tr>
                            </tbody>
                        </table>    
                    <div class="clr"></div>

                </fieldset>        
    </div>
</div>
</form>
<script type="text/javascript" language="javascript">
    function addRow(control) {
        var tbody=jQuery(control).closest("tbody")[0];
        var currRow = tbody.rows[tbody.rows.length - 1];
        var cloneRow = currRow.cloneNode(true);
        tbody.appendChild(cloneRow);
        reIndex();
    }
    function removeRow(control) {
        var tbody=jQuery(control).closest("tbody")[0];
        var tr=jQuery(control).closest("tr")[0];
        var index = jQuery(tr).index();         
        tbody.deleteRow(index);
        reIndex();
    }
    function reIndex() {            
        var tbody=jQuery(".table-image > tbody")[0];
        var tdcmd = jQuery(tbody).find("td.tdcmd");                    
        for (var i = 0; i < tdcmd.length - 1; i++) {                
            jQuery(tdcmd[i]).html('<a href="javascript:void(0)"  onclick="removeRow(this);"><img class="img_media_file" src="<?php echo url("/public/admin/images/delete-icon.png"); ?>" /></a>');
        }
        jQuery(tdcmd[tdcmd.length - 1]).html('<a href="javascript:void(0)"  onclick="addRow(this);"><img class="img_media_file" src="<?php echo url("/public/admin/images/add.png"); ?>" /></a>');
    }
</script>
@endsection()            