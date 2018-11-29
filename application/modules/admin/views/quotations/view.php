<script src="<?php echo base_url(); ?>public/docxtemplater/node_modules/docxtemplater/build/docxtemplater.js"></script>
<script src="<?php echo base_url(); ?>public/docxtemplater/node_modules/docxtemplater/vendor/FileSaver.min.js"></script>
<script src="<?php echo base_url(); ?>public/docxtemplater/node_modules/docxtemplater/vendor/jszip-utils.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script>
    var print_data;
    var doc;
    var out;
    var loadFile = function (url, callback) {
        JSZipUtils.getBinaryContent(url, callback);
    }
    
    
    
    
    
    $(document).ready(function () {

        $.ajax({
            method: "POST",
            url: "<?php echo base_url('admin/quotations/print_doc'); ?>",
            data: {quotations_id: "<?php echo $this->uri->segment(4) ?>"},
            dataType: "json"
        }).done(function (msg) {
                    print_data = msg;
                    loadFile("<?php echo base_url(); ?>uploads/words/<?php echo $template ?>", function (err, content) {
                    if (err) {
                        throw e
                    }
                    ;

                    doc = new Docxtemplater(content);
                    doc.setData(print_data);
                    doc.render()
                    out = doc.getZip().generate({type: "blob"})
                    //saveAs(out, print_data.page.quotations_number+".docx")
                });
       });


        $("form[name='send_quotation']").submit(function (e) {

            var formData = new FormData($(this)[0]);
            $.ajax({
                url: "<?php echo base_url('admin/quotations/send_quotation'); ?>",
                type: "POST",
                data: formData,
                async: false,
                success: function (msg) {
                    $('body,html').animate({scrollTop: 0}, 200);
                    $("#quotation_ajax").html(msg);
                    $("#quotation_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');

                    //$("form[name='send_quotation']").find("input[type=text]").val("");


                },
                cache: false,
                contentType: false,
                processData: false
            });

            e.preventDefault();
        });
    });

function print_doc()
    {
        saveAs(out, print_data.page.quotations_number+".docx");
    }

    /*
     var loadFile = function (url, callback) {
     JSZipUtils.getBinaryContent(url, callback);
     }
     */
    /*function print_doc()
     {
     
     loadFile("<?php echo base_url(); ?>uploads/words/<?php echo $template ?>", function (err, content) {
     if (err) {
     throw e
     }
     ;
     
     doc = new Docxtemplater(content);
     doc.setData(print_data);
     doc.render()
     out = doc.getZip().generate({type: "blob"})
     saveAs(out, print_data.page.quotations_number+".docx")
     });
     }
     */
    function create_pdf(quotation_id)
    {

        $.ajax({
            type: "GET",
            url: "<?php echo base_url('admin/quotations/ajax_create_pdf'); ?>/" + quotation_id,
            success: function (msg)
            {
                if (msg != '')
                {

                    $("#pdf_url").attr("href", msg)

                    var index = msg.lastIndexOf("/") + 1;
                    var filename = msg.substr(index);
                    $("#pdf_url").html(filename);

                    $("#quotation_pdf").val(filename);

                }

            }

        });


    }
    function create_pdf(quotation_id)
    {

        $.ajax({
            type: "GET",
            url: "<?php echo base_url('admin/quotations/ajax_create_pdf'); ?>/" + quotation_id,
            success: function (msg)
            {
                if (msg != '')
                {

                    $("#pdf_url").attr("href", msg)

                    var index = msg.lastIndexOf("/") + 1;
                    var filename = msg.substr(index);
                    $("#pdf_url").html(filename);

                    $("#quotation_pdf").val(filename);

                }

            }

        });


    }

</script>
<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="row">
        <h2 class="col-md-6"><strong>Quotation <?php echo $quotation->quotations_number; ?></strong></h2> 
        <div style="float:right; padding-top:10px;">
            <?php
            $expiration_date = $quotation->exp_date;
            $today = strtotime(date('m/d/Y'));
            if ($expiration_date < $today) {
                ?>
                <button type="button" class="btn btn-danger">Expired</button>
            <?php } ?>

            <?php if (check_staff_permission('quotations_write')) { ?>
                <!--a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal-send_by_email" onclick="create_pdf(<?php echo $quotation->id; ?>)">Send by Email</a-->
                <a href="#" onClick="print_doc()" class="btn btn-embossed btn-success" target="">Print Words</a>
                <a href="<?php echo base_url('admin/quotations/print_quot/' . $quotation->id); ?>" class="btn btn-embossed btn-success" target="">Print</a>
                <?php if ($quotation->status == "Draft Quotation") { ?>
                    <?php if ($quotation->quot_or_order == "q"): ?>
                        <a href="<?php echo base_url('admin/quotations/confirm_sale/' . $quotation->id); ?>" class="btn btn-embossed btn-warning" target="">Confirm Sale</a>

                        <a href="<?php echo base_url('admin/quotations/update/' . $quotation->id); ?>" class="btn btn-embossed btn-primary">Edit</a>
                    <?php endif; ?>
                <?php } ?>
            <?php } ?>

        </div>                
    </div>
    <div class="row">

        <div class="panel">

            <div class="panel-content">


                <div class="row">
                    &nbsp;	   
                </div>
                <div class="row">
                    <input type="hidden" name="opportunity_id" value="<?php echo $quotation->customer_id ?>" >
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><i class="fa fa-user"></i>Customer</label>
                                    <div class="col-sm-8 append-icon">  
                                        <?php echo customer_name($quotation->customer_id)->name; ?><br/>
                                        <?php echo $this->customers_model->get_company($quotation->customer_id)->address; ?>     
                                    </div>

                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><i class="fa fa-calendar"></i>Date</label>
                                    <div class="col-sm-8 append-icon">
                                        <?php echo date('m/d/Y H:i', $quotation->date); ?> 
                                    </div>

                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><i class="fa fa-calendar"></i>Expiration Date</label>
                                    <div class="col-sm-8 append-icon">
                                        <?php echo date('m/d/Y', $quotation->exp_date); ?> 
                                    </div>

                                </div>
                            </div>
                        </div> 	
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><i class="fa fa-user-plus"></i>Salesperson</label>
                                    <div class="col-sm-8 append-icon">
                                        <?php echo $this->staff_model->get_user_fullname($quotation->sales_person); ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><i class="fa fa-users"></i>Sales Team</label>
                                    <div class="col-sm-8 append-icon">
                                        <?php echo $this->salesteams_model->get_salesteam($quotation->sales_team_id)->salesteam; ?>
                                    </div>

                                </div>
                            </div>
                        </div>	  

                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><i class="fa fa-expand"></i>Payment Term</label>
                                    <div class="col-sm-8 append-icon">
                                        <?php
                                        if ($quotation->payment_term == 0) {
                                            echo 'Immediate Payment';
                                        } else {
                                            echo $quotation->payment_term . ' Days';
                                        }
                                        ?>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><i class="fa fa-plus-square"></i>Status</label>
                                    <div class="col-sm-8 append-icon">
                                        <?php echo $quotation->status; ?>   

                                    </div>

                                </div>
                            </div>
                        </div>	 

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><i class="fa fa-plus-square"></i>FIle</label>
                                    <div class="col-sm-8 append-icon"> 
                                        <?php if ($quotation->file_quotation != "") { ?>
                                            <a href="<?php echo base_url('uploads/contacts/'.$quotation->file_quotation); ?>" target="_blank"> 
                                            <img class='preview' src="<?php echo base_url('uploads/contacts/'.$quotation->file_quotation); ?>" style="width: auto; height: 100px;"/>
                                            </a>
                                        <?php } ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>    

                <div class="row">

                    <div class="panel-content">
                        <label class="control-label"><i class="fa fa-cubes"></i>Order</label> 
                        <table class="table">
                            <thead>
                                <tr style="font-size: 12px;">                         
                                    <th style='text-align:center;width:50px'>S/N</th>
                                    <th>Product & Description</th>
                                    <th style='text-align:center'>QTY</th>
                                    <th style='text-align:center'>UOM</th>
                                    <th style='text-align:center'>Unit Price</th>
                                    <th style='text-align:center'>Disc(%)</th>
                                    <th style='text-align:center'>Taxes</th>
                                    <th style='text-align:center'>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="InputsWrapper">
                                <?php
                                if (!empty($qo_products)) {
                                    $no = 0;
                                    ?>
                                    <?php
                                    foreach ($qo_products as $qo_product) {
                                        $no++;
                                        ?> 
                                        <?php
                                        $total_uom = $this->products_model->get_products($qo_product->product_id)->total_uom;
                                        // $uom_id = $this->products_model->get_products($qo_product->product_id)->uom_id;
                                        $uom = $this->system_model->system_single_value('UOM', $qo_product->uom_id)->system_value_txt;
                                        ?>
                                        <tr>
                                            <td style='text-align:center'><?php echo $no; ?></td>
                                            <td><b><?php echo $qo_product->product_name; ?></b><br><pre style= "border: medium none; background: none; padding: 0px; margin: 0px;"><?php echo $qo_product->discription; ?></pre></td>
                                            <td style='text-align:center'><?php echo $qo_product->quantity; ?></td>
                                            <td style='text-align:center'><?php echo $uom ?></td>
                                            <td class="numeric"><?php echo number_format($qo_product->price, 2, '.', ','); ?></td>
                                            <td class="numeric"><?php echo $qo_product->product_discount; ?></td>
                                            <td class="numeric"><?php echo number_format($qo_product->quantity * $qo_product->price * $this->products_model->get_products($qo_product->product_id)->tax / 100, 2, '.', ','); ?></td>

                                            <td class="numeric"><?php echo number_format($qo_product->sub_total, 2, '.', ','); ?></td>

                                        </tr>	

                                    <?php } ?>
                                <?php } ?> 

                            </tbody>
                        </table>

                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><i class="fa fa-clipboard"></i>Terms and Conditions</label>
                                    <div class="col-sm-8 append-icon">
                                        <?php echo $quotation->terms_and_conditions; ?>      

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Untaxed Amount </label>
                                    <div class="col-sm-6 append-icon numeric">
                                        <?php echo number_format($quotation->total, 2, '.', ','); ?> 

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Discount</label>
                                    <div class="col-sm-6 append-icon numeric">
                                        <?php echo number_format($quotation->discount, 2, '.', ','); ?> 

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Taxes </label>
                                    <div class="col-sm-6 append-icon numeric">
                                        <?php echo number_format($quotation->tax_amount, 2, '.', ','); ?> 

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Total </label>
                                    <div class="col-sm-6 append-icon numeric">
                                        <?php echo number_format($quotation->grand_total, 2, '.', ','); ?> 

                                    </div>

                                </div>
                            </div>
                        </div>	
                    </div>
                </div>       
                <div class="row">
                    &nbsp;	   
                </div>            

            </div>
        </div>

    </div>

</div>   
<!-- END PAGE CONTENT -->


<!-- START MODAL PRODUCT CONTENT -->
<div class="modal fade" id="modal-send_by_email" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                <h4 class="modal-title"><strong>Send </strong>by Email</h4>
            </div>
            <div id="quotation_ajax" style="text-align:center;
                 "> 
                     <?php
                     if ($this->session->flashdata('message')) {
                         echo $this->session->flashdata('message');
                     }
                     ?>         
            </div>

            <div class="modal-body">
                <form id="send_quotation" name="send_quotation" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="quotation_id" id="quotation_id" value="<?php echo $quotation->id; ?>" class="form-control">    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="field-1" class="control-label">Subject</label> 
                                <input type="text" name="email_subject" id="email_subject" value="Demo Company Order (Ref <?php echo $quotation->quotations_number; ?>)" class="form-control"> 

                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="field-1" class="control-label">Recipients</label> 
                                <select name="recipients[]" id="recipients" class="form-control" data-search="true" multiple>
                                    <option value=""></option>
                                    <?php foreach ($companies as $company) { ?>
                                        <option value="<?php echo $company->email; ?>" <?php if ($quotation->customer_id == $company->id) { ?>selected<?php } ?>><?php echo $company->name . " (" . $company->email . ")"; ?></option>

                                    <?php } ?> 

                                </select>

                            </div>
                        </div>


                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="field-1" class="control-label"></label>

                                <textarea name="message_body" id="message_body" cols="80" rows="10" class="cke-editor">
                       	
                       	<p>Hello <?php echo customer_name($quotation->customer_id)->name; ?>,</p>

    <p>Here is your order confirmation from Demo Company: </p>

    <p style="border-left: 1px solid #8e0000; margin-left: 30px;">
       &nbsp;&nbsp;<strong>REFERENCES</strong><br>
       &nbsp;&nbsp;Order number: <strong><?php echo $quotation->quotations_number; ?></strong><br>
       &nbsp;&nbsp;Order total: <strong><?php echo $quotation->grand_total; ?></strong><br>
       &nbsp;&nbsp;Order date: <?php echo date('m/d/Y H:i', $quotation->date); ?> <br>
       
    </p>
                       	
                                </textarea>	 

                            </div>
                        </div>

                    </div>	

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="field-1" class="control-label">File</label> 
                                <a href="" id="pdf_url" target="_blank"></a>
                                <input type="hidden" name="quotation_pdf" id="quotation_pdf" value="" class="form-control">
                            </div>
                        </div>


                    </div> 
                    <div class="modal-footer text-center"> 
                        <div id="quotation_submitbutton"><button type="submit" class="btn btn-embossed btn-primary">Save</button></div>
                    </div>
                </form> 

            </div>





        </div>
    </div>
</div>
