<?php
session_start();
// error_reporting(0);
// include "../config/cek.php";
date_default_timezone_set('Asia/Jakarta');
?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang=""> <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Halaman Admin Archie CarWash</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/lib/datatable/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="shortcut icon" type="image/x-icon" href="../images/2.png">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

    <style>
        /* Responsive Admin Tables & Modern Touch */
        .card-body table, .table-responsive table {
            width: 100% !important;
        }
        .dataTables_wrapper, .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .card {
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            margin-bottom: 25px;
        }
        .card-header {
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
        }
        @media (max-width: 768px) {
            .header .top-left {
                width: 100%;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .header .top-right {
                width: 100%;
            }
            .breadcrumbs .page-header {
                text-align: left !important;
            }
            .breadcrumbs .breadcrumb {
                float: none !important;
                text-align: left !important;
                padding-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Left Panel -->
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="./"><i class="menu-icon fa fa-dashboard"></i>Dashboard Admin </a>
                    </li>
                    <li>
                        <a href="../index.php" target="_blank"><i class="menu-icon fa fa-globe text-success"></i>Buka Website Utama </a>
                    </li>
                    <li>
                        <a href="index.php?p=pendaftaran"> <i class="menu-icon fa fa-clipboard"></i>Pendaftaran </a>
                    </li>
                    <li>
                        <a href="index.php?p=transaksi"> <i class="menu-icon fa fa-credit-card-alt"></i>Transaksi </a>
                    </li>
                    <li>
                        <a href="index.php?p=customer"> <i class="menu-icon fa fa-id-card"></i>Customer </a>
                    </li>
                    <li>
                        <a href="index.php?p=laporan"> <i class="menu-icon fa fa-file"></i>Laporan </a>
                    </li>
                    <li>
                        <a href="../display_antrian.php" target="_blank" style="color: #0284c7; font-weight: 600;"> <i class="menu-icon fa fa-desktop text-primary"></i>Display TV Antrian <span class="badge badge-primary ml-1">Live</span></a>
                    </li>

                    <li class="menu-title">Tambah Data</li><!-- /.menu-title -->
                    <li>
                        <a href="index.php?p=user"> <i class="menu-icon fa fa-user-plus"></i>User </a>
                    </li>

                    <li>
                        <a href="index.php?p=type_mobil"> <i class="menu-icon fa fa-car"></i>Tipe Mobil </a>
                    </li>

                    <li>
                        <a href="index.php?p=jenis_cucian"> <i class="menu-icon fa fa-shower"></i>Jenis Cucian </a>
                    </li>

                    <li>
                        <a href="index.php?p=saran"> <i class="menu-icon fa fa-envelope"></i>Kritik dan Saran </a>
                    </li>

                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">
            <div class="top-left">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./"><img src="../images/ARCHIE CARWASH.png" alt="Logo"></a>
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                </div>
            </div>
            <div class="top-right">
                <div class="header-menu">
                    <div class="header-left">


                        <div class="user-area dropdown float-right d-flex align-items-center">
                            <span class="mr-2 text-muted d-none d-md-inline" style="font-size: 13px;">Halo, <strong><?= isset($_SESSION['admin_name']) ? htmlspecialchars($_SESSION['admin_name']) : 'Admin'; ?></strong></span>
                            <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="user-avatar rounded-circle" src="images/setting.png" alt="User Avatar">
                            </a>

                            <div class="user-menu dropdown-menu">
                                <a class="nav-link" href="../config/logout.php"><i class="fa fa-power-off"></i>Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
        </header><!-- /header -->
        <!-- Header-->








        <!--
      ========================================================
                                  CONTENT
      ========================================================
      -->


        <?php
        $pages_dir = 'pages';
        if (!empty($_GET['p'])) {
            $pages = scandir($pages_dir, 0);
            unset($pages[0], $pages[1]);

            $p = $_GET['p'];
            if (in_array($p . '.php', $pages)) {
                include $pages_dir . '/' . $p . '.php';
            } else {
        ?>

                <script language="JavaScript">
                    document.location = 'index.php?p=error-404'
                </script>
        <?php
            }
        } else {
            include $pages_dir . '/home.php';
        }
        ?>



        <!--
      ========================================================
                                  FOOTER
      ========================================================
      -->






        <div class="clearfix"></div>

        <footer class="site-footer">
            <div class="footer-inner bg-white">
                <div class="row">
                    <div class="col-sm-12 text-center text-sm-left">
                        Copyright &copy; <?= date('Y'); ?> <strong>Archie CarWash</strong> by Archie Arya Manggala.
                    </div>
                </div>
            </div>
        </footer>

    </div><!-- /#right-panel -->

    <!-- Right Panel -->

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="assets/js/main.js"></script>


    <script src="assets/js/lib/data-table/datatables.min.js"></script>
    <script src="assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
    <script src="assets/js/lib/data-table/dataTables.buttons.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
    <script src="assets/js/lib/data-table/jszip.min.js"></script>
    <script src="assets/js/lib/data-table/vfs_fonts.js"></script>
    <script src="assets/js/lib/data-table/buttons.html5.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.print.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.colVis.min.js"></script>
    <script src="assets/js/init/datatables-init.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#bootstrap-data-table-export').DataTable();
        });
    </script>


</body>

</html>