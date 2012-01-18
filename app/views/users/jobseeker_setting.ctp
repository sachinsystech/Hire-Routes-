<?php echo $this->Session->flash(); ?>
<div>Welcome back, USER!</div>
<div class="sigup_heading"><center><u>My Jobseeker Settings</u></center></div>

<div class="form_content"  style="margin-left:150px;">
	<?php echo $form->create('Jobseekers', array('action' => 'add')); ?>
        <?php echo $form->input('name', array('label' => 'Your Name',
                                           			'type'  => 'text',
													'class' => 'jobseekers_text required'
                                           			)
                                 );
        ?>
    <div>
      <div style="float:left;margin-left: -7px;clear: both;">
          <?php echo $form -> input('industry_1',array(
                                                      'type'=>'select',
                                                      'label'=>'Industry 1:',
                                                      'options'=>array('test1','test2'),
                                                      'empty' =>' -- Select Industry-- ',
                                                      'class'=>'jobseeker_select'
                                              )
                                  );
          ?>
      </div>
      <div style="float:left;">
          <?php echo $form -> input('industry_specification_1',array(
                                                      'type'=>'select',
                                                      'label'=>'',
                                                      'multiple'=>'multiple',
                                                      'size' => '4',
                                                      'options'=>array('test1','test2','test1','test2','test1','test2'),
                                                      'empty' =>' -- select Specification-- ',
                                                      'class'=>'jobseeker_select__i_s'
                                              )
                                  );
          ?>
      </div>
    </div>
    <div>
      <div style="float:left;margin-left: -7px;clear: both;">
          <?php echo $form -> input('industry_2',array(
                                                      'type'=>'select',
                                                      'label'=>'Industry 2:',
                                                      'options'=>array('test1','test2'),
                                                      'empty' =>' -- Select Industry-- ',
                                                      'class'=>'jobseeker_select'
                                              )
                                  );
          ?>
      </div>
      <div style="float:left;">
          <?php echo $form -> input('industry_specification_2',array(
                                                      'type'=>'select',
                                                      'label'=>'',
                                                      'multiple'=>'multiple',
                                                      'size' => '4',
                                                      'options'=>array('test1','test2','test1','test2','test1','test2'),
                                                      'empty' =>' -- select Specification-- ',
                                                      'class'=>'jobseeker_select__i_s'
                                              )
                                  );
          ?>
      </div>
    </div>
    <div style=" clear :both;">
      <div style="float: left; width: 302px;">
          <?php echo $form->input('location', array('label' => 'Location:',
                                                      'type'  => 'text',
                                                      'class' => 'jobseekers_text_location required'
                                                      )
                                   );
          ?>
      </div>
      <div style="float:left">
          <?php echo $form -> input('state',array(
                                                    'type'=>'select',
                                                    'label'=>'',
                                                    'options'=>array('test1','test2'),
                                                    'empty' =>' -- Select state-- ',
                                                    'class'=>'jobseeker_select'
                                            )
                                );
          ?>
      </div> 
    </div>
    <div style=" clear :both;">
    <?php echo $form -> input('salary',array(
                                                      'type'=>'select',
                                                      'label'=>'Annual Salary Range',
                                                      'options'=>array('test1','test2'),
                                                      'empty' =>' -- Select Industry-- ',
                                                      'class'=>'jobseeker_select'
                                              )
                                  );
          ?>
    <?php echo $form->end(); ?>
    </div>
</div>

<div style="clear:both">
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
<div>
	<b>Subscription Frequency:</b><p>
	<div style="float:left">
		<span style=" margin-left:10px;font-size: 87%;">I would like to receive job notifications by email based on my network settings:<span>
	</div>
	<div style="float:right">
      <?php echo $form -> input('job_notification_email',array(
                                                  'type'=>'select',
                                                  'label'=>'',
                                                  'options'=>array('Every 10 Post','Every Day','Every 3 Days','Every Week'),
                                                  'class'=>'networker_select_job_notify'
                                          )
                              );
      ?>
	</div>
	<center><button style="background-color:#00FF00;" onclick="return saveSubFrequency();">Save</button></center>
</div>


<script>
$(document).ready(function(){
	$("#NetworkersAddForm").validate();
}); 
 
function deleteItem($id){
	if (confirm("Are you sure to delete this?")){
		window.location.href="/jobseekers/delete/"+$id;
	}
	return false;
}

function saveSubFrequency(){
	var notifyId = $("#job_notification_email").val();
	window.location.href="/jobseekers/sendNotifyEmail/"+notifyId;
	return false;
}
</script>