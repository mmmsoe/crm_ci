<select name="attendees[]" id="attendees" class="form-control" data-search="true" multiple>
    <option value=""></option>
	 <?php 
	    $attendees = explode(",", $meeting->attendees); 
		foreach( $contacts as $contact){ ?>
		<option value="<?php echo $contact->id;?>" <?php if(in_array($contact->id,$attendees)){?>selected<?php }?>><?php echo $contact->first_name.' ' .$contact->last_name;?></option>
	   <?php } ?> 
	    </select>
		
	