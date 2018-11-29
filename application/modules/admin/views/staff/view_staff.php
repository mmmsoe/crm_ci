<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6 clearPad-r" style="text-align: right;">
            <a href="<?php echo base_url('admin/staff/update/' . $staff->id); ?>" class="btn btn-primary btn-embossed"> Edit Staff</a>
        </div>              
    </div>	
    <div class="row">
        <div class="col-sm-12">
            <div class="panel widget-member2">
                <h3 class="pad-l clearMar-t">Staff Details Information</h3>
                <hr /><div class="clearfix"></div>
                <div class="row">
                    <div class="col-xs-12" style="text-align: center;">
                        <?php if ($staff->user_avatar) { ?>
                            <img src="<?php echo base_url('uploads/staffs') . '/' . $staff->user_avatar; ?>" alt="profil 4" style="height: auto;width:150px;">
                        <?php } else { ?>
                            <img src="<?php echo base_url(); ?>public/assets/global/images/avatars/avatar1_big.png" alt="user image" style="height: auto;width:auto">  
                        <?php } ?>
                        <h3 style="text-align:center; font-weight: bold"  class="mar-t clearMar-b">&nbsp;<?php echo $staff->first_name; ?> <?php echo $staff->last_name; ?></h3>
                    </div>
                    <div class="col-xs-12">
                        <hr /><div class="clearfix"></div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-sm-5 control-label"><i class="fa fa-phone"></i> &nbsp;Phone</label>
                                    <div class="col-sm-7 append-icon">					                                 
                                        <p class="pad-l">&nbsp;<?php echo $staff->phone_number; ?></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-5 control-label"><i class="fa fa-envelope"></i> &nbsp;Email</label>
                                    <div class="col-sm-7 append-icon">
                                        <p class="pad-l">&nbsp;<?php echo $staff->email; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>					
                </div>
            </div>
        </div><div class="clearfix"></div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="panel widget-member2">
                <div class="row">
                    <div class="panel-content">
                        <label class="control-label"><i class="fa fa-cubes"></i>Leads</label> 
                        <table class="table">
                            <thead>
                                <tr style="font-size: 12px;">                         
                                    <th>Lead Name</th>
                                    <th>Company</th>
                                </tr>
                            </thead>
                            <tbody id="InputsWrapper">
                                <?php if (!empty($leads)) { ?>
                                    <?php foreach ($leads as $lead) { ?> 
                                        <tr>
                                            <td><a href="<?php echo base_url('admin/leads/view/' . $lead->id); ?>"><?php echo $lead->lead_name; ?></a></td>
                                            <td><?php echo $lead->company_name; ?></td>
                                        </tr>	
                                    <?php } ?>
                                <?php } ?> 
                            </tbody>
                        </table>
                    </div>							
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="panel widget-member2">
                <div class="row">
                    <div class="panel-content">
                        <label class="control-label"><i class="fa fa-cubes"></i>Opportunity</label> 
                        <table class="table">
                            <thead>
                                <tr style="font-size: 12px;">                         
                                    <th>Opportunity</th>
                                    <th>Account Name</th>
                                </tr>
                            </thead>
                            <tbody id="InputsWrapper">
                                <?php if (!empty($opportunities)) { ?>
                                    <?php foreach ($opportunities as $opportunity) { ?> 
                                        <tr>
                                            <td><a href="<?php echo base_url('admin/opportunities/view/' . $opportunity->id); ?>"><?php echo $opportunity->opportunity; ?></a></td>
                                            <td><?php echo $this->customers_model->get_company($opportunity->customer_id)->name; ?></td>
                                        </tr>	
                                    <?php } ?>
                                <?php } ?> 
                            </tbody>
                        </table>
                    </div>							
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="panel widget-member2">
                <div class="row">
                    <div class="panel-content">
                        <label class="control-label"><i class="fa fa-cubes"></i>Sales Order</label> 
                        <table class="table">
                            <thead>
                                <tr style="font-size: 12px;">                         
                                    <th>Order Number</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="InputsWrapper">
                                <?php if (!empty($salesorders)) { ?>
                                    <?php foreach ($salesorders as $order) { ?> 
                                        <tr>
                                            <td><a href="<?php echo base_url('admin/salesorder/view/' . $order->id); ?>"><?php echo $order->quotations_number; ?></a></td>
                                            <td><?php echo $order->status; ?></td>
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

</div>   
<!-- END PAGE CONTENT -->

