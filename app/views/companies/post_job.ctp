
<div class="job_top-heading">
<?php if($this->Session->read('Auth.User.id')):?>
	<?php if($this->Session->read('welcomeName') && ($this->Session->read('UserRole'))):?>
			<h2>WELCOME <?php echo strtoupper($this->Session->read('welcomeName'));?>!</h2>
	<?php endif; ?>
<?php endif; ?>
</div>

<div class="job_container">
    	<div class="job_container_top_row">
    		<?php echo $this->element('side_menu');?>

            <div class="job_right_bar">
            	<div class="new_job">
            		<h2>POST NEW JOB</h2>
					<?php echo $this->Form->create('Job', array('url' => array('controller' => 'companies', 'action' => 'postJob') )); ?>
                	<div class="job_feild"> <span>Job Title:</span>
                    <div class="job-share-tb-top job_feild_margin">
						<?php	echo $form->input('title', array('label' => '',
													'type'  => 'text',
													'class' => 'required',
													'placeholder'=>'Job Title',
													'div'=>false
													)
								 );
						?>						
					</div>
                    </div>
                    <div class="clr"></div>
                    <div class="job_feild"> <span>Reward ($):</span>
                        <div class="job-share-tb-top job_feild_margin">
							<?php	echo $form->input('reward', array('label' => '',
													'type'  => 'text',
													'class' => 'required number',
													'min' =>1000,
													'placeholder'=>'Reward',
													'div'=>false
												)
									      );
						     ?>					
                        </div>
                    </div>
                    <div class="clr"></div>
                    <div class="job_feild"> <span>Job Description:</span>
                            <div class="post_job_textbox">
								   <?php echo $form->input('short_description', array('label' => '',
															'type'  => 'textarea',
															'class' => 'required',
															'placeholder'=>'Job Description',
												            'div'=>false
														)
											    );
						           ?>
                            </div>
                            <div class="clr"></div>
                    </div>
		    <div class="clr"></div>
                    <div class="job_feild company_select"> <span>Category:</span>
						<div class="category_dropdown">
                             	<!-- div class="jobseeker_select_i_error" style="float:left;margin-left: -7px;clear: both;" -->					<div class="copmany_select_box">		 
							 <?php echo $form -> input('industry',array(
												  'type'=>'select',
												  'label'=>'',
												  'options'=>$industries,
												  'empty' =>'Select Industry',
												  'class'=>'required',
												  'div'=>false
												 )
											);
							  ?>
							  </div>						
							  <div class="copmany_select_box">							  		  
							  <?php echo $form -> input('specification',array(
												  'type'=>'select',
												  'label'=>'',
												  'empty' =>'Select Specifications',
												  'options'=>$specifications,
												  'class'=>'required',
												  'div'=>false
												  )
											);
		     				 ?>
		     				 </div>
						</div>
                    </div>
                     <div class="clr"></div>
                    <div class="job_feild company_select"> <span>Location:</span>
                            <div class="category_dropdown">
							   <!-- div class="jobseeker_select_i_error" style="float:left;margin-left: -7px;clear: both;" -->	 					<div class="copmany_select_box">
                               <?php echo $form -> input('state',array(
												  'type'=>'select',
												  'label'=>'',
												  'options'=>$states,
												  'empty' =>'All States',
												  'class'=>'required',
												  'onchange'=>'return fillCities(this.value,"JobCity","city_loader");',
												  'div'=>false
									            )
								         );
							    ?>
							    </div>
							    <div class="copmany_select_box">
								<?php echo $form -> input('city',array(
											'type'=>'select',
											'label'=>'',
											'empty' =>'All Cities',
											'div'=>false
										    )
									    );
							    ?>
							    </div>
                            </div>
                    </div>
                     <div class="clr"></div>
                    <div class="job_feild job_salary"> <span class="annual_sal_lh">Salary Range ($):</span>
                      	<div class="annual_field"> <span>From</span> 
                        		<div class="from_date textbox-date">
                                	<?php	echo $form->input('salary_from', array('label' => '',
													'type'  => 'text',
													'class' => 'required number',
													'title'=> 'Enter amount in $',
													'div'=>false
												)
								          );
						            ?>			
                                </div>
                                <span>a year &nbsp;&nbsp;&nbsp; To:</span>
                                <div class="from_date textbox-date">
                                	<?php	echo $form->input('salary_to', array('label' => '',
											'type'  => 'text',
											'class' => 'required number',
											'title'=> 'Enter amount in $',
											'div'=>false
											)
								        );
						            ?>
                                </div>
                                <span>a year</span>
                         </div>     
                    </div>
                     <div class="clr"></div>
                    <div class="job_feild"> <span class="job_float">Job Type:</span>
                            <div class="category_dropdown_job">
                                <?php
								       $job_array = array(
												  '1'=>'Full Time',
												  '2'=>'Part Time',
												  '3'=>'Contract',
												  '4'=>'Internship',
												  '5'=>'Temporary'
												); 
						               
									   echo $form -> input('job_type',array(
												  'type'=>'select',
												  'label'=>'',
												  'options'=>$job_array,
												  'class'=>'required',
												  'div'=>false
												  )
								  );
                                 ?>
                            </div>
                            <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                    <div class="job_feild"> <span>Responsibilities:</span>
                            <div class="post_job_textbox">
                                   <?php echo $form->input('description', array('label' => '',
													'type'  => 'textarea',
													'class' => 'required',
													'placeholder'=>'Description',
												    'div'=>false
												)
								      );
                                   ?>
                            </div>
                            <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                    <div class="job_feild" style="margin-top:8px;"> <span>Requirements:</span>
                        <div class="job-share-tb-top job_feild_margin">
							<?php	echo $form->input('requirements', array('label' => '',
													'type'  => 'text',
													'class' => 'required',
													'placeholder'=>'Requirements',
													'div'=>false
												)
									      );
						     ?>					
                        </div>
                    </div>
                    <div class="clr"></div>
                    <div class="job_feild"> <span>Benefits:</span>
                        <div class="job-share-tb-top job_feild_margin">
							<?php	echo $form->input('benefits', array('label' => '',
													'type'  => 'text',
													//'class' => 'required number',
													'placeholder'=>'Benefits',
													'div'=>false
												)
									      );
						     ?>					
                        </div>
                    </div>
                    <div class="clr"></div>
                    <div class="job_feild"> <span>Keywords:</span>
                        <div class="job-share-tb-top job_feild_margin">
							<?php	echo $form->input('keywords', array('label' => '',
													'type'  => 'text',
													//'class' => 'required number',
													'placeholder'=>'Keywords',
													'div'=>false
												)
									      );
						     ?>					
                        </div>
                    </div>
                    <div class="post_job_button">
                        <div class="network_register_bttn post_job_left">
                            <?php echo $form->submit('SAVE FOR LATER',array(
												'name'=>'save',
												'value'=>'later',
												'div'=>false,
												)
									); 
							?>					
                        </div>
                        <div class="network_register_bttn post_job_left">
							<?php echo $form->submit('POST AND SHARE',array(
												'div'=>false,
												'name'=>'save',
												'value'=>'share'
												)
                                        );
							?>					
                        </div>
						<?php echo $form->end(); ?>
                     </div>                  
            	</div>
          <div class="clr"></div>
       </div>
               
            </div>
     
        
        <div class="clr"></div>
        <div class="job_pagination_bottm_bar"></div>									


 	<div class="clr"></div>
