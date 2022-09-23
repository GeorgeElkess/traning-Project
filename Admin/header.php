<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>cla</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="/GitHub/traning-Project/css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="/GitHub/traning-Project/css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="/GitHub/traning-Project/css/responsive.css">
    <!-- fevicon -->
    <link rel="icon" href="/GitHub/traning-Project/images/fevicon.png" type="image/gif" />
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="/GitHub/traning-Project/css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    <style>
        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidenav a:hover {
            color: #f1f1f1;
        }

        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        #Body {
            transition: margin-left .5s;
        }

        @media screen and (max-height: 450px) {
            .sidenav {
                padding-top: 15px;
            }

            .sidenav a {
                font-size: 18px;
            }
        }
    </style>
</head>
<!-- body -->

<body class="main-layout inner_posituong">
    <!-- loader  -->
    <div class="loader_bg">
        <div class="loader"><img src="/GitHub/traning-Project/images/loading.gif" alt="#" /></div>
    </div>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="/GitHub/traning-Project/Admin/user">Users</a>
        <a href="/GitHub/traning-Project/Admin/productcategory">Products Categories</a>
        <a href="/GitHub/traning-Project/Admin/product">Products</a>
        <a href="/GitHub/traning-Project/Admin/productcategoryoptions">Category Extra values</a>
        <a href="/GitHub/traning-Project/Admin/options">Extra Values</a>
        <a href="/GitHub/traning-Project/Admin/optionvalues">Products Extra Values</a>
        <a href="/GitHub/traning-Project/Admin/orders">Orders</a>
        <a href="/GitHub/traning-Project/Admin/orderdetails">Order Details</a>
    </div>
    <!-- end loader -->
    <div id="Body">
        <!-- header -->
        <header>
            <!-- header inner -->
            <div class="header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                            <div class="full">
                                <div class="center-desk">
                                    <div class="logo">
                                        <span style="font-size:30px;cursor:pointer" onclick="openNav()">
                                            <img src="/GitHub/traning-Project/images/logo.png" alt="#" />
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                            <nav class="navigation navbar navbar-expand-md navbar-dark ">
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarsExample04">
                                    <ul class="navbar-nav mr-auto">
                                        <li class="nav-item d_none">
                                            <?php
                                            if (session_id() == '') {
                                                session_start();
                                            }
                                            if (isset($_SESSION["UserId"])) { ?>
                                                <a class="nav-link" href="/GitHub/traning-Project/Login/Logout.php">Logout</a>
                                            <?php } else { ?>
                                                <a class="nav-link" href="/GitHub/traning-Project/Login/SignUp.php">SignUp</a>
                                            <?php } ?>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- end header inner -->
        <!-- end header -->