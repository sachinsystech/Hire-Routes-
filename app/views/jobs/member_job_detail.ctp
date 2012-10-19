<script type="text/javascript"> 
	
    function showDescription(){
		$('#full_description').show();
		$('#short_description').hide();
		$('#more_info').hide();
	}
</script>
<?php $job_array = array('1'=>'Full Time',
                                 '2'=>'Part Time',
								 '3'=>'Contract',
								 '4'=>'Internship',
								 '5'=>'Temporary'); 
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
      <!-- Job- Left - Sidebar -->
      <?php echo $this->element('side_menu');?>
	 <!-- Job - left- sidebar Ends --> 
              
	 <!-- Job - Right- sidebar -->  
		<div class="job_right_bar job_right_bar_position">
			<div class="job_right_top_bar job-right-top-bar-border"> 
				<div class="job-right-heading"><a href="/jobs">Back to Search</a></div>
			</div>
			<div class="job-right-extreme-right">
				<div class="job-right-reward">
					<div class="job-right-reward-text">Reward: <span> <?php echo $this->Number->format(
										$job['Job']['reward'],
										array(
											'places' => 0,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?> </span>
					</div>
					<?php if(isset($userRole) && $userRole==JOBSEEKER && !isset($jobapply)){?>
                    <div class="button-jobseeker button-apply-margin"> <a href="/jobs/applyJob/<?php echo $job['Job']['id'];?>">APPLY FOR JOB</a></div>
					<?php }?>
					
					<div class="button-network button-apply-margin">  <a href="#" onclick='shareJobShowView(4);'>SHARE JOB</a></div>
		        </div>
		        <div class="job-right-how-payout"><a href="#" class="howPayoutWorks">How payouts work</a></div>
		    </div>
		    <div class="job-right-text">
		    	<div class="job-right-text-heading"><a href="#"><?php echo strtoupper($job['Job']['title']); ?></a></div>
		        <p><span>Company:</span><?php echo ucwords($job['comp']['company_name']);?></p>
	            <?php 
               		if(strpos($job['comp']['company_url'],"http") === false){
						$jobUrl = "http://".$job['comp']['company_url']; 
					}else{
						$jobUrl = $job['comp']['company_url']; 
					}
				?>
		        <p><span>Website:</span> <?php	echo $this->Html->link($job['comp']['company_url'],
		        												$jobUrl,array(
		        												'class'=>'NewTab',
		        												)
		        											); ?></p>
		        <p><span>Published:</span> <?php echo $job['ind']['industry_name']." - ".$job['spec']['specification_name']."</br> added on ".date('m/d/Y', strtotime($job['Job']['created']) ); ?></p>
		        <p><span>Salary:</span>  <?php echo $this->Number->format(
										$job['Job']['salary_from'],
										array(
											'places' => 0,
											'before' => '$',
											//'decimals' => '.',
											'thousands' => ',')
										)." - ".$this->Number->format(
										$job['Job']['salary_to'],
										array(
											'places' => 0,
											'before' => '$',
											'thousands' => ',')
				)." / Year";?></p>
		        <p><span>Location:</span> <?php
												if(!empty($job['city']['city']))
												echo $job['city']['city'].",&nbsp;";
											?>
											<?php echo $job['state']['state']; ?></p>
		        <p><span>Type:</span> <?php echo $job_array[$job['Job']['job_type']]; ?></p>
                 <?php if(isset($job['Job']['requirements']) && $job['Job']['requirements'] != ""){ ?>
					<p><span>Requirements:</span> <?php echo $job['Job']['requirements']; ?></p>				
				<?php }?>
				<?php if(isset($job['Job']['benefits']) && $job['Job']['benefits']!= ""){ ?>
					<p><span>Benefits:</span> <?php echo $job['Job']['benefits']; ?></p>
				<?php } ?>
				<?php if(isset($job['Job']['keywords']) && $job['Job']['keywords']!= ""){ ?>				
					<p><span>Keywords:</span> <?php echo $job['Job']['keywords']; ?></p>
				<?php } ?>
				 <br />
		        <p><span>Job Description:</span></p>
		        <p><div class="description" id="short_description" style="width:681px;">
						<?php $desc = "Description Our Client is seeking a Java Developer. 
 
                              
 
Position Purpose
We are looking for a Java Front-End Developer who can put pretty faces on our internal and customer facing web applications.  The ideal candidate is a developer with strong graphical aptitudes, has a passion for good UI design, and is able to implement a feature all the way from front to back
 
Key Responsibilities
Work closely with product managers, developers and quality assurance engineers to build exciting new features and applications
Solicit feedback early and often to make sure we are building the &acirc;��right stuff&acirc;��
Proactively obtain and clarify requirements as necessary
Contribute to the automated testing of our web applications
Estimate and plan with the development team to help ensure delivery schedules are met
 
Qualifications
Education/Certification:
4 year degree (preferred)
 
Required Knowledge:     
Strong understanding of Java SE and related web technologies
Excellent knowledge of CSS, HTML, JavaScript and one or more Java presentation technologies (e.g. JSP, Velocity, etc.)
Effective knowledge of SQL and databases
Strong understanding of performance and scalability considerations when building applications
Works well as an individual and as part of a team
Experience with Unix/Linux
Experience with agile software development  methodologies/Scrum (preferred)
Experience with Groovy or other Java platform languages (preferred)
Experience with automating web application testing (preferred)
Experience with XML and JSON (preferred)
 
Experience Required:
3 or more years developing the front ends of Java based web applications          
 
Skills/Abilities:                                   
Experience working with one or more Java web application frameworks and application servers
Passion for UI design and usability
 
Physical Requirements and Working Conditions
&acirc;�&cent;Physical Requirements:         Those required in a typical office environment including sitting most of the time, finger dexterity for computer and paper work, talking to convey detailed or important instructions, average hearing for normal conversations, and average visual acuity.  
&acirc;�&cent;Working Conditions:               No hazardous or significantly unpleasant conditions";//$job['Job']['description'];
									if($desc!=''){
		                            	$explode = explode(' ',$desc);
										$string  = '';
										$dots = '...';
										if(count($explode) <= 130){
											$dots = '';
										}
										$count  = count($explode)>= 130 ? 130 :count($explode) ;
										for($i=0;$i<$count;$i++){
											$string .= $explode[$i]." ";
										}
										if($dots){
											$string = substr($string, 0, strlen($string));
										}
										echo html_entity_decode($string.$dots,ENT_QUOTES);
									}?>
					</div>
					<div class="description full_description" id="full_description" style="display:none;">
						<?php echo $job['Job']['description'];?>
					</div>
					<?php if(str_word_count($desc)>130){?>
						<div id="more_info">
							<a onclick="showDescription();">More Info</a>
						</div>
					<?php }?>
				</p>
		    </div>
		</div>
	</div>
	<div class="job_pagination_bottm_bar"></div>
	<div class="clr"></div>
</div>	
<div class="clr"></div>
<div style="display:none;">
	<?php echo $this->element('share_job');?>
</div>

<!--------------Dialog box for how payout works ----------->

<div style="display:none;" id = "about-dialog">
	<?php echo $this->element("payout");?>
</div>
