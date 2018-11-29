<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6 clearPad-r" style="text-align: right;">
            <a href="<?php echo base_url('admin/contact_persons/update/' . $contact_person->id); ?>" class="btn btn-primary btn-embossed"> Edit Contact</a>
        </div>              
    </div>	
    <div class="row">
        <div class="col-sm-12">
            <div class="panel widget-member2">
                <h3 class="pad-l clearMar-t">Contact Details Information</h3>
                <hr /><div class="clearfix"></div>
                <div class="row">

                    <div class="col-xs-4" style="text-align: center;">
                        <?php if ($contact_person->customer_avatar) { ?>
                            <img src="<?php echo base_url('uploads/contacts') . '/' . $contact_person->customer_avatar; ?>" alt="profil 4" style="height: auto;width:150px;">
                        <?php } else { ?>
                            <img src="<?php echo base_url(); ?>public/assets/global/images/avatars/avatar1_big.png" alt="user image" style="height: auto;width:auto">  
                        <?php } ?>
                        <h3 style="text-align:center; font-weight: bold"  class="mar-t clearMar-b">&nbsp;<?php echo $contact_person->first_name; ?> <?php echo $contact_person->last_name; ?></h3>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i> &nbsp;Date Birth</label>
                                <div class="col-sm-9 append-icon">
                                    <?php if ($contact_person->date_birth != 0) { ?>
                                        <p class="pad-l">&nbsp;<?php echo date('m/d/Y', $contact_person->date_birth); ?></p>
                                    <?php } else { ?>
                                        <p class="pad-l">&nbsp;</p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group" style="margin-top: -5px;">
                                <label class="col-sm-3 control-label"><i class="fa fa-phone"></i> &nbsp;Phone</label>
                                <div class="col-sm-9 append-icon">					                                 
                                    <p class="pad-l">&nbsp;<?php echo $contact_person->phone; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group" style="margin-top: -5px;">
                                <label class="col-sm-3 control-label"><i class="fa fa-tablet"></i> &nbsp;Mobile</label>
                                <div class="col-sm-9 append-icon">					                                 
                                    <p class="pad-l">&nbsp;<?php echo $contact_person->mobile; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group" style="margin-top: -5px;">
                                <label class="col-sm-3 control-label"><i class="fa fa-envelope"></i> &nbsp;Email</label>
                                <div class="col-sm-9 append-icon">
                                    <p class="pad-l">&nbsp;<?php echo $contact_person->email; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group" style="margin-top: -5px;">
                                <label class="col-sm-3 control-label"><i class="fa fa-fax"></i> &nbsp;Fax</label>
                                <div class="col-sm-9 append-icon">					                                 
                                    <p class="pad-l">&nbsp;<?php echo $contact_person->fax; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group" style="margin-top: -5px;">
                                <label class="col-sm-3 control-label"><i class="fa fa-globe"></i> &nbsp;Website</label>
                                <div class="col-sm-9 append-icon">					                                 
                                    <?php /* <p class="pad-l">&nbsp;<?php echo $this->system_model->system_single_value('LEAD', $lead->lead_source_id)->system_value_txt; ?></p> */ ?>
                                    <p class="pad-l">&nbsp;<?php echo $contact_person->website; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group" style="margin-top: -5px;">
                                <label class="col-sm-3 control-label"><i class="fa fa-map-marker"></i> &nbsp;Address</label>
                                <div class="col-sm-9 append-icon">
                                    <p class="pad-l"><?php echo $contact_person->address; ?>
                                        <?php echo city_name($contact_person->city_id)->name; ?>
                                        <?php echo state_name($contact_person->state_id)->name; ?><?= (state_name($contact_person->state_id)->name != "" && country_name($contact_person->country_id)->name != "" ? ", " : '') ?><?php echo country_name($contact_person->country_id)->name; ?>
                                        <?php echo $contact_person->zip_code; ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="form-group" style="margin-top: -5px;">
                                <label class="col-sm-3 control-label"><i class="fa fa-map-marker"></i> &nbsp;Owner</label>
                                <div class="col-sm-9 append-icon">
                                    <p class="pad-l">
                                    <?php echo $this->system_model->system_single_value('ACC_OWNER', $contact_person->contact_owner)->system_value_txt; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12" >
                        <!--   <hr /><div class="clearfix"></div>
                         <div class="row">
                              <div class="col-sm-6">
                                  <div class="form-group">
                                      <label class="col-sm-5 control-label"><i class="fa fa-calendar"></i> &nbsp;Date Birth</label>
                                      <div class="col-sm-7 append-icon">
                        <?php if ($contact_person->date_birth != 0) { ?>
                                                  <p class="pad-l">&nbsp;<?php echo date('m/d/Y', $contact_person->date_birth); ?></p>
                        <?php } else { ?>
                                                  <p class="pad-l">&nbsp;</p>
                        <?php } ?>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-5 control-label"><i class="fa fa-phone"></i> &nbsp;Phone</label>
                                      <div class="col-sm-7 append-icon">					                                 
                                          <p class="pad-l">&nbsp;<?php echo $contact_person->phone; ?></p>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-5 control-label"><i class="fa fa-tablet"></i> &nbsp;Mobile</label>
                                      <div class="col-sm-7 append-icon">					                                 
                                          <p class="pad-l">&nbsp;<?php echo $contact_person->mobile; ?></p>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-5 control-label"><i class="fa fa-envelope"></i> &nbsp;Email</label>
                                      <div class="col-sm-7 append-icon">
                                          <p class="pad-l">&nbsp;<?php echo $contact_person->email; ?></p>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-sm-6">
                                  <div class="form-group">
                                      <label class="col-sm-5 control-label"><i class="fa fa-map-marker"></i> &nbsp;Address</label>
                                      <div class="col-sm-7 append-icon">
                                          <p class="pad-l">&nbsp;<?php //echo $contact_person->address;  ?></p>
                                          <p class="pad-l">&nbsp;<?php //echo city_name($contact_person->city_id)->name;  ?></p>
                                          <p class="pad-l">&nbsp;<?php //echo state_name($contact_person->state_id)->name;  ?><?= (state_name($contact_person->state_id)->name != "" && country_name($contact_person->country_id)->name != "" ? ", " : '') ?><?php echo country_name($contact_person->country_id)->name; ?></p>
                                          <p class="pad-l">&nbsp;<?php //echo $contact_person->zip_code;  ?></p>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-sm-6">
                                  <div class="form-group">
                                      <label class="col-sm-5 control-label"><i class="fa fa-fax"></i> &nbsp;Fax</label>
                                      <div class="col-sm-7 append-icon">					                                 
                                          <p class="pad-l">&nbsp;<?php echo $contact_person->fax; ?></p>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-5 control-label"><i class="fa fa-globe"></i> &nbsp;Website</label>
                                      <div class="col-sm-7 append-icon">					                                 
                        <?php /* <p class="pad-l">&nbsp;<?php echo $this->system_model->system_single_value('LEAD', $lead->lead_source_id)->system_value_txt; ?></p> */ ?>
                                          <p class="pad-l">&nbsp;<?php echo $contact_person->website; ?></p>
                                      </div>
                                  </div>
                              </div>
                          </div> -->
                        <div class="row">
                            <hr /><div class="clearfix"></div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-sm-5 control-label"><i class="fa fa-building"></i> &nbsp;Company</label>
                                    <div class="col-sm-7 append-icon">
                                        <p class="pad-l">&nbsp;<?php echo $this->customers_model->get_company($contact_person->company_id)->name; ?></p>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top: -32px;">
                                    <label class="col-sm-5 control-label"><i class="fa fa-briefcase"></i> &nbsp;Job Position</label>
                                    <div class="col-sm-7 append-icon">
                                        <p class="pad-l">&nbsp;<?php echo $contact_person->job_position; ?></p>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top: -32px;">
                                    <label class="col-sm-5 control-label"><i class="fa fa-user-plus"></i> &nbsp;Assistant</label>
                                    <div class="col-sm-7 append-icon">
                                        <p class="pad-l">&nbsp;<?php echo $contact_person->assistant; ?></p>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top: -32px;">
                                    <label class="col-sm-5 control-label"><i class="fa fa-phone"></i> &nbsp;Asst Phone</label>
                                    <div class="col-sm-7 append-icon">
                                        <p class="pad-l">&nbsp;<?php echo $contact_person->asst_phone; ?></p>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top: -32px;">
                                    <label class="col-sm-5 control-label"><i class="fa fa-building"></i> &nbsp;Previous Company</label>
                                    <div class="col-sm-7 append-icon">
                                        <p class="pad-l">&nbsp;<?php echo $this->customers_model->get_company($contact_person->prev_company_id)->name; ?></p>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top: -32px;">
                                    <label class="col-sm-5 control-label"><i class="fa fa-building-o"></i> &nbsp;Department</label>
                                    <div class="col-sm-7 append-icon">
                                        <p class="pad-l">&nbsp;<?php echo $contact_person->department; ?></p>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top: -32px;">
                                    <label class="col-sm-5 control-label"><i class="fa fa-files-o"></i> &nbsp;Reports to</label>
                                    <div class="col-sm-7 append-icon">
                                        <p class="pad-l">&nbsp;<?php echo $contact_person->reports_to; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-sm-5 control-label"><i class="fa fa-twitter"></i> &nbsp;Twitter</label>
                                    <div class="col-sm-7 append-icon">
                                        <p class="pad-l">&nbsp;<?= ($contact_person->twitter != "" ? '@' . $contact_person->twitter : '') ?></p>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top: -32px;">
                                    <label class="col-sm-5 control-label"><i class="fa fa-skype"></i> &nbsp;Skype Id</label>
                                    <div class="col-sm-7 append-icon">
                                        <p class="pad-l">&nbsp;<?php echo $contact_person->skype_id; ?></p>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top: -32px;">
                                    <label class="col-sm-5 control-label"><i class="fa fa-envelope"></i> &nbsp;Secondary Email</label>
                                    <div class="col-sm-7 append-icon">
                                        <p class="pad-l">&nbsp;<?php echo $contact_person->secondary_email; ?></p>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top: -32px;">
                                    <label class="col-sm-5 control-label"><i class="glyphicon glyphicon-pushpin"></i> &nbsp;Main Contact</label>
                                    <div class="col-sm-7 append-icon">
                                        <p class="pad-l">&nbsp;<?= ($contact_person->main_contact_person != 0 ? 'Yes' : 'No' ) ?></p>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top: -32px;">
                                    <label class="col-sm-5 control-label"><i class="glyphicon glyphicon-pushpin"></i> &nbsp;Email Opt Out</label>
                                    <div class="col-sm-7 append-icon">
                                        <p class="pad-l">&nbsp;<?= ($contact_person->email_opt_out != 0 ? 'Yes' : 'No' ) ?></p>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top: -32px;">
                                    <label class="col-sm-5 control-label"><i class="fa fa-clipboard"></i>Description</label>
                                    <div class="col-sm-7 append-icon">
                                        <p class="pad-l"><?php echo $contact_person->description; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>					
                </div>
            </div>
        </div><div class="clearfix"></div>
    </div>

    <!--div class="row">
            <div class="row">
                    
                    <div class="col-md-4">
                            <h3 class="m-t-30"><strong>CONTACT PERSON Calendar</strong></h3> 
                            <div class="widget widget_calendar bg-red">
                                    <div class="multidatepicker"></div>
                            </div>
                    </div>
            </div>
    </div-->
</div>   
<!-- END PAGE CONTENT -->

