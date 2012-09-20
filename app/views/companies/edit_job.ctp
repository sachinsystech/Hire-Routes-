
<?php
    function unhtmlspecialchars( $string ){
        $string = str_replace ( '&#039;', '\'', $string );
        $string = str_replace ( '&quot;', '\"', $string );
        $string = str_replace ( '&lt;', '<', $string );
        $string = str_replace ( '&gt;', '>', $string );
       
        return $string;
    }
?>

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
				<h2>EDIT JOB</h2>
				<?php if($job['is_active']==1):?>
				<div class="job_feild"> <span>Job Url:</span>
				<div class="job-share-tb-top job_feild_margin">
					<?php	echo $form->input('', array('label' => '',
												'type'  => 'text',
												'div'=>false,
												'value' => $jobUrl,
												'readonly'=>true,
												)
							 );
					?>						
				</div>
				</div>
				<?php endif;?>
				<?php echo $this->Form->create('Job', array('url' => array('controller' => 'companies', 'action' => 'editJob',$job['id']))); ?>
				<?php echo $form->input('Job.id', array('label' => '',
														'type'  => 'hidden',
														'value' => $job['id'],
														
													)
									 );
				?>
				
				<div class="job_feild"> <span>Title:</span>
				<div class="job-share-tb-top job_feild_margin">
					<?php	echo $form->input('title', array('label' => '',
												'type'  => 'text',
												'class' => 'required',
												'placeholder'=>'Title',
												'div'=>false,
												'value' => isset($job['title'])?unhtmlspecialchars($job['title']):"",
												)
							 );
					?>						
				</div>
				</div>
				
				<div class="job_feild"> <span>Reward$:</span>
					<div class="job-share-tb-top job_feild_margin">
						<?php	echo $form->input('reward', array('label' => '',
												'type'  => 'text',
												'class' => 'required number',
												'min' =>1000,
												'placeholder'=>'Rewards',
												'value' => isset($job['reward'])?$job['reward']:"",
												'div'=>false
											)
									  );
						 ?>					
					</div>
				</div>
				
				<div class="job_feild"> <span>Short Description:</span>
						<div class="post_job_textbox">
							   <?php echo $form->input('short_description', array('label' => '',
														'type'  => 'textarea',
														'class' => 'required',
														'placeholder'=>'Short Description',
														'div'=>false,
														'value' => isset($job['short_description'])?unhtmlspecialchars($job['short_description']):""
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
												  'onchange'=>'return fillSpecification(this.value,"JobSpecification","specification_loader");',
												  'class'=>'required',
												  'div'=>false,
												  'selected' => isset($job['industry'])?$job['industry']:""
												 )
											);
							  ?>
							  </div>								  
							  <div class="copmany_select_box">	
							  <?php echo $form -> input('specification',array(
												  'type'=>'select',
												  'label'=>'',
												  'empty' =>'Select Specifications',
												  'selected'=>isset($job['specification'])?$job['specification']:"",
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
						   <!-- div class="jobseeker_select_i_error" style="float:left;margin-left: -7px;clear: both;" -->	 				<div class="copmany_select_box">	
						   <?php echo $form -> input('state',array(
											  'type'=>'select',
											  'label'=>'',
											  'options'=>$states,
											  'empty' =>'All States',
											  'class'=>'required',
											  'onchange'=>'return fillCities(this.value,"JobCity","city_loader");',
											  'div'=>false,
											  'selected' => isset($job['state'])?$job['state']:""
											)
									 );
							?>
							</div>
							<div class="copmany_select_box">	
							<?php echo $form -> input('city',array(
										'type'=>'select',
										'label'=>'',
										'empty' =>'All Cities',
										'div'=>false,
										'selected' => isset($job['city'])?$job['city']:""
										)
									);
							?>
							</div>
						</div>
				</div>
				 <div class="clr"></div>
				<div class="job_feild"> <span class="annual_sal_lh">Minimum Salary ($):</span>
					<div class="annual_field"> <span>From</span> 
							<div class="from_date textbox-date">
								<?php	echo $form->input('salary_from', array('label' => '',
												'type'  => 'text',
												'class' => 'required number',
												'title'=> 'Enter aount in $',
												'div'=>false,
												'value' => isset($job['salary_from'])?$job['salary_from']:""
											)
									  );
								?>			
							</div>
							<span>a year &nbsp;&nbsp;&nbsp; To:</span>
							<div class="from_date textbox-date">
								<?php	echo $form->input('salary_to', array('label' => '',
										'type'  => 'text',
										'class' => 'required number',
										'title'=> 'Enter aount in $',
										'div'=>false,
										'value' => isset($job['salary_to'])?$job['salary_to']:""
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
											  'div'=>false,
											  'selected' => $job['job_type']
											  )
							  );
							 ?>
						</div>
						<div class="clr"></div>
				</div>
				 <div class="clr"></div>
				<div class="job_feild"> <span>Description:</span>
						<div class="post_job_textbox">
							   <?php echo $form->input('description', array('label' => '',
												'type'  => 'textarea',
												'class' => 'required',
												'placeholder'=>'Description',
												'div'=>false,
												'value' => isset($job['description'])?unhtmlspecialchars($job['description']):""
											)
								  );
							   ?>
						</div>
						<div class="clr"></div>
				</div>
				<div class="post_job_button">
					<div class="network_register_bttn post_job_left">
						<?php echo $form->submit('SAVE',array(
											'name'=>'save',
											'value'=>'later',
											'div'=>false,
											)
								); 
						?>					
					</div>
					
					<?php if($job['is_active']==3){ ?>
					<div class="network_register_bttn post_job_left">
						<?php echo $form->submit('POST AND SHARE',array(
											'div'=>false,
											'name'=>'shareJob',
											'value'=>'share'
											)
									);
						?>					
					</div>
					<?php }?>
					<?php echo $form->end(); ?>
				 </div>
				 
				
					<div class="edit_job_icon">
                          <div class="ej_icon">
                            <ul>
                                <li><a class="ej-fb" onclick='shareJobShowView(1);' ></a></li>
                                <li><a class="ej-in" onclick='shareJobShowView(2);' ></a></li>
                                <li><a class="ej-twit" onclick='shareJobShowView(3);' ></a></li>
                                <li><a class="ej-mail" onclick='shareJobShowView(4);' ></a></li>
                            </ul>
                         </div> 
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
<div style="display:none;">
	<?php echo $this->element('share_job');?>
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
		$("#JobEditJobForm").validate({
			errorClass: 'error_input_message',
			errorPlacement: function (error, element) {
				if($(element).attr("id")== "JobSalaryFrom"){
					error.insertAfter(element.parents(".annual_field").parent());
					error.css({'float':'left','width':'192px' });
				}else if($(element).attr("id")== "JobSalaryTo"){
					error.insertAfter(element.parents(".annual_field").parent());
					error.css({'float':'left','margin-left':'132px','width':'192px' });
				}else{
					error.insertAfter(element)
					error.css({'clear':'both','width':'auto'});
				}
				
			}
		});
		
		$("#JobEditJobForm").submit(function(){ 
			if(!validateSalary()) return false;
		});

		$("#JobSalaryTo").blur(function(){ 
			validateSalary();
		});
	});
	
	function validateSalary(){
		if(parseInt($("#JobSalaryFrom").val()) > parseInt($("#JobSalaryTo").val()) ) {	
			$(".annual_field").after("<label class='error_input_message' for='JobSalaryTo' style='margin-left:325px;' >Must greater than or equal to From field value</label>");
			return false;
		}
		return true;
	} 
</script>
<script>
	
$(document).ready(function(){
	<?php if(isset($job['industry'])){?>
	fillSpecification(<?php echo $job['industry'];?>,"JobSpecification","specification_loader");
	$("select#JobSpecification option[value=<?php echo $job['specification'];?>]").attr('selected', 'selected');
	<?php 
	}
	?>
	<?php if(isset($job['state'])){?>
	fillCities(<?php echo $job['state'];?>,"JobCity","city_loader");
	$("select#JobCity option[value=<?php echo $job['city'];?>]").attr('selected', 'selected');
	<?php
	}
	?>
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






