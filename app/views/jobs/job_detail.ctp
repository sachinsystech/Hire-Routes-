<?php /*Job Details*/?>

<script type="text/javascript"> 
	
    function showDescription(){
	    $('#full_description').show();
            $('#short_description').hide();
            $('#more_info').hide();
	}
</script>
		
<!-- ------------------------ PARTICULAR JOB DETAIL ---------------------->	

	
<?php if(isset($job)): ?>	
<div class="page">
	<!--left section start-->
	<div class="leftPanel">
		<div class="sideMenu">
			<?php echo $this->element('side_menu');?>
		</div>
	</div>
	<!--left section end-->
	<!-- middle section start -->
	<div class="rightBox" style="width:690px;" >
		<!--middle conyent top menu start-->
			<div class='top_menu'>
				<?php echo $this->element('top_menu');?>
			</div>
		<!--middle conyent top menu end-->
		<!-- middle conyent list -->
		<?php $job_array = array('1'=>'Full Time',
                                 '2'=>'Part Time',
								 '3'=>'Contract',
								 '4'=>'Internship',
								 '5'=>'Temporary'); ?>
			<div class="jobDetail_middleBox">
				<table>
					<tr>
						<td>
							<div>
								<div class="logo">
									<img src="" alt="Company Logo" title="company logo" />
								</div>
								<div>
									<div class="title"><?php echo ucfirst($job['Job']['title']); ?></div>
									<div class="detail">
										<strong>By Company :</strong> <?php echo $job['Job']['company_name']."<br>"; ?>

                                        <strong>Website : </strong><?php	echo $this->Html->link($job['comp']['company_url'], 'http://'.$job['comp']['company_url']); ?>
                                        <br>

                                        <strong>Published in :</strong> 
											<?php echo $job['ind']['industry_name']." - ".$job['spec']['specification_name'].", "; ?>
											<?php  echo $time->timeAgoInWords($job['Job']['created'])."<br><br>";?>
									</div>
								</div>
								<div>
									<div class="about_job"><strong>About the Job</strong></div>
                                    <div class="other_detail">
                                    	<strong>Location :</strong> 
											<?php echo $job['city']['city'].", ".$job['state']['state']."<br>"; ?>
										<strong>Annual Salary Range :</strong> 
											<?php echo $job['Job']['salary_from']." - ".$job['Job']['salary_to']."<br>"; ?>
										<strong>Type :</strong> 
											<?php echo $job_array[$job['Job']['job_type']]."<br>"; ?>
									</div>
									<div class="desc">
										<?php echo $job['Job']['short_description']."<br>";?>
									</div>
								</div>
								<div class="company_detail">
									<span>
										<strong><?php echo $job['Job']['company_name']; ?></strong></span> - 
												<?php echo $job['city']['city'].", ".$job['state']['state']."<br>"; ?>
                                                <?php echo $this->Html->link($job['comp']['company_url'], 'http://'.$job['comp']['company_url']); ?><br><br>
											<div class="description" id="short_description">
											<?php $desc = $job['Job']['description'];
													if($desc!=''){
                                                    	$explode = explode(' ',$desc);
														$string  = '';
														$dots = '...';
														if(count($explode) <= 20){
															$dots = '';
														}
														$count  = count($explode)>= 20 ? 20 :count($explode) ;
														for($i=0;$i<$count;$i++){
															$string .= $explode[$i]." ";
														}
														if($dots){
															$string = substr($string, 0, strlen($string));
														}
														echo $string.$dots;
													}?>
											</div>
											<div class="description" id="full_description" style="display:none;">
												<?php echo $job['Job']['description'];?>
											</div>
										</div>
										<?php if(str_word_count($desc)>20){?>
											<div id="more_info">
												<a onclick="showDescription();">More Info</a>
											</div>
										<?php }?>
									</div>
								<div>
							</div>
							<?php if(isset($userrole) && $userrole['role_id']==2 && !isset($jobapply)){?>
                            <div id="apply" style="padding:20px;">
								<div class="selection-button">
									  <button style="width:200px" onclick='window.location.href="/jobs/applyJob/<?php echo $job['Job']['id'];?>"'><a style="text-decoration: none;">Apply for this job</a></button>
								</div>
							</div>
							<?php }?>
						</td>
					</tr>
				</table>

			</div>
		</div>	
            <?php //echo $this->element("jobRight"); ?>
		<!-- middle conyent list -->
	</div>

	<div style="font-size:1.2em;float:right;width:200px;text-align:center;margin-right:30px;">
		<div style="font-weight:bold;">
			<div style="font-size:1.4em;">
				Total Reward <?php echo $this->Number->format(
										$job['Job']['reward'],
										array(
											'places' => 2,
											'before' => '',
											'decimals' => '.',
											'thousands' => ',')
										)."$";?>
			</div>
			<div>
				Your reward is up to <?php echo $this->Number->format(
										$job['Job']['reward'],
										array(
											'places' => 2,
											'before' => '',
											'decimals' => '.',
											'thousands' => ',')
										)."$";?>
			</div>
		</div>
		<div style="font-size:1.2em;">
			<a href='/howItWorks'>See how it works >></a>
		</div>

		<?php if(empty($userrole['role'])){?>
			<div style="margin-top:20px;">
				<div >
					Know the perfact candidate for this job?
				</div>
				<div >
					<a href='/users/login'><b>Login</b></a>
					OR
					<a href='/users/networkerSignup'><b>Register</b></a>
				</div>
				<div >
					To share and get a Reward
				</div>
			</div>
			<div style="margin-top:20px;">
				<div >
					Are you the perfact candidate for this job?
				</div>
				<div >
					<a href='/users/login'><b>Login</b></a>
					OR
					<a href='/users/jobseekerSignup'><b>Register</b></a>
				</div>
					To apply
			</div>
		<?php }else{
		?>
			<div style="text-align:left">
				<div> Share your unique URL </div>
<div><input type="" value="<?php echo Configure::read('httpRootURL').'jobs/jobDetail/'.$job['Job']['id'].'/'; isset($code)?'?code='.$code:'' ?>"></div>

	<div>Mail It</div>

	<div>Share It on Facebook</div>

	<div>Post on LinkedIn</div>

	<div>Tweet It</div>
	</div>
		<?php
			}
		
		?>
	</div>
	<!-- middle section end -->
</div>
<?php  endif; ?>

