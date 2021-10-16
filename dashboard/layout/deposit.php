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
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?=$page?></h4>

                        <form class="ajax-form">
                            <div class="form-group">
                                <label for="youSend">Amount</label>
                                <input type="number" class="form-control" name="amount" placeholder="Amount"/>
                            </div>
                            <div class="form-group">
                                <label for="paymentMethod">Payment Method</label>
                                <select id="paymentMethod" class="custom-select" required="" name="method">
                                    <option value="">Select Payment Method</option>
                                    <option value="online">Online</option>
                                    <option value="online">Crypto</option>
                                </select>
                            </div>

                            <div class="form-group" id="card-payment" style="display: none;">
                                <label for="paymentgate">Payment Gateway</label>
                                <select id="paymentgate" class="custom-select" required="" name="gateway">
                                    <option value="">Select</option>
                                    <option value="paystack">Paystack</option>
                                    <option value="flutterwave">Flutterwave</option>
                                </select>
                            </div>

                            <div id="bank-payment">
                            </div>
                            <!-- /#bank-payment -->

                            <button class="btn btn-dark btn-block" type="submit">Continue</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Deposit History</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 0;
                                foreach ($app->userTransactions($user->id) as $transaction) {
                                    if ($transaction->type !== "deposit") continue;
                                    $count++;
                                    ?>
                                <tr>
                                    <th><?=$count?></th>
                                    <td><?=$coin.number_format($transaction->amount)?></td>
                                    <td><?=date("d M Y h:ia", $transaction->date)?></td>
                                    <td><span class="badge badge-success">Success</span></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $("#paymentMethod").change(function(event) {
                    if ($(this).val() == "online") {
                        $("#card-payment").show();
                        $("#bank-payment").hide();
                    } else {
                        $("#card-payment").hide();
                        $("#bank-payment").show();
                    }
                });
                $("form.ajax-form").ajaxSubmit({
                    url : "./backend/deposit",
                    callback_function : function(data) {
                        redirect(data.url);
                    }
                });
            });
        </script>
    </div>
    <!-- container-fluid -->
</div>