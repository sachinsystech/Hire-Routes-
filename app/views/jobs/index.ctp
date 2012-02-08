<?php 

	if(isset($job)){
		//echo "<pre>";print_r($job); exit;
	}

?>
<div class="page">
	<!-- left section start -->
	<?php if(!isset($job)):?>
		<div class="joblist_rightBox">
			<div class="sideMenu">
			Industries
			</div>
			<div>Salary Range</div>
			<div>Location</div>
			<div>Job Type</div>
			<div>Company</div>			
		</div>
	<?php endif;?>
	
	<!-- left section end -->
	<!-- middle section start -->
	<div class="rightBox" >
		<!-- middle conent top menu start -->
		<?php if(!isset($job)):?>
		<div class="jobs_topMenu">
			<div style="margin-top:10px">
				<div style="float:left">
					<?php echo $form -> input('short_by',array(
												'type'=>'select',
												'label'=>'SORT BY ',
												'options'=>array('1' => 'Date Added', '2' => 'Company Name', '3' => 'Industry', '4' => 'Salary'),
												'class'=>'job_select_shortby',
												'selected'=>'1'
										)
							);
					?>
				</div>
				
				<div style="float:right">
					<?php echo $form -> input('short_by',array(
												'type'=>'select',
												'label'=>'DISPLAYING ',
												'options'=>array('10' => '10', '20' => '20', '30' => '30', '50' => '50'),
												'class'=>'job_select_diplay',
												'selected'=>'1'
										)
							);
					?>
				</div>
			</div>	
		</div>
		<?php endif;?>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
		<?php $job_array = array('1'=>'Full Time','2'=>'Part Time','3'=>'Contract','4'=>'Internship','5'=>'Temporary'); ?>
			<div class="joblist_middleBox">
			<table style="width:100%">

			<?php if(isset($job)){?>

				<tr>
					<td>
						<div>
							<div style="float:left" class="text_heading"> <?php	echo $job['title']; ?></div>
							<div style="float:right"> <?php	echo $job['reward'];?>$</div>
						</div>
						<div style="clear:both">		
						<div>
							<?php	echo $companies[$job['user_id']]." - ".$job['city'].",".$states[$job['state']]."<br>";
									echo $industries[$job['industry']].", ".$specifications[$job['specification']]."<br>";
									echo $job_array[$job['job_type']]."<br>";
									echo $job['short_description']."<br>";
									echo $job['description']."<br>";
							?>
						</div>			
					</td>
				</tr>
			<?php	
			}
			else{
					foreach($jobs as $job):?>	
					<tr>
						<td>
							<div>
								<div style="float:left"> <?php	echo $this->Html->link($job['title'], '/jobs/'.$job['id']); ?></div>
								<div style="float:right"> <?php	echo $job['reward'];?>$</div>
							</div>
							<div style="clear:both">		
							<div>
								<?php	echo $companies[$job['user_id']]."- ".$job['city'].",".$states[$job['state']]."<br>";
										echo $industries[$job['industry']].", ".$specifications[$job['specification']]."<br>";
										echo $job_array[$job['job_type']]."<br>";
										echo $job['short_description']."<br>";
								?>
							</div>			
						</td>
					</tr>
				<?php endforeach; 
			}?>
			</table>
			</div>

		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->

</div>

<script>
function goTo(){
	window.location.href="/companies/postJob";			
}
</script>