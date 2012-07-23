
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
								<a href="#">Your Total Points</a>
							</div>
							<div class="networker_points_heading_data">
								<span><?php echo $user['Networkers']['points']?></span>
							</div>
						</div>
						<div class="networker_bonus_heading">
							<div>
								<a href="#">Your Bonus Rewards</a>
							</div>
							<div class="networker_bonus_heading_data">
								<span>$ 2,500</span>
							</div>
						</div>
						<div class="networker_ranking_heading">
							<div>
								<a href="#">Ranking</a>
							</div>
							<div class="networker_ranking_heading_data">
								<span> 4 Out Of 350</span>
							</div>						
						</div>	
					</div>
					<div class="networker_points_main_content">
						<div class ="networker_point_experience">
							<div class ="points_experience_level">
								<a href="#">Experience Level</a>
								<div><span > <?php echo $pointLables['PointLabels']['level'] ?></span></div>
							</div>
							<div class ="points_experience_level">
								<a href="#">Bonus</a>
								<div><span > + <?php echo $pointLables['PointLabels']['bonus'] ?> %</span></div>
							</div>
							<div class ="points_experience_level">
								<a href="#">Networker Title</a>
								<div><span ><?php echo $pointLables['PointLabels']['networker_title'] ?></span></div>
							</div>
						</div>
						<div class ="points_leader_board">
							<div class="leader_heading"><a href="#"> Leader Board</a> </div>
							<?php $i = 1; ?>
							<?php foreach( $boardData as $key =>$data) {?>
								<div>
									<?php echo $i++ ; echo ".  ".$data ; ?>
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
