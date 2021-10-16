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
            <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Profile Details</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="<?=$user->profilepic?>" alt="<?=$user->name?> passport" class="img-fluid rounded-circle mb-2" width="128" height="128" />
                        <h5 class="card-title mb-0"><?=$user->name?></h5>
                        <!-- <div class="text-muted mb-2"><?=$naira.$app->format($user->balance)?></div> -->

                        <div>
                            <a class="btn btn-dark btn-sm" href="javascript:" id="changeDp"><i class="ri ri-upload-line"></i> Change Picture</a>
                            <a class="btn btn-primary btn-sm" href="./deposit">Fund wallet</a>
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                        <h5 class="h6 card-title">About</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-1">
                                <span>Balance : </span>
                                <span><b><?=$naira.$app->format($user->balance)?></b></span>
                            </li>
                            <li class="mb-1">
                                <span>Email : </span>
                                <span><?=$user->email?></span>
                            </li>
                            <li class="mb-1">
                                <span>Phone : </span>
                                <span><?=$user->phone?></span>
                            </li>
                            
                        </ul>
                    </div>
                </div>

                
            </div>

            <div class="col-sm-12 col-md-6 col-lg-8">
                <?php if(empty($sub)):?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Edit Profile</h5>
                    </div>
                    <div class="card-body">
                        <form id="update-profile" class="ajax-form mb-3">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="fname" placeholder="First Name" value="<?=$user->fname?>">
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="lname" placeholder="Last Name" value="<?=$user->lname?>">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email" value="<?=$user->email?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="number" class="form-control" name="phone" placeholder="Phone" value="<?=$user->phone?>">
                            </div>
                            
                            <input type="hidden" name="save_type" value="update-profile">
                            <button class="btn btn-primary" type="submit">Update Profile</button>
                        </form>

                        <hr>
                        <form id="update-password" class="ajax-form">
                            <h5 class="card-title">Update Password</h5>
                            <div class="form-group">
                                <label>Old Password</label>
                                <input type="password" class="form-control" name="old_password" placeholder="Old password" required="" />
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" class="form-control" name="new_password" placeholder="New password" required="" />
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" name="con_new_password" placeholder="Confirm password" required="" />
                            </div>
                            <input type="hidden" name="save_type" value="update-password">
                            <button class="btn btn-dark" type="submit">Update Password</button>
                        </form>
                    </div>  
                </div>

                <?php elseif($sub == "verify"):?>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Verify Identity</h5>
                    </div>
                    <div class="card-body">
                        <?php if($user->identityVerified != 0):?>
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
                        <?php else:?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="mdi mdi-check-all mr-2"></i>
                                Identity Verified successfully
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!-- /.alert alert-success -->
                            <ul>
                                <li>Verification Method : <?=ucfirst($user->data->verificationMethod)?></li>
                                <li>Verification Number : <?=$user->data->verificationNumber?></li>
                            </ul>
                        <?php endif?>
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
                        else if(choice == "voters_card"){
                            $(".voters_card_div").removeClass('d-none');
                            $(".voters_card_div input[type=file]").removeAttr('disabled');
                        }
                    });
                    $("form#verifyID").ajaxSubmit({
                        url : "./backend/verifyID",
                        callback_function : function(data) {
                            reload();
                        }
                    });
                </script>
                <?php endif?>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $("#changeDp").click(function(event) {
                    event.preventDefault();
                    $("#file_picker").click();
                });
                $("#file_picker").change(function(event) {
                    $("form#update-dp").submit();
                });
                $("form.ajax-form").ajaxSubmit({
                    url : "./backend/update-profile",
                    callback_function:function(){
                    }
                })
            });
        </script>
    </div>
    <!-- container-fluid -->
</div>