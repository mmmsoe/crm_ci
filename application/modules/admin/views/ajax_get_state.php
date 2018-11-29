<select name="state_id" id="state_id" class="form-control" onChange="getcitydetails(this.value)">
	<option value="" selected="selected">Select State</option>
	<?php foreach($state as $stt){ ?>
		<option value="<?php echo $stt->id; ?>"><?php echo $stt->name; ?></option>
	<?php }?>
</select>