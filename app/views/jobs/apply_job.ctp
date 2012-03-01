<script type="text/javascript"> 	   
    function checkValidForm(){       
       if(document.getElementById("resume").value==""){
           document.getElementById("error").innerHTML = "<font color='red'>Please Select File to upload</font>";
           return false;
        }       
    }
</script>
<div class="page">
	<div class="rightBox" >		
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
									<?php echo $job['company_name']."<br>"; ?>
                                </div>
							</div>
						</div>
						<?php if(isset($userrole) && $userrole['role_id']==2){ ?>
						<div style="padding:20px;">
							<div>           
								<?php echo $form->create('JobseekerApply', array('url' => array('controller' => 'jobs', 'action' => 'applyJob'), 'type' => 'file'));?>
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
									<span id="error"></span>
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
