<script>
    $(document).ready(function(){
	    $("#switch_display").change(onSelectChange);
		$("#short_by").change(onSelectChange);
	});
	function onSelectChange(){

	    var displaySelected = $("#switch_display option:selected");
		var shortSelected = $("#short_by option:selected"); 
		window.location.href="/jobseekers/archivedJob/display:"+displaySelected.text()+"/shortby:"+shortSelected.val();
	}
</script>
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
		<div class="topMenu">
			<?php echo $this->element('top_menu');?>
		</div>
		<div class="middleBox">
        	<div class="jobs_topMenu">
				<div>
					<div style="float:left;">
						<?php echo $form -> input('short_by',array(
												  'type'=>'select',
												  'label'=>'SORT BY ',
												  'options'=>array('date-added' => 'Date Added', 'company-name' => 'Company Name', 'industry' => 'Industry', 'salary' => 'Salary'),
												  'class'=>'job_select_shortby',
												  'selected'=>isset($shortBy)?$shortBy:'date-added',));?>
					</div>
					<div style="float:right">
						<?php $display_page_no = array('5' => '5', '10' => '10', '15' => '15', '20' => '20');?>
						<?php 
							echo $form -> input('switch_display',array(
												  'type'=>'select',
												  'label'=>"".($this->Paginator->numbers()) ?$paginator->first(' << ', null, null, array("class"=>"disableText"))." ".$this->Paginator->prev(' < ', null, null, array("class"=>"disableText"))." ".$this->Paginator->numbers()." ".$this->Paginator->next(' > ', null, null, array("class"=>"disableText"))." ".$paginator->last(' >> ', null, null, array("class"=>"disableText"))." DISPLAYING":" DISPLAYING",
												  'options'=>$display_page_no,
												  'class'=>'job_select_diplay',
												  'selected'=>isset($displayPageNo)?$displayPageNo:5,));?>
					</div>
				</div>	
			</div>		
		<!-- middle conyent list -->
			<?php $job_array = array('1'=>'Full Time',
									 '2'=>'Part Time',
									 '3'=>'Contract',
									 '4'=>'Internship',
									 '5'=>'Temporary'); ?>
			<?php $job_status = array('0'=>'Applied',
									  '1'=>'Selected',
									  '2'=>'Rejected'); ?>
			<div>
				<table>
					<?php foreach($jobs as $job):?>	
						<tr>
							<td>
								<div>
									<div>
										<?php	echo $this->Html->link($job['job']['title'], '/jobs/jobDetail/'.$job['job']['id']); ?>
									</div>									
								</div>
								<div style="clear:both"></div>
                                <div style="float:right"> <?php echo $job_status[$job['JobseekerApply']['is_active']];?> <br><?php	echo $this->Html->link('Delete', '/jobseekers/delete/'.$job['job']['id']); ?></div>		
								<div>
									<?php	echo $job['job']['company_name']."- ".$job['city']['city'].",".$job['state']['state']."<br>";
											echo $job['ind']['industry_name'].", ".$job['spec']['specification_name']."<br>";
											echo $job_array[$job['job']['job_type']]."<br>";
											echo $job['job']['short_description']."<br>";?>
                                 </div>                                 
                                 <div style="float:left">
									Posted 
                                    <?php  echo $time->timeAgoInWords($job['job']['created'])." <br><br>";?>							
								 </div>	
                                 <div style="padding-left:550px;">
                                    <?php	echo $this->Html->link('Read More', '/jobs/jobDetail/'.$job['job']['id']); ?>
                                 </div>                                	
							</td>
						</tr>
					<?php endforeach; ?>
				</table>
				<?php if(!$jobs):?>
					<div><h4>There is no job found for this search.</h4></div>
				<?php endif;?>
			</div>
			<!-- middle conyent list -->
		</div>
	<!-- middle section end -->
	</div>
</div>
