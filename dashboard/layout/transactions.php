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
        
        <?php if (empty($sub)):?>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-lg-2">
                <a href="./transactions/pos" class="lazy">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="card-title">POS</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-2">
                <a href="./transactions/airtime" class="lazy">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="card-title">Airtime</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-2">
                <a href="./transactions/data" class="lazy">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="card-title">Data</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-2">
                <a href="./transactions/wallet_funding" class="lazy">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="card-title">Wallet Funding</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-2">
                <a href="./transactions/transfer" class="lazy">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="card-title">Transfers</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div> <!-- end row -->
        <?php endif?>
            
        <?php if(!empty($sub)):?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="float-right">
                            <button class="btn btn-dark btn-sm" title="Refresh" onclick="reload(true)"><i class="ri-refresh-line"></i></button>
                            <!-- /.btn btn-sm -->
                        </div>
                        <h4 class="card-title mb-4"><?=$page?></h4>

                        <?php if($sub == "pos"):?>
                        <div class="table-responsive mb-0">
                            <div class="buttons___container"></div>
                            <table class="table data-table table-striped table-bordered dt-buttons">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <?php /*
                                    <th>Type</th>
                                    <th>Channel</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    */?>
                                    <th>RRN</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 0;
                                    foreach ($app->apiTransactions() as $transaction) {
                                        $count++;
                                        // $transaction = (object) $transaction;
                                        $transData = json_decode($transaction->raw);
                                        $transStatus = (!empty($transData->responseDescription)) ? $transData->responseDescription : null;
                                        $date = date('d-M-Y h:ia', strtotime($transData->transactionTime));
                                        // print_r($transData);
                                        ?>
                                        <tr>
                                            <td><?=$count?></td>
                                            <?php /*
                                            <td><?=$transaction->feature?></td>
                                            <td><?=$transaction->channel?></td>
                                            <td><?=$transaction->customer->email?></td>
                                            <td><?=$transaction->payment_data->amount?></td>
                                            <td><?=$transaction->status?></td>
                                            <td><?=$transaction->date_created?></td>
                                            */?>
                                            <td><?=$transaction->rrn?></td>
                                            <td><?=$transStatus?></td>
                                            <td><?=$coin.$app->format($transaction->amount)?></td>
                                            <td><?=$date?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <?php elseif(in_array($sub, array("data","airtime","transfer","deposit", "wallet_funding"))):?>
                            <div class="table-responsive mb-0">
                                <div class="buttons___container"></div>
                                <table class="table data-table table-striped table-bordered dt-buttons">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Trans. ID</th>
                                        <th>Amount</th>
                                        <th>Type</th>
                                        <th>Credit/Debit</th>
                                        <th>Date</th>
                                        <th class="no-export">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 0;
                                        if ($sub == "wallet_funding") {
                                            $sub == "deposit";
                                        }
                                        foreach ($app->transactions() as $transaction) {
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
                                                <td><?=(!empty($luser)) ? $luser->email : "NOT FOUND" ?></td>
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
                        <?php endif?>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
        <?php endif?>

    </div>
    <!-- container-fluid -->
</div>