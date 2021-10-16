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
                <div class="alert alert-danger font-weight-bold">
                    <b>Viewing Staff - <?=$luser->name?></b>
                </div>
                <!-- /.alert alert-danger -->
            </div>
            <!-- /.col-12 -->
        </div>

        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Profile Details</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="<?=$luser->profilepic?>" alt="<?=$luser->name?> passport" class="img-fluid rounded-circle mb-2" width="128" height="128" />
                        <h5 class="card-title mb-0"><?=$luser->name?></h5>
                        <div class="text-muted mb-2"><?=ucfirst($luser->user_type)?></div>

                        <div>
                            <!-- <a class="btn btn-dark btn-sm" href="javascript:" id="changeDp"><i class="ri ri-upload-line"></i> Change Picture</a> -->
                            <?php if ($user->permissions->fund_wallet):?>
                            <a class="btn btn-primary btn-sm" href="./<?=$luser->user_type?>s/<?=$luser->uid?>?edit=true" disabled>Edit Staff</a>
                            <?php endif?>
                        </div>
                    </div>
                    <?php if(empty($_GET['verify'])):?>
                    <hr class="my-0" />
                    <div class="card-body">
                        <h5 class="h6 card-title">About</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-1">
                                <span>Balance : </span>
                                <span><b><?=$coin.number_format($luser->balance)?></b></span>
                            </li>
                            <li class="mb-1">
                                <span>Email : </span>
                                <span><?=$luser->email?></span>
                            </li>
                            <li class="mb-1">
                                <span>Phone : </span>
                                <span><?=$luser->phone?></span>
                            </li>
                            <li class="mb-1">
                                <span>Status : </span>
                                <span>
                                    <?php if($luser->identityVerified == 1):?>
                                        <span class="badge badge-success">Verified</span>
                                    <?php elseif($luser->identityVerified == 2):?>
                                        <span class="badge badge-warning">Pending</span>
                                    <?php else:?>
                                        <span class="badge badge-danger">Un-Verified</span>
                                    <?php endif?>
                                </span>
                            </li>
                            
                        </ul>
                    </div>
                    <?php endif?>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-8">

                <?php if(!$luser->identityVerified && !empty($_GET['verify'])):?>
                <div class="card">
                    <div class="card-header">
                        <div class="float-right">
                            <!-- <button id="reloadVerification" class="btn btn-sm btn-dark" title="Re-run verification request">Reload Verification</button> -->
                            <!-- /#reloadVerification -->
                        </div>
                        <!-- /.float-right -->
                        <h5 class="card-title mb-0">Verify Staff</h5>
                    </div>
                    <div class="card-body">
                        <form id="verifyID" class="mb-3">
                            <div class="form-group">
                                <label>Verification Method</label>
                                <select name="identity_document" id="vType" class="form-control">
                                    <option value="">Select Verification Method</option>
                                    <option value="national_id">National ID (NIN)</option>
                                    <option value="drivers_license">Dirvers License</option>
                                    <option value="voters_card">Voters Card</option>
                                </select>
                                <!-- /#.form-control -->
                            </div>
                            <div class="d-none doc-div national_id_div">
                                <div class="form-group">
                                    <label class="form-label">NIN Number</label>
                                    <input type="text" maxlength="11" minlength="11" name="ninNumber" class="form-control" placeholder="11 digits NIN number">
                                </div>
                            </div>
                            <div class="d-none doc-div national_id_div">
                                <div class="form-group">
                                    <label class="form-label">NIN Card (Front)</label>
                                    <div class="custom-file">
                                        <input type="file" name="ninFile" class="custom-file-input" accept=".png,.jpg,.jpeg,.pdf,.doc" id="ninFile">
                                        <label class="custom-file-label" for="ninFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-none doc-div drivers_license_div">
                                <div class="form-group basic">
                                    <label class="form-label">Drivers License Number</label>
                                    <input type="text" minlength="11" name="driversLicenseNumber" class="form-control">
                                </div>
                            </div>
                            <div class="d-none doc-div drivers_license_div">
                                <div class="form-group">
                                    <label class="form-label">Drivers License (Front)</label>
                                    <div class="custom-file">
                                        <input type="file" name="drivers_license_front" class="custom-file-input" accept=".png,.jpg,.jpeg,.pdf,.doc" id="drivers_license_front">
                                        <label class="custom-file-label" for="drivers_license_front">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-none doc-div drivers_license_div">
                                <div class="form-group">
                                    <label class="form-label">Drivers License (Back)</label>
                                    <div class="custom-file">
                                        <input type="file" name="drivers_license_back" class="custom-file-input" accept=".png,.jpg,.jpeg,.pdf,.doc" id="drivers_license_back">
                                        <label class="custom-file-label" for="drivers_license_back">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-none doc-div voters_card_div">
                                <div class="form-group basic">
                                    <label class="form-label">Voters Card Number</label>
                                    <input type="text" name="votersCardNumber" class="form-control">
                                </div>
                            </div>
                            <div class="d-none doc-div voters_card_div">
                                <div class="form-group">
                                    <label class="form-label">Voters Card (Front)</label>
                                    <div class="custom-file">
                                        <input type="file" name="voters_card_front" class="custom-file-input" accept=".png,.jpg,.jpeg,.pdf,.doc" id="voters_card_front">
                                        <label class="custom-file-label" for="voters_card_front">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-none doc-div voters_card_div">
                                <div class="form-group">
                                    <label class="form-label">Voters Card (Back)</label>
                                    <div class="custom-file">
                                        <input type="file" name="voters_card_back" class="custom-file-input" accept=".png,.jpg,.jpeg,.pdf,.doc" id="voters_card_back">
                                        <label class="custom-file-label" for="voters_card_back">Choose file</label>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-primary" type="submit">Verify Identity</button>
                        </form>
                    </div>  
                </div>
                <script type="text/javascript">
                    $("#vType").on('change', function() {
                        var choice = $(this).val();
                        if(choice == ""){
                            alert("Select a document type");
                            return false;
                        }
                        $(".doc-div").addClass('d-none');
                        $(".doc-div input[type=file]").attr('disabled', true);

                        if(choice == "national_id") {
                            $(".national_id_div").removeClass('d-none');
                            $(".national_id_div input[type=file]").removeAttr('disabled');
                        }
                        else if(choice == "drivers_license"){
                            $(".drivers_license_div").removeClass('d-none');
                            $(".drivers_license_div input[type=file]").removeAttr('disabled');
                        }
                        else if(choice == "voters_card") {
                            $(".voters_card_div").removeClass('d-none');
                            $(".voters_card_div input[type=file]").removeAttr('disabled');
                        }
                    });
                    $("form#verifyID").ajaxSubmit({
                        url : "./backend/verifyID?thirdparty=true",
                        append : {
                            luser_id : "<?=$luser->id?>"
                        },
                        callback_function : function(data) {
                            reload();
                        }
                    });
                </script>
                <?php endif?>

                <?php if($luser->identityVerified):?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Verification Details</h5>
                    </div>
                    <div class="card-body">
                        <dt>Verification Method</dt>
                        <dd><?=strtoupper($luser->data->verificationMethod)?></dd>
                        <dt>Verification Number</dt>
                        <dd><?=$luser->data->verificationNumber?></dd>
                        <dt>Verification Document</dt>
                        <dd>
                        <?php if(!empty($luser->data->verificationFileFront)):?>
                            <a href="<?=$siteurl?>/<?=$luser->data->verificationFileFront?>" target="_blank">Front</a>
                        <?php endif?>
                        <?php if(!empty($luser->data->verificationFileBack)):?>
                            | <a href="<?=$siteurl?>/<?=$luser->data->verificationFileBack?>" target="_blank">Back</a>
                        <?php endif?>
                        </dd>
                    </div>  
                </div>
                <?php endif?>
            </div>
        </div>

    </div>
    <!-- container-fluid -->
</div>