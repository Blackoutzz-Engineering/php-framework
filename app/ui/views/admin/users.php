<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Users Management
                <button class="btn btn-default" data-toggle="modal" data-target="#new-user">
                    <i class="fa fa-user-plus"></i>
                </button>
            </h6>
        </div>
        <div class="card-body" style="padding:0px;margin:0px;">
            <div class="table-responsive">
            <table class="table table-striped table-hover" style="margin-bottom:0px;">
                <thead>
                    <tr>
                        <th scope="col">Gravatar</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Group</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $users = $this->get_data("users");
                    foreach($users as $user)
                    {
                        echo "<tr>";
                        echo "  <td>".$this->get_widget("gravatar",["email"=>$user->email,"username"=>$user->username])."</td>";
                        echo "  <td>{$user->name}</td>";
                        echo "  <td>{$user->email}</td>";
                        echo "  <td>{$user->group}</td>";
                        echo "  <td> <button id=\"reset\" type=\"button\" data-id='{$user->id}' class=\"btn btn-primary\">Reset password</button> </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>     
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">
                        <i class="fa fa-users"></i><?php echo count($users); ?> users found.
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                        <ul class="pagination">
                            <li class="paginate_button page-item previous disabled" id="dataTable_previous">
                                <a href="#" aria-controls="dataTable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
                            </li>
                            <li class="paginate_button page-item active">
                                <a href="#" aria-controls="dataTable" data-dt-idx="1" tabindex="0" class="page-link">1</a>
                            </li>
                            <li class="paginate_button page-item next" id="dataTable_next">
                                <a href="#" aria-controls="dataTable" data-dt-idx="7" tabindex="0" class="page-link">Next</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="1" id="new-user" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Invite new user
                    <i class="fa fa-user"></i>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="NewUserName">
                            <i class="fa fa-id-card"></i> Username :
                        </label>
                        <input type="text" class="form-control" id="NewUserName" aria-describedby="UsernameHelp" placeholder="Enter Username" />
                        <small id="UsernameHelp" class="form-text text-muted">Use something not related to your real name.</small>
                    </div>
                    <div class="form-group">
                        <label for="NewUserEmail">
                            <i class="fa fa-envelope"></i> Email address :
                        </label>
                        <input type="email" class="form-control" id="NewUserEmail" aria-describedby="emailHelp" placeholder="Enter email" />
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="NewUserGroup">
                            <i class="fa fa-users"></i> Group :
                        </label>
                        <select class="form-control" id="NewUserGroup">
                            <?php
                            $groups = $this->get_data("groups");
                            foreach($groups as $group)
                            {
                                if($group->get_name() != "Guest" || $group->get_name() != "Banned")
                                {
                                    if($group->get_name() === "User")
                                    {
                                        echo "<option value='{$group->get_id()}' Selected>{$group->get_name()}</option>" ;
                                    }
                                    else
                                        {
                                        echo "<option value='{$group->get_id()}'>{$group->get_name()}</option>";
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="add-user" type="button" class="btn btn-primary">Send Invite</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
