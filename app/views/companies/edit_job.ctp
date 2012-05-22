<?php ?>
<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<?php echo $this->element('side_menu');?>
		</div>		
	</div>
	<!-- left section end -->
	<!-- middle section start -->
	<div class="rightBox" >
		<!-- middle conent top menu start -->
        <div class="topMenu">
			<?php echo $this->element('top_menu');?>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
		<?php $job_array = array('1'=>'Full Time','2'=>'Part Time','3'=>'Contract','4'=>'Internship','5'=>'Temporary'); ?>
		<div class="job_middleBox">
			<div style="width:600px;margin: auto;">
			<?php if($job['is_active']==1):?>
				<div style="width:300px; margin: 4px 0;">Job URL 
					<input type="text" class='text_field_bg' value="<?php echo $jobUrl; ?>" readonly=true>
				</div>
				<?php endif;?>
				<div style="clear:both"></div>
				<div class="sigup_heading">Edit Posted Job </div>
					<?php echo $this->Form->create('Job', array('url' => array('controller' => 'companies', 'action' => 'editJob',$job['id']))); ?>
					<?php echo $form->input('Job.id', array('label' => '',
															'type'  => 'hidden',
															'value' => $job['id'],
															
														)
            		                     );
    				?>
    				<div class="lable_error" style="overflow:auto;" >
					<?php echo $form->input('Job.title', array('label' => 'Title:',
        		       		                           			'type'  => 'text',
																'class' => 'text_field_job_title required',
        		       		                                    'value' => isset($job['title'])?$job['title']:"",
					                                   			)
        			        	                 );
				    ?>
				    </div>
				    <div class="lable_error_rewards" style="overflow:auto;clear:both;margin:2px;">
					<?php echo $form->input('reward', array('label' => 'Reward$:',
        		   		                           			'type'  => 'text',
															'class' => 'text_field_bg required number',
        		           	                                'value' => isset($job['reward'])?$job['reward']:""
		                                           			)
        		           		             );
				    ?>	
				    </div>
				    <div class="lable_error" style="overflow:auto;clear:both;" class="lable_error">
					<?php echo $form->input('short_description', array('label' => 'Short_Description:',
		           				                               			'type'  => 'textarea',
																		'class' => 'textarea_bg_job required',
																		'value' => isset($job['short_description'])?$job['short_description']:""													
		           				                               			)
		           		                     );
				    ?>
				    </div>
				    <div style="clear:both;overflow:auto;">
						<div class="jobseeker_select_i_error" style="float:left;margin-left: -7px;clear: both;">
					   		<?php echo $form -> input('industry',array(
                        		                          'type'=>'select',
                                	                      'label'=>'Category',
                                	                      'options'=>$industries,
                                	                      'empty' =>' -- Select Industry-- ',
                                	                      'class'=>'jobseeker_select_i required',
                                	                      'onchange'=>'return fillSpecification(this.value,"JobSpecification","specification_loader");',
                                	                      'selected' => isset($job['industry'])?$job['industry']:""
                                			              )
                                				  );
						          ?>
					      	</div>
					
					      	<div id="specification_loader" style="float:left;"></div>
						  	<div style="float:left;">
						          <?php echo $form -> input('specification',array(
                        			                        'type'=>'select',
                                		                    'label'=>'',
                                		                    'empty' =>' -- Select Specifications-- ',
                                		                    'class'=>'job_select__i_s required',
															'selected'=>isset($job['specification'])?$job['specification']:""
                        				                      )
                        				          );
						          ?>
							</div>
						</div>
						<?php $state_val = $job['state']; ?>
						<div style="clear:both;">
							<!-- 	Location :: State wise cities....	-->
							<div class="jobseeker_select_i_error"  style="float:left;margin-left:-5px;clear: both;">
								<?php echo $form -> input('state',array(
														  'type'=>'select',
															'label'=>'Location: ',
															'options'=>$states,
															'empty' =>' -- All States-- ',
															'class'=>'pj_select_ls required',
															'onchange'=>'return fillCities(this.value,"JobCity","city_loader");',
															'selected' => isset($job['state'])?$job['state']:""
															)
												);
								?>	
							</div>
							<div id="city_loader" style="float:left;"></div>
							<div style="float:left;">
								<?php echo $form -> input('city',array(
															'type'=>'select',
															'label'=>'',
															'empty' =>' -- All Cities-- ',
															'class'=>'job_select__i_s',
															'selected' => isset($job['city'])?$job['city']:""
															)
														);
								?>							
							</div>
						</div>	  	  
      						<!-- 	End of Location fields...	-->

						
						<div style=" clear :both; width: 135px;float:left;">
							<label>Annual salary   Range ($):</label>
						</div>
						<div class="salary_range" style="width:150px;float:left;margin-left:0px;">	
							<?php	echo $form->input('salary_from', array('label' => 'From',
				                                           			'type'  => 'text',
																	'class' => 'job_text_field_from required number',
																'value' => isset($job['salary_from'])?$job['salary_from']:""
			                                           			)
						                                 );
				    		?>
					   	</div>
					   	<div style="float:left;width:55px;">a year</div>
					   	<div class= "job_text_field_to_error" style="width:145px;float:left;padding:0;margin:0px;">	
							<?php	echo $form->input('salary_to', array('label' => 'To',
			                                          			'type'  => 'text',
																'class' => 'job_text_field_from required number',
																'value' => isset($job['salary_to'])?$job['salary_to']:""
            			                               			)
            							                     );
							?>
					   	</div>
					   	<div style="float:left;width:50px;overflow:visible;">a year</div>
	    				<div style="clear:both;margin-left:-3px;">
							    <?php $job_array = array('1'=>'Full Time',
							    						'2'=>'Part Time',
							    						'3'=>'Contract',
							    						'4'=>'Internship',
							    						'5'=>'Temporary'); 
							    ?>

							    <?php echo $form -> input('job_type',array(
                            	                          'type'=>'select',
                            	                          'label'=>'Job Type',
                            	                          'options'=>$job_array,
                            	                          'class'=>'job_select_job_type required',
                            	                          'selected' => $job['job_type']
                            			                  )
                            				      );
							    ?>
						 </div>
  						 <div class="lable_error" style="clear:both;margin-left:-3px;">  
								<?php	echo $form->input('description', array('label' => 'Description:',
                            		               			'type'  => 'textarea',
															'class' => 'textarea_bg_job required',
															'value' => isset($job['description'])?$job['description']:""
                                    		       			)
					                                 );
							    ?>
						</div>
						<div style="clear: both;"></div>
							<?php echo $form->submit('Save',array('div'=>false,'style'=>'margin:2px 0px 0px 150px;'));
								if($job['is_active']==3){
									echo $form->submit('Post and Share',array('div'=>false,'name'=>'shareJob','value'=>'share','style'=>'margin:2px 0px 0px 15px;'));
								}
							?>
							<?php echo $form->end(); ?>
						</div>
					</div>
				</div>
	
		<!-- middle conyent list -->
			</div>
			<div style="text-align:left;float:left;width:100px;margin-top:40px;">
			<?php if($job['is_active']==1){?>
					<div style="clear:both;margin-top:5px;padding:5px;">
						<span><b>Share Job</b></span>
					</div>
					<div style="clear:both;margin-top:5px;padding: 5px;">
						<img src="/img/mail_it.png" style="float: left;cursor:pointer" onclick='showView(4);'/>
					</div>
	
					<div style="clear:both;margin-top: 5px;padding: 5px;">
						<img src="/img/facebook_post.png" style="float: left;cursor:pointer" onclick='showView(1);'/>
					</div>
	
					<div style="clear:both;margin-top: 5px;padding: 5px;">
						<img src="/img/linkedin_post.png" style="float: left;cursor:pointer" onclick='showView(2);'/>
					</div>
	
					<div style="clear:both;margin-top: 5px;padding: 5px;">
						<img src="/img/tweeter_post.png" style="float: left;cursor:pointer" onclick='showView(3);'/>
					</div>
			<?php } ?>
		<!-- middle section end -->
			</div>
			<div style="display:none;">
				<?php echo $this->element('share_job');?>
			</div>
<script>
	$("#JobEditJobForm").validate();
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
	showView(4);
	<?php
		$this->Session->delete('openShare');
		endif;
	?>
});
</script>






