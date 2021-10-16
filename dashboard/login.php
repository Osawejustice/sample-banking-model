<?php require dirname(__FILE__,2)."/core/functions.php";?>
<!doctype html>
<html lang="en">
    <head>   
        <meta charset="utf-8" />
        <title>Login - Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="assets/libs/notyf/notyf.min.css">
        <style type="text/css">
            .auth-body-bg {
                background-color: #f1f5f7;
            }
        </style>
    </head>

    <body class="auth-body-bg">
        <div class="container-fluid p-0">
            <div class="col-lg-4 col-sm-12" style="margin: 0 auto;">
                <div class="authentication-page-content p-4 d-flex align-items-center min-vh-100">
                    <div class="w-100" style="background-color : #fff">
                        <div class="row justify-content-center">
                            <div class="col-lg-9">
                                <div>
                                    <div class="text-center">
                                        <div>
                                            <a href="<?=$siteurl?>" class="logo"><img src="assets/images/logo-dark.png" height="20" alt="logo"></a>
                                        </div>

                                        <h4 class="font-size-18 mt-4">Welcome Back</h4>
                                    </div>

                                    <div class="p-2 mt-4">
                                        <form class="form-horizontal" id="login-form">
            
                                            <div class="form-group auth-form-group-custom mb-4">
                                                <i class="ri-user-2-line auti-custom-input-icon"></i>
                                                <label for="username">Account Number</label>
                                                <input type="text" class="form-control" name="account_number" placeholder="Enter Account number">
                                            </div>
                    
                                            <div class="form-group auth-form-group-custom mb-4">
                                                <i class="ri-lock-2-line auti-custom-input-icon"></i>
                                                <label for="userpassword">Password</label>
                                                <input type="password" class="form-control" id="userpassword" placeholder="Enter password" name="password" required="">
                                            </div>
                                            <div class="mt-1 text-center">
                                                <a href="./forgot-password" class="text-muted"><i class="mdi mdi-lock mr-1"></i> Forgot your password?</a>
                                            </div>

                                            <div class="mt-4 text-center">
                                                <button class="btn btn-primary w-md waves-effect waves-light btn-block" type="submit">Login</button>
                                            </div>

                                        </form>
                                    </div>

                                    <div class="mt-2 text-center">
                                        <p>© <?=date("Y")?> <?=$sitename?>.</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>
        <script src="assets/js/app.js"></script>
        <!-- BEGIN Required Files -->
        <script src="assets/libs/pjax/pjax.js"></script>
        <script src="assets/libs/notyf/notyf.min.js"></script>
        <!-- Logad App Javascript (do not remove!) -->
        <script src="assets/libs/logadApp/js/logad.js"></script>
        <script src="assets/libs/logadApp/js/custom.js?time=<?=time()?>"></script>
        <!-- END Required files -->

        <script type="text/javascript">
            const logad = new LogadApp("main");
            $("form#login-form").ajaxSubmit({
                url : "./backend/login",
                callback_function : function(data) {
                    redirect(data.url);
                }
            });
        </script>
    </body>
</html>
