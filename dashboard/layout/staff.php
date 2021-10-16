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
                            <a href="./<?=($pager == "agents") ? 'agents/add' : 'aggregators/add'?>" class="lazy btn btn-sm btn-dark text-white lazy"><i class="align-middle ri ri-add-line"></i></a>
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
                                    <?php if($user_type == "aggregator"):?>
                                    <td title="Aggregator Code">Agg. Code</td>
                                    <td>No. of POS</td>
                                    <?php endif?>
                                    <th>Date Added</th>
                                    <th class="no-export">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $filter = null;
                                    if (!empty($user_type)) {
                                        $filter = "user_type = '$user_type'";
                                    }
                                    foreach ($app->all_users($filter, false) as $luser) {
                                        ?>
                                        <tr user_id="<?=$app->encrypt($luser->id)?>">
                                            <td><?=$luser->name?></td>
                                            <td><?=$luser->email?></td>
                                            <td><?=$luser->phone?></td>
                                            <td><?=$app->get_states($luser->location)?></td>
                                            <?php if($user_type == "aggregator"):?>
                                            <td><?=$luser->phone?></td>
                                            <td><?=$luser->pos_count?></td>
                                            <?php endif?>
                                            <td><?=date("d M, Y", $luser->date)?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="userActions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Actions <i class="mdi mdi-chevron-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="userActions" style="">
                                                        <a class="dropdown-item lazy" href="./<?=$user_type?>s/<?=$luser->uid?>">View</a>
                                                        <div class="dropdown-divider"></div>
                                                        
                                                        <a class="dropdown-item lazy" href="./<?=$user_type?>s/<?=$luser->id?>?edit=true">Edit</a>
                                                        <div class="dropdown-divider"></div>

                                                        <?php if($luser->active == 1):?>
                                                        <a class="dropdown-item lazy deactivate-item" href="javascript:">Deactivate</a>
                                                        <?php else:?>
                                                        <a class="dropdown-item lazy activate-item" href="javascript:">Activate</a>
                                                        <?php endif?>
                                                        <div class="dropdown-divider"></div>

                                                        <a class="dropdown-item lazy view-activity" href="javascript:">View activities</a>
                                                        <div class="dropdown-divider"></div>

                                                        <a class="dropdown-item lazy" href="./<?=$user_type?>s/<?=$luser->uid?>?verify=true">Verify</a>
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
                    var conf = confirm("Are you sure you want to delete this account?");
                    if (!conf) { return false;}

                    tr = $(this).closest('tr');
                    user_id = tr.attr('user_id');
                    var data = {
                        user_id:user_id
                    }
                    xhrRequest({
                        url : "./backend/users-actions?action=delete",
                        data : data,
                        done : function(data) {
                            if(data.error == false) {
                                notyf.success(data.msg);
                            } else {
                                page_error(data.msg);
                            }
                        }
                    })
                });

                // Deativate user
                $(".deactivate-item, .activate-item").click(function(event) {
                    event.preventDefault();

                    if ($(this).hasClass('activate-item')) {
                       var action = "activate";
                    } else if ($(this).hasClass('deactivate-item')) {
                       var action = "deactivate";
                    }
                    var conn = confirm("Are you sure you want to "+ action +" this account?");
                    if (!conn) { return false; }

                    tr = $(this).closest('tr');
                    user_id = tr.attr('user_id');
                    var data = {
                        user_id:user_id
                    }
                    xhrRequest({
                        url : "./backend/users-actions?action="+action,
                        data : data,
                        done : function(data) {
                            if(data.error == false) {
                                notyf.success(data.msg);
                            } else {
                                page_error(data.msg);
                            }
                        }
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