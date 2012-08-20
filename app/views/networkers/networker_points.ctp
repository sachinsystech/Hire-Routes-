<div class="job_top-heading">
	<?php if($this->Session->read('Auth.User.id')):?>
		<?php if($this->Session->read('welcomeName') && ($this->Session->read('UserRole'))):?>
				<h2>WELCOME <?php echo strtoupper($this->Session->read('welcomeName'));?>!</h2>
		<?php endif; ?>
	<?php endif; ?>
</div>
<div class="job_container">
	<div class="job_container_top_row">
		<!------------------------ Start Networker side menu ------------------------->
			<?php echo $this->element('side_menu');?>
		<!------------------------ End Networker side menu ------------------------->
		<div class="job_right_bar">
			<div class="job-right-top-content1">
				<div class="job-right-top-left">
            		<h2>POINTS</h2>
                    <p>Your Total Points: <span><?php echo $user['Networkers']['points']?></span></p>
                    <p>Your Bonus Rewards: <span><?php echo $this->Number->format(
													$networkerBonus[0]['nr_bonus'],
													array(
														'places' => 2,
														'before' => '$',
														'decimals' => '.',
														'thousands' => ',')
													);?>
													</span>
					</p>
					<p>Ranking: <span><?php echo $userRank['rank']; ?> Of <?php echo $userRank['totalNr'] ?></span></p>
					<p>Your Experience Level: <span> <?php echo $pointLables['PointLabels']['level'] ?></span></p>
					<p>Your Bonus: <span>+ <?php echo $pointLables['PointLabels']['bonus'] ?> %</span></p>
					<p>Networker Title: <span><?php echo $pointLables['PointLabels']['networker_title'] ?></span></p>
				</div>
                <div class="job-pts-right-top-left">
                	<h2>LEADERBOARD</h2>
                    <ul>
                   		<?php $i = 1; 
							 foreach( $boardData as $key =>$data) {?>
						<li><?php if($data['Networker']['contact_name'] != null && $data['Networker']['contact_name'] != ""){	
									 echo $data['Networker']['contact_name']." , ".$data['UserList']['account_email'];
								 }else{
								 	 echo $data['UserList']['account_email'];
								 }
							?>
						</li>
						<?php } ?>
                   </ul>
				</div>
			</div>
		</div>
		<div class="clr"></div>
	</div>
    <div class="job_pagination_bottm_bar"></div>
 	<div class="clr"></div>
</div>

