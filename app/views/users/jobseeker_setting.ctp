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
                                                      'options'=>array('20K-30K','30K-40K','40K-50K','50K-60K'),
                                                      'class'=>'jobseeker_select_salary'
                                              )
                                  );
          ?>
<div>
	<b>Subscription Frequency:</b><p>
	<div style="float:left;margin-top: 8px;">
		<span style=" margin-left:10px;font-size: 87%;">I would like to receive job notifications by email based on my network settings:<span>
	</div>
	<div>
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
	<?php echo $form ->submit('Save');?>

    <?php echo $form->end(); ?>
    </div>
</div>

<script>
$(document).ready(function(){
	$("#JobseekersAddForm").validate();
}); 

</script>