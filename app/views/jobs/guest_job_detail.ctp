<?php $job_array = array('1'=>'Full Time',
                                 '2'=>'Part Time',
								 '3'=>'Contract',
								 '4'=>'Internship',
								 '5'=>'Temporary'); 
?>
<div class="job_top-heading_guest">
   	<div class="job_top_one">
   		<div class="job_top_heading1">Share this post with your network
       		<div class="job_top_share_job">
            	<div class="button-blue1">
					<input type="button" value="SHARE JOB" onclick='window.location.href="/jobs/shareJob/jobId=<?php echo $job['Job']['id'];?>";'>
					<div class="clr"></div>
				</div>
            </div>
        	<a href="/networkerInformation">How it works</a>
        </div>
	</div>
	<div class="job_top_two">OR</div>
    	<div class="job_top_one">
			<div class="job_top_heading1">Apply for the job yourself
				<div class="job_top_apply">
					<div class="login-button job-apply-button">
						<input type="button" value="APPLY FOR JOB" onclick='window.location.href="/jobs/applyJob/<?php echo $job['Job']['id'];?>"'>
						<div class="clr"></div>
					</div>
                    <div class="clr"></div>
				</div>
			<div class="job_apply_color"><a href="/jobseekerInformation">How it works</a></div>
		</div>
		<div class="clr"></div>
	</div>
    <div class="clr"></div>
</div>
<div class="job_container1">
	<div class="job_container_top_row job_guest_container">
		<div class="job_left_bar job_detail_guest_left">
			<h2>5 REASONS TO JOIN HIRE ROUTES</h2>
            <ul>
            	<li>Networkers can help friends and others find jobs and get paid for doing so!</li>
                <li>Employers can access new, select social networks to find talent!</li>
                <li>Job Seekers can find jobs and get paid for getting hired!</li>
                <li>Everyone can help the less fortunate.  A % of the reward goes to charity!</li>
                <li>Everyone can help Hire Routes grow so we can help more people!</li>
            </ul>
		</div>
		<div class="job_right_bar job_detail_guest_right job_right_bar_position">
			<div class="job_right_rightmost">
				<div class="job-right-reward-text job_reward_text">Reward: 
            		<span> <?php echo $this->Number->format(
										$job['Job']['reward'],
										array(
											'places' => 0,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?> </span>
				</div>
                <a href="JavaScript:void(0);" class="howPayoutWorks">How payouts work</a>
			</div>
            <div class="job-right-text">
				<div class="job_backtosearch"><a href="/jobs" >BACK TO SEARCH</a></div>
                <div class="job-right-text-heading"><a href="#"><?php echo strtoupper($job['Job']['title']); ?></a>
                </div>
                <p><span>Company:</span> <?php echo ucwords($job['comp']['company_name']);?></p>
                <p><span>Website:</span> <?php	echo $this->Html->link($job['comp']['company_url'],
                											 	$job['comp']['company_url'],
                											 	array('class'=>'NewTab')); ?></p>
                <p><span>Published:</span> <?php echo $job['ind']['industry_name']." - ".$job['spec']['specification_name']."</br> added on ".date('m/d/Y', strtotime($job['Job']['created']) ); ?>
                <p><span>Salary:</span> 
                 <?php echo $this->Number->format(
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
											//'decimals' => '.',
											'thousands' => ',')
				)." / Year";?>
                    <!--- 35,000 - $45,000 / Year-->
                </p>
                <p><span>Location:</span> <?php
												if(!empty($job['city']['city']))
												echo $job['city']['city'].",&nbsp;";
											?>
											<?php echo $job['state']['state']; ?>
				</p>
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
                <p>											
		            <div class="description" id="short_description">
						<?php $desc = $job['Job']['description'];
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
										echo $string.$dots;
									}?>
					</div>
					<div class="description" id="full_description" style="display:none;">
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
		<div class="clr"></div>
	</div>
	<div class="job_pagination_bottm_bar"></div>
	<div class="clr"></div>
</div>
<div >
	<?php echo $this->element('share_job');?>
</div>
<script type="text/javascript"> 
	
    function showDescription(){
		$('#full_description').show();
		$('#short_description').hide();
		$('#more_info').hide();
	}
</script>
<!--------------Dialog box for how payout works ----------->
<?php echo $this->element("sql_dump");?>
<div style="display:none;" id = "about-dialog">
	<?php echo $this->element("payout");?>
</div>
