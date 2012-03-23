<script> 	
    $(document).ready(function(){
  		$("#JobseekerProfileJobProfileForm").validate();
    });	
</script>
<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<?php echo $this->element('side_menu');?>
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
					<div style="padding:20px;">
							<div>           
								<?php echo $form->create('JobseekerProfile', array('url' => array('controller' => 'jobseekers', 'action' => 'jobProfile'), 'type' => 'file'));?>
								<div>
                            		<?php echo $form->input('id', array('label' => 'Your Name ',
																	    'type'  => 'hidden',
																	    'value' => isset($jobprofile['id'])?$jobprofile['id']:""));?></div>	
								<div style="padding-bottom:20px"><strong>Qualification <font color="red">*</font>: </strong>
								<?php $answer1_array = array('High School'=>'High School','Diploma'=>'Diploma','Graduation'=>'Graduation','Post Graduation'=>'Post Graduation'); ?>
                      				<?php echo $form->input('answer1', array('label' => '',
																			 'type'  => 'select',
																			 'id'    => 'answer1',
																			 'class' => 'required',
																			 'options'=>$answer1_array,
																			 'value' => isset($jobprofile['answer1'])?$jobprofile['answer1']:""));?>
								</div>
								<div style="padding-bottom:20px"><strong>Work Experience <font color="red">*</font>: </strong>
								<?php $answer2_array = array('0 to 2 year'=>'0 to 2 year','2 to 5 year'=>'2 to 5 year','More than 5 year'=>'More than 5 year'); ?>
                      				<?php echo $form->input('answer2', array('label' => '',
																			 'type'  => 'select',
																			 'id'    => 'answer2',
																			 'class' => 'required',
																			 'options'=>$answer2_array,
																			 'value' => isset($jobprofile['answer2'])?$jobprofile['answer2']:""));?>
								</div>
								<div style="padding-bottom:20px"><strong>Current CTC <font color="red">*</font>: </strong>
								<?php $answer3_array = array('Less than 1,20,000'=>'Less than 1,20,000','1,20,000 to 3,60,000'=>'1,20,000 to 3,60,000','More than 3,60,000'=>'More than 3,60,000'); ?>
                      				<?php echo $form->input('answer3', array('label' => '',
																			 'type'  => 'select',
                                                                             'id'    => 'answer3',
																			 'class' => 'required',
																			 'options'=>$answer3_array,
																			 'value' => isset($jobprofile['answer3'])?$jobprofile['answer3']:""));?>
								</div>
								<div style="padding-bottom:20px"><strong>Expected CTC <font color="red">*</font>: </strong>
                      				<?php echo $form->input('answer4', array('label' => '',
																			 'type'  => 'select',
                                                                             'id'    => 'answer4',
																			 'class' => 'required',
																			 'options'=>$answer3_array,
																			 'value' => isset($jobprofile['answer4'])?$jobprofile['answer4']:""));?>
								</div>
								<div style="padding-bottom:20px"><strong>Why are you applying for this job <font color="red">*</font>: </strong>
                      				<?php echo $form->input('answer5', array('label' => '',
																			 'type'  => 'text',
                                                                             'id'    => 'answer5',
																			 'class' => 'required',
																			 'value' => $jobprofile['answer5']));?>
								</div>
								<div style="padding-bottom:20px"><strong>Ready to relocate <font color="red">*</font>: </strong>
								<?php $answer6_array = array('Yes'=>'Yes','No'=>'No'); ?>
                      				<?php echo $form->input('answer6', array('label' => '',
																			 'type'  => 'select',
                                                                             'id'    => 'answer6',
																			 'class' => 'required',
																			 'options'=>$answer6_array,
																			 'value' => isset($jobprofile['answer6'])?$jobprofile['answer6']:""));?>
								</div>
								<div style="padding-bottom:20px"><strong>Ready to work on shifts <font color="red">*</font>: </strong>
								<?php echo $form->input('answer7', array('label' => '',
																			 'type'  => 'select',
                                                                             'id'    => 'answer7',
																			 'class' => 'required',
																			 'options'=>$answer6_array,
																			 'value' => isset($jobprofile['answer7'])?$jobprofile['answer7']:""));?>
								</div>
								<div style="padding-bottom:20px"><strong>Do you have passport <font color="red">*</font>: </strong>
                      				<?php echo $form->input('answer8', array('label' => '',
																			 'type'  => 'select',
                                                                             'id'    => 'answer8',
																			 'class' => 'required',
																			 'options'=>$answer6_array,
																			 'value' => isset($jobprofile['answer8'])?$jobprofile['answer8']:""));?>
								</div>
								<div style="padding-bottom:20px"><strong>Do You Have Any Restrictions On Your Ability To Travel? <font color="red">*</font>: </strong>
                      				<?php echo $form->input('answer9', array('label' => '',
																			 'type'  => 'select',
                                                                             'id'    => 'answer9',
																			 'class' => 'required',
																			 'options'=>$answer6_array,
																			 'value' => isset($jobprofile['answer9'])?$jobprofile['answer9']:""));?>
								</div>
								<div style="padding-bottom:20px"><strong>Do You Need Additional Training? <font color="red">*</font>: </strong>
                      				<?php echo $form->input('answer10', array('label' => '',
																			 'type'  => 'select',
                                                                             'id'    => 'answer10',
																			 'class' => 'required',
																			 'options'=>$answer6_array,
																			 'value' => isset($jobprofile['answer10'])?$jobprofile['answer10']:""));?>
								</div>
								<?php if($jobprofile['resume']!=''){?>
								<div>
									<?php echo $html->link('Your Resume',array('action' => '/viewResume/resume/'.$jobprofile['id']));?>							        
								</div>
								<?php }?>
								<?php if($jobprofile['resume']!=''){?>
 								<div style="padding-bottom:20px"><strong>Upload Resume (pdf, txt, doc) : </strong>
                      				<?php echo $form->input('resume', array('label' => '',
																			 'type'  => 'file',
                                                                             'id'    => 'resume',));?>
								</div>
								<?php }else{ ?>
								<div style="padding-bottom:20px"><strong>Upload Resume (pdf, txt, doc) <font color="red">*</font>: </strong>
                      				<?php echo $form->input('resume', array('label' => '',
																			 'type'  => 'file',
                                                                             'id'    => 'resume',
																			 'class' => 'required',));?>
								</div>
								<?php }?>
								<?php if($jobprofile['cover_letter']!=''){?>
								<div>
									<?php echo $html->link('Your Cover Letter',array('action' => '/viewResume/cover_letter/'.$jobprofile['id']));?>		
								</div>
								<?php }?>
								<div style="padding-bottom:20px"><strong>Upload Cover Letter (pdf, txt, doc) : </strong>
									<?php echo $form->input('cover_letter', array('label' => '',
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
