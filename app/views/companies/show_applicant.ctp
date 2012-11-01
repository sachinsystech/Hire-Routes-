<style>
.js_terms-condition-error {
    color: #FF0000;
    float: left;
    font-size: 10px;
    margin: 17px auto auto 170px;
    width: 274px;
}
.ui-dialog-titlebar { display:none; }
.ui-widget-overlay{
    background: none repeat scroll 0 0 #000000;
    opacity: 0.6;
}
#jobseekerApplyProfile{
    margin: 50px;
    overflow:visible;
}
.pi_popup_cancel_bttn a {
    display: block;
    height: 50px;
    margin: 7px 0 0 8px;
    width: 50px;
}
.japdiv {
    background: url("/images/about_popup_bg.png") repeat scroll 0 0 transparent;
    height: 400px;
    overflow: visible;
}
.pi_popup_cancel_bttn {
    background: url("/images/popup_cancel_bttn.png") no-repeat scroll 0 0 transparent;
    height: 72px;
    position: absolute;
    right: 38px;
    top: -24px;
    width: 72px;
}
</style>

<script>

function valid_form(){
	answer1 = $("#UserAnswer1").val();
	answer2 = $("#UserAnswer2").val();
	answer3 = $("#UserAnswer3").val();
	answer4 = $("#UserAnswer4").val();
	answer5 = $("#UserAnswer5").val();
	answer6 = $("#UserAnswer6").val();
	answer7 = $("#UserAnswer7").val();
	answer8 = $("#UserAnswer8").val();
	answer9 = $("#UserAnswer9").val();
	answer10 = $("#UserAnswer10").val();
	if(answer1==="" && answer2==="" && answer3==="" && answer4==="" && answer5==="" && answer6==="" && answer7==="" && answer8==="" && answer9==="" && answer10===""){
		$("#error_div").removeClass().addClass("js_terms-condition-error").html("Please select at least one option to filter results.");
		return false;
	}
}
function jobseekersDetail(jobseekerId, jobseekerName){
		$.ajax({
		url:"/companies/jobseekerFilledProfile",
		type:"post",
	    dataType:"json",
	 	async:false,
		data: {jobseekerId:jobseekerId},
		success:function(response){
			
			$("#jobseekerApplyProfile").dialog({
				height:550,
				width:500,
				top : 0,
				modal:true,
				//show: { effect: 'drop', direction: "up" },
				resizable: false ,
				title:jobseekerName
			});
			//$( ".ui-dialog" ).css("position", "fixed" );
				$(".japdiv").html(
				'<div class="about_popup_cancel_bttn_row">'+
					'<div class="pi_popup_cancel_bttn">'+
						'<a id="close" href="#"></a>'+
					'</div>'+
				'</div>	'+
				'<div>'+
				'<div class="job-right-top-left job-profile" style="margin-top: 15px;">'+
					'<h2>'+jobseekerName+'</h2>'+
					'<p><span>Qualification : </span>'+response['qualificaiton']+
					'<p><span>Experience : </span>'+response['experience']+
					'<p><span>Current CTC :</span>'+response['ctc_current']+
					'<p><span>Expected CTC : </span>'+response['ctc_expected']+
					'<p><span>Job Type : </span>'+response['job_type']+
					'<p><span>University/College : </span>'+response['university']+
					'<p><span>Shifts Availability  : </span>'+response['shifts_available']+
					'<p><span>Passport Availability  : </span>'+response['passport_availability']+
					'<p><span>Travel Ability  : </span>'+response['travel_availability']+
					'<p><span>Training Needs   : </span>'+response['training_needs']+
				'</div>'+
			'</div>');
				$( "#jobseekerApplyProfile" ).parent("div").css({"padding":"0","opacity":"0.9","height":"500px","top":"100px","left":"222px","width":"574px", "background":"none","border":"none"});
				$(document).ready(function(){
					$("a#close").click(function(){
						$("#jobseekerApplyProfile" ).dialog( "close" );
						return false;
					});
				});	
		}		
			
	});
}

