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
			<div class="job-right-top-content1">
				<div class="job-right-top-left job-profile">
					<h2>DATA</h2>
					<p><span>Job Posted:</span>
						<?php echo $JobPosted;?>
					</p>
											
					<p><span>Job Filled:</span> 
						<?php echo $JobFilled;?>
					</p>
					<p><span>Rewards Posted:</span> 
						<?php echo $this->Number->format(
										$RewardsPosted,
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
							);?>
					</p>
					<p><span>Applicants:</span> 
						<?php echo $Applicants;?>
					</p>
					<p><span>Views:</span> 
						<?php echo $Views;?>
					</p>
				</div>
		   </div>
		</div>
		<div class="clr"></div>
	</div>
	<div class="job_pagination_bottm_bar"></div>
	<div class="clr"></div>
</div>	
