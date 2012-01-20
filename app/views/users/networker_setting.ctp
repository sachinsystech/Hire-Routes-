<?php echo $this->Session->flash(); ?>
<div>Welcome back, USER!</div>
<div class="sigup_heading"><center><u>My Networker Settings</u></center></div>

<div class="form_content"  style="margin-left:150px;">
	<div><b>Add Subscriptions:</b></div>
	<?php echo $form->create('Networkers', array('action' => 'add')); ?>
	<div>
		<div style="float:left">
		<?php echo $form -> input('industry',array(
													'type'=>'select',
													'label'=>'',
													'options'=>$company_names,
													'empty' =>' -- Select Industry-- ',
													'class'=>'networker_select_bg required'
											)
								);
		?>
		</div>
		<div style="float:right">
		<?php echo $form -> input('specification',array(
													'type'=>'select',
													'label'=>'',
													'options'=>array('test1','test2'),
													'empty' =>' -- Select Specification-- ',
													'class'=>'networker_select_bg'
											)
								);
		?>
		</div>
	</div>
	<div>
		<div style="float:left;margin-left: 43px;clear: both;">
			<?php echo $form -> input('city',array(
														'type'=>'select',
														'label'=>'Location:',
														'options'=>array('test1','test2'),
														'empty' =>' -- All Cities-- ',
														'class'=>'networker_select_city'
												)
									);
			?>
		</div>
		<div style="float:left;">
			<?php echo $form -> input('state',array(
														'type'=>'select',
														'label'=>'',
														'options'=>array('test1','test2'),
														'empty' =>' -- All States-- ',
														'class'=>'networker_select_state'
												)
									);
			?>
		</div>
		<div style="float:right;margin-top: -15px;">
			<?php echo $form ->submit('Subscribe');?>
		</div>
	</div>	
		<?php echo $form->end(); ?>
</div>

<div style="clear: both; margin-left: 150px;" class="form_content">
	<b>Current Subscriptions:</b>
	<table width="100%">
		<tr>
			<th>Industry Name</th>
			<th style="width:15%;">Delete</th>
		</tr>
		<?php foreach($networkers_setting_info as $NSI): ?>
		<tr>
			<td><?php echo $company_names[$NSI['industry']]; ?></td>
			<td>
				<button style="background-color:#00FF00;" onclick="return deleteItem(<?php echo $NSI['id']?>);">Delete</button>
			</td>
		</tr>
		<?php endforeach;?>
	</table>	
</div>

<div class="form_content" style="clear: both; margin-left: 150px;">
	<b>Subscription Frequency:</b><p>
	<div style="float:left;">		
		<?php	echo $form->input('is_notify', array('label' => '<span style="font-size: 87%;">I would like to receive job notifications by email based on my network settings:<span>',
														'type'  => 'checkbox',
														)
									 );
		?>
	</div>
		
	<div style="float:right;">	
		<?php echo $form -> input('job_notification_email',array(
													'type'=>'select',
													'label'=>'',
													'options'=>array('Every 10 Post','Every Day','Every 3 Days','Every Week'),
													'class'=>'networker_select_job_notify'
											)
								);
		?>
	</div>
</div>
<br>
<button style="background-color:#00FF00;" onclick="return saveSubFrequency();">Save</button>



<script>
$(document).ready(function(){
	$("#NetworkersAddForm").validate();
	//$("#accordion").accordion();
}); 
 
function deleteItem($id){
	if (confirm("Are you sure to delete this?")){
		window.location.href="/networkers/delete/"+$id;
	}
	return false;
}

function saveSubFrequency(){
	var notifyId = $("#job_notification_email").val();
	window.location.href="/networkers/sendNotifyEmail/"+notifyId;
	return false;
}
</script>