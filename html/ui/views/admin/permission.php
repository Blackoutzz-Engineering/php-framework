<?php $permission = $this->get_data("permission"); ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fa fa-cog"></i> Permission <?php echo $permission->name; ?>
            <input type="hidden" id="permission-id" value="<?php echo $permission->id; ?>" />
        </h1>    
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fa fa-sliders-v-square"></i><?php echo $permission->name; ?>'s Pages
            </h6>
            <button class="btn btn-primary" data-toggle="modal" data-target="#new-page">
                <i class="fa fa-plus"></i>
            </button>
        </div>
        <div class="card-body" style="padding:0px;margin:0px;">
            <div class="table-responsive">
                <table class="table" style="margin-bottom:0px;">
                    <thead>
                        <tr>
                            <th scope="col">Page</th>
                            <th scope="col">Granted</th>
                        </tr>
                    </thead>
                    <tbody><?php
                        
                        if($permission->get_controller_views() != array())
                        {
                            foreach($permission->get_controller_views() as $permission_controller_view)
                            {
                                echo('<tr>');
                                echo('<th scope="row">'.$permission_controller_view->get_controller_view().'</th>');
                                if($permission_controller_view->granted == true)
                                {
                                    echo('<td><i class="fa fa-2x fa-toggle-on" name="permission_controller_view" status="granted" id="'.$permission_controller_view->get_id().'"></i></td>');
                                } else {
                                    echo('<td><i class="fa fa-2x fa-toggle-off" name="permission_controller_view" status="denied" id="'.$permission_controller_view->get_id().'"></i></td>');
                                }
                                echo('</tr>');
                            }
                        } else {
                            echo("<div> <i class='fa fa-info-circle'></i> No page access found for this group.</div>");
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="1" id="new-page" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    New Permission Page Access
                    <i class="fa fa-users"></i>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="NewPermissionPage">
                            <i class="fa fa-desktop"></i> Page :
                        </label>
                        <select class="form-control" id="NewPermissionPage" aria-describedby="PermissionPageHelp">
                            <?php
                            $pages = $this->get_data("pages");
                            if(count($pages) >= 1)
                            {
                                foreach($pages as $page)
                                {
                                    echo("<option value='{$page->id}'>{$page}</option>");
                                }
                            }
                            ?>
                        </select>
                        <small id="PermissionPageHelp" class="form-text text-muted">The access to this page will be granted to this permission.</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="add-page" type="button" class="btn btn-primary">Grant</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>