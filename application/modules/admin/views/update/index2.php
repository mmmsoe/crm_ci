<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="admin-themes-lab">
        <meta name="author" content="themes-lab">
        <link rel="shortcut icon" href="<?php echo base_url(); ?>public/assets/global/images/favicon.jpg" type="image/png">
        <title><?php echo config('site_name'); ?></title>

        <link href="<?php echo base_url(); ?>public/assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet">

        <link href="<?php echo base_url(); ?>public/assets/global/css/style.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>public/assets/global/css/theme.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>public/assets/global/css/ui.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>public/assets/admin/layout1/css/layout.css" rel="stylesheet">
        <!-- BEGIN PAGE STYLE -->
        <link href="<?php echo base_url(); ?>public/assets/global/plugins/metrojs/metrojs.min.css" rel="stylesheet">

        <!-- END PAGE STYLE -->

        <!-- BEGIN PAGE STYLE -->
        <link href="<?php echo base_url(); ?>public/assets/global/plugins/datatables/dataTables.min.css" rel="stylesheet">
        <!-- END PAGE STYLE -->

        <script src="<?php echo base_url(); ?>public/assets/global/plugins/modernizr/modernizr-2.6.2-respond-1.1.0.min.js"></script>

        <script src="<?php echo base_url(); ?>public/assets/global/plugins/jquery/jquery-1.11.1.min.js"></script>

        <!-- CUSTOM ADDON -- [EGA] -->
        <link href="<?php echo base_url(); ?>public/assets/global/css/custom01.css" rel="stylesheet">
        <!-- PLUGIN -->
        <link href="<?php echo base_url(); ?>public/assets/global/plugins/chartphp/js/chartphp.css" rel="stylesheet">
        <!-- END CUSTOM ADDON -- [EGA] -->

    </head>
    <!-- LAYOUT: Apply "submenu-hover" class to body element to have sidebar submenu show on mouse hover -->
    <!-- LAYOUT: Apply "sidebar-collapsed" class to body element to have collapsed sidebar -->
    <!-- LAYOUT: Apply "sidebar-top" class to body element to have sidebar on top of the page -->
    <!-- LAYOUT: Apply "sidebar-hover" class to body element to show sidebar only when your mouse is on left / right corner -->
    <!-- LAYOUT: Apply "submenu-hover" class to body element to show sidebar submenu on mouse hover -->
    <!-- LAYOUT: Apply "fixed-sidebar" class to body to have fixed sidebar -->
    <!-- LAYOUT: Apply "fixed-topbar" class to body to have fixed topbar -->
    <!-- LAYOUT: Apply "rtl" class to body to put the sidebar on the right side -->
    <!-- LAYOUT: Apply "boxed" class to body to have your page with 1200px max width -->

    <!-- THEME STYLE: Apply "theme-sdtl" for Sidebar Dark / Topbar Light -->
    <!-- THEME STYLE: Apply  "theme sdtd" for Sidebar Dark / Topbar Dark -->
    <!-- THEME STYLE: Apply "theme sltd" for Sidebar Light / Topbar Dark -->
    <!-- THEME STYLE: Apply "theme sltl" for Sidebar Light / Topbar Light -->

    <!-- THEME COLOR: Apply "color-default" for dark color: #2B2E33 -->
    <!-- THEME COLOR: Apply "color-primary" for primary color: #319DB5 -->
    <!-- THEME COLOR: Apply "color-red" for red color: #C9625F -->
    <!-- THEME COLOR: Apply "color-green" for green color: #18A689 -->
    <!-- THEME COLOR: Apply "color-orange" for orange color: #B66D39 -->
    <!-- THEME COLOR: Apply "color-purple" for purple color: #6E62B5 -->
    <!-- THEME COLOR: Apply "color-blue" for blue color: #4A89DC -->
    <!-- BEGIN BODY -->
    <body class="fixed-topbar color-default sidebar-light theme-sltd sidebar-collapsed">
        <section>
            <!-- BEGIN SIDEBAR -->
            <style>
                .sidebar .sidebar-inner .nav-sidebar .children > li > a {
                    height: 45px;
                }

                .sidebar-light:not(.sidebar-collapsed) .sidebar .sidebar-inner .nav-sidebar > li > a {
                    border-bottom: 1px solid #ddd;
                }

                .theme-sltd.color-default .sidebar .sidebar-inner .nav-sidebar .children > li.active > a {
                    font-weight: bold;
                }

                .theme-sltd.color-default .sidebar .sidebar-inner .nav-sidebar > li.active > a, .theme-sltd.color-default .nav-sidebar > li.active > a:hover, .theme-sltd.color-default .nav-sidebar > li.active > a:focus {
                    background-color: #555 !important;
                }

                .theme-sltd.color-default .sidebar .sidebar-inner .nav-sidebar .children li:hover:before{
                    background-color: #000;
                    border-color: #000;
                }
                .sidebar{display:none;}

            </style>

            <div class="sidebar">
                <div class="logopanel">
                    <a href="admin/dashboard"><img src="uploads/site/3aa1ec55f57540ce3e1e87e278770310.png" alt="company logo" class="" style="height: 30px;"></a>
                </div>

            </div>      <!-- END SIDEBAR -->
            <div class="main-content">
                <!-- BEGIN TOPBAR -->
                <script>

                    function delete_notification(notification_id, section_name, section_view, id)
                    {
                        $.ajax({
                            type: "GET",
                            url: "admin/dashboard/delete_notification/" + notification_id,
                            success: function (msg)
                            {
                                if (msg == 'deleted')
                                {
                                    $('#noti_id_' + notification_id).fadeOut('normal');

                                    setTimeout(function () {
                                        window.location.href = "admin/" + section_name + '/' + section_view + '/' + id;
                                    }, 500); //will call the function after 1 secs.
                                }
                            }

                        });

                    }


                </script>

                <div class="topbar">

                    <div class="header-left">
                        <div class="topnav">
                           <!-- <a class="menutoggle" href="#" data-toggle="sidebar-collapsed"><span class="menu__handle"><span>Menu</span></span></a>-->
                            <ul class="nav nav-horizontal">
                                <!--li><a href="#">A2000 Sales &amp; CRM</a></li-->

                            </ul>

                        </div>
                    </div>
                    <div class="header-right">
                        <ul class="header-menu nav navbar-nav">
                            <!-- BEGIN NOTIFICATION DROPDOWN -->
                            <li class="dropdown" id="notifications-header">
                                <a href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="icon-bell"></i>
                                    <span class="badge badge-danger badge-header">21</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-header clearfix">
                                        <p class="pull-left">21 Pending Notifications</p>
                                    </li>
                                    <li>
                                        <ul class="dropdown-menu-list withScroll" data-height="220">


                                            <li id="noti_id_81" onclick="delete_notification(81, 'leads', 'view', 52)">
                                                <a href="javascript:void(0)">
                                                    <i class="fa fa-rocket p-r-10 f-18 c-red"></i>
                                                    New Lead Added                        <span class="dropdown-time">17 days ago</span>
                                                </a>
                                            </li>


                                            <li id="noti_id_80" onclick="delete_notification(80, 'leads', 'view', 51)">
                                                <a href="javascript:void(0)">
                                                    <i class="fa fa-rocket p-r-10 f-18 c-red"></i>
                                                    New Lead Added                        <span class="dropdown-time">17 days ago</span>
                                                </a>
                                            </li>


                                            <li id="noti_id_58" onclick="delete_notification(58, 'leads', 'view', 31)">
                                                <a href="javascript:void(0)">
                                                    <i class="fa fa-rocket p-r-10 f-18 c-red"></i>
                                                    New Lead Added                        <span class="dropdown-time">18 days ago</span>
                                                </a>
                                            </li>


                                            <li id="noti_id_25" onclick="delete_notification(25, 'quotations', 'update', 14)">
                                                <a href="javascript:void(0)">
                                                    <i class="icon-tag p-r-10 f-18 c-red"></i>
                                                    New Quotation Added                        <span class="dropdown-time">1 month ago</span>
                                                </a>
                                            </li>


                                            <li id="noti_id_24" onclick="delete_notification(24, 'quotations', 'update', 13)">
                                                <a href="javascript:void(0)">
                                                    <i class="icon-tag p-r-10 f-18 c-red"></i>
                                                    New Quotation Added                        <span class="dropdown-time">1 month ago</span>
                                                </a>
                                            </li>


                                            <li id="noti_id_23" onclick="delete_notification(23, 'leads', 'view', 9)">
                                                <a href="javascript:void(0)">
                                                    <i class="fa fa-rocket p-r-10 f-18 c-red"></i>
                                                    New Lead Added                        <span class="dropdown-time">1 month ago</span>
                                                </a>
                                            </li>


                                            <li id="noti_id_22" onclick="delete_notification(22, 'leads', 'view', 8)">
                                                <a href="javascript:void(0)">
                                                    <i class="fa fa-rocket p-r-10 f-18 c-red"></i>
                                                    New Lead Added                        <span class="dropdown-time">1 month ago</span>
                                                </a>
                                            </li>


                                            <li id="noti_id_21" onclick="delete_notification(21, 'leads', 'view', 7)">
                                                <a href="javascript:void(0)">
                                                    <i class="fa fa-rocket p-r-10 f-18 c-red"></i>
                                                    New Lead Added                        <span class="dropdown-time">1 month ago</span>
                                                </a>
                                            </li>


                                            <li id="noti_id_15" onclick="delete_notification(15, 'quotations', 'update', 7)">
                                                <a href="javascript:void(0)">
                                                    <i class="icon-tag p-r-10 f-18 c-red"></i>
                                                    New Quotation Added                        <span class="dropdown-time">1 month ago</span>
                                                </a>
                                            </li>


                                            <li id="noti_id_14" onclick="delete_notification(14, 'leads', 'view', 5)">
                                                <a href="javascript:void(0)">
                                                    <i class="fa fa-rocket p-r-10 f-18 c-red"></i>
                                                    New Lead Added                        <span class="dropdown-time">1 month ago</span>
                                                </a>
                                            </li>


                                            <li id="noti_id_11" onclick="delete_notification(11, 'quotations', 'update', 4)">
                                                <a href="javascript:void(0)">
                                                    <i class="icon-tag p-r-10 f-18 c-red"></i>
                                                    New Quotation Added                        <span class="dropdown-time">1 month ago</span>
                                                </a>
                                            </li>


                                            <li id="noti_id_10" onclick="delete_notification(10, 'quotations', 'update', 3)">
                                                <a href="javascript:void(0)">
                                                    <i class="icon-tag p-r-10 f-18 c-red"></i>
                                                    New Quotation Added                        <span class="dropdown-time">1 month ago</span>
                                                </a>
                                            </li>


                                            <li id="noti_id_9" onclick="delete_notification(9, 'quotations', 'update', 2)">
                                                <a href="javascript:void(0)">
                                                    <i class="icon-tag p-r-10 f-18 c-red"></i>
                                                    New Quotation Added                        <span class="dropdown-time">1 month ago</span>
                                                </a>
                                            </li>


                                            <li id="noti_id_8" onclick="delete_notification(8, 'quotations', 'update', 1)">
                                                <a href="javascript:void(0)">
                                                    <i class="icon-tag p-r-10 f-18 c-red"></i>
                                                    New Quotation Added                        <span class="dropdown-time">1 month ago</span>
                                                </a>
                                            </li>


                                            <li id="noti_id_7" onclick="delete_notification(7, 'opportunities', 'view', 1)">
                                                <a href="javascript:void(0)">
                                                    <i class="icon-key p-r-10 f-18 c-red"></i>
                                                    New Opportunities Added                        <span class="dropdown-time">2 months ago</span>
                                                </a>
                                            </li>


                                            <li id="noti_id_6" onclick="delete_notification(6, 'quotations', 'update', 3)">
                                                <a href="javascript:void(0)">
                                                    <i class="icon-tag p-r-10 f-18 c-red"></i>
                                                    New Quotation Added                        <span class="dropdown-time">2 months ago</span>
                                                </a>
                                            </li>


                                            <li id="noti_id_5" onclick="delete_notification(5, 'contracts', 'update', 1)">
                                                <a href="javascript:void(0)">
                                                    <i class="fa fa-search-plus p-r-10 f-18 c-red"></i>
                                                    New Contract Added                        <span class="dropdown-time">2 months ago</span>
                                                </a>
                                            </li>


                                            <li id="noti_id_4" onclick="delete_notification(4, 'quotations', 'update', 2)">
                                                <a href="javascript:void(0)">
                                                    <i class="icon-tag p-r-10 f-18 c-red"></i>
                                                    New Quotation Added                        <span class="dropdown-time">2 months ago</span>
                                                </a>
                                            </li>


                                            <li id="noti_id_3" onclick="delete_notification(3, 'leads', 'view', 3)">
                                                <a href="javascript:void(0)">
                                                    <i class="fa fa-rocket p-r-10 f-18 c-red"></i>
                                                    New Lead Added                        <span class="dropdown-time">2 months ago</span>
                                                </a>
                                            </li>


                                            <li id="noti_id_2" onclick="delete_notification(2, 'leads', 'view', 1)">
                                                <a href="javascript:void(0)">
                                                    <i class="fa fa-rocket p-r-10 f-18 c-red"></i>
                                                    New Lead Added                        <span class="dropdown-time">2 months ago</span>
                                                </a>
                                            </li>


                                            <li id="noti_id_1" onclick="delete_notification(1, 'quotations', 'update', 1)">
                                                <a href="javascript:void(0)">
                                                    <i class="icon-tag p-r-10 f-18 c-red"></i>
                                                    New Quotation Added                        <span class="dropdown-time">2 months ago</span>
                                                </a>
                                            </li>


                                        </ul>
                                    </li>

                                </ul>
                            </li>
                            <!-- END NOTIFICATION DROPDOWN -->
                            <!-- BEGIN USER DROPDOWN -->
                            <li class="dropdown" id="user-header">
                                <a href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">

                                    <img src="public/assets/global/images/avatars/user1.png" alt="user image" style="height: 36px;width: 36px;">                




                                    <span class="username">Hi, Admin</span>
                                </a>
                                <ul class="dropdown-menu">                   
                                    <li>
                                        <a href="admin/settings"><i class="icon-settings"></i><span>General Settings</span></a>
                                    </li>
                                    <li>
                                        <a href="admin/account_settings"><i class="icon-settings"></i><span>Account Settings</span></a>
                                    </li>
                                    <li>
                                        <a href="admin/logout"><i class="icon-logout"></i><span>Logout</span></a>
                                    </li>
                                </ul>
                            </li>
                            <!-- END USER DROPDOWN -->


                            <!-- CHAT BAR ICON -->
                            <!--<li id="quickview-toggle"><a href="#"><i class="icon-bubbles"></i></a></li>-->
                        </ul>
                    </div>
                    <!-- header-right -->
                </div>        <!-- END TOPBAR --><!-- BEGIN PAGE CONTENT -->
                <div class="page-content">
                    <div class="row">

                    </div>
                    <div class="row">
                        <div class="panel">
                            <div class="panel-content">
                                <div class="panel-content pagination2 table-responsive">
                                    <h1><?php if ($this->user_model->get_role(userdata('id'))[0]->role_id == '1'): ?>Database Update<?php else: ?>Version Mismatch<?php endif; ?></h1>
                                    <hr />
                                    <h3>Application and Database version mismatch. please update your database</h3>
                                    <?php if ($this->user_model->get_role(userdata('id'))[0]->role_id == '1'): ?>
                                        <form method="post" id="fileinfo" enctype="multipart/form-data" name="fileinfo" onsubmit="return submitForm();">
                                            <label>Select a file:</label><br>
                                            <input type="file" name="file" accept=".zip,.ZIP,.sql,.SQL" required />
                                            <br>
                                            <input type="submit" value="Start Update" />
                                        </form>
                                    <?php else: ?>
                                        <h3>Please contact your administrator</h3>
                                    <?php endif; ?>
                                    <br>

                                    <div id="output"></div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PAGE CONTENT -->
                <script type="text/javascript">
                    function submitForm() {
                        //console.log("submit event");

                        var fd = new FormData(document.getElementById("fileinfo"));
                        fd.append("label", "WEBUPLOAD");
                        $('#output').html('<img src="<?php echo base_url() ?>public/images/loading.gif"/>&nbsp; Please wait while system updating your database');
                        $.ajax({
                            url: "update/do_upload2",
                            type: "POST",
                            data: fd,
                            processData: false, // tell jQuery not to process the data
                            contentType: false   // tell jQuery not to set contentType
                        }).done(function (data) {
                            console.log("PHP Output:");
                            console.log(data);

                            $('#output').text(data);
                            if (data == "Update Finished")
                            {
                                setTimeout(
                                        function () {
                                            window.location = "<?php echo base_url()?>admin/dashboard";
                                        },
                                        100);
                            }
                        });
                        return false;
                    }


                </script><div class="footer">
                    <div class="copyright">
                        <p class="pull-left sm-pull-reset">
                            <span>Copyright <span class="copyright">©</span> 2016 </span>
                            <span>A2000 Sales &amp; CRM</span>.
                            <span>All rights reserved. </span>
                        </p>
                        <!--<p class="pull-right sm-pull-reset">
                          <span><a href="#" class="m-r-10">Support</a> | <a href="#" class="m-l-10 m-r-10">Terms of use</a> | <a href="#" class="m-l-10">Privacy Policy</a></span>
                        </p>-->
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT -->

        </section>

        <!-- BEGIN PRELOADER -->
        <div id="preloader"></div>

        <!--<div class="loader-overlay">
          <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
          </div>
        </div>   -->  
        <!-- END PRELOADER -->
        <a href="#" class="scrollup"><i class="fa fa-angle-up"></i></a> 


        <?php
        $get_dcontroller_nm = $this->uri->segment(2);

        if ($get_dcontroller_nm == "dashboard") {
            ?>
            <script src="<?php echo base_url(); ?>public/assets/global/plugins/jquery/jquery-1.11.1.min.js"></script>

        <?php } ?>

        <script src="<?php echo base_url(); ?>public/assets/global/plugins/jquery/jquery-migrate-1.2.1.min.js"></script>
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/jquery-ui/jquery-ui-1.11.2.min.js"></script>
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/gsap/main-gsap.min.js"></script>
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/bootstrap/js/bootstrap.min.js"></script>

        <script src="<?php echo base_url(); ?>public/assets/global/plugins/jquery-block-ui/jquery.blockUI.min.js"></script> <!-- simulate synchronous behavior when using AJAX -->
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/bootbox/bootbox.min.js"></script> <!-- Modal with Validation -->
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/mcustom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script> <!-- Custom Scrollbar sidebar -->
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/bootstrap-dropdown/bootstrap-hover-dropdown.min.js"></script> <!-- Show Dropdown on Mouseover -->
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/charts-sparkline/sparkline.min.js"></script> <!-- Charts Sparkline -->
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/retina/retina.min.js"></script> <!-- Retina Display -->
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/select2/select2.min.js"></script> <!-- Select Inputs -->
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/icheck/icheck.min.js"></script> <!-- Checkbox & Radio Inputs -->
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/backstretch/backstretch.min.js"></script> <!-- Background Image -->
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/bootstrap-progressbar/bootstrap-progressbar.min.js"></script> <!-- Animated Progress Bar -->

        <script src="<?php echo base_url(); ?>public/assets/global/js/sidebar_hover.js"></script> <!-- Sidebar on Hover -->
        <script src="<?php echo base_url(); ?>public/assets/global/js/application.js"></script> <!-- Main Application Script -->
        <script src="<?php echo base_url(); ?>public/assets/global/js/plugins.js"></script> <!-- Main Plugin Initialization Script -->
        <script src="<?php echo base_url(); ?>public/assets/global/js/widgets/notes.js"></script> <!-- Notes Widget -->
        <script src="<?php echo base_url(); ?>public/assets/global/js/quickview.js"></script> <!-- Chat Script -->

        <!-- BEGIN PAGE SCRIPT -->
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/noty/jquery.noty.packaged.min.js"></script>  <!-- Notifications -->
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/bootstrap-editable/js/bootstrap-editable.min.js"></script> <!-- Inline Edition X-editable -->
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/bootstrap-context-menu/bootstrap-contextmenu.min.js"></script> <!-- Context Menu -->

        <script src="<?php echo base_url(); ?>public/assets/global/plugins/timepicker/jquery-ui-timepicker-addon.min.js"></script> <!-- Time Picker -->
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/multidatepicker/multidatespicker.min.js"></script> <!-- Multi dates Picker -->
        <script src="<?php echo base_url(); ?>public/assets/global/js/widgets/todo_list.js"></script>
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/metrojs/metrojs.min.js"></script> <!-- Flipping Panel -->
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/charts-chartjs/Chart.min.js"></script>  <!-- ChartJS Chart -->
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/charts-highstock/js/highstock.min.js"></script> <!-- financial Charts -->
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/charts-highstock/js/modules/exporting.min.js"></script> <!-- Financial Charts Export Tool -->

        <script src="<?php echo base_url(); ?>public/assets/global/plugins/dashboard/ammap.min.js"></script>         
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/datatables/jquery.dataTables.min.js"></script> <!-- Tables Filtering, Sorting & Editing -->
        <script src="<?php echo base_url(); ?>public/assets/global/js/pages/table_dynamic.js"></script>


        <script src="<?php echo base_url(); ?>public/assets/global/plugins/summernote/summernote.min.js"></script> <!-- Simple HTML Editor --> 
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/cke-editor/ckeditor.js"></script> <!-- Advanced HTML Editor -->
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/cke-editor/adapters/adapters.min.js"></script>
        <!-- END PAGE SCRIPTS -->

        <script src="<?php echo base_url(); ?>public/assets/global/plugins/countup/countUp.min.js"></script> <!-- Animated Counter Number -->

        <!-- END PAGE SCRIPT -->
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/bootstrap-loading/lada.min.js"></script> <!-- Buttons Loading State -->

        <script src="<?php echo base_url(); ?>public/assets/global/js/pages/search.js"></script> <!-- Search Script -->

        <script src="<?php echo base_url(); ?>public/assets/global/plugins/bootstrap-tags-input/bootstrap-tagsinput.min.js"></script> <!-- Select Inputs -->

        <script src="<?php echo base_url(); ?>public/assets/global/plugins/quicksearch/quicksearch.min.js"></script> <!-- Search Filter -->

        <script src="<?php echo base_url(); ?>public/assets/global/js/pages/mailbox.js"></script>

        <script src='<?php echo base_url(); ?>public/assets/global/plugins/moment/moment.min.js'></script>
        <script src='<?php echo base_url(); ?>public/assets/global/plugins/fullcalendar/fullcalendar.min.js'></script>
        <!--<script src="<?php echo base_url(); ?>public/assets/global/js/pages/fullcalendar.js"></script>-->

        <script src="<?php echo base_url(); ?>public/assets/global/js/pages/dashboard.js"></script>
        <!-- BEGIN PAGE SCRIPTS -->

        <script src="<?php echo base_url(); ?>public/assets/admin/layout1/js/layout.js"></script>
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/chartphp/js/chartphp.js"></script>
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/amcharts/amcharts.js"></script>
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/amcharts/funnel.js"></script>
        <script src="<?php echo base_url(); ?>public/assets/global/js/custom01.js"></script>

        <script>
                    var getBase_url = "<?= base_url() ?>";
                    var getSiteName = "<?php echo config('site_name'); ?>";
                    var widgetMapHeight = $('.widget-map').height();
                    var pstatHeadHeight = $('.panel-stat-chart').parent().find('.panel-header').height() + 12;
                    var pstatBodyHeight = $('.panel-stat-chart').parent().find('.panel-body').height() + 15;
                    var pstatheight = widgetMapHeight - pstatHeadHeight - pstatBodyHeight + 30;
                    $('.panel-stat-chart').css('height', pstatheight);
                    var clockHeight = $('.jquery-clock ').height();
                    var widgetProgressHeight = $('.widget-progress-bar').height();
                    if ($('.widget-map').length) {
                        $('.widget-progress-bar').css('margin-top', widgetMapHeight - clockHeight - widgetProgressHeight - 3);
                    }
                    var monthLables = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                    var visitorsData = {
                        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        datasets: [
                            {
                                label: "New",
                                fillColor: "rgba(255, 206, 86, 0)",
                                strokeColor: "rgba(255, 206, 86, 0.9)",
                                pointColor: "rgba(255, 206, 86, 0.9)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(200,200,200,1)",
                                data: []
                            },
                            {
                                label: "Total Sales",
                                fillColor: "rgba(254, 118, 122, 0)",
                                strokeColor: "rgba(254, 118, 122, 0.9)",
                                pointColor: "rgba(254, 118, 122, 0.9)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(49, 157, 181,1)",
                                data: [<?php echo sales_by_month_chart('January'); ?>,<?php echo sales_by_month_chart('February'); ?>,<?php echo sales_by_month_chart('March'); ?>,<?php echo sales_by_month_chart('April'); ?>,<?php echo sales_by_month_chart('May'); ?>,<?php echo sales_by_month_chart('June'); ?>,<?php echo sales_by_month_chart('July'); ?>,<?php echo sales_by_month_chart('August'); ?>,<?php echo sales_by_month_chart('September'); ?>,<?php echo sales_by_month_chart('October'); ?>,<?php echo sales_by_month_chart('November'); ?>,<?php echo sales_by_month_chart('December'); ?>]
                            }

                        ]
                    };
                    var chartOptions = {
                        //scaleGridLineColor: "rgba(0, 0, 0, 0.3)",
                        scaleGridLineWidth: 1,
                        bezierCurve: false,
                        pointDot: true,
                        pointHitDetectionRadius: 20,
                        tooltipCornerRadius: 0,
                        tooltipTemplate: "dffdff",
                        multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>",
                        maintainAspectRatio: true,
                        responsive: false,
                        scaleShowLabels: false
                    };

                    if ($('#visitors-chart').length) {
                        var ctx = document.getElementById("visitors-chart").getContext("2d");
                        //ctx.canvas.height = 100;
                        var myNewChart = new Chart(ctx).Line(visitorsData, chartOptions);
                    }

        </script>
        <?php
        $check_controller_nm = $this->uri->segment(2);
        if ($check_controller_nm == "dashboard") {
            ?>

            <!--Sales Performance-->
            <script>

    <?php
    foreach ($salesteams_performance_list as $team_performnce) {
        $y = date('Y');
        $first_date = date('d-m-Y', strtotime('01-01-' . $y . ''));
        $last_date = date('d-m-Y', strtotime('31-12-' . $y . ''));
        ?>

                    var data<?php echo $team_performnce->id; ?> = [
        <?php
        $i = 1;
        while (strtotime($first_date) <= strtotime($last_date)) {
            ?>
                            [<?php echo strtotime($first_date) * 1000; ?>,<?php echo sales_performance_salescount(strtotime($first_date), $team_performnce->id); ?>],
            <?php
            $first_date = date("Y-m-d", strtotime("+1 day", strtotime($first_date)));
            $i++;
        }
        ?>
                    ];

    <?php } ?>

                var data12 = [
                    [1426719600000, 5],
                    [1426806000000, 0],
                    [1426892400000, 7],
                    [1426978800000, 0],
                    [1427065200000, 1],
                    [1427151600000, 3],
                    [1427238000000, 10],
                ];

                function stockCharts2(tabName, id) {
                    var items = Array('',<?php
    foreach ($salesteams_performance_list as $team_performnce) {
        echo 'data' . $team_performnce->id . ',';
    }
    ?>data12);
                    //var randomData = items[Math.floor(Math.random() * items.length)];

                    if (id == '')
                    {
                        var randomData = items['1'];
                    }
                    else
                    {
                        var randomData = items[id];
                    }


                    // var custom_colors = ['#C9625F', '#18A689', '#90ed7d', '#f7a35c', '#8085e9', '#f15c80', '#8085e8', '#91e8e1'];
                    // var custom_color = custom_colors[Math.floor(Math.random() * custom_colors.length)];
                    var custom_colors = '#18A689';
                    var custom_color = custom_colors;
                    // Create the chart
                    $('#stock-' + tabName).highcharts('StockChart', {
                        chart: {
                            //width:831,
                            height: 370,
                            plotBorderColor: '#C21414',
                            plotBorderColor: '#C21414'
                        },
                        credits: {
                            enabled: false
                        },
                        colors: [custom_color],
                        exporting: {
                            enabled: false
                        },
                        rangeSelector: {
                            inputEnabled: false,
                            selected: 4
                        },
                        scrollbar: {
                            enabled: false
                        },
                        navigator: {
                            enabled: false
                        },
                        tooltip: {
                            enabled: true
                        },
                        xAxis: {
                            gridLineColor: '#C21414',
                            gridLineColor: '#C21414',
                                    lineColor: '#EFEFEF',
                            tickColor: '#EFEFEF',
                        },
                        yAxis: {
                            gridLineColor: '#EFEFEF',
                            lineColor: '#B324B3'
                        },
                        series: [{
                                //name: tabName,
                                name: 'Sales',
                                data: randomData,
                                tooltip: {
                                    valueDecimals: 0,
                                    valuePrefix: '$'
                                }
                            }]
                    });
                }
    <?php foreach ($salesteams_performance_list as $team_performnce) { ?>
                    stockCharts2('<?php echo str_replace(' ', '', $team_performnce->salesteam); ?>', '<?php //echo $team_performnce->id;   ?>');
    <?php } ?>

                $('.stock2 .nav-tabs a').on('click', function () {
                    $('.stock2 .tab-content .tab-pane.active').fadeOut(300, function () {
                        $('.stock2 .tab-content .tab-pane.active').fadeIn(300);
                    });

                    var current_stock_id = $(this).data('id');
                    var current_stock = $(this).attr('id');
                    var current_value = $(this).data('value');
                    var current_color = $(this).data('color');
                    var current_title = $(this).data('title');
                    title = current_title.toLowerCase().replace(/\b[a-z]/g, function (letter) {
                        return letter.toUpperCase();
                    });
                    $('.title-stock h1').text(title);
                    $('.title-stock span').removeClass().addClass('c-' + current_color).text(current_value);
                    stockCharts2(current_stock, current_stock_id);
                });

                $('.stock2 .nav-tabs li').on('click', function () {
                    $('.stock2 .nav-tabs li').removeClass('active');
                });

            </script>

<?php } ?>

        <!-- Search between two date -->   
        <?php
        $get_controller_nm = $this->uri->segment(2);
        ?>
        <script type="text/javascript" class="init">

            $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {

                        var min = new Date($('#min').val()).getTime();
                        var max = new Date($('#max').val()).getTime();
            <?php if ($get_controller_nm == "contracts") { ?>
                            var date = new Date(data[0]).getTime() || 0;
            <?php } else { ?>
                            var date = new Date(data[1]).getTime() || 0;
            <?php } ?>
                        // use data for the date column
                        //alert(date);
                        if ((isNaN(min) && isNaN(max)) ||
                                (isNaN(min) && date <= max) ||
                                (min <= date && isNaN(max)) ||
                                (min <= date && date <= max))
                        {
                            return true;
                        }
                        return false;
                    }
            );

            <?php if ($get_controller_nm == "invoices") { ?>
                /*  Initialse DataTables, with no sorting on the 'date' column  */
                var oTable = $('.table-dynamic').dataTable({
                    "aoColumnDefs": [{
                            "bSortable": false,
                            "aTargets": [0]
                        }],
                    "aaSorting": [
                        [1, 'desc']
                    ]
                });
            <?php } ?>

        </script>

        <script>
            // site preloader -- also uncomment the div in the header and the css style for #preloader	 
            jQuery(document).ready(function ($) {
                $('input.numeric').on('input', function () {
                    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
                });
            });

            $(window).load(function () {
                $('#preloader').fadeOut('slow', function () {
                    $(this).remove();
                });
            });


        </script>
    </body>
</html>