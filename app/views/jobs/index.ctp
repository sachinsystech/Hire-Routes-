

<!-- ------------------------ ALL JOBS LISTING -------------------------->
<script>
	$(document).ready(function(){
	    $("#switch_display").change(onSelectChange);
		$("#short_by").change(onSelectShortByChange);
	});
	function onSelectChange(){
	    var selected = $("#switch_display option:selected");    
	    if(selected.val() != 0){
			window.location.href="/jobs/index/display:"+selected.text();
	    }
	}
	function onSelectShortByChange(){
	    var selected = $("#short_by option:selected");    
	    if(selected.val() != 0){
			window.location.href="/jobs/index/shortby:"+selected.val();
	    }
	}
</script>
<?php if(!isset($job)): ?>

<div class="page">
	<div style="width:890px;height:10px;padding: 22px;">
		<div style="float:left;width: 268px;margin-left: 65px;">
			WHAT <input class="text_field_bg"> 
		</div>
		<div style="float:left;width: 268px;margin-left: 160px;">
			WHERE <input class="text_field_bg"> 
		</div>
		<div style="float:right;width: 100px;">
			<button style="float: right; width: 100px; background:rgb(0, 255, 0);"> Find Job</button>
		</div>

	</div>

	<!-- left section start -->
		<div class="joblist_rightBox">
			<div class="sideMenu">
				<span>Industries</span>
				<div>
					<?php /* foreach($industries as $industry):?>
						<div>
							<?php	echo $form->input('', array('label' => "<span>$industry</span>",
														'type'  => 'checkbox',
														'name'  => "data[User][agree_condition]",
														)
									 );
							?>
						</div>
					<?php endforeach; */ ?>
				</div>				
			</div>
			<div>Salary Range</div>
			<div>Location</div>
			<div>Job Type</div>
			<div>Company</div>			
		</div>
	
	<!-- left section end -->
	<!-- middle section start -->
	<div class="rightBox" >
		<!-- middle conent top menu start -->
		<div class="jobs_topMenu">
			<div style="margin-top:10px">
				<div style="float:left">
					<?php echo $form -> input('short_by',array(
												'type'=>'select',
												'label'=>'SORT BY ',
												'options'=>array('date-added' => 'Date Added', 'company-name' => 'Company Name', 'industry' => 'Industry', 'salary' => 'Salary'),
												'class'=>'job_select_shortby',
												'selected'=>isset($shortBy)?$shortBy:'date-added',
										)
							);
					?>
				</div>
				
				<div style="float:right">
					<?php $display_page_no = array('5' => '5', '10' => '10', '15' => '15', '20' => '20');?>
					<?php echo $form -> input('switch_display',array(
												'type'=>'select',
												'label'=>"< < <".$this->Paginator->numbers()."> > > DISPLAYING </span>",
												'options'=>$display_page_no,
												'class'=>'job_select_diplay',
												'selected'=>isset($displayPageNo)?$displayPageNo:5,
												)
							);
					?>
				</div>
			</div>	
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
		<?php $job_array = array('1'=>'Full Time','2'=>'Part Time','3'=>'Contract','4'=>'Internship','5'=>'Temporary'); ?>
			<div class="joblist_middleBox">
			<table style="width:100%">

				<?php foreach($jobs as $job):?>	
					<tr>
						<td>
							<div>
								<div style="float:left"> <?php	echo $this->Html->link($job['title'], '/jobs/'.$job['id']); ?></div>
								<div style="float:right"> <?php	echo $job['reward'];?>$</div>
							</div>
							<div style="clear:both">		
							<div>
								<?php	echo $job['company_name']."- ".$job['city'].",".$states[$job['state']]."<br>";
										echo $industries[$job['industry']].", ".$specifications[$job['specification']]."<br>";
										echo $job_array[$job['job_type']]."<br>";
										echo $job['short_description']."<br>";
								?>
							</div>			
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
			</div>

		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->

</div>
<?php  else:?>	
		
<!-- ------------------------ PARTICULAR JOB DETAIL ---------------------->	

	
<?php if(isset($job)): ?>	
<div class="page">


	<!-- left section start -->
	
	<!-- left section end -->
	<!-- middle section start -->
	<div class="rightBox" >
		<!-- middle conent top menu start -->
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
		<?php $job_array = array('1'=>'Full Time','2'=>'Part Time','3'=>'Contract','4'=>'Internship','5'=>'Temporary'); ?>
			<div class="joblist_middleBox">
				<table style="width:100%">
					<tr>
						<td>
							<div>
								<div style="float:left" class="text_heading"> <?php	echo $job['title']; ?></div>
								<div style="float:right"> <?php	echo $job['reward'];?>$</div>
							</div>
							<div style="clear:both">		
							<div>
								<?php	echo $job['company_name']." - ".$job['city'].",".$states[$job['state']]."<br>";
										echo $industries[$job['industry']].", ".$specifications[$job['specification']]."<br>";
										echo $job_array[$job['job_type']]."<br>";
										echo $job['short_description']."<br>";
										echo $job['description']."<br>";
								?>
							</div>			
						</td>
					</tr>
				</table>
			</div>

		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->
</div>
<?php  endif; ?>	
<?php  endif; ?>	
	