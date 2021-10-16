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
                    <div class="card-body">

                        <h4 class="card-title mb-3"><?=$page?></h4>

                        <div class="table-responsive mb-0">
                            <table class="table data-table table-striped table-bordered dt-buttons">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>User / Staff</th>
                                    <th>Dept.</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th class="no-export">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 0;
                                    foreach ($app->all_tickets() as $ticket) {
                                        $luser = $app->user($ticket->user_id, null, true);
                                        if ($ticket->status == "open") {
                                            $statusText = '<span class="badge badge-success">Open</span>';
                                        } elseif ($ticket->status == "resolved") {
                                            $statusText = '<span class="badge badge-dark">Resolved</span>';
                                        } elseif ($ticket->status == "closed") {
                                            $statusText = '<span class="badge badge-danger">Closed</span>';
                                        }
                                        $count++;
                                        $department = $app->support_departments($ticket->department);
                                        ?>
                                        <tr>
                                            <td><?=$count?></td>
                                            <td><?=$ticket->title?></td>
                                            <td><?=$luser->name?></td>
                                            <td><?=($department->name) ? $department->name : null?></td>
                                            <td><?=$statusText?></td>
                                            <td><?=date("d M Y h:ia", strtotime($ticket->created))?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="userActions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Actions <i class="mdi mdi-chevron-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="userActions" style="">
                                                        <a class="dropdown-item lazy" href="./tickets/<?=$ticket->ticket_id?>">View</a>
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
    </div>
    <!-- container-fluid -->
</div>