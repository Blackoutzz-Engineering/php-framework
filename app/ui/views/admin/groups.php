<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fa fa-users"></i> Groups
            </h6>
            <button class="btn btn-primary right" data-toggle="modal" data-target="#new-group">
                <i class="fa fa-plus"></i>
            </button>
        </div>
        <div class="card-body" style="padding:0px;margin:0px;">
            <div class="table-responsive">
                <table class="table table-striped table-hover" style="margin-bottom:0px;">
                    <thead>
                        <th> Name </th>
                    </thead>
                    <tbody>
                    <?php
                    foreach($this->get_data("groups") as $user_group)
                    {
                        echo("<tr id='{$user_group->id}'>");
                        echo("<td><a href='/admin/group/{$user_group->id}'>{$user_group->name}</a></td>");
                        echo("</tr>");
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
                        <i class="fa fa-users"></i> <?php echo count($this->get_data("groups")); ?> groups found.
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

<div class="modal" tabindex="1" id="new-group" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Create User Group
                    <i class="fa fa-users"></i>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="NewGroupName">
                            <i class="fa fa-id-card"></i> Group Name :
                        </label>
                        <input type="text" class="form-control" id="NewGroupName" aria-describedby="GroupNameHelp" placeholder="Enter Group Name" />
                        <small id="GroupNameHelp" class="form-text text-muted">Will be used to group user together and give them permissions.</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="add-group" type="button" class="btn btn-primary">Create</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>