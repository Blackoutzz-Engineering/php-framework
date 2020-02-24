<?php $user = $this->get_data("user");
use core\backend\database\dataset_array;
?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fa fa-user"></i> User <?php echo $user->name; ?>
            <input type="hidden" id="user-id" value="<?php echo $user->id; ?>" />
        </h1>    
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fa fa-lock-alt"></i> <?php echo $user->name; ?>'s Permissions
            </h6>
            <button class="btn btn-primary" data-toggle="modal" data-target="#new-permission">
                <i class="fa fa-plus"></i>
            </button>
        </div>
        <div class="card-body" style="padding:0px;margin:0px;">
            <div class="table-responsive">
                <table class="table" style="margin-bottom:0px;">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Granted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($user->get_permissions() != array())
                        {
                            foreach($user->get_permissions() as $user_permission)
                            {
                                echo '<tr>';
                                echo '<th scope="row">'.$user_permission->get_permission()->get_name().'</th>';
                                echo '<td>'.$user_permission->get_permission()->get_description().'</td>';
                                if($user_permission->granted == true)
                                {
                                    echo '<td><i class="fa fa-2x fa-toggle-on" name="user_permission" alt="granted" id="'.$user_permission->get_id().'"></i></td>';
                                } else {
                                    echo '<td><i class="fa fa-2x fa-toggle-off" name="user_permission" alt="denied" id="'.$user_permission->get_id().'"></i></td>';
                                }
                                echo '</tr>';
                            }
                        } else {
                            echo "<div> <i class='fa fa-info-circle'></i> No permissions found for this user.</div>";
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fa fa-sliders-v-square"></i><?php echo $user->name; ?>'s Options
            </h6>
            <button class="btn btn-primary" data-toggle="modal" data-target="#new-option">
                <i class="fa fa-plus"></i>
            </button>
        </div>
        <div class="card-body" style="padding:0px;margin:0px;">
            <div class="table-responsive">
                <table class="table" style="margin-bottom:0px;">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($user->get_options() instanceof dataset_array){
                            foreach($user->get_options() as $user_option){
                                echo '<tr>';
                                echo '<th scope="row">'.$user_option->get_option()->get_name().'</th>';
                                echo '<th scope="row">'.$user_option->get_value().'</th>';
                                echo '</tr>';
                            }
                        } else {
                            echo("<tr><td><i class='fa fa-info-circle'></i> No options set for this user.</td><td></td></tr>");
                        }

                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fa fa-sliders-v-square"></i><?php echo $user->name; ?>'s Pages
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
                    <tbody>
                        <?php
                        if($user->get_controller_views() != array())
                        {
                            foreach($user->get_controller_views() as $user_controller_view)
                            {
                                echo('<tr>');
                                echo('<th scope="row">'.$user_controller_view->get_controller_view().'</th>');
                                if($user_permission->granted == true)
                                {
                                    echo('<td><i class="fa fa-2x fa-toggle-on" name="user_controller_view" status="granted" id="'.$user_controller_view->get_id().'"></i></td>');
                                } else {
                                    echo('<td><i class="fa fa-2x fa-toggle-off" name="user_controller_view" status="denied" id="'.$user_controller_view->get_id().'"></i></td>');
                                }
                                echo('</tr>');
                            }
                        } else {
                            echo("<div> <i class='fa fa-info-circle'></i> No page access found for this user.</div>");
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="1" id="new-permission" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    New user permissions
                    <i class="fa fa-user"></i>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="NewUserPermission">
                            <i class="fa fa-id-card"></i> Permission :
                        </label>
                        <select id="NewUserPermission" class="form-control" aria-describedby="UserPermissionHelp">
                            <?php
                            $permissions = $this->get_data("permissions");
                            if(count($permissions) >= 1){
                                foreach($permissions as $permission){
                                    echo("<option value='{$permission->id}'>{$permission->name}</option>");
                                }
                            }
                            ?>
                        </select>
                        <small id="UserPermissionHelp" class="form-text text-muted">This permission will be granted to this user</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="add-permission" type="button" class="btn btn-primary">Grant</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="1" id="new-option" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    New user option
                    <i class="fa fa-user"></i>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="NewUserOption">
                            <i class="fa fa-id-card"></i> Option :
                        </label>
                        <select class="form-control" id="NewUserOption" aria-describedby="UserOptionHelp">
                            <?php
                            $options = $this->get_data("options");
                            if(count($options) >= 1){
                                foreach($options as $option){
                                    echo("<option value='{$option->id}'>{$option->name}</option>");
                                }
                            }
                            ?>
                        </select>
                        <small id="UserNameHelp" class="form-text text-muted">This option will let you save a new value for this user as a setting.</small>
                    </div>
                    <div class="form-group">
                        <label for="NewUserOptionValue">
                            <i class="fa fa-id-card"></i> Value :
                        </label>
                        <input type="text" class="form-control" id="NewUserOptionValue" aria-describedby="UserOptionValueHelp" placeholder="Enter Option Value" />
                        <small id="UserOptionValueHelp" class="form-text text-muted">This value will be used a the new setting value for this user.</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="add-option" type="button" class="btn btn-primary">Create</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="1" id="new-page" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    New user page
                    <i class="fa fa-users"></i>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="NewUserPage">
                            <i class="fa fa-desktop"></i> Page :
                        </label>
                        <select class="form-control" id="NewUserPage" aria-describedby="UserPageHelp">
                            <?php
                            $pages = $this->get_data("pages");
                            if(count($pages) >= 1){
                                foreach($pages as $page){
                                    echo("<option value='{$page->id}'>{$page}</option>");
                                }
                            }
                            ?>
                        </select>
                        <small id="UserPageHelp" class="form-text text-muted">The access to this page will be granted to this user.</small>
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