<select name="contact_id" id="contact_id" class="form-control" data-search="true">
	<option value="" selected="selected">Choose Contact</option>
	<?php foreach( $contact_persons as $contact){ ?>
		<option value="<?php echo $contact->id;?>" <?php if($contact->main_contact_person=='1'){?> selected <?php }?>><?php echo $contact->first_name ." ". $contact->last_name;?></option>
	<?php }?> 
</select>
<!--select name="contact_id" id="contact_id" class="form-control">
	<option value="" selected="selected">Choose</option>
	<?php //foreach($contacts as $contact){ ?>
		<option value="<?php //echo $contact->id; ?>"><?php //echo $contact->first_name; ?><?php //echo ' '.$contact->last_name; ?></option>
	<?php //} ?>
</select-->