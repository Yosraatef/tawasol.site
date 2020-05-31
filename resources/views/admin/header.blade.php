<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Adminto - Responsive Admin Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="icon" type="image/x-icon"  href="{{asset('public/admin/images/favicon.ico')}}">

    <!--Morris Chart-->
    <link rel="stylesheet"  href="{{asset('public/admin/libs/morris-js/morris.css')}}" />



    <!-- App css -->
    <link   href="{{asset('public/admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />


    <link  href="{{asset('public/admin/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link  href="{{asset('public/admin/css/app-rtl.min.css')}}" rel="stylesheet" type="text/css" />


    @yield('styles')



    <style>

        @media print{
            table, th, td
            {
                border-collapse:collapse;
                border: 1px solid black;
                width:100%;
                text-align:right !important;
            }
            body{
                float: right;
                text-align: right;
            }
            th{
                float: right;
            }
            tr{
                float: right;
            }
            td{
                float: right;
                text-align: right;
            }
            table{
                float: right;
                text-align: right;
            }
        }

    </style>
</head>