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
            <?php if ($sub == "general"):?>
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Site Settings</h5>
                        <form class="ajax-form">
                            <div class="form-group">
                                <label class="form-label">Site Name</label>
                                <input type="text" class="form-control" placeholder="Sitename" name="site_name" value="<?=$sitename?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Site Email</label>
                                <input type="email" class="form-control" placeholder="Site email" value="<?=$site->site_email?>" name="site_email">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Site Phone</label>
                                <input type="text" class="form-control" placeholder="+234------" value="<?=$site->site_phone?>" name="site_phone">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Logo (Recommended Width - 1980px: Height - 500px)</label>
                                <input type="file" class="form-control" name="site_logo">
                                <?php
                                if (!empty($site->site_logo)) {
                                    ?>
                                    <a href="<?=$site->site_logo?>" target="_blank">View</a>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Site Icon</label>
                                <input type="file" class="form-control" name="site_icon">
                                <?php
                                if (!empty($site->site_icon)) {
                                    ?>
                                    <a href="<?=$site->site_icon?>" target="_blank">View</a>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" placeholder="Site address" value="<?=$site->site_address?>" name="site_address">
                            </div>
                            <div class="form-group">
                                <label class="form-label">SEO Decription</label>
                                <textarea class="form-control" placeholder="Site description" rows="3" name="seo_description"><?=$site->seo_description?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">SEO Keywords</label>
                                <input type="text" class="form-control" placeholder="SEO Keywords" name="seo_keywords" value="<?=$site->seo_keywords?>">
                            </div>

                            <input type="hidden" name="save_type" value="site-settings">
                            <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Social Settings</h5>
                        <form class="ajax-form">
                            <div class="form-group">
                                <label class="form-label">Facebook Link</label>
                                <input type="text" class="form-control" placeholder="Facebook Link" name="facebook_link" value="<?=$site->facebook_link?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Instagram Link</label>
                                <input type="text" class="form-control" placeholder="Instagram Link" name="instagram_link" value="<?=$site->instagram_link?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Twitter Link</label>
                                <input type="text" class="form-control" placeholder="Twitter Link" name="twitter_link" value="<?=$site->twitter_link?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">LinkedIn Link</label>
                                <input type="text" class="form-control" placeholder="LinkedIn Link" name="linkedin_link" value="<?=$site->linkedin_link?>">
                            </div>
                            <input type="hidden" name="save_type" value="social">
                            <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif?>

            <?php if ($sub == "fees"): ?>
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Fees & Commissions</h5>
                    </div>
                    <div class="card-body">
                        <form class="ajax-form">
                            <div class="form-group">
                                <label class="form-label">Unverified Account limit (<?=$coin?>)</label>
                                <input type="text" class="form-control" placeholder="Unverified account limit" name="unverified_limit" value="<?=$site->unverified_limit?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Aggregator Bank Transfer Commission (%)</label>
                                <input type="text" class="form-control" placeholder="Aggregator Bank Transfer Commission" name="aggregator_bank_commission" value="<?=$site->aggregator_bank_commission?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Aggregator POS withdrawal Commission (%)</label>
                                <input type="text" class="form-control" placeholder="Aggregator POS withdrawal Commission" name="aggregator_pos_commission" value="<?=$site->aggregator_pos_commission?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Referral Commission</label>
                                <input type="text" class="form-control" placeholder="Referral Commission" name="ref_commission" value="<?=$site->ref_commission?>">
                            </div>
                            <p>Fees</p>
                            <div class="form-group">
                                <label class="form-label">Bank Transfer Fee</label>
                                <input type="text" class="form-control" placeholder="ank Transfer Fee" name="bank_transfer_fee" value="<?=$site->bank_transfer_fee?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Minimum POS withdrawal Fee (%)</label>
                                <input type="text" class="form-control" placeholder="Minimum POS withdrawal Fee" name="min_pos_withdrawal_fee" value="<?=$site->pos_withdrawal_fee?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Maximum POS withdrawal Fee (<?=$coin?>)</label>
                                <input type="text" class="form-control" placeholder="Maximum POS withdrawal Fee" name="max_pos_withdrawal_fee" value="<?=$site->pos_withdrawal_fee?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Savings Interest</label>
                                <input type="text" class="form-control" placeholder="Savings Interest" name="savings_interest" value="<?=$site->savings_interest?>">
                            </div>
                            <input type="hidden" name="save_type" value="payment">
                            <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif?>
            
            <?php if ($sub == "email_sms"): ?>
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">SMS / Mail Settings</h5>
                    </div>
                    <div class="card-body">
                        <form class="ajax-form">
                            <div class="form-group">
                                <label class="form-label">SMS API Key (Message Bird)</label>
                                <input type="text" class="form-control" placeholder="SMS API" name="sms_token" value="<?=$site->sms_token?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Mail Method</label>
                                <select name="mail_method" class="form-control">
                                    <option value="mail">Mail Server</option>
                                    <option value="smtp" <?=($site->mail_method == "smtp") ? "selected" : null;?> >SMTP</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">SMTP Host</label>
                                <input type="text" class="form-control" placeholder="SMTP Host" name="smtp_host" value="<?=$site->smtp_host?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">SMTP Username</label>
                                <input type="text" class="form-control" placeholder="SMTP Username" name="smtp_username" value="<?=$site->smtp_username?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">SMTP Password</label>
                                <input type="text" class="form-control" placeholder="SMTP Password" name="smtp_password" value="<?=$site->smtp_password?>">
                            </div>

                            <input type="hidden" name="save_type" value="mail">
                            <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif?>

            <?php if ($sub == "api"):?>
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">API Settings</h5>
                        <form class="ajax-form">
                            <div class="form-group">
                                <label class="form-label">Paystack Secret Key</label>
                                <input type="text" class="form-control" placeholder="Paystack secret key" name="paystack_secret_key" value="<?=$site->paystack_secret_key?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Flutterwave API</label>
                                <input type="text" class="form-control" placeholder="Flutterwave api key" name="flutterwave_secret_key" value="<?=$site->flutterwave_secret_key?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">POS API</label>
                                <select name="pos_api" class="form-control">
                                    <option value="">Choose</option>
                                    <option value="watu" <?=($site->pos_api == "watu") ? 'selected' : null?>>WATU</option>
                                    <option value="itex" <?=($site->pos_api == "itex") ? 'selected' : null?>>ITEX</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">WATU Secret Key</label>
                                <input type="text" class="form-control" placeholder="WATU secret key" name="watu_secret_key" value="<?=$site->watu_secret_key?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">VerifyMe API Key</label>
                                <input type="text" class="form-control" placeholder="Verifyme secret key" name="verifyme_key" value="<?=$site->verifyme_key?>">
                            </div>
                            <input type="hidden" name="save_type" value="payment">
                            <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif?>

            <?php if ($sub == "features"):?>
            <div class="col-lg-6 col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Site Features</h5>
                        <h6 class="card-subtitle text-muted">Enable and Disable site features</h6>
                    </div>
                    <style type="text/css">
                        .form-switch {
                            margin-bottom: 1rem;
                        }
                    </style>
                    <div class="card-body">
                        <form class="ajax-form">
                            <?php
                            // Group data by the "group" key 
                            $byGroup = $app->group_by_key("group", $app->site_features(true));
                            ksort($byGroup);
                            ?>
                            <div id="accordion2" class="custom-accordion">
                            <?php foreach ($byGroup as $groupKey => $subfeatures) :?>
                                <div class="card mb-1 shadow-none">
                                    <a href="#collapse_<?=$groupKey?>" class="text-dark collapsed" data-toggle="collapse" aria-expanded="false" aria-controls="collapseOne">
                                        <div class="card-header" id="headingOne">
                                            <h6 class="m-0">
                                                <?=ucfirst($groupKey)?>
                                                <i class="mdi mdi-minus float-right accor-plus-icon"></i>
                                            </h6>
                                        </div>
                                    </a>

                                    <div id="collapse_<?=$groupKey?>" class="collapse"
                                            aria-labelledby="headingOne" data-parent="#accordion2">
                                        <div class="card-body">
                                            <?php
                                            foreach($subfeatures as $feat) {
                                                $featName = ucfirst(str_replace("_", " ", $feat->name));
                                                ?>
                                                <div class="form-group">
                                                    <div class="form-label">
                                                        <?=$featName?>
                                                    </div>
                                                    <div class="custom-control custom-switch mb-2" dir="ltr">
                                                        <input type="hidden" name="features[<?=$feat->name?>]" value="0">
                                                        <input type="checkbox" class="custom-control-input" name="features[<?=$feat->name?>]" id="customSwitch1" value="1" <?=($feat->value == 1) ? "checked" : null;?>>
                                                        <label class="custom-control-label" for="customSwitch1">Enable</label>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach?>
                            </div>
                            <input type="hidden" name="save_type" value="features">
                            <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.col-lg-6 col-sm-12 col-md-6 -->
            <?php endif?>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $("form.ajax-form").ajaxSubmit({
                    url : "./backend/save-settings",
                    callback_function : function(data) {
                    }
                });
            });
        </script>
    </div>
    <!-- container-fluid -->
</div>