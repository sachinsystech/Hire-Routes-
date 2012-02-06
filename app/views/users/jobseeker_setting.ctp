<?php echo $this->Session->flash(); 

	//echo "<pre>"; print_r($industries); exit;

?>
<?php if($jobseekerData):?>
	<div>Welcome back, <?php echo $jobseekerData['name'];?>!</div>
<?php endif;?>
<div class="sigup_heading"><center><u>My Jobseeker Settings</u></center></div>

<div class="form_content"  style="margin:auto;">
	<?php echo $form->create('Jobseekers', array('action' => 'add')); ?>
        <?php echo $form->input('id', array('label' => 'Your Name',
                                           			'type'  => 'hidden',
													'value' => isset($jobseekerData['id'])?$jobseekerData['id']:""
                                           			)
                                 );
        ?>
        <?php echo $form->input('name', array('label' => 'Your Name',
                                           			'type'  => 'text',
													'class' => 'jobseekers_text required',
													'value' => isset($jobseekerData['name'])?$jobseekerData['name']:""
                                           			)
                                 );
        ?>
    <div>
      <div style="float:left;margin-left: -7px;clear: both;">
      	  <?php $industry_array = array('1'=>'Industry1','2'=>'Industry2','3'=>'Industry3','4'=>'Industry4');?>
          <?php echo $form -> input('industry_1',array(
                                                      'type'=>'select',
                                                      'label'=>'Industry 1:',
                                                      'options'=>$industries,
                                                      'empty' =>' -- Select Industry-- ',
                                                      'class'=>'jobseeker_select required',
                                                      'selected' => isset($jobseekerData['industry_1'])?$jobseekerData['industry_1']:""
                                              )
                                  );
          ?>
      </div>
      <div style="float:left;">
      	  <?php $industry_specification_array = array('1'=>'Industry specification 1','2'=>'Industry specification 2','3'=>'Industry specification 3','4'=>'Industry specification 4');?>
          <?php echo $form -> input('industry_specification_1',array(
                                                      'type'=>'select',
                                                      'label'=>'',
                                                      'multiple'=>'multiple',
                                                      'size' => '4',
                                                      'options'=>$specifications,
                                                      'class'=>'jobseeker_select__i_s required',
						      'selected'=>isset($jobseekerData['specification_1'])?explode(",",$jobseekerData['specification_1']):""
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
                                                      'options'=>$industries,
                                                      'empty' =>' -- Select Industry-- ',
                                                      'class'=>'jobseeker_select required',
                                                      'selected' => isset($jobseekerData['industry_2'])?$jobseekerData['industry_2']:""
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
                                                      'options'=>$specifications,
                                                      'class'=>'jobseeker_select__i_s required',
						      'selected'=>isset($jobseekerData['specification_2'])?explode(",",$jobseekerData['specification_2']):""
                                              )
                                  );
          ?>
      </div>
    </div>
    <div style=" clear :both;">
      <div style="float: left; width: 302px;">
          <?php echo $form->input('city', array('label' => 'Location:',
                                                      'type'  => 'text',
                                                      'class' => 'jobseekers_text_location required',
                                                      'value' => isset($jobseekerData['city'])?$jobseekerData['city']:""
                                                      )
                                   );
          ?>
      </div>
      <div style="float:left">
      	  <?php $state_array = array('1'=>'state1','2'=>'state2','3'=>'state3','4'=>'state4');?>
          <?php echo $form -> input('state',array(
                                                    'type'=>'select',
                                                    'label'=>'',
                                                    'options'=>$states,
                                                    'empty' =>' -- Select state-- ',
                                                    'class'=>'jobseeker_select required',
                                                    'selected' => isset($jobseekerData['state'])?$jobseekerData['state']:""
                                            )
                                );
          ?>
      </div> 
    </div>
    <div style=" clear :both;">
    <?php $salary_array = array('25'=>'20K-30K','35'=>'30K-40K','45'=>'40K-50K','55'=>'50K-60K'); ?>
    <?php echo $form -> input('salary_range',array(
                                                      'type'=>'select',
                                                      'label'=>'Annual Salary Range',
                                                      'options'=>$salary_array,
                                                      'class'=>'jobseeker_select_salary',
                                                      'selected' => isset($jobseekerData['salary_range'])?$jobseekerData['salary_range']:""
                                              )
                                  );
          ?>
<div>
	<b>Subscription Frequency:</b><p>
	<div style="float:left;margin-top: 8px;">
		<span style=" margin-left:10px;font-size: 87%;">I would like to receive job notifications by email based on my network settings:<span>
	</div>
	<div>
	<?php $emil_post_array =array('10'=>'Every 10 Post','1'=>'Every Day','3'=>'Every 3 Days','7'=>'Every Week'); ?>
      <?php echo $form -> input('subscribe_email',array(
                                                  'type'=>'select',
                                                  'label'=>'',
                                                  'options'=>$emil_post_array,
                                                  'class'=>'networker_select_job_notify',
                                                  'selected' => isset($jobseekerData['subscribe_email'])?$jobseekerData['subscribe_email']:""
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
