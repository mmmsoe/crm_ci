<div class="page-content">
    <div class="row">
        <div>
            <a style="float:right;" href="<?php echo base_url('admin/mailbox'); ?>" class="btn btn-primary btn-embossed"> Create New</a>
            <a href="<?php echo base_url('admin/mail_entry'); ?>" class="btn btn-black btn-embossed"> E-Mail</a>
            <?php if (check_staff_permission('meetings_read')) { ?> <a href="<?php echo base_url('admin/meetings'); ?>" class="btn btn-gray btn-embossed"> Meetings</a><?php } ?>
            <?php if (check_staff_permission('logged_calls_read')) { ?><a href="<?php echo base_url('admin/logged_calls'); ?>" class="btn btn-gray btn-embossed"> Logged Calls</a><?php } ?>
            

        </div>           
    </div>

    <div class="row">
        <div class="panel">																				<div class="panel-content">

                <div class="panel-content pagination2 table-responsive">

                    <table class="table table-hover table-dynamic ">
                        <thead>
                            <tr>                        
                                <th>Subject</th>
                                <th>Date Update</th>
                                <th>Company Name</th>
                                <th>Entered By</th> 
                            </tr>
                        </thead>
                        <tbody>

                            <?php if (!empty($mail_entry)) { ?>
                                <?php foreach ($mail_entry as $m) { ?>
                                    <tr id="mail_entry_id_<?php echo $mail_entry->id; ?>">
                                        <td><?php echo $m->subject; ?></td>
                                        <td><?php echo date('m/d/Y H:i', $m->created_dt); ?></td>         
                                        <td><?php echo $m->company_name; ?></td>         
                                        <td><?php echo $m->entered_by; ?></td>         
                                    </tr>
                            <?php } ?>
                        <?php } ?> 


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- END PAGE CONTENT -->
