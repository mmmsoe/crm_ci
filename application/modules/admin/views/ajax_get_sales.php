<select name="salesperson_id" id="salesperson_id" class="form-control">
	<option value="">Choose Sales</option>
<?php 
foreach( $staffs as $staff){ ?>
	<?php if(userdata('id') == $staff->id) { ?>
		<?php if(in_array($staff->id,$team)){?>
			<option value="<?php echo $staff->id;?>" selected><?php echo $staff->first_name.' '. $staff->last_name;?></option>
		<?php }?> 
	<?php }else{ ?>	
		<?php if(in_array($staff->id,$team)){?>
			<option value="<?php echo $staff->id;?>"><?php echo $staff->first_name.' '. $staff->last_name;?></option>
		<?php }?>
	<?php }?>
<?php }?>
</select>