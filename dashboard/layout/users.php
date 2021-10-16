<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><?=$page?></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item lazy"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active"><?=$page?></li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-actions float-right">
                        </div>
                        <h4 class="card-title"><?=$page?></h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive mb-0">
                            <table class="table data-table table-striped table-bordered dt-responsive nowrap">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Location</th>
                                    <th>Date Added</th>
                                    <th class="no-export">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $filter = null;
                                    $filter = "user_type = 'normal'";
                                    foreach ($app->all_users($filter, false) as $luser) {
                                        ?>
                                        <tr user_id="<?=$app->encrypt($luser->id)?>">
                                            <td><?=$luser->name?></td>
                                            <td><?=$luser->email?></td>
                                            <td><?=$luser->phone?></td>
                                            <td><?=$app->get_states($luser->location)?></td>
                                            <td><?=date("d M, Y", $luser->date)?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="userActions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Actions <i class="mdi mdi-chevron-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="userActions" style="">
                                                        <a class="dropdown-item lazy" href="./<?=$user_type?>s/<?=$luser->id?>">View</a>
                                                        <div class="dropdown-divider"></div>
                                                        
                                                        <a class="dropdown-item lazy" href="./<?=$user_type?>s/<?=$luser->id?>?edit=true">Edit</a>
                                                        <div class="dropdown-divider"></div>

                                                        <a class="dropdown-item lazy deactivate-item" href="javascript:">Deactivate</a>
                                                        <div class="dropdown-divider"></div>

                                                        <a class="dropdown-item lazy view-activity" href="javascript:">View activities</a>
                                                        <div class="dropdown-divider"></div>

                                                        <a class="dropdown-item lazy" href="./<?=$user_type?>s/<?=$luser->id?>">Verify</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item delete-item" href="javascript:">Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

        <script type="text/javascript">
            $(document).ready(function() {

                // Delete user
                $(".delete-item").click(function(event) {
                    event.preventDefault();
                    var conf = confirm("Are you sure?");
                    if (!conf) { return false;}

                    tr = $(this).closest('tr');
                    user_id = tr.attr('user_id');
                    var data = {
                        user_id:user_id
                    }
                    var req = ajax_request("./backend/user-actions?action=delete", data, false);
                    req.done(function(data) {
                        if(data.error == false) {
                            notyf.success(data.msg);
                        } else {
                            page_error(data.msg);
                        }
                    });
                    req.fail(function(xhr) {
                        page_error(xhr.StatusText);
                    });
                });

                // Deativate user
                $(".deactivate-item").click(function(event) {
                    event.preventDefault();
                    var conf = confirm("Are you sure?");
                    if (!conf) { return false;}

                    tr = $(this).closest('tr');
                    user_id = tr.attr('user_id');
                    var data = {
                        user_id:user_id
                    }
                    var req = ajax_request("./backend/user-actions?action=deactivate", data, false);
                    req.done(function(data) {
                        if(data.error == false) {
                            notyf.success(data.msg);
                        } else {
                            page_error(data.msg);
                        }
                    });
                    req.fail(function(xhr) {
                        page_error(xhr.StatusText);
                    });
                });

                // View User
                $(".view-activity").on('click', function(event) {
                    event.preventDefault();
                    tr = $(this).closest('tr');
                    user_id = tr.attr('user_id');
                    var data = {
                        user_id:user_id
                    }
                    buttons = "";
                    modal_load({
                        url:"./backend/users-actions?action=details", 
                        data:{
                            user_id:user_id
                        }, 
                        buttons:""
                    });
                });
            });
        </script>
    </div>
    <!-- container-fluid -->
</div>