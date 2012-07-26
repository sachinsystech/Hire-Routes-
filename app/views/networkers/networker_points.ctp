
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
		<!-- middle content top menu start -->
		<div class="topMenu">
			<?php echo $this->element('top_menu');?>
		</div>
		<!-- middle content top menu end -->
		<!-- middle content list -->
		
			<div class="network_points_middleBox">
				<div class= "networker_points_content">
					<div class ="networker_points_top_content">
						<div class="networker_points_heading">
							<div>
								<span>Your Total Points</span>
							</div>
							<div class="networker_points_heading_data">
								<span><?php echo $user['Networkers']['points']?></span>
							</div>
						</div>
						<div class="networker_bonus_heading">
							<div>
								<span>Your Bonus Rewards</span>
							</div>
							<div class="networker_bonus_heading_data">
								<span><?php echo $this->Number->format(
										$networkerBonus[0]['nr_bonus'],
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?>
								</span>
							</div>
						</div>
						<div class="networker_ranking_heading">
							<div>
								Ranking
							</div>
							<div class="networker_ranking_heading_data">
								<span> <?php echo $userRank['rank']; ?> Out Of <?php echo $userRank['totalNr'] ?></span>
							</div>						
						</div>	
					</div>
					<div class="networker_points_main_content">
						<div class ="networker_point_experience">
							<div class ="points_experience_level">
								<span>Experience Level</span>
								<div><span > <?php echo $pointLables['PointLabels']['level'] ?></span></div>
							</div>
							<div class ="points_experience_level">
								<span>Bonus</span>
								<div><span > + <?php echo $pointLables['PointLabels']['bonus'] ?> %</span></div>
							</div>
							<div class ="points_experience_level">
								<span>Networker Title</span>
								<div><span ><?php echo $pointLables['PointLabels']['networker_title'] ?></span></div>
							</div>
						</div>
						<div class ="points_leader_board">
							<div class="leader_heading"><span> Leader Board</span> </div>
							<?php $i = 1; ?>
							<?php foreach( $boardData as $key =>$data) {?>
								<div>
									<b><?php echo $i++ ; ?></b>
									<?php echo ".  ".$data['UserList']['account_email'] ?>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		<!-- middle content list -->

	</div>
	<!-- middle section end -->

</div>
