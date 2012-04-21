<!-- start content-->
<center>
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
</center>
<div id="HomeContanier">
	<div>
		<?php
			echo $this->Form->create('SearchJob', array('url' => array('controller' => 'Jobs', 'action' => 'searchJob')));
		?>
		<div style="border:1px solid;overflow:auto;padding:0px;">
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
			echo $this->Form->end();
		?>
	</div>
	<div id="HeadingHome">		
		<div id="HeadingVedio">HOW IT WORKS VIDEO</div>
		<div id="HeadingWhyHireRoutes">	WHY HIRE ROUTES?</div>
		<div id="HeadingJobList">JOBS</div>
	</div>
	<div style="margin-top:10px;clear:both;">
		<div class="Video">video</div>
		<div class="WhyHireRoutes">
			<div class="WhyHireRoutesData">1: Hire Routes </div>
			<div class="WhyHireRoutesData">2: Hire Routes </div>
			<div class="WhyHireRoutesData">3: Hire Routes </div>
			<div class="WhyHireRoutesData">4: Hire Routes </div>
		</div>
		<div id="JobListOnHome">
			<?php foreach($jobs as $job):?>
				<div class="JobListData">
					<?php echo $this->Html->link($job['Job']['title'], '/jobs/jobDetail/'.$job['Job']['id']);
										
					 ?>
					<span style="float:right"><? echo "<b>$</b>".number_format($job['Job']['reward'],'2','.','');?></span>
				</div>
				<div>	
					<?php 
						if(!empty($job['companies']['company_name'])) 
							echo $job['companies']['company_name'].",&nbsp;";
							echo $job['ind']['name'];
					?>
				</div>
			<?	endforeach;?>
		</div>
	</div>
		<div id='GetStart' onclick="getStarted();"> Get Started </div>
		<div id="ContanierForSearch">
			<label>Be in know</label>
			<input type="text" style="width:180px; border: 1px solid #000000;;height:20px;">
			<div id="Go" onclick="">Go</div>
		</div>
	</div>	
<script>
function getStarted(){
    window.location.href="/users/userSelection";			
}
</script>
<!-- end content-->
