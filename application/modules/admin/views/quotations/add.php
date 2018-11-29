<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>

    $(document).ready(function () {
        $('#radioBtn a').on('click', function () {
            var sel = $(this).data('title');
            var tog = $(this).data('toggle');
            $('#' + tog).prop('value', sel);

            $('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('btn-primary').addClass('btn-default');
            $('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('btn-default').addClass('btn-primary');
        });

        $('#date').change(function () {
            console.log($('#date').val());
            $.ajax({
                url: "<?php echo base_url('admin/quotations/get_ajax_expired'); ?>",
                type: "POST",
                data: {
                    date: $('#date').val()
                },
                async: false,
                success: function (msg) {
                    var data = msg.replace(/\-/g, "/");
                    var dt = data.replace(/\"/g, '')
                    $("#expiration_date").val(dt);
                }
            });
        });

        $("form[name='add_quotation']").submit(function (e) {
            update_total_price();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: "<?php echo base_url('admin/quotations/add_process'); ?>",
                type: "POST",
                data: formData,
                async: false,
                success: function (msg) {

                    var str = msg.split("_");
                    var id = str[1];
                    var status = str[0];

                    if (status == "yes")
                    {
                        $('body,html').animate({scrollTop: 0}, 200);
                        $("#quotation_ajax").html('<?php echo '<div class="alert alert-success">' . $this->lang->line('create_succesful') . '</div>' ?>');
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url('admin/quotations/view'); ?>/" + id;
                        }, 800); //will call the function after 2 secs.
                    } else
                    {

                        $('body,html').animate({scrollTop: 0}, 200);
                        $("#quotation_ajax").html(msg);
                        $("#quotation_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');

                        //$('.remove_tr').remove(); //remove tr

                        //$("form[name='add_quotation']").find("input[type=text]").val("");
                    }

                },
                cache: false,
                contentType: false,
                processData: false
            });

            e.preventDefault();
        });
    });


