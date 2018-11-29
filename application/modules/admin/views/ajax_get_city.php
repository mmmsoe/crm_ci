<select name="city_id" id="city_id" class="form-control">
	<option value="" selected="selected">Select City</option>
	<?php foreach($cities as $city){ ?>
		<option value="<?php echo $city->id; ?>"><?php echo $city->name; ?></option>
	<?php }?>
</select>