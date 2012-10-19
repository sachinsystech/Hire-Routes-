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
