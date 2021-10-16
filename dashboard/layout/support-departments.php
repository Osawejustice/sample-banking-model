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
                        <div class="float-right">
                            <?php if($user->permissions->add_support_departments):?>
                            <a href="./support_departments/add" class="btn btn-dark btn-sm lazy">Add Department</a>
                            <!-- /.btn btn-dark -->
                            <?php endif?>
                        </div>
                        <!-- /.float-right -->
                        <h4 class="card-title mb-3"><?=$page?></h4>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive mb-0">
                            <table class="table data-table table-striped table-bordered dt-buttons">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th class="no-export">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 0;
                                    foreach ($app->support_departments() as $dept) {
                                        $count++;
                                        ?>
                                        <tr item_id="<?=$app->encrypt($dept->id)?>">
                                            <td><?=$count?></td>
                                            <td><?=$dept->name?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="userActions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Actions <i class="mdi mdi-chevron-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="userActions" style="">
                                                        <?php if($user->permissions->edit_support_departments):?>
                                                        <a class="dropdown-item lazy" href="./support_departments/<?=$dept->id?>">Edit</a>
                                                        <?php endif?>
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
    </div>
    <!-- container-fluid -->
</div>