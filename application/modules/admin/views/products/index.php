<script>

    function delete_product(product_id)
    {

        $.ajax({
            type: "GET",
            url: "<?php echo base_url('admin/products/delete'); ?>/" + product_id,
            success: function (msg)
            {
                if (msg == 'deleted')
                {
                    $('#product_id_' + product_id).fadeOut('normal');
                }
                else
                {
                    $('#modal_error').modal('show');
                }
            }

        });

    }

</script>
<!-- BEGIN PAGE CONTENT -->

<div class="modal fade" id="modal_error" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                <h4 class="modal-title"><strong>Error</strong></h4>
            </div>
            <div class="modal-body">
                Product is being used in quotations, sales orders, or invoices<br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-embossed" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<div class="page-content">
    <div class="row">
<!--h2 class="col-md-6"><strong>Products</strong></h2--> 
        <div>
            <?php if (check_staff_permission('products_write')) { ?>
                <a  style="float:right;" href="<?php echo base_url('admin/products/add/'); ?>" class="btn btn-primary btn-embossed"> Create New</a> 	
                <a href="<?php echo base_url('admin/products/'); ?>" class="btn btn-black btn-embossed"> Manage Products</a> 	
            <?php } ?>	
        </div>           
    </div>

    <div class="row">
        <div class="panel">																				<div class="panel-content">

                <div class="panel-content pagination2 table-responsive">

                    <table class="table table-hover table-dynamic ">
                        <thead>
                            <tr>                        
                                <th>Name</th>
                                <th>Internal Category</th>
                                <th>Product Type</th>                        
                                <th>Status</th> 
                                <th>Quantity On Hand</th>
                                <th>Quantity Available</th>
                                <th><?php echo $this->lang->line('options'); ?></th>     
                            </tr>
                        </thead>
                        <tbody>

                            <?php if (!empty($products)) { ?>
                                <?php foreach ($products as $product) { ?>
                                    <tr id="product_id_<?php echo $product->id; ?>">

                                        <td><a href="<?php echo base_url('admin/products/view/' . $product->id); ?>"><?php echo $product->product_name; ?></a></td>
                                        <td><?php echo $this->system_model->system_single_value('INTERNAL_CAT', $product->internal_category)->system_value_txt; ?> </td>
                                        <td><?php echo $product->product_type; ?></td>
                                        <td><?php echo $product->status; ?></td>
                                        <td class="numeric"><?php echo $product->quantity_on_hand; ?></td>
                                        <td class="numeric"><?php echo $product->quantity_available; ?></td>

                                        <td style="width: 12%;">
                                            <?php if (check_staff_permission('products_write')) { ?>
                                                <a href="<?php echo base_url('admin/products/update/' . $product->id); ?>" class="edit btn btn-sm btn-default dlt_sm_table"><i class="icon-note"></i></a> 
                                            <?php } ?>

                                            <?php if (check_staff_permission('products_delete')) { ?>
                                                <a href="javascript:void(0)" class="delete btn btn-sm btn-danger dlt_sm_table" data-toggle="modal" data-target="#modal-basic<?php echo $product->id; ?>"><i class="glyphicon glyphicon-trash"></i></a>
                                            <?php } ?>

                                        </td> 
                                    </tr>
                                <div class="modal fade" id="modal-basic<?php echo $product->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                                                <h4 class="modal-title"><strong>Confirm</strong></h4>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this?<br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default btn-embossed" data-dismiss="modal">Cancel</button>
                                                <button type="button" onclick="delete_product(<?php echo $product->id; ?>)" class="btn btn-primary btn-embossed" data-dismiss="modal">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
