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
		<input type=text id="SearchInput">
		<div id="FindJob" onclick="alert('find job');">FIND JOB</div>
	</div>
	<div id="HeadingHome">		
		<div id="HeadingVedio">HOW IT WORKS VIDEO</div>
		<div id="HeadingWhyHireRoutes">	WHY HIRE ROUTES?</div>
		<div id="HeadingJobList">JOB</div>
	</div>
	<div style="margin-top:10px;clear:both;">
		<div id="Video">vedio</div>
		<div id="WhyHireRoutes">
			<div id="WhyHireRoutesData">1: Hire Routes </div>
			<div id="WhyHireRoutesData">2: Hire Routes </div>
			<div id="WhyHireRoutesData">3: Hire Routes </div>
			<div id="WhyHireRoutesData">4: Hire Routes </div>
		</div>
		<div id="JobListOnHome">
			<?php foreach($jobs as $job):?>
				<div id="JobListData">
					<?php echo $this->Html->link($job['Job']['title'], '/jobs/jobDetail/'.$job['Job']['id']);
										
					 ?>
					<span style="float:right"><? echo "$".$job['Job']['reward'];?></span>
				</div>
				<div>	
					<?php echo $job['Job']['company_name'].','.$job['ind']['industry_name'];?>
				</div>
			<?	endforeach;?>
		</div>
	</div>
		<div id='GetStart' onclick="alert('Video');"> Get Started </div>
		<div id="ContanierForSearch">
			<label>Be in know</label>
			<input type="text" style="width:180px;">
			<div id="Go" onclick="alert('Find Job');">Go</div>
		</div>
	</div>	

<!-- end content-->
