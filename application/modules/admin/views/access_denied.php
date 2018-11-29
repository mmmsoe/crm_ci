<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo config('site_name'); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta content="" name="description" />
        <meta content="themes-lab" name="author" />
        <link rel="shortcut icon" href="../assets/global/images/favicon.png">
        <link href="<?php echo base_url(); ?>public/assets/global/css/style.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>public/assets/global/css/ui.css" rel="stylesheet">
    </head>
    <body class="sidebar-light error-page" style="background-color: #0c5aaf">
        <div class="row">
            <div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
                <div class="error-container">
                    <div class="error-main">
                        <span><img src="<?php echo base_url('uploads/site') . '/' . config('site_logo'); ?>" alt="company logo" class="" style="height: 60px;"></span>
                        <br/>                        <br/>
                        <br/>

                        <font style="color: #FFFFFF"><h3><span id="404" style="font-size: 40px;font-weight: bold;"></span></h3></font>
                        <font style="color: #FFFFFF"><h3><span id="404-txt"></span></h3></font>
                        <font style="color: #FFFFFF"><h4><span id="404-txt-2"></span></h4></font>
                        <br>
                        <div class="row" id="content-404">

                            <div class="col-md-12 text-center">

                                <div class="btn-group">
                                    <a class="btn btn-white" href="<?php echo base_url('admin/dashboard'); ?>" >
                                        <i class="fa fa-angle-left"></i> Go back&nbsp;
                                    </a>
                                    <!--                                    <a class="btn btn-white" href="dashboard.html">
                                                                        <i class="icon-home"></i> Home Page
                                                                        </a>-->


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="<?php echo base_url(); ?>public/assets/global/plugins/jquery/jquery-1.11.1.min.js"></script>
        <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>public/assets/global/plugins/typed/typed.js"></script>
        <script>
            $(function () {
                $("#404").typed({
                    strings: ["Access Denied"],
                    typeSpeed: 100,
                    backDelay: 500,
                    loop: false,
                    contentType: 'html',
                    loopCount: false,
                    callback: function () {
                        $('h1 .typed-cursor').css('-webkit-animation', 'none').animate({opacity: 0}, 1000);
                        $("#404-txt").typed({
                            strings: ["You do not have access right to this page."],
                            typeSpeed: 1,
                            backDelay: 500,
                            loop: false,
                            contentType: 'html',
                            loopCount: false,
                            callback: function () {
                                $('h3 .typed-cursor').css('-webkit-animation', 'none').animate({opacity: 0}, 400);
                                $("#404-txt-2").typed({
                                    strings: ["Please contact the CRM Administrator for more info."],
                                    typeSpeed: 1,
                                    backDelay: 500,
                                    loop: false,
                                    contentType: 'html',
                                    loopCount: false,
                                    callback: function () {
                                        $('#content-404').delay(300).slideDown();
                                    },
                                });
                            }
                        });
                    }
                });
            });
        </script>
        <script src="<?php echo base_url(); ?>public/assets/admin/layout3/js/layout.js"></script>
    </body>
</html>