</script>
<script>

    function product_price_changes(quantity, product_price, sub_total_id, tax, no_tax, disc)
    {

        var no_quantity = $("#" + quantity).val();
        var res = disc.split("_");
        var price = $("#product_price" + res[1]).val();
        var sub_total = parseInt(no_quantity * price);

        // if(disc){
        var no_disc = $("#" + disc).val();
        var discount = parseInt((no_quantity * price * no_disc) / 100);
        $("#discount" + res[1]).val(discount);
        var sub_disc = 0;
        $('input[name^="discount"]').each(function () {
            sub_disc += parseFloat($(this).val());
        });
        $('#total_discount').val(sub_disc.toFixed(2));
        // }
        var amount = sub_total - discount;
        var tax_amount = 0;
        tax_amount = (amount * tax) / 100;
        $('#' + no_tax).val(tax_amount.toFixed(2));

        $('#' + sub_total_id).val(amount.toFixed(2));

    }

    function update_total_price()
    {
        var sub_total = 0;
        $('input[name^="sub_total"]').each(function () {
            sub_total += parseFloat($(this).val());
            $('#total').val(sub_total.toFixed(2));

            var tax_per =<?php echo config('sales_tax'); ?>;
            var tax_amount = 0;
            var discount = 0;

            // tax_amount = (sub_total*tax_per) / 100;
            $('input[name^="taxes"]').each(function () {
                tax_amount += parseFloat($(this).val());
            });
            $('#tax_amount').val(tax_amount.toFixed(2));

            var sub_disc = 0;
            $('input[name^="discount"]').each(function () {
                sub_disc += parseFloat($(this).val());
            });
            $('#total_discount').val(sub_disc.toFixed(2));

            var grand_total = 0;
            grand_total = sub_total + tax_amount;
            $('#grand_total').val(grand_total.toFixed(2));
        });

    }

    function product_value()
    {
        var all_Val = $("#product_list").val();
        var res = all_Val.split("_");

        $('#product_id').val(res[0]);
        $('#product_name1').val(res[1]);
        $('#unit_price').val(res[2]);
        $('#pdescription').val(res[3]);
        $('#product_tax').val(res[4]);
        $('#total_uom').val(res[5]);
        $('#uom_id').val(res[6]);
        var edit_save = document.getElementById("edit-save");
        edit_save.src = '<?php echo base_url("uploads/products") . "/"; ?>' + res[7];
        $('#uom option[value=' + res[6] + ']').prop("selected", true).trigger('change');
    }

    $(document).ready(function () {

        var MaxInputs = 50; //maximum input boxes allowed
        var InputsWrapper = $("#InputsWrapper"); //Input boxes wrapper ID
        var AddButton = $("#AddMoreFileBox"); //Add button ID

        var x = InputsWrapper.length; //initlal text box count
        var FieldCount = 1 + <?php echo count($qtemplate_products); ?>; //to keep track of text box added


        //$("#total").val("0");

        $(AddButton).click(function (e)  //on add input button click
        {
            var product_id = $("#product_id").val();

            if (product_id == '')
            {
                $("#call_ajax").html('<div class="alert alert-danger">Select Product</div>');
                return false;
            } else {


                var new_product_price = getProducts_Price(product_id);
                var product_name = $("#product_name1").val();
                var product_quantity = $("#product_quantity").val();
                var product_price = $("#unit_price").val();
                if (new_product_price !== "")
                {
                    product_price = parseFloat(new_product_price).toFixed(2);
                } else
                {
                    product_price = parseFloat(product_price).toFixed(2);
                }

                var description = $("#pdescription").val();
                var tax_rat = $("#product_tax").val();
                var total_uom = $("#total_uom").val();
                var uom_id = $("#uom_id").val();
                console.log(uom_id);

                var sub_total = parseFloat(product_quantity * product_price).toFixed(2);
                var tax_sub = 0;
                tax_sub = parseFloat((product_quantity * product_price * tax_rat) / 100).toFixed(2);
                var main_total = $("#total").val();
                var main_tax_amount = 0;
                main_tax_amount = $("#tax_amount").val();
                var main_disc = 0;
                main_disc = $("#total_discount").val();


                if (x <= MaxInputs) //max input box allowed
                {
                    FieldCount++; //text box added increment

                    $(InputsWrapper).append('<tr class="remove_tr"><td><input type="hidden" name="p_id[]" id="p_id" value="' + product_id + '" readOnly><input type="hidden" name="tax[]" id="tax" value="' + tax_rat + '" readOnly><input type="text" name="product_name[]" id="product_name" value="' + product_name + '" class="form-control"></td><td><textarea name="description[]" id="description" rows="2" class="form-control">' + description + '</textarea></td><td><input type="text" name="quantity[]" id="quantity' + FieldCount + '" value="' + product_quantity + '" class="form-control numeric" onchange="product_price_changes(\'quantity' + FieldCount + '\',' + product_price + ',\'sub_total' + FieldCount + '\',' + tax_rat + ',\'taxes' + FieldCount + '\',\'disc_' + FieldCount + '\');"></td><td><select name="uom_quot[]" id="uom_quot' + FieldCount + '" class="form-control full" data-search="true" ><option value=""></option><?php foreach ($uoms as $uom) { ?><?php if ($uom->system_code !== '00') { ?><option value="<?php echo $uom->system_code; ?>"><?php echo $uom->system_value_txt; ?></option><?php } ?><?php } ?></select></td><td><input type="text" name="product_price[]" id="product_price' + FieldCount + '" value="' + product_price + '" class="form-control numeric" onchange="product_price_changes(\'quantity' + FieldCount + '\',' + product_price + ',\'sub_total' + FieldCount + '\',' + tax_rat + ',\'taxes' + FieldCount + '\',\'disc_' + FieldCount + '\');"></td><td><input type="text" name="disc[]" id="disc_' + FieldCount + '" value="0" maxlength="3" class="form-control numeric" onchange="product_price_changes(\'quantity' + FieldCount + '\',' + product_price + ',\'sub_total' + FieldCount + '\',' + tax_rat + ',\'taxes' + FieldCount + '\',\'disc_' + FieldCount + '\');"><input type="hidden" name="discount[]" id="discount' + FieldCount + '" value="0" class="form-control numeric"></td><td><input type="text" name="taxes[]" id="taxes' + FieldCount + '" value="' + tax_sub + '" class="form-control numeric" readOnly></td><td><input type="text" name="sub_total[]" id="sub_total' + FieldCount + '" value="' + sub_total + '" class="form-control numeric" readOnly></td><td><a href="javascript:void(0)" class="delete btn btn-sm btn-danger removeclass" data-toggle="modal" data-target="#modal-basic"><i class="icons-office-52"></i></a></td></tr>');

                    $('#uom_quot' + FieldCount + ' option[value=' + uom_id + ']').prop('selected', true);
                    x++; //text box increment
                }
                //Total price count 
                var total1 = parseInt(sub_total) + parseInt(main_total);
                $('#total').val(total1.toFixed(2));

                var tax_amount = 0;
                tax_amount = parseInt(tax_sub) + parseInt(main_tax_amount);
                $('#tax_amount').val(tax_amount.toFixed(2));

                var sub_disc = 0;
                $('input[name^="discount"]').each(function () {
                    sub_disc += parseFloat($(this).val());
                });
                var total_disc = 0;
                total_disc = parseInt(sub_disc) + parseInt(main_disc);
                $('#total_discount').val(total_disc.toFixed(2));

                var grand_total = 0;
                grand_total = parseInt(total1) + parseInt(tax_amount) - parseInt(total_disc);
                $('#grand_total').val(grand_total.toFixed(2));

                $("#call_ajax").html('<div class="alert alert-success">Added Successful</div>');

                return false;
            }
        });



        $("body").on("click", ".removeclass", function (e) { //user click on remove text
            if (x > 1) {
                $(this).parent().parent().remove(); //remove text box
                x--; //decrement textbox
            }
            return false;
        })

    });

    /*$(document).on('focus',".date-picker", function(){
     $(this).datepicker();
     }); */