function clear_div(val){
	if(val!=""){
		$("#error_div").html(""); 
	}
}
	
</script>


<div id="jobseekerApplyProfile" style="display:none;">
	<div class="japdiv"></div>
</div>

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
            		<h2>APPLICANTS</h2>
                    <div class="applicants_left">
						<?php echo $form->create('', array('url' => array('controller' => 'companies', 'action' => 'showApplicant/'.$jobId),'name'=>'webform','onsubmit'=>'return valid_form();'));?>
                    
                    	<div class="app_feild">
                        	<span>Degree</span>
                        	<div class="app_selectbox">
								<?php $answer1_array = array('Not Specified'=>'Not Specified',
															'None'=>'None',
															'High School'=>'High School',
															'2 Year Degree'=>'2 Year Degree',
															'4 Year Degree'=>'4 Year Degree',
															'Graduate Degree'=>'Graduate Degree');
									echo $form->input('answer1', array(
															'label'   => '',
															'type'    => 'select',
															'class'   => 'show_appl_filter_select',
															'options' =>$answer1_array,
															'value'   => isset($filterOpt['answer1'])?$filterOpt['answer1']:"",
															'onChange'=>"return clear_div(this.value);",
															'div' =>false
															)
													  );
								?>
								
								
								
                            </div>
                        </div>
                        <div class="app_feild">
                        	<span>Current Salary</span>
                        	<div class="app_selectbox">
                            	<?php	$answer3_array = array('Less than $50K'=>'Less than $50K',
											'$50 - 75K'=>'$50 - 75K',
											'$75 - 100K'=>'$75 - 100K',
											'$100 - 150K'=>'$100 - 150K',
											'More than $150K'=>'More than $150K');
							echo $form->input('answer3', array('label'   => '',
															   'type'    => 'select',
                                                               'class'   => 'show_appl_filter_select',
															   'options' =>$answer3_array,
															   'div' 	 =>false,
															   'value'   => isset($filterOpt['answer3'])?$filterOpt['answer3']:"",
																'onChange'=>"return clear_div(this.value);"
															   ));?>
                            </div>
                        </div>
                        <div class="app_feild">
                        	<span>Job Type</span>
                        	<div class="app_selectbox">
                            	<?php $answer5_array = array(''=>'Select',
												 '1'=>'Full Time',
									 			 '2'=>'Part Time',
									 			 '3'=>'Contract',
									 			 '4'=>'Internship',
									 			 '5'=>'Temporary'); 

                      	  echo $form->input('answer5', array('label'   => '',
															 'type'    => 'select',
                                                             'class'   => 'show_appl_filter_select',
															 'options' =>$answer5_array,
															 'div'		=>false,
															 'value'   => isset($filterOpt['answer5'])?$filterOpt['answer5']:"",
															 'onChange'=>"return clear_div(this.value);"
															 ));?>
                            </div>
                        </div>
                        <div class="app_feild">
                        	<span>Shifts Availability</span>
                        	<div class="app_selectbox">
                            	<?php $answer7_array = array(''=>'Select','Yes'=>'Yes','No'=>'No');  ?>
								<?php echo $form->input('answer7', array('label'   => '',
															 'type'    => 'select',
                                                             'class'   => 'show_appl_filter_select',
									                         'options' =>$answer7_array,
															 'div'		=>false,
															 'value'   => isset($filterOpt['answer7'])?$filterOpt['answer7']:"",
															 'onChange'=>"return clear_div(this.value);"
															 ));?>
                            </div>
                        </div>
                        <div class="app_feild">
                        	<span>Training Needs</span>
                        	<div class="app_selectbox">
                            	<?php echo $form->input('answer10', array('label'   => '',
															  'type'    => 'select',
                                                              'class'   => 'show_appl_filter_select',
															  'options' =>$answer7_array,
															  'div' =>false,
															  'value'   => isset($filterOpt['answer10'])?$filterOpt['answer10']:"",
															  'onChange'=>"return clear_div(this.value);"
															 ));?>
                            </div>
                        </div>
                        
                        
                        
                    </div>
                    
                    <div class="applicants_right">
                    <div class="app_feild">
                        	<span>Work Experience</span>
                        	<div class="app_selectbox">
                            	<?php $answer2_array = array('0 to 2 Years'=>'0 to 2 Years',
											'2 to 5 Years'=>'2 to 5 Years',
											'5 to 10 Years'=>'5 to 10 Years',
											'More than 10 Years'=>'More than 10 Years');
									echo $form->input('answer2', array('label'   => '',
																 'type'    => 'select',
																 'class'   => 'show_appl_filter_select',
																 'options' =>$answer2_array,
																 'div'	   =>false,
																 'value'   => isset($filterOpt['answer2'])?$filterOpt['answer2']:"",
																 'onChange'=>"return clear_div(this.value);"));?>
                            </div>
                        </div>
                        <div class="app_feild">
                        	<span>Expected Salary</span>
                        	<div class="app_selectbox">
                            	<?php echo $form->input('answer4', array('label'   => '',
															 'type'    => 'select',
                                                             'class'   => 'show_appl_filter_select',
															 'options' =>$answer3_array,
															 'div'	   =>false,	
															 'value'   => isset($filterOpt['answer4'])?$filterOpt['answer4']:"",
															 'onChange'=>"return clear_div(this.value);"
															 ));?>
                            </div>
                        </div>
                        <div class="app_feild">
                        	<span>University/College</span>
                        	<div class="app_selectbox">
                            	<?php 
                    	  echo $form->input('answer6', array('label'   => '',
															 'type'    => 'select',
                                                             'class'   => 'show_appl_filter_select',
															 'options' =>$universities,
															 'empty'   =>"Select",
															 'div'		=>false,
															 'value'   => isset($filterOpt['answer6'])?$filterOpt['answer6']:"",
															 'onChange'=>"return clear_div(this.value);"
															));?>
                            </div>
                        </div>
                        <div class="app_feild">
                        	<span>Passport Availability</span>
                        	<div class="app_selectbox">
                            	<?php echo $form->input('answer8', array('label'   => '',
															 'type'    => 'select',
                                                             'class'   => 'show_appl_filter_select',
															 'options' =>$answer7_array,
															 'div'		=>false,
															 'value'   => isset($filterOpt['answer8'])?$filterOpt['answer8']:"",
															 'onChange'=>"return clear_div(this.value);"
															 ));?>
                            </div>
                        </div>
                        <div class="app_feild">
                        	<span>Travel Ability</span>
                        	<div class="app_selectbox">
                            	<?php echo $form->input('answer9', array('label'   => '',
															 'type'    => 'select',
                                                             'class'   => 'show_appl_filter_select',
															 'options' =>$answer7_array,
															 'div'		=>false,
															 'value'   => isset($filterOpt['answer9'])?$filterOpt['answer9']:"",
														     'onChange'=>"return clear_div(this.value);"
															 ));?>
                            </div>
                        </div>    
                    </div>
					<div class="clr"></div>
                    <div class="app_search">
						<div id="error_div" style="color:#FF0000"></div> 
                    	<div class="find_clr_button">
						<?php	echo $form->submit('SEARCH',array('div'=>false,)); ?>	
                        </div>
						<?php echo $form->end();?>
                        <div class="clr"></div>
                    </div>
                 
                </div>
					
					
                	<div class="app_table">
                    	<ul class="app_table_heading">
                        	<li class="app_table_name">Name</li>
                            <li class="app_dos">Degree of Separation</li>
                            <li>Network</li>
                            <li>Networker</li>
                            <li>Action</li>
                        </ul>
						
						<?php if(empty($applicants)): ?>
							<div style="font-size: 14px; margin: 40px auto auto; width:280px;*width:255px;">
								<span>Sorry, no applicant applied for this job.</span>
							</div>
						<?php endif; ?>
					
						<?php $i=0;?>
                        <?php foreach($applicants as $applicant):?>	
                         <ul class="<?php if($i%2==0) echo'dark';?>">
                        	<li class="app_table_name">
                            	<span>
									<a href="#" onclick="return jobseekersDetail(<?php echo $applicant['JobseekerApply']['id']; ?>, '<?php echo ucfirst($applicant['jobseekers']['contact_name']) ;?>')">
										<?php echo ucFirst($applicant['jobseekers']['contact_name']); ?>
									</a>
								</span>
                                <p>Submitted <?php echo $time->timeAgoInWords($applicant['JobseekerApply']['created']); ?></p>
	                            
								<p>
								<?php if($applicant['JobseekerApply']['resume']!=''){
										echo $html->link('view resume',array('controller'=>'/companies/','action' => '/viewResume/resume/'.$applicant['JobseekerApply']['id'])); }?>
								<?php if($applicant['JobseekerApply']['resume']!='' && $applicant['JobseekerApply']['cover_letter']!=''){ echo " | "; }?>
								<?php if($applicant['JobseekerApply']['cover_letter']!=''){ 
										echo $html->link('view cover letter',array('controller'=>'/companies/','action' => '/viewResume/cover_letter/'.$applicant['JobseekerApply']['id'])); }?>
								</p>
								
								
                            </li>
                            <li class="app_dos app_topmargin">
								<?php 
									$degree = 0;
									if($applicant['JobseekerApply']['intermediate_users']!=''){
									$intermediate_user_ids=explode(",",$applicant['JobseekerApply']['intermediate_users']);
										$degree = count($intermediate_user_ids);
									if(empty($intermediate_user_ids[0]) && $degree>1)
										$degree=$degree-1;
									} 
									echo $degree+1;
								?>
							</li>
                            <li class="app_topmargin">
								<?php
									// Match first networkers i.e. $applicant['User'] parent user
									$networkerEmail="--------"; $networkerUniversity="";
									if($applicant['User']['parent_user_id']==$applicant['Job']['user_id']&&$degree<1){
											echo "Personal";
									}elseif($applicant['NetworkerUser']['parent_user_id']==$applicant['Job']['user_id'] && $degree>=1){
										$networkerEmail=$applicant["NetworkerUser"]["account_email"];
										$networkerUniversity = $applicant["Networker"]["university"]!=0?"[".$universities[$applicant["Networker"]["university"]]."]":"";
											echo "Extended-Personal";
									}else{
										if($degree<1)
											echo "Hireroutes";
										else
											echo "Extended-Hireroutes";
									} 
								?>
								
							</li>
                            <li class="app_topmargin">
								<?php if(isset($networkerEmail)){
										echo $networkerEmail."<br>".$networkerUniversity;
									  }
								 ?>
							</li>
                            <li class="app_topmargin">
                            	<div class="app_action">
                                	<div class="app_action_check" title="Accept">
										<?php									
											echo $this->Html->link("" ,"/companies/checkout/".$applicant['JobseekerApply']['id'],array(
												"width"=>"24","height"=>"24",
												'title'=>'Accept'
											));
										?>
										
									</div>
                                    <div class="app_action_cross" title="Reject" onclick="return deleteItem(<?php echo $applicant['JobseekerApply']['id']; ?>,<?php echo $applicant['JobseekerApply']['job_id']; ?>);">
										<?php
											echo $this->Html->link("","javascript:void();", array(
											"alt" => "","width"=>"24","height"=>"24",
											'title'=>'Reject'
											));
										?>
									</div>
                                </div>
								
                            </li>
                        </ul>
                        <?php endforeach; ?>
                        
                    </div>
            </div>
     
        </div>
        <div class="clr"></div>
        <div class="job_pagination_bottm_bar"></div>									


<div class="clr"></div>
</div>
</div>


<script>
function goTo(){
	window.location.href="/companies/postJob";			
}

function deleteItem(id,jobid){

	if (confirm("Are you sure to Reject?")){
		window.location.href="/companies/rejectApplicant/"+id+"/"+jobid;
	}
	return false;
}
</script>



