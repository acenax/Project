<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <!-- App favicon -->
    <link rel="icon" type="image/x-icon" href="./images/responsive.png">
    <!-- App title -->
    <title>ระบบหลังบ้านของ OHOcom | </title>

    <!-- Summernote css -->
    <link href="Assets/plugins/summernote/0.8.18/summernote.css" rel="stylesheet" />

    <!-- Select2 -->
    <link href="Assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <!-- Jquery filer css -->
    <link href="Assets/plugins/jquery.filer/1.3.0/css/jquery.filer.css" rel="stylesheet" />
    <link href="Assets/plugins/jquery.filer/1.3.0/css/themes/jquery.filer-dragdropbox-theme.css" rel="stylesheet" />

    <!-- App css -->
    <link href="Assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="Assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="Assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="Assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="Assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="Assets/css/menu.css" rel="stylesheet" type="text/css" />
    <link href="Assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="Assets/plugins/switchery/switchery.min.css">
    <script src="https://code.jquery.com/jquery-3.6.1.js"
        integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="Assets/js/modernizr.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.15.3/css/pro.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Mitr&display=swap" rel="stylesheet">
    <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-default/default.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>


</head>


<body class="fixed-left">
    <style>
        * {
            font-family: 'Mitr', sans-serif;
        }

        .dataTables_filter {
            text-align: right;
        }

        .dataTables_filter input {
            display: unset !important;
            width: 200px !important;
            margin-left: 5px;
        }

        .dataTables_paginate {
            margin-bottom: 10px;
            display: flex;
            align-items: flex-end;
            justify-content: end;
        }

        .dataTables_info {
            margin-top: 10px;
        }

        .dataTables_info {
            font-family: 'Mitr', sans-serif;
        }

        .dataTables_length select {
            border: 1px solid #ddd;
            border-radius: 5px;
            display: unset !important;
            width: 75px !important;
        }

        .page-title {
            font-family: 'Mitr', sans-serif;
        }

        .sorting {
            font-family: 'Mitr', sans-serif;
        }

        .sorting_desc {
            font-family: 'Mitr', sans-serif;
        }

        .odd {
            font-family: 'Mitr', sans-serif;
        }

        .dataTables_empty {
            text-align: center;
        }

        .swal2-popup {
            font-size: 1.5rem !important;
            width: 35em !important;
        }

        .required::after {
            content: '*';
            color: red;
        }
    </style>
    <div id="wrapper">
        <?php include('View/Admin_page/topheader.php'); ?>
        <?php include('View/Admin_page/leftsidebar.php'); ?>