//Delete products

    function delete_product(product_id)
    {

        $.ajax({
            type: "GET",
            url: "<?php echo base_url('admin/qtemplates/delete_product'); ?>/" + product_id,
            success: function (msg)
            {
                if (msg != '')
                {
                    $('#qo_product_id_' + product_id).remove();
                    $('#total').val(msg.toFixed(2));
                }

            }

        });


    }

//Get quotation templates products
    function getQtemplatesProducts(id)
    {
        //alert('this id value :'+id);
        var pricelist_id = document.getElementById("pricelist_id").value;
        //alert(pricelist_id);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/quotations/ajax_qtemplates_products') . '/'; ?>' + id + '/' + pricelist_id,
            //data: id='qt_id',
            success: function (data) {
                //alert(data);
                $("#InputsWrapper").html(data);
                update_total_price();
            },
        });

        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/quotations/ajax_get_quotation_template_duration') . '/'; ?>' + id,
            success: function (data1) {

                //$("#expiration_date").val(data1);
            },
        });

    }

//Get quotation templates products
    function getPricelistProducts(id)
    {
        //alert('this id value :'+id);
        var qtemplate_id = document.getElementById("quotation_template").value;

        if (qtemplate_id != "")
        {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url('admin/quotations/ajax_qtemplates_products') . '/'; ?>' + qtemplate_id + '/' + id,
                data: id = 'qt_id',
                success: function (data) {
                    //alert(data);
                    $("#InputsWrapper").html(data);
                    update_total_price();
                },
            });
        }
    }

    function getProducts_Price(id)
    {
        var pricelist_id = document.getElementById("pricelist_id").value;
        var result = "";
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/quotations/ajax_get_products_price') . '/'; ?>' + id + '/' + pricelist_id,
            async: false,
            data: id = 'p_id',
            success: function (data) {
                result = data;
            }
        });
        return result;
    }
    function getsalesdetails(id)
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/salesteams/ajax_sales_team_list') . '/'; ?>' + id,
            // data: id='cat_id',
            success: function (data) {
                $("#load_sales").html(data);
                //$("#load_city").html('');
                $('#loader').slideUp(200, function () {
                    $(this).remove();
                });
                $('select').select2();
            },
        });
    }

//get contact details in company
    function getcontactdetails(id)
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/quotations/ajax_contact_list') . '/'; ?>' + id,
            // data: id='cat_id',
            success: function (data) {
                $("#load_contacts").html(data);
                //$("#load_city").html('');
                $('#loader').slideUp(200, function () {
                    $(this).remove();
                });
                $('select').select2();
            },
        });
    }


    $(function () {
        //getQtemplatesProducts(id); //this calls it on load
        var id = document.getElementById("quotation_template").value;
        if (id !== '')
        {
            $("select#quotation_template").change(getQtemplatesProducts(id));
        }

    });

</script>
<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="header">
        <h2><strong>Add Quotation</strong></h2>            
    </div>
    <div class="row">

        <div class="panel">

            <div class="panel-content">
                <div class="row">
                    &nbsp;	   
                </div>
                <div id="quotation_ajax"> 
                    <?php
                    if ($this->session->flashdata('message')) {
                        echo $this->session->flashdata('message');
                    }
                    ?>         
                </div>

                <form id="add_quotation" name="add_quotation" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" style="color:red;">* Customer</label>
                                <div class="form-group">
                                    <select name="customer_id" id="customer_id" class="form-control" data-search="true" onChange="getcontactdetails(this.value)">
                                        <option value="" selected="selected">Choose Customer</option>
                                        <?php foreach ($companies as $company) { ?>
                                            <option value="<?php echo $company->id; ?>"><?php echo $company->name; ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>
                            <!--div class="form-group">
                              <label class="control-label" style="color:red;">* Customer</label>
                              <div class="append-icon">
                                
                                 <select name="customer_id" class="form-control" data-search="true" onChange="getcontactdetails(this.value)">
                                <option value="">Choose</option>
                            <?php //foreach( $companies as $company){  ?>
                                <option value="<?php //echo $company->id;   ?>"><?php //echo $company->name;   ?></option>
                            <?php //} ?> 
                                </select>
                                 
                              </div>
                            </div-->
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" style="color:red;">* Sales Owner</label>
                                <div class="form-group">
                                    <?php
                                    $salesteam_id;
                                    foreach ($salesteams_user as $sales_user) {
                                        $salesteam_id = $sales_user[id];
                                    }
                                    ?>
                                    <div class="form-group col-xs-4 clearPad-lr clearRad-r-box">
                                        <select name="sales_team_id" id="sales_team_id" class="form-control full" data-search="true" onChange="getsalesdetails(this.value)">
                                            <option value="" selected="selected">Choose Team</option>
                                            <?php foreach ($salesteams as $salesteam) { ?>
                                                <?php if ($salesteams_user->id == $salesteam->id) { ?>
                                                    <option value="<?php echo $salesteam->id; ?>" selected><?php echo $salesteam->salesteam; ?></option>
                                                    <script>
                                                        $(document).ready(function () {
                                                            getsalesdetails($("#sales_team_id").val());
                                                        });
                                                    </script>
                                                <?php } else { ?>
                                                    <option value="<?php echo $salesteam->id; ?>" <?php if ($lead->sales_team_id == $salesteam->id) { ?> selected="selected"<?php } ?>><?php echo $salesteam->salesteam; ?></option>
                                                <?php } ?> 
                                            <?php } ?> 
                                        </select>
                                    </div>
                                    <div class="form-group col-xs-8 clearPad-lr bord-l clearRad-l-box" id="load_sales">
                                        <select name="salesperson_id" id="salesperson_id" class="form-control full clearRad-r" data-search="true">
                                            <option value="" selected="selected">Choose Sales</option>
                                            <?php foreach ($staffs as $staff) { ?>
                                                <option value="<?php echo $staff->id; ?>" <?php if ($lead->salesperson_id == $staff->id) { ?> selected="selected"<?php } ?>><?php echo $staff->first_name . ' ' . $staff->last_name; ?></option>
                                            <?php } ?> 
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6" style="display:none;">
                            <div class="form-group">
                                <label class="control-label">Quotation Template</label>
                                <div class="append-icon">

                                    <select name="quotation_template" id="quotation_template" class="form-control" data-search="true" onChange="getQtemplatesProducts(this.value)">

                                        <?php foreach ($qtemplates as $qtemplate) { ?>
                                            <option value="<?php echo $qtemplate->id; ?>" <?php if ($qtemplate->id == 2) { ?>selected<?php } ?>><?php echo $qtemplate->quotation_template; ?></option>
                                        <?php } ?> 
                                    </select>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" style="color:red;">* Contact</label>
                                <div class="form-group" id="load_contacts">
                                    <select name="contact_id" id="contact_id" class="form-control" data-search="true">
                                        <option value="" selected="selected">Choose Contact</option>
                                        <?php foreach ($contact_persons as $contact_person) { ?>
                                            <option value="<?php echo $contact_person->id; ?>" <?php if ($contact_person->main_contact_person == '1') { ?> selected <?php } ?>><?php echo $contact_person->first_name . " " . $contact_person->last_name; ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" style="color:red;">* Payment Term</label>
                                <div class="append-icon">	 
                                    <select name="payment_term" class="form-control">
                                        <option value=""></option>
                                        <option value="<?php echo config('payment_term1'); ?>"><?php echo config('payment_term1'); ?> Days</option>
                                        <?php if (config('payment_term2') != '0') { ?>
                                            <option value="<?php echo config('payment_term2'); ?>"><?php echo config('payment_term2'); ?> Days</option>
                                        <?php } ?>	

                                        <?php if (config('payment_term3') != '0') { ?>	
                                            <option value="<?php echo config('payment_term3'); ?>"><?php echo config('payment_term3'); ?> Days</option>
                                        <?php } ?>										
                                        <!--<option value="30% Advance End 30 Days">30% Advance End 30 Days</option>
<option value="30 Days End of Month">30 Days End of Month</option>
<option value="30 Net Days">30 Net Days</option>-->
                                        <option value="0">Immediate Payment</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Date</label>
                                <div class="append-icon">
                                    <input type="text" name="date" id="date" class="datetimepicker form-control"  placeholder="Choose a date...">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Status</label>
                                <div class="append-icon">	 
                                    <select name="status" class="form-control"> 
                                        <option value="Draft Quotation">Draft Quotation</option>
                                        <option value="Quotation Sent">Quotation Sent</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6" style="display:none;">
                            <div class="form-group">
                                <label class="control-label">Pricelist</label>
                                <div class="append-icon">

                                    <select name="pricelist_id" id="pricelist_id" class="form-control" data-search="true"  onChange="getPricelistProducts(this.value)">
                                        <option value=""></option>
                                        <?php foreach ($pricelists as $pricelist) { ?>
                                            <option value="<?php echo $pricelist->id; ?>"><?php echo $pricelist->pricelist_name . ' (' . $pricelist->pricelist_currency . ')'; ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Expiration Date</label>
                                <div class="append-icon">
                                    <input type="text" name="expiration_date" id="expiration_date" class="datetimepicker form-control"  placeholder="Choose a date...">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Archive</label>
                                <div class="input-group">
                                    <div id="radioBtn" class="btn-group">
                                        <a class="btn btn-default btn-sm" data-toggle="archive" data-title="1">YES</a>
                                        <a class="btn btn-primary btn-sm" data-toggle="archive" data-title="0">NO</a>
                                    </div>
                                    <input type="hidden" name="archive" id="archive" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">

                        </div>

                    </div>
                    <!--
                    <div class="row">

                            
                    </div>
                    -->
                    <div class="row">

                        <div class="panel-content">
                            <label class="control-label">Order</label> 
                            <table class="table">
                                <thead>
                                    <tr style="font-size: 12px;">                         
                                        <th>Product</th>
                                        <th>Description</th>
                                        <th style="width:80px;text-align:center">QTY</th>
                                        <th style="width:100px;text-align:center">UOM</th>
                                        <th style="text-align:center">Unit Price</th>
                                        <th style="width:80px;text-align:center">Disc(%)</th>
                                        <th style="text-align:center">Taxes</th>
                                        <th >Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="InputsWrapper">


                                </tbody>
                            </table>
                            <button type="button" class="btn btn-embossed btn-dark" data-toggle="modal" data-target="#modal-create_product">Add a product</a>
                        </div>

                    </div>   
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Terms and Conditions</label>
                                <div class="append-icon">

                                    <textarea name="terms_and_conditions" rows="4" class="form-control height-row-2"></textarea> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">File</label>
                                <div class="append-icon">
                                    <input type="file" name="file_quotation" id="file_quotation" class="form-control height-row-2" onchange="openFile(event, 0)">
                                    <img class='preview' src="" style="width: auto; height: 100px;"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Untaxed Amount</label>
                                <div class="append-icon">

                                    <input type="text" name="total" id="total" value="0" class="form-control numeric" readonly/> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Discount</label>
                                <div class="append-icon">

                                    <input type="text" name="total_discount" id="total_discount" value="0" class="form-control numeric" readonly/> 
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-6">

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Taxes</label>
                                <div class="append-icon">

                                    <input type="text" name="tax_amount" id="tax_amount" value="0" class="form-control numeric" readonly/> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Total (<a href="javascript:void(0);" id="update_total" onclick="update_total_price();"><b>Update</b></a>)</label>
                                <div class="append-icon">

                                    <input type="text" name="grand_total" id="grand_total" value="0" class="form-control numeric" readonly/> 
                                </div>
                            </div>
                        </div>

                    </div>     

                    <div class="text-left  m-t-20">
                        <div id="quotation_submitbutton"><button type="submit" class="btn btn-embossed btn-primary">Create</button></div>

                    </div>
                </form>             
                <div class="row">
                    &nbsp;	   
                </div>		    
            </div>
        </div>

    </div>

</div>   
<!-- END PAGE CONTENT -->

<!-- START MODAL PRODUCT CONTENT -->
<div class="modal fade" id="modal-create_product" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                <h4 class="modal-title"><strong>Product</strong> Order</h4>
            </div>
            <div id="call_ajax"> 
                <?php
                if ($this->session->flashdata('message')) {
                    echo $this->session->flashdata('message');
                }
                ?>         
            </div>



            <div class="modal-body clearPad-tb">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">Product</label>
                            <input type="hidden" name="product_id" id="product_id" value="">
                            <input type="hidden" name="product_name1" id="product_name1" value="">
                            <select name="product_list" id="product_list" class="form-control" data-search="true" onchange="product_value();">
                                <option value=""></option>
                                <?php foreach ($products as $product) { ?>
                                    <option value="<?php echo $product->id . '_' . $product->product_name . '_' . $product->sale_price . '_' . $product->description . '_' . $product->tax . '_' . $product->total_uom . '_' . $product->uom_id . '_' . $product->product_image; ?>"><?php echo $product->product_name; ?></option>
                                <?php } ?> 

                            </select>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">Quantity</label>

                            <input type="text" name="product_quantity" id="product_quantity" value="1" class="form-control numeric">	 

                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">Unit Price</label>

                            <input type="text" name="unit_price" id="unit_price" value="" class="form-control numeric">	 

                        </div>
                        <div class="form-group">
                            <label for="field-1" class="control-label">UOM</label>                         
                            <div class="form-group">
                                <div class="append-icon">
                                    <input type="hidden" name="uom_id" id="uom_id" value="" class="form-control numeric">	 
                                    <select name="uom" id="uom" class="form-control full" data-search="true" >
                                        <option value=""></option>
                                        <?php foreach ($uoms as $uom) { ?>
                                            <?php if ($uom->system_code !== '00') { ?>
                                                <option value="<?php echo $uom->system_code; ?>"><?php echo $uom->system_value_txt; ?></option>
                                            <?php } ?> 
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="control-label">Taxes</label>                         
                            <div class="append-icon">
                                <input type="text" name="product_tax" id="product_tax" value="" class="form-control numeric" readOnly>	 
                                <i class="icon-">%</i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">Description</label>

                            <textarea name="pdescription" id="pdescription" rows="2" class="form-control"></textarea>	 

                        </div>

                        <div id="view_img">
                            <img src='#' alt='company image' class='' id="edit-save">
                        </div>
                    </div>

                </div>	


            </div>
            <hr class="clearMar-t" />
            <div class="modal-footer text-center clearPad-t"> 
                <a href="#" id="AddMoreFileBox"><button type="button" class="btn btn-embossed btn-primary" data-dismiss="modal" onclick="">Add item</button></a>
            </div>



        </div>
    </div>
</div>
<script type="text/javascript">
   var openFile = function(event, index) {
      var input = event.target;
      var reader = new FileReader();
      reader.onload = function(){
         var dataURL = reader.result;
            //alert(index);
         var output = document.getElementsByClassName('preview')[index];
         output.src = dataURL;
      };
      reader.readAsDataURL(input.files[0]);
   };
</script>