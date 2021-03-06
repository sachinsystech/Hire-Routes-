
<script> 	
    $(document).ready(function(){
  		$("#JobseekerApplyApplyJobForm").validate();
    });	

</script>
<h1 class="title-emp"><span><?php echo ucfirst($job['title']); ?></span> Application</h1>
<div class="sub-title-ty application_top_submenu">Company Posted By: <a href="<?php echo $jobCompany['company_url'] ?>" class="NewTab"><?php echo ucfirst($jobCompany['company_name']);?></a></div>
 <!---  application form start --->
<div class="application_form_main">
	
	<?php if(isset($userRole) && $userRole==JOBSEEKER){ ?>
	<?php echo $form->create('JobseekerApply', array('url' => array('controller' => 'jobs', 'action' => 'applyJob/'.$job['id']), 'type' => 'file'));?>
    	<div class="application_form_row">
    		<div class="application_form_text">Degree</div>
			<div class="application_form_field">
	            <?php $answer1_array = array('Not Specified'=>'Not Specified',
															'None'=>'None',
															'High School'=>'High School',
															'2 Year Degree'=>'2 Year Degree',
															'4 Year Degree'=>'4 Year Degree',
															'Graduate Degree'=>'Graduate Degree');?>
                      				<?php echo $form->input('answer1', array('label' => false,
																			 'type'  => 'select',
                                                                             'div' => false,
																			 'options'=>$answer1_array,
																			 'value' => isset($jobprofile['answer1'])?$jobprofile['answer1']:""));?>
            </div>
            <div class="clr"></div>
        </div>
        
        
        <div class="application_form_row">
        	<div class="application_form_text">Work Experience</div>
            <div class="application_form_field">
					<?php $answer2_array = array('0 to 2 Years'=>'0 to 2 Years',
											'2 to 5 Years'=>'2 to 5 Years',
											'5 to 10 Years'=>'5 to 10 Years',
											'More than 10 Years'=>'More than 10 Years'); ?>
      				<?php echo $form->input('answer2', array('label' => false,
															 'type'  => 'select',
                                                             'div' => false,
															 'options'=>$answer2_array,
															 'value' => isset($jobprofile['answer2'])?$jobprofile['answer2']:""));?>
            </div>
            <div class="clr"></div>
        </div>
        
        
        <div class="application_form_row">
        	<div class="application_form_text">Current Salary</div>
            <div class="application_form_field">
				<?php $answer3_array = array('Less than $50K'=>'Less than $50K',
											'$50 - 75K'=>'$50 - 75K',
											'$75 - 100K'=>'$75 - 100K',
											'$100 - 150K'=>'$100 - 150K',
											'More than $150K'=>'More than $150K'); ?>
      				<?php echo $form->input('answer3', array('label' => false,
															 'type'  => 'select',
                                                             'div' => false,
															 'options'=>$answer3_array,
															 'value' => isset($jobprofile['answer3'])?$jobprofile['answer3']:""));?>
            </div>
            <div class="clr"></div>
        </div>
        
        
        <div class="application_form_row">
        	<div class="application_form_text">Expected Salary</div>
            <div class="application_form_field">
  				<?php echo $form->input('answer4', array('label' => false,
														 'type'  => 'select',
                                                         'div' => false,
														 'options'=>$answer3_array,
														 'value' => isset($jobprofile['answer4'])?$jobprofile['answer4']:""));?>
            </div>
            <div class="clr"></div>
        </div>
        
        
        <div class="application_form_row">
        	<div class="application_form_text">Job Type</div>
            <div class="application_form_field">
				<?php $answer5_array = array('1'=>'Full Time',
				 						 '2'=>'Part Time',
				 						 '3'=>'Contract',
				 						 '4'=>'Internship',
				 						 '5'=>'Temporary'); ?>
				<?php echo $form->input('answer5', array('label' => false,
														 'type'  => 'select',
		                                                 'div' => false,
														 'options'=>$answer5_array,
														 'value' => isset($jobprofile['answer5'])?$jobprofile['answer5']:""));?>
            </div>
            <div class="clr"></div>
        </div>
        
        
        <div class="application_form_row">
        	<div class="application_form_text">University</div>
            <div class="application_form_field">
				<?php echo $form->input('answer6', array('label' => false,
														 'type'  => 'select',
                                                         'class' => 'required',
                                                         'div'	=> false,
														 'options'=>$universities,
														 'empty'=>"Select",
														 'value' => isset($jobprofile['answer6'])?$jobprofile['answer6']:""));?>
            </div>
            <div class="clr"></div>
        </div>
        
        <div class="application_form_row">
        	<div class="application_form_text">Ready to work on shifts</div>
            <div class="application_form_field">
				<?php $answer7_array = array('Yes'=>'Yes','No'=>'No'); ?>
  				<?php echo $form->input('answer7', array('label' => false,
														 'type'  => 'select',
														 'div'	=> false,
                                                         'class' => '',
														 'options'=>$answer7_array,
														 'value' => isset($jobprofile['answer7'])?$jobprofile['answer7']:""));?>
            </div>
            <div class="clr"></div>
        </div>
        
        <div class="application_form_row">
        	<div class="application_form_text">Do you have passport</div>
            <div class="application_form_field">
				<?php echo $form->input('answer8', array('label' => false,
														 'type'  => 'select',
		                                                 'class' => '',
		                                                 'div'	=>false,
														 'options'=>$answer7_array,
														 'value' => isset($jobprofile['answer8'])?$jobprofile['answer8']:""));?>
            </div>
            <div class="clr"></div>
        </div>
        
        <div class="application_form_row">
        	<div class="application_form_text">Do You Have Any Restrictions On Your Ability To Travel?</div>
            <div class="application_form_field">
				<?php echo $form->input('answer9', array('label' => false,
														 'type'  => 'select',
		                                                 'class' => '',
		                                                 'div'	=> false,
														 'options'=>$answer7_array,
														 'value' => isset($jobprofile['answer9'])?$jobprofile['answer9']:""));?>
            </div>
            <div class="clr"></div>
        </div>
        
        <div class="application_form_row">
        	<div class="application_form_text">Do You Need Additional Training?</div>
            <div class="application_form_field">
				<?php echo $form->input('answer10', array('label' => false,
														 'type'  => 'select',
		                                                 'class' => '',
		                                                 'div'	=>false,
														 'options'=>$answer7_array,
														 'value' => isset($jobprofile['answer10'])?$jobprofile['answer10']:""));?>
            </div>
            <div class="clr"></div>
        </div>
        
        <div class="application_form_row">
        	<div class="application_form_text">Resume</div>
            <div class="application_browse_field">
	            <?php if(isset($is_resume) && $is_resume!=''){?>
				<div>
					<?php echo $form->input('resume', array('label' => false,
									 'type'  => 'file',
									'div'	=> false,
                                    'id'    => 'resume',));?>
				</div>
				<?php }else{ ?>
				<div>
					<?php echo $form->input('resume', array('label' => false,
									'type'  => 'file',
									 'div'=> false,
									 'id'    => 'resume',
									 'class' => 'required',));?>
				</div>
				<?php }?>
				<?php if(isset($is_resume) && $is_resume!=''){?>
				    <div class="upload_resume">
					    <?php echo $html->link('Your Resume',array('controller'=>'jobseekers','action' => '/viewResume/resume/'.$jobprofile['id']));?>							        
				    </div>
				<?php }?>
        	</div>
            <div class="clr"></div>
        </div>
        
         <div class="clr"></div>
        <div class="application_form_row application_cover_letter">
        	<div class="application_form_text">Cover Letter</div>
            <div class="application_browse_field">
				<?php echo $form->input('cover_letter', array('label' => false,
								'type'  => 'file',
								'div'	=> false,
                                                           'id'    => 'cover_letter'));?>
        	</div>
           <div class="clr"></div>
            <?php if(isset($is_cover_letter) && $is_cover_letter!=''){?>
			<div class="upload_resume upload_cover_letter">
				<?php echo $html->link('Your Cover Letter',array('controller'=>'jobseekers','action' => '/viewResume/cover_letter/'.$jobprofile['id']));?>	
			</div>
				<?php }?>
		<div class="clr"></div>
        </div>
        
        <div style="display:none;">
			<?php echo $form->input('job_id', array('label' => '',
	                                                'type'  => 'text',
	                                                'value' => $job['id']));?>
			<?php echo $form->input('user_id', array('label' => '',
	                                                 'type'  => 'text',
	                                                 'value' => $this->Session->read('Auth.User.id')));?>
        
        </div>
        
        <div class="application_form_buttn_row job_apply_buttn">
        	<div class="left_bttn">
				<div class="uploadresume_bttn">
					<?php  echo $form->submit('Apply',array('div'=>false,
            											'type'=>'submit',
            											)); ?>
				</div>            											
            </div>
        </div>
        <?php echo $form->end();?>
		<?php } ?>
    </div>
</div>
<div class="clr"></div>


<!---------------------------------->


