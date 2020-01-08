<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                Plugins
            </h6>
        </div>
        <div class="card-body" style="padding:0px;margin:0px;">
            <div class="table-responsive">
                <table class="table table-striped table-hover" style="margin-bottom:0px;">
                    <thead>
                        <th>Name </th>
                        <th>Version </th>
                        <th>Activated </th>
                    </thead>
                    <tbody id="plugins"><?php
                        foreach($this->get_data("plugins") as $plugin)
                        {
                            echo "<tr id='".$plugin->get_slug()."' name='plugin'>";
                            echo "<td>".$plugin->get_name()."</td>";
                            echo "<td>".$plugin->get_version()."</td>";
                            echo "<td>";
                            if($plugin->is_enabled())
                            {
                                echo "<button class='toggle' id='uninstall' name='".$plugin->get_slug()."'><i class='fa fa-toggle-on fa-2x'></i></button>";
                            }
                            else
                            {
                                echo "<button class='toggle' id='install' name='".$plugin->get_slug()."'><i class='fa fa-toggle-off fa-2x'></i></button>";
                            }
                            echo "</td></tr>";
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
                        <?php echo count($this->get_data("plugins")); ?> Plugins found.
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