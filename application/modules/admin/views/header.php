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
    <script src="<?php echo base_url(); ?>public/assets/global/js/jquery-sortable.js"></script>
	<!-- CUSTOM ADDON -- [EGA] -->
	<link href="<?php echo base_url(); ?>public/assets/global/css/custom01.css" rel="stylesheet">
		<!-- PLUGIN -->
		<link href="<?php echo base_url(); ?>public/assets/global/plugins/chartphp/js/chartphp.css" rel="stylesheet">
	<!-- END CUSTOM ADDON -- [EGA] -->
	<!--AUTOCOMPLETE-->
        <link href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" type="text/css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>public/assets/global/dist/css/tokenfield-typeahead.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>public/assets/global/dist/css/bootstrap-tokenfield.css" rel="stylesheet">
        <!--END AUTO COMPLETE-->
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
  <body class="fixed-topbar color-default sidebar-light theme-sltd">
   <section>
      <!-- BEGIN SIDEBAR -->
      <?php $this->load->view('sidebar');?>
      <!-- END SIDEBAR -->
      <div class="main-content">
        <!-- BEGIN TOPBAR -->
        <?php $this->load->view('topbar');?>
        <!-- END TOPBAR -->