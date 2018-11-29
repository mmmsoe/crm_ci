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
</style>

<div class="sidebar">
    <div class="logopanel">
        <a href="<?php echo base_url('admin/dashboard/'); ?>"><img src="<?php echo base_url('uploads/site') . '/' . config('site_logo'); ?>" alt="company logo" class="" style="height: 30px;"></a>
    </div>
    <div class="sidebar-inner">
        <div class="menu-title" style="font-size: 15px;">Navigation</div>
        <ul class="nav nav-sidebar">
            <li class="nav-active <?php echo is_active_menu('dashboard'); ?>"><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
            <li class="nav-parent <?php echo is_active_menu('leads'); ?><?php echo is_active_menu('opportunities'); ?><?php echo is_active_menu('quotations'); ?><?php echo is_active_menu('salesorder'); ?><?php echo is_active_menu('invoices'); ?><?php echo is_active_menu('in_payment_log'); ?><?php echo is_active_menu('report'); ?>">
                <a href="#"><i class="fa fa-shopping-cart c-blue"></i><span>Sales</span> <span class="fa arrow"></span></a>
                <ul class="children collapse">
                    <?php if (check_staff_permission('lead_read')){?> <li class="<?php echo is_active_menu('leads'); ?>"><a href="<?php echo base_url('admin/leads'); ?>" class="list-group-item borne pasif" style="border-radius: 0;background:#fff;">Leads</a></li><?php } ?>
                    <?php if (check_staff_permission('opportunities_read')){?><li class="<?php echo is_active_menu('opportunities'); ?>"><a href="<?php echo base_url('admin/opportunities/dashboard///'); ?>" class="list-group-item borne pasif" style="border-radius: 0;background:#fff;">Opportunities</a></li><?php } ?>
                    <?php if (check_staff_permission('quotations_read')){?><li class="<?php echo is_active_menu('quotations'); ?>"><a href="<?php echo base_url('admin/quotations'); ?>" class="list-group-item borne pasif" style="border-radius: 0;background:#fff;">Quotations</a></li> <?php } ?>
                    <?php if (check_staff_permission('sales_orders_read')){?><li class="<?php echo is_active_menu('salesorder'); ?>"><a href="<?php echo base_url('admin/salesorder'); ?>" class="list-group-item borne pasif" style="border-radius: 0;background:#fff;">Sales Order</a></li> <?php } ?>
                    <!--
					<?php if (check_staff_permission('invoices_read')){?><li class="<?php echo is_active_menu('invoices'); ?>"><a href="<?php echo base_url('admin/invoices'); ?>" class="list-group-item borne pasif" style="border-radius: 0;background:#fff;">Invoices</a></li><?php } ?>
                    <?php if (check_staff_permission('payment_log_read')){?><li class="<?php echo is_active_menu('in_payment_log'); ?>"><a href="<?php echo base_url('admin/in_payment_log'); ?>" class="list-group-item borne pasif" style="border-radius: 0;background:#fff;">Payment Log</a></li> <?php } ?>
					-->
                    <?php if (check_staff_permission('analytics_read')){?><li class="<?php echo is_active_menu('report'); ?>"><a href="<?php echo base_url('admin/report'); ?>" class="list-group-item borne pasif" style="border-radius: 0;background:#fff;">Analytics</a></li><?php } ?>
                </ul>
            </li>

            <li class="nav-parent <?php echo is_active_menu('events'); ?><?php echo is_active_menu('calendars'); ?><?php echo is_active_menu('logged_calls'); ?><?php echo is_active_menu('meetings'); ?><?php echo is_active_menu('mailbox'); ?>">
               <a href="#"><i class="fa fa-calendar c-green"></i><span>Activities</span> <span class="fa arrow"></span></a>
                <ul class="children collapse">
                     <?php if (check_staff_permission('email_read')){?><li class="<?php echo is_active_menu('mailbox'); ?>"><a href="<?php echo base_url('admin/mailbox'); ?>" class="list-group-item borne pasif" style="border-radius: 0;background:#fff;">E-Mail</a></li><?php } ?>
                     <?php if (check_staff_permission('activity_entry_read') == true){?><li class="<?php echo is_active_menu('meetings'); ?><?php echo is_active_menu('logged_calls'); ?>"><a href="<?php echo base_url('admin/meetings'); ?>" class="list-group-item borne pasif" style="border-radius: 0;background:#fff;">Activity Entry</a></li><?php } ?>
                    <?php if (check_staff_permission('calendar_read')){?><li class="<?php echo is_active_menu('calendars'); ?>"><a href="<?php echo base_url('admin/calendar'); ?>" class="list-group-item borne pasif" style="border-radius: 0;background:#fff;">Calendar</a></li><?php } ?>
                    

                </ul>
            </li>

            <li class="nav-parent <?php echo is_active_menu('customers'); ?><?php echo is_active_menu('contact_persons'); ?>">
                <a href="#"><i class="fa fa-group c-red"></i><span>Customers</span> <span class="fa arrow"></span></a>
                <ul class="children collapse">
                    <?php if (check_staff_permission('account_read')){?><li class="<?php echo is_active_menu('customers'); ?>"><a href="<?php echo base_url('admin/customers'); ?>" class="list-group-item borne pasif" style="border-radius: 0;background:#fff;">Account</a></li><?php } ?>
                    <?php if (check_staff_permission('contacts_read')){?><li class="<?php echo is_active_menu('contact_persons'); ?>"><a href="<?php echo base_url('admin/contact_persons'); ?>" class="list-group-item borne pasif" style="border-radius: 0;background:#fff;">Contacts</a></li><?php } ?>
                </ul>
            </li>

            <li class="nav-parent <?php echo is_active_menu('tickets'); ?><?php echo is_active_menu('knowledgebase'); ?>">
                <a href="#"><i class="fa fa-life-bouy c-orange"></i><span>Support</span> <span class="fa arrow"></span></a>
                <ul class="children collapse">
                    <?php if (check_staff_permission('tickets_read')){?><li class="<?php echo is_active_menu('tickets'); ?>"><a href="<?php echo base_url('admin/tickets'); ?>" class="list-group-item borne pasif" style="border-radius: 0;background:#fff;">Tickets</a></li><?php } ?>
                    <?php if (check_staff_permission('knowledge_base_read')){?><li class="<?php echo is_active_menu('knowledgebase'); ?>"><a href="<?php echo base_url('admin/knowledgebase'); ?>" class="list-group-item borne pasif" style="border-radius: 0;background:#fff;">Knowledgebase</a></li><?php } ?>
                </ul>
            </li>

            <li class="nav-parent <?php echo is_active_menu('campaign'); ?><?php echo is_active_menu('marketing_templates'); ?><?php echo is_active_menu('marketing_schedules'); ?><?php echo is_active_menu('e_marketing_settings'); ?><?php echo is_active_menu('sms_api'); ?><?php echo is_active_menu('send_sms'); ?>">
                <a href="#"><i class="fa fa-bookmark c-yellow"></i><span>Marketing</span> <span class="fa arrow"></span></a>
                <ul class="children collapse">
                    <?php if (check_staff_permission('campaign_listing_read')){?><li class="<?php echo is_active_menu('campaign'); ?>"><a href="<?php echo base_url('admin/campaign'); ?>" class="list-group-item borne pasif" style="border-radius: 0;background:#fff;">Campaign Listing</a></li><?php } ?>
                </ul>
            </li>
           <li class="nav-parent <?php echo is_active_menu('update'); ?><?php echo is_active_menu('staff'); ?><?php echo is_active_menu('users'); ?><?php echo is_active_menu('products'); ?><?php echo is_active_menu('settings'); ?>">
                <a href="#"><i class="fa fa-gears"></i><span>Settings</span> <span class="fa arrow"></span></a>
                <ul class="children collapse">
                    <?php if (check_staff_permission('update_application_read')){?><li class="<?php echo is_active_menu('update'); ?>"><a href="<?php echo base_url('admin/update'); ?>" class="list-group-item borne pasif" style="border-radius: 0;background:#fff;">Update Application</a></li><?php } ?>

                    <?php if($this->user_model->get_role(userdata('id'))[0]->role_id == 1)
			{
                            if (check_staff_permission('people_listing_read')){?><li class="<?php echo is_active_menu('staff'); ?>"><a href="<?php echo base_url('admin/staff'); ?>" class="list-group-item borne pasif" style="border-radius: 0;background:#fff;">People Listing</a></li><?php } 
                        }; 
                    ?>
                    <?php if (check_staff_permission('product_setting_read')){?><li class="<?php echo is_active_menu('products'); ?>"><a href="<?php echo base_url('admin/products'); ?>" class="list-group-item borne pasif" style="border-radius: 0;background:#fff;">Product Setting</a></li><?php } ?>
                    <?php if (check_staff_permission('system_setting_read')){?><li class="<?php echo is_active_menu('settings'); ?>"><a href="<?php echo base_url('admin/settings'); ?>" class="list-group-item borne pasif" style="border-radius: 0;background:#fff;">System Setting</a></li><?php } ?>
                    <?php if (check_staff_permission('master_system_read')){?><li class="<?php echo is_active_menu('systems'); ?>"><a href="<?php echo base_url('admin/systems'); ?>" class="list-group-item borne pasif" style="border-radius: 0;background:#fff;">Master System</a></li><?php } ?>
                </ul>
            </li>
        </ul>
    </div>
</div>