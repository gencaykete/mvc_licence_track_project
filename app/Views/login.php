<!DOCTYPE html>
<html lang="<?php echo config("App")->defaultLocale; ?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo lang("Auth.login")." - ".lang("General.app_title"); ?></title>
    <link href="<?php echo base_url("assets/fontawesome/css/all.min.css"); ?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="<?php echo base_url("assets/css/sb-admin-2.min.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/css/auth-style.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/css/sweetalert2.min.css"); ?>" rel="stylesheet">

</head>

<body class="bg-gradient-primary d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4><i class="text-primary fas fa-user-lock fa-2x mb-4"></i></h4>
                                        <h1 class="h4 text-gray-900">
                                            <?php echo lang("General.app_title").": ".lang("Auth.login"); ?></h1>
                                        <p class="my-4"><?php echo lang("Auth.login_text"); ?></p>
                                    </div>
                                    <form class="user ajaxForm" method="post"
                                        action="<?php echo base_url("ajax/login"); ?>"
                                        data-redirect="<?php echo base_url(); ?>">
                                        <div class="form-group">
                                            <input name="email" required="required" type="email"
                                                class="form-control form-control-user"
                                                placeholder="<?php echo lang("Auth.enter_email"); ?>">
                                        </div>
                                        <div class="form-group">
                                            <input name="password" required="required" type="password"
                                                class="form-control form-control-user"
                                                placeholder="<?php echo lang("Auth.enter_password"); ?>">
                                        </div>
                                        <button type="submit"
                                            class="btn btn-primary btn-user btn-block"><?php echo lang("Auth.login"); ?></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <script src="<?php echo base_url("assets/js/jquery-3.4.1.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/bootstrap.bundle.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/sb-admin-2.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/sweetalert2.all.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/ajaxForm.js"); ?>"></script>
</body>

</html>