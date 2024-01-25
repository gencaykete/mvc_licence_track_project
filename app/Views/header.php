<!DOCTYPE html>
<html lang="<?php echo config("App")->defaultLocale; ?>">


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $title; ?></title>
    <link rel="shortcut icon" href="<?php echo base_url("assets/img/icon.png"); ?>">
    <link href="<?php echo base_url("assets/fontawesome/css/all.min.css"); ?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="<?php echo base_url("assets/css/sb-admin-2.min.css"); ?>" rel="stylesheet">
    <script src="<?php echo base_url("assets/js/jquery-3.4.1.min.js"); ?>"></script>
</head>

<body id="page-top">

    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url(); ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-key"></i>
                </div>
                <div class="sidebar-brand-text mx-3"><?php echo lang("General.app_title"); ?></div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item <?php echo $page == "dashboard" ? "active" : ""; ?>">
                <a class="nav-link" href="<?php echo base_url(); ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span><?php echo lang("Menu.dashboard"); ?></span></a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                <?php echo lang("Menu.product_management"); ?>
            </div>
            <li class="nav-item <?php echo $page == "products" ? "active" : ""; ?>">
                <a class="nav-link" href="<?php echo base_url("products"); ?>">
                    <i class="fas fa-fw fa-archive"></i>
                    <span><?php echo lang("Menu.products"); ?></span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                <?php echo lang("Menu.license_management"); ?>
            </div>
            <li class="nav-item <?php echo $page == "licenses" ? "active" : ""; ?>">
                <a class="nav-link" href="<?php echo base_url("licenses"); ?>">
                    <i class="fas fa-fw fa-project-diagram"></i>
                    <span><?php echo lang("Menu.licenses"); ?></span>
                </a>
            </li>
            <li class="nav-item <?php echo $page == "license_checks" ? "active" : ""; ?>">
                <a class="nav-link" href="<?php echo base_url("checks"); ?>">
                    <i class="fas fa-crosshairs fa-fw"></i>
                    <span><?php echo lang("Menu.license_checks"); ?></span>
                </a>
            </li>
            <li class="nav-item <?php echo $page == "unauthorized_uses" ? "active" : ""; ?>">
                <a class="nav-link" href="<?php echo base_url("warnings"); ?>">
                    <i class="fas fa-exclamation-triangle fa-fw"></i>
                    <span><?php echo lang("Menu.unauthorized_uses"); ?></span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                <?php echo lang("Menu.settings"); ?>
            </div>
            <li class="nav-item <?php echo $page == "general_settings" ? "active" : ""; ?>">
                <a class="nav-link" href="<?php echo base_url("settings"); ?>">
                    <i class="fas fa-fw fa-cog"></i>
                    <span><?php echo lang("Menu.general_settings"); ?></span>
                </a>
            </li>
            <li class="nav-item <?php echo $page == "admins" ? "active" : ""; ?>">
                <a class="nav-link" href="<?php echo base_url("admins"); ?>">
                    <i class="fas fa-fw fa-users"></i>
                    <span><?php echo lang("Menu.admins"); ?></span>
                </a>
            </li>
            <li class="nav-item <?php echo $page == "integration" ? "active" : ""; ?>">
                <a class="nav-link" href="<?php echo base_url("integration"); ?>">
                    <i class="fas fa-fw fa-code"></i>
                    <span><?php echo lang("Menu.integration"); ?></span>
                </a>
            </li>
            <li class="nav-item <?php echo $page == "encoder" ? "active" : ""; ?>">
                <a class="nav-link" href="<?php echo base_url("encoder"); ?>">
                    <i class="fas fa-fw fa-file-code"></i>
                    <span><?php echo lang("Menu.php_encoder"); ?></span>
                </a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-header navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $user["name"]; ?></span>
                                <img class="img-profile rounded-circle"
                                    src="https://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($user["email"]))); ?>">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?php echo base_url("admins/edit")."/".$user["id"]; ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    <?php echo lang("Menu.my_profile"); ?>
                                </a>
                                <a class="dropdown-item" href="<?php echo base_url("logout"); ?>">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    <?php echo lang("Menu.logout"); ?>
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>