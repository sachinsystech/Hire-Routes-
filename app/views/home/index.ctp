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
<ul>

</center>

<!-- end content-->