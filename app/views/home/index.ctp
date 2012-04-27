<!-- start content-->
<div style="clear:both">
	<?php echo $this->Session->flash('auth');?>
	
	<ul class="home-image">
		<li>
			<?php 
				echo $html->link($html->image("../img/media/1.png",array('width' => 240)), array('controller'=>'home', 'action' => 'companyInformation'), array('escape' => false));
			?>
		</li>
		<li>
			<?php 
				echo $html->link($html->image("../img/media/2.png",array('width' => 240)), array('controller'=>'home', 'action' => 'networkerInformation'), array('escape' => false));
			?>
		</li>
		<li>
			<?php 
				echo $html->link($html->image("../img/media/3.png",array('width' => 240)), array('controller'=>'home', 'action' => 'jobseekerInformation'), array('escape' => false));
			?>
		</li>
	</ul>
</div>
<div id="HomeContanier">
	<div>
		<?php
			echo $this->Form->create('SearchJob', array('url' => array('controller' => 'Jobs', 'action' => 'searchJob')));
		?>
		<div style="border:1px solid;overflow:auto;padding:0px;width:850px;">
		<?php
			echo $this->Form->input('what', array('label' => '',
							                'type' => 'text',
        	                                'id' => 'SearchInput',
        	                                'div'=>false
        	                                )
        	                            );
			echo $this->Form->submit('Find Job',array('id'=>'FindJob',
													'div'=>false
												)
										);
		?>
		</div>
		<?php
			echo $this->Form->end();
		?>
	</div>
	<div style="width:283px;overflow:auto;float:left;">
		<center>
			<div id="HeadingHome">HOW IT WORKS VIDEO</div>
			<div class="Video">video</div>
			<div id='GetStart' onclick="getStarted();"> Get Started </div>
		</center>
	</div>
	<div style="width:283px;overflow:auto;float:left;">
		<div id="HeadingHome">	WHY HIRE ROUTES?</div>
		<div class="WhyHireRoutes">
			<div class="WhyHireRoutesData">1: Job Search </div>
			<div class="WhyHireRoutesData">2: Share Job </div>
			<div class="WhyHireRoutesData">3: Earn Reward </div>
			<div class="WhyHireRoutesData">4: Hire Routes </div>
		</div>
	</div>
	<div style="width:283px;overflow:auto;float:left;">
		<div id="HeadingHome">JOBS</div>
		<div id="JobListOnHome">
			<?php foreach($jobs as $job):?>
				<div class="JobListData">
					<?php
						echo $this->Html->link($job['Job']['title'], '/jobs/jobDetail/'.$job['Job']['id']);
					?>
					<span style="float:right">
						<?php
							echo "<b>$</b>".number_format($job['Job']['reward'],'2','.','');
						?>
					</span>
				</div>
				<div>	
					<?php 
						if(!empty($job['companies']['company_name'])) 
							echo $job['companies']['company_name'].",&nbsp;";
						echo $job['ind']['name'];
					?>
				</div>
				<?php
					endforeach;
				?>
		</div>
		<div id="ContanierForSearch">
			<label>Be in know</label>
			<input type="text" style="width:180px; border: 1px solid #000000;;height:20px;">
			<div id="Go" onclick="">Go</div>
		</div>
	</div>
</div>
<script>
function getStarted(){
    window.location.href="/users/userSelection";			
}
</script>
<!-- end content-->
