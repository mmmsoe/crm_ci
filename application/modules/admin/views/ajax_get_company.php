<option value="" selected>Choose Customer</option>
<?php foreach ($companies as $company) { ?>
	<option value="<?php echo $company->id; ?>" <?php if ($opportunity->customer_id == $company->id) { ?> selected="selected"<?php } ?>><?php echo $company->name; ?></option>
<?php } ?>