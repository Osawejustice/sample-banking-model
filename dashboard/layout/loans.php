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
                        <h4 class="card-title mb-4"><?=$page?></h4>

                        <div class="table-responsive mb-0">
                            <div class="buttons___container"></div>
                            <table class="table data-table table-striped table-bordered dt-buttons">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Amount</th>
                                    <th>Package</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th class="no-export">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 0;
                                    foreach ($app->userTransactions($user_id) as $transaction) {
                                        if (!empty($sub) && $sub != "all") {
                                            if ($transaction->type != $sub) continue;
                                        }
                                        $count++;
                                        $luser = $app->user($transaction->user_id);
                                        ?>
                                        <tr item_id="<?=$app->encrypt($transaction->id)?>">
                                            <td>
                                                <?=$count?>
                                            </td>
                                            <td><?=$transaction->trans_id?></td>
                                            <td><?=$coin.$app->format($transaction->amount)?></td>
                                            <td><?=$transaction->typeText?></td>
                                            <td>
                                                <?php if ($transaction->transType == "credit"):?>
                                                    <span class="badge badge-success">Credit</span>
                                                    <?php else:?>
                                                    <span class="badge badge-danger">Debit</span>
                                                <?php endif?>
                                            </td>
                                            <td><?=date("d-M-Y h:ia", $transaction->date)?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="pTypeActions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Actions <i class="mdi mdi-chevron-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="pTypeActions" style="">
                                                        <a class="dropdown-item" href="./transaction/<?=$transaction->trans_id?>" target="_blank"><i class="fe fe-eye"></i> Details</a>
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