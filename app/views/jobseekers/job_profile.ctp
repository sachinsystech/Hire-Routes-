<script> 	
    $(document).ready(function(){
  		$("#JobseekerProfileJobProfileForm").validate();
    });	
</script>
<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers/newJob"><span>My Jobs</span></a></li>
				<li class="active"><span><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers">My Account</a></span></li>
			</ul>
		</div>
		<div>Feed Back</div>
		<div><textarea class="feedbacktextarea"></textarea></div>	
		<div class="feedbackSubmit">Submit</div>
	</div>
	<!-- left section end -->
	<!-- middle section start -->
	<div class="rightBox" >
		<!-- middle conent top menu start -->
		<div class="topMenu">
			<ul>
                <li class="active"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers/jobProfile">Job Profile</a></li>	
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers/setting">Settings/Subscription</a></li>	
                <li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers">Profile</a></li>
			</ul>
            <ul style="float:right">
				<li style="background-color: #3DB517;"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers/editProfile"><span>Edit</span></a></li>
			</ul>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
			<div class="middleBox">                                 
                <div class="setting_profile">
					<div class="payment_form">
							<div>           
								<?php echo $form->create('JobseekerProfile', array('url' => array('controller' => 'jobseekers', 'action' => 'jobProfile'), 'type' => 'file'));?>
								<div>
                            		<?php echo $form->input('id', array('label' => 'Your Name ',
																	    'type'  => 'hidden',
																	    'value' => isset($jobprofile['id'])?$jobprofile['id']:""));?></div>	
								<div>
      							<?php $answer1_array = array('High School'=>'High School','Diploma'=>'Diploma','Graduation'=>'Graduation','Post Graduation'=>'Post Graduation'); ?>
                      				<?php echo $form->input('answer1', array('label' => 'Qualification',
																			 'type'  => 'select',
																			 'class' => '',
																			 'options'=>$answer1_array,
																			 'value' => isset($jobprofile['answer1'])?$jobprofile['answer1']:""));?>
								</div>
								<div style="clear:both"></div>
								<div>
								<?php $answer2_array = array('0 to 2 year'=>'0 to 2 year','2 to 5 year'=>'2 to 5 year','More than 5 year'=>'More than 5 year'); ?>
                      				<?php echo $form->input('answer2', array('label' => 'Work Experience',
																			 'type'  => 'select',
																			 'class' => '',
																			 'options'=>$answer2_array,
																			 'value' => isset($jobprofile['answer2'])?$jobprofile['answer2']:""));?>
								</div>
								<div>
								<?php $answer3_array = array('Less than 1,20,000'=>'Less than 1,20,000','1,20,000 to 3,60,000'=>'1,20,000 to 3,60,000','More than 3,60,000'=>'More than 3,60,000'); ?>
                      				<?php echo $form->input('answer3', array('label' => 'Current CTC',
																			 'type'  => 'select',
                                                                             'class' => '',
																			 'options'=>$answer3_array,
																			 'value' => isset($jobprofile['answer3'])?$jobprofile['answer3']:""));?>
								</div>
								<div>
                      				<?php echo $form->input('answer4', array('label' => 'Expected CTC',
																			 'type'  => 'select',
                                                                             'class' => '',
																			 'options'=>$answer3_array,
																			 'value' => isset($jobprofile['answer4'])?$jobprofile['answer4']:""));?>
								</div>
								<div>
									<?php $answer5_array = array('1'=>'Full Time',
									 						 '2'=>'Part Time',
									 						 '3'=>'Contract',
									 						 '4'=>'Internship',
									 						 '5'=>'Temporary'); ?>
                      				<?php echo $form->input('answer5', array('label' => 'Job Type',
																			 'type'  => 'select',
                                                                             'class' => '',
																			 'options'=>$answer5_array,
																			 'value' => $jobprofile['answer5']));?>
								</div>
								<div>
								<?php $answer6_array = array('Yes'=>'Yes','No'=>'No'); ?>
                      				<?php echo $form->input('answer6', array('label' => 'Ready to relocate',
																			 'type'  => 'select',
                                                                             'class' => '',
																			 'options'=>$answer6_array,
																			 'value' => isset($jobprofile['answer6'])?$jobprofile['answer6']:""));?>
								</div>
								<div>
								<?php echo $form->input('answer7', array('label' => 'Ready to work on shifts',
																			 'type'  => 'select',
                                                                             'class' => '',
																			 'options'=>$answer6_array,
																			 'value' => isset($jobprofile['answer7'])?$jobprofile['answer7']:""));?>
								</div>
								<div>
                      				<?php echo $form->input('answer8', array('label' => 'Do you have passport',
																			 'type'  => 'select',
                                                                             'class' => '',
																			 'options'=>$answer6_array,
																			 'value' => isset($jobprofile['answer8'])?$jobprofile['answer8']:""));?>
								</div>
								<div>
                      				<?php echo $form->input('answer9', array('label' => 'Do You Have Any Restrictions On Your Ability To Travel?',
																			 'type'  => 'select',
                                                                             'class' => '',
																			 'options'=>$answer6_array,
																			 'value' => isset($jobprofile['answer9'])?$jobprofile['answer9']:""));?>
								</div>
								<div>
                      				<?php echo $form->input('answer10', array('label' => 'Do You Need Additional Training?',
																			 'type'  => 'select',
                                                                             'class' => '',
																			 'options'=>$answer6_array,
																			 'value' => isset($jobprofile['answer10'])?$jobprofile['answer10']:""));?>
								</div>
								<?php if($is_resume!=''){?>
								<div>
									<?php echo $html->link('Your Resume',array('action' => '/viewResume/resume/'.$jobprofile['id']));?>							        
								</div>
								<?php }?>
								<?php if($is_resume!=''){?>
 								<div>
                      				<?php echo $form->input('resume', array('label' => 'Upload Resume (pdf, txt, doc)',
																			 'type'  => 'file',
                                                                             'id'    => 'resume',));?>
								</div>
								<?php }else{ ?>
								<div>
                      				<?php echo $form->input('resume', array('label' => 'Upload Resume (pdf, txt, doc)',
																			 'type'  => 'file',
                                                                             'id'    => 'resume',
																			 'class' => 'required',));?>
								</div>
								<?php }?>
								<?php if($is_cover_letter!=''){?>
								<div>
									<?php echo $html->link('Your Cover Letter',array('action' => '/viewResume/cover_letter/'.$jobprofile['id']));?>		
								</div>
								<?php }?>
								<div>
									<?php echo $form->input('cover_letter', array('label' => 'Upload Cover Letter (pdf, txt, doc)',
																				   'type'  => 'file',
                                                                                   'id'    => 'cover_letter'));?>
								</div>
								<div>
									<?php echo $form->input('user_id', array('label' => 'User ID',
							                                                 'type'  => 'hidden',
							                                                 'value' => $this->Session->read('Auth.User.id')));?>
									<?php  echo $form->submit('Apply',array('div'=>false,)); ?>
								</div>
								<?php echo $form->end();?>
							</div>
						</div>
				</div>
			</div>
			
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->


</div>
