<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers/newJob"><span>New Jobs</span></a></li>
                <li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers/appliedJob"><span>Applied Jobs</span></a></li>
				<li><span><a style="color: #000000;text-decoration: none;font-weight: normal;" href=""><span>My Network</span></li>
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
					<div style="padding:20px;">
							<div>           
								<?php echo $form->create('JobseekerProfile', array('url' => array('controller' => 'jobseekers', 'action' => 'jobProfile'), 'type' => 'file'));?>
								<div>
                            		<?php echo $form->input('id', array('label' => 'Your Name ',
																	    'type'  => 'hidden',
																	    'value' => isset($jobprofile['id'])?$jobprofile['id']:""));?></div>	
								<div style="padding-bottom:20px"><strong>Qualification : </strong>
                      				<?php echo $form->input('answer1', array('label' => '',
																			 'type'  => 'text',
                                                                             'id'    => 'answer1',
																			 'value' => $jobprofile['answer1']));?>
								</div>
								<div style="padding-bottom:20px"><strong>Work Experience : </strong>
                      				<?php echo $form->input('answer2', array('label' => '',
																			 'type'  => 'text',
                                                                             'id'    => 'answer2',
																			 'value' => $jobprofile['answer2']));?>
								</div>
								<div style="padding-bottom:20px"><strong>Current CTC : </strong>
                      				<?php echo $form->input('answer3', array('label' => '',
																			 'type'  => 'text',
                                                                             'id'    => 'answer3',
																			 'value' => $jobprofile['answer3']));?>
								</div>
								<div style="padding-bottom:20px"><strong>Expected CTC : </strong>
                      				<?php echo $form->input('answer4', array('label' => '',
																			 'type'  => 'text',
                                                                             'id'    => 'answer4',
																			 'value' => $jobprofile['answer4']));?>
								</div>
								<div style="padding-bottom:20px"><strong>Why are you applying for this job : </strong>
                      				<?php echo $form->input('answer5', array('label' => '',
																			 'type'  => 'text',
                                                                             'id'    => 'answer5',
																			 'value' => $jobprofile['answer5']));?>
								</div>
								<div style="padding-bottom:20px"><strong>Ready to relocate : </strong>
                      				<?php echo $form->input('answer6', array('label' => '',
																			 'type'  => 'text',
                                                                             'id'    => 'answer6',
																			 'value' => $jobprofile['answer6']));?>
								</div>
								<div style="padding-bottom:20px"><strong>Ready to work on shifts : </strong>
                      				<?php echo $form->input('answer7', array('label' => '',
																			 'type'  => 'text',
                                                                             'id'    => 'answer7',
																			 'value' => $jobprofile['answer7']));?>
								</div>
								<div style="padding-bottom:20px"><strong>Do you have passport : </strong>
                      				<?php echo $form->input('answer8', array('label' => '',
																			 'type'  => 'text',
                                                                             'id'    => 'answer8',
																			 'value' => $jobprofile['answer8']));?>
								</div>
								<div style="padding-bottom:20px"><strong>Do You Have Any Restrictions On Your Ability To Travel? : </strong>
                      				<?php echo $form->input('answer9', array('label' => '',
																			 'type'  => 'text',
                                                                             'id'    => 'answer9',
																			 'value' => $jobprofile['answer9']));?>
								</div>
								<div style="padding-bottom:20px"><strong>Do You Need Additional Training? : </strong>
                      				<?php echo $form->input('answer10', array('label' => '',
																			 'type'  => 'text',
                                                                             'id'    => 'answer10',
																			 'value' => $jobprofile['answer10']));?>
								</div>
								<?php if($jobprofile['resume']!=''){?>
								<div>
									<a href="<?php echo BASEPATH;?>webroot/files/resume/<?php echo $jobprofile['resume'];?>" target="_blank">Your Resume</a>
								</div>
								<?php }?>
 								<div style="padding-bottom:20px"><strong>Upload Resume (pdf, txt, doc) : </strong>
                      				<?php echo $form->input('resume', array('label' => '',
																			 'type'  => 'file',
                                                                             'id'    => 'resume'));?>
								</div>
								<?php if($jobprofile['cover_letter']!=''){?>
								<div>
									<a href="<?php echo BASEPATH;?>webroot/files/cover_letter/<?php echo $jobprofile['cover_letter'];?>">Your Cover Letter</a>
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
