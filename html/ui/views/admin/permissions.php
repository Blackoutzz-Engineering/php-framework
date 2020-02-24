<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                Permissions
            </h6>
            <button class="btn btn-primary" data-toggle="modal" data-target="#new-permission">
                <i class="fa fa-plus"></i>
            </button>
        </div>
        <div class="card-body" style="padding:0px;margin:0px;">
            <div class="table-responsive">
                <table class="table table-striped table-hover" style="margin-bottom:0px;">
                    <thead>
                        <th>Name </th>
                        <th>Description </th>
                    </thead>
                    <tbody>
                        <?php
                        foreach($this->get_data("permissions") as $permission)
                        {
                            echo "<tr id='{$permission->id}'>";
                            echo "  <td><a href='/admin/permission/{$permission->id}'>{$permission->name}</a></td>";
                            echo "  <td>".$permission->get_description()."</td>";
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
                        <?php echo count($this->get_data("permissions")); ?> Permissions found.
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
<div class="modal" tabindex="1" id="new-permission" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Create Permission
                    <i class="fa fa-lock-alt"></i>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="NewPermissionName">
                            <i class="fa fa-id-card"></i> Permission Name :
                        </label>
                        <input type="text" class="form-control" id="NewPermissionName" aria-describedby="PermissionNameHelp" placeholder="Enter Name" />
                        <small id="PermissionNameHelp" class="form-text text-muted">Make it sounds useful.</small>
                    </div>
                    <div class="form-group">
                        <label for="NewPermissionDescription">
                            <i class="fa fa-info-circle"></i> Permission Description :
                        </label>
                        <input type="text" class="form-control" id="NewPermissionDescription" aria-describedby="PermissionDescriptionHelp" placeholder="Enter Description" />
                        <small id="PermissionDescriptionHelp" class="form-text text-muted">Explain the purpose of the permission.</small>
                    </div>
                    <input type="hidden" class="form-control" id="NewPermissionId" />
                </form>
            </div>
            <div class="modal-footer">
                <button id="add-permission" type="button" class="btn btn-primary">Create</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>