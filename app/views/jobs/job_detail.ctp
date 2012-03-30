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
	<div class="rightBox" >
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
                                        <strong>Website :</strong> <?php	echo $this->Html->link($job['comp']['company_url'], 'http://'.$job['comp']['company_url']); ?><br>
 										<strong>URL :</strong> <input type="text" value="<?php echo Configure::read('httpRootURL').'jobs/jobDetail/'.$job['Job']['id'].'/'; echo isset($code)?'?code='.$code:''; ?>" style="width:100px;"><br>
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
                            <div id="apply">
                            	<a href="/jobs/applyJob/<?php echo $job['Job']['id'];?>">
										<input type="button" name="apply" value="Apply For This Job"/>
									</a>
							</div>
							<?php }?>
						</td>
					</tr>
				</table>

			</div>
		</div>	
            <?php echo $this->element("jobRight"); ?>
		<!-- middle conyent list -->
	</div>
	<div class="reward">
		<p><font size='5px'><b>Total Reward $<?php echo $job['Job']['reward'];?></b></font></br>
		<font size='3px'><b>Your reward is up to $<?php echo $job['Job']['reward'];?></b></font></p></br>
		<p><a href='httpRootUrl/how_it_works'>See how it works >></a></p></br>
		<?php if(empty($userrole['role'])){?>
			<p>Know the perfact candidate for this job?</br>
			<font size='3px'><a href='/users/login'><b>Login</b></a>
			OR
			<a href='/users/networkerSignup'><b>Register</b></a>
			</font></br>
			To share and get a Reward
			</p></br>
			<p>Are you the perfact candidate for this job?</br>
			<font size='3px'><a href='/users/login'><b>Login</b></a>
			OR
			<a href='/users/jobseekerSignup'><b>Register</b></a>
			</font></br>
			To apply
			</p>
		<?php }?>
	</div>
	<!-- middle section end -->
</div>
<?php  endif; ?>

