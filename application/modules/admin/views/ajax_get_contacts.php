<select name="contact_id" id="contact_id" class="form-control" data-search="true">
	<option value="" selected="selected">Choose Contact</option>
	<?php foreach( $contact_persons as $contact_person){ ?>
	<option value="<?php echo $contact_person->email;?>"><?php echo $contact_person->first_name.' '.$contact_person->last_name.' ('.$contact_person->email.')';?></option>
	<?php }?> 
</select>