</div>
</div>
<style>
.category_dropdown {

    float: right;
    margin-top: 14px;
    width: 380px;
}

</style>


<script>
	$(document).ready(function(){
   		$("#JobPostJobForm").validate({
			errorClass: 'error_input_message',
			errorPlacement: function (error, element) {
				if($(element).attr("id")== "JobSalaryFrom"){
					$(".salery_error").remove();
					error.insertAfter(element.parents(".annual_field").parent());
					error.css({'float':'left','width':'192px','margin-left':'132px' });
				}else if($(element).attr("id")== "JobSalaryTo"){
					$(".salery_error").remove();
					if(!element.parents(".job_salary").next().hasClass("error_input_message")){
						error.insertAfter(element.parents(".annual_field").parent());
						error.css({'float':'left','margin-left':'132px','width':'192px' });
					}else{
						error.insertAfter(element.parents(".job_salary").next(".error_input_message"));
						error.css({'float':'left','width':'192px' });
					}
				}else{
					error.insertAfter(element)
					error.css({'clear':'both','width':'295px'});
				}
				
			}
		});
		$("#JobPostJobForm").submit(function(){ 
			if(!validateSalary()) return false;
		});
		$("#JobSalaryTo").blur(function(){ 
			validateSalary();
		});
	
	});

	function validateSalary(){
		var salaryFrom = $("#JobSalaryFrom").val() , salaryTo = $("#JobSalaryTo").val();
		
		if( !isNaN(salaryFrom) && !isNaN(salaryTo) && parseInt(salaryFrom) > parseInt(salaryTo) ) {	
			$(".annual_field").after("<label class='error_input_message salery_error' for='JobSalaryTo' style='margin-left:325px;clear:both;width:auto;' >Must greater than or equal to From field value</label>");
			return false;
		}
		return true;
	} 
</script>
<script>
	
$(document).ready(function(){
	<?php
	    if($this->Session->check('openShare')):
	?>
	    shareJobShowView(4);
	<?php
	    $this->Session->delete('openShare');
	    endif;
	?>
});
</script>
