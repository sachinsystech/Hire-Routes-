<script> 	
    $(document).ready(function(){
  		$("#JobseekerApplyApplyJobForm").validate();
    });	
</script>
<div class="page">
	<!--left section start-->
	<div class="leftPanel">
		<div class="sideMenu">
			<?php echo $this->element('side_menu');?>
		</div>
	</div>
	<!--left section end-->
	<div class="rightBox" >
		<!--middle conyent top menu start-->
		<div class='top_menu'>
			<?php echo $this->element('top_menu');?>
		</div>
		<!--middle conyent top menu end-->		
		<div class="joblist_middleBox">
			<table style="width:100%">
				<tr>
					<td>					
                    	<div>
                        	<div style="float:left;width:150px;height:90px;">
                            	<img src="" alt="Company Logo" title="company logo" />
                            </div>
                            <div>
                            	<div style="font-size:20px;"><strong><?php echo ucfirst($job['title']); ?></strong>
                                </div>
                                <div style="font-size:13px;line-height:22px;"><strong>By Company :</strong> 
									<?php echo $jobCompany."<br>"; ?>
                                </div>
							</div>
						</div>
						<?php if(isset($userRole) && $userRole==JOBSEEKER){ ?>
						<div style="padding:20px;">
							<div>           
								<?php echo $form->create('JobseekerApply', array('url' => array('controller' => 'jobs', 'action' => 'applyJob/'.$job['id']), 'type' => 'file'));?>
								<div>
									<?php $answer1_array = array('High School'=>'High School','Diploma'=>'Diploma','Graduation'=>'Graduation','Post Graduation'=>'Post Graduation'); ?>
                      				<?php echo $form->input('answer1', array('label' => 'Qualification',
																			 'type'  => 'select',
                                                                             'class' => '',
																			 'options'=>$answer1_array,
																			 'value' => isset($jobprofile['answer1'])?$jobprofile['answer1']:""));?>
								</div>
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
																			 'value' => isset($jobprofile['answer5'])?$jobprofile['answer5']:""));?>
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
								<?php if(isset($is_resume) && $is_resume!=''){?>
								<div>
									<?php echo $html->link('Your Resume',array('controller'=>'/jobseekers','action' => '/viewResume/resume/'.$jobprofile['file_id']));?>
								</div>
								<?php }?>
 								<?php if(isset($is_resume) && $is_resume!=''){?>
 								<div>
                      				<?php echo $form->input('resume', array('label' => 'Upload Resume (pdf, txt, doc)',
																			 'type'  => 'file',
                                                                             'id'    => 'resume',));?>
								</div>
								<?php }else{ ?>
								<div>
                      				<?php echo $form->input('resume', array('label' => 'Upload Resume* (pdf, txt, doc)',
																			 'type'  => 'file',
                                                                             'id'    => 'resume',
																			 'class' => 'required',));?>
								</div>
								<?php }?>
								<?php if(isset($is_cover_letter) && $is_cover_letter!=''){?>
								<div>
									<?php echo $html->link('Your Cover Letter',array('controller'=>'/jobseekers','action' => '/viewResume/cover_letter/'.$jobprofile['file_id']));?>
								</div>
								<?php }?>
								<div>
									<?php echo $form->input('cover_letter', array('label' => 'Upload Cover Letter (pdf, txt, doc)',
																				   'type'  => 'file',
                                                                                   'id'    => 'cover_letter'));?>
								</div>
								<div>
									<?php echo $form->input('job_id', array('label' => '',
							                                                'type'  => 'hidden',
							                                                'value' => $job['id']));?>
									<?php echo $form->input('user_id', array('label' => '',
							                                                 'type'  => 'hidden',
							                                                 'value' => $this->Session->read('Auth.User.id')));?>
									<?php  echo $form->submit('Apply',array('div'=>false,)); ?>
								</div>
								<?php echo $form->end();?>
							</div>
						</div>
						<?php }?>
					</td>
				</tr>
			</table>
		</div>             			
		<!-- middle conyent list -->
	</div>
	<!-- middle section end -->
</div>	
