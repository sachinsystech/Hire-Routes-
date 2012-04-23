<script>
	$(document).ready(function(){
	    $("#switch_display").change(onSelectChange);
		$("#short_by").change(onSelectShortByChange);
		
	});
	function onSelectChange(){
	    var selected = $("#switch_display option:selected");    
	    if(selected.val() != 0){
			window.location.href="/jobseekers/newJob/display:"+selected.text();
	    }
	}
	function onSelectShortByChange(){
	    var selected = $("#short_by option:selected");    
	    if(selected.val() != 0){
			window.location.href="/jobseekers/newJob/shortby:"+selected.val();
	    }
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
		<!-- middle conent top menu start -->
		<div class="topMenu">
			<?php echo $this->element('top_menu');?>			
		</div>		
		
		<div class="middleBox">
			<div class="jobs_topMenu">
				<div>
				<?php if(isset($jobs)&&!empty($jobs)):?>
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
												  'label'=>"".($this->Paginator->numbers()) ?$paginator->first(' << ', null, null, array("class"=>"disableText"))." ".$this->Paginator->prev(' < ', null, null, array("class"=>"disableText"))." ".$this->Paginator->numbers(array('modulus'=>4))." ".$this->Paginator->next(' > ', null, null, array("class"=>"disableText"))." ".$paginator->last(' >> ', null, null, array("class"=>"disableText"))."DISPLAYING":"DISPLAYING",
												  'options'=>$display_page_no,
												  'class'=>'job_select_diplay',
												  'selected'=>isset($displayPageNo)?$displayPageNo:5,));
							?>
					</div>
				</div>	
			</div>		
		<!-- middle conyent list -->
			<?php $job_array = array('1'=>'Full Time',
									 '2'=>'Part Time',
									 '3'=>'Contract',
									 '4'=>'Internship',
									 '5'=>'Temporary'); ?>
				<div>
					<table>
						<?php foreach($jobs as $job):?>	
							<tr>
								<td>
									<div>
										<div><?php	echo $this->Html->link($job['Job']['title'], '/jobs/jobDetail/'.$job['Job']['id']); ?></div>								<div style="float:right"><b>Reward : </b><?php echo $this->Number->format(
										$job['Job']['reward'],
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?></div>										
									</div>
									<div style="clear:both"></div>			
                                	<div>
										<?php	
											if(!empty($job['comp']['company_name']))
												echo $job['comp']['company_name']."&nbsp;-&nbsp;";
										?>
										<?php
											if(!empty($job['city']['city']))
												echo $job['city']['city'].",&nbsp;";
										?>
										<?php
											echo $job['state']['state']."<br>";
											echo $job['ind']['industry_name'].", ".$job['spec']['specification_name']."<br>";
											echo $job_array[$job['Job']['job_type']]."<br>";
											echo $job['Job']['short_description']."<br>";
										?>
                                	</div>
                                 	<div style="float:left"> Posted 
               							<?php  echo $time->timeAgoInWords($job['Job']['created'],'m/d/Y')." <br><br>";?>									
									</div>	
                                	<div style="padding-left:550px;">
                                    	<?php	echo $this->Html->link('Read More', '/jobs/jobDetail/'.$job['Job']['id']); ?>
                               		</div>                              	
								</td>
							</tr>
						<?php endforeach; ?>
					</table>
					<?php else:?>
						<div id='NoJobMessage'><h4>There is no job found for this search.</h4></div>
					<?php endif;?>
				</div>
		<!-- middle conyent list -->
			</div>
			<?php //echo $this->element('sql_dump');?>
	<!-- middle section end -->
		</div>
	</div>

