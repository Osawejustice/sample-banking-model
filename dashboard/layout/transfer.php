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
            <div class="col-lg-5 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?=$page?></h4>

                        <form class="ajax-form">
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="number" placeholder="Amount" class="form-control" name="amount" required="">
                            </div>
                            <div class="form-group">
                                <label>Beneficiary Account Number</label>
                                <input type="number" placeholder="Beneficiary Account Number" class="form-control" name="account_number" required="">
                            </div>
                            <div class="form-group">
                                <label>Transfer Type</label>
                                <input type="text" class="form-control" value="<?=strtoupper($sub)?>" required="" disabled="">
                            </div>
                            <div class="form-group">
                                <label>Naration / Purpose</label>
                                <textarea name="naration" class="form-control" required="" placeholder="Funds Description"></textarea>
                                <!-- /#.form-control -->
                            </div>

                            <p class="alert alert-danger font-weight-bold">Your balance : <?=$naira.$app->format($user->balance)?></p>

                            <button class="btn btn-dark btn-block" type="submit">Continue</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $("form.ajax-form").ajaxSubmit({
                    url : "./backend/transfer",
                    append : {
                        type : "<?=$sub?>"
                    },
                    callback_function : function(data) {
                        redirect('./transfer_history', true);
                    }
                });
            });
        </script>
    </div>
    <!-- container-fluid -->
</div>