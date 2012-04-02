<script>
	$(document).ready(function(){
	    $("#switch_display").change(onSelectChange);
		$("#short_by").change(onSelectShortByChange);
		
	});
	function onSelectChange(){
	    var selected = $("#switch_display option:selected");    
	    if(selected.val() != 0){
			window.location.href="/networkers/archiveJob/display:"+selected.text();
	    }
	}
	function onSelectShortByChange(){
	    var selected = $("#short_by option:selected");    
	    if(selected.val() != 0){
			window.location.href="/networkers/archiveJob/shortby:"+selected.val();
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
			<?php echo $this->element('top_menu'); ?>
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
												'selected'=>isset($shortBy)?$shortBy:'date-added',
										)
							);
					?>
				</div>
				
				<div style="float: right;margin-right: 100px;">
					<?php $display_page_no = array('5' => '5', '10' => '10', '15' => '15', '20' => '20');?>
					<?php if($this->Paginator->numbers()){
							echo $form -> input('switch_display',array(
												'type'=>'select',
												'label'=>"< < <".$this->Paginator->numbers()."> > > DISPLAYING </span>",
												'options'=>$display_page_no,
												'class'=>'job_select_diplay',
												'selected'=>isset($displayPageNo)?$displayPageNo:5,
												));
						}?>
				</div>
			</div>	
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
		<?php $job_array = array('1'=>'Full Time','2'=>'Part Time','3'=>'Contract','4'=>'Internship','5'=>'Temporary'); ?>
			<div>
				<table>
					<?php foreach($jobs as $job):?>	
						<tr>
							<td>
								<div>
									<div style="float:left"> <?php	echo $this->Html->link($job['Job']['title'], '/jobs/jobDetail/'.$job['Job']['id']); ?></div>
									<div style="float:right"><b>Reward : </b><?php echo $job['Job']['reward'];?>$</div>									
								</div>
								<div style="clear:both"></div>
                                <div>
									<?php	echo $job['Job']['company_name']."- ".$job['city']['city'].",".$job['state']['state']."<br>";
											echo $job['ind']['industry_name'].", ".$job['spec']['specification_name']."<br>";
											echo $job_array[$job['Job']['job_type']]."<br>";
											echo $job['Job']['short_description']."<br>";
									?>
                                 </div>
                                 
                                 <div style="float:left">
				                 	Posted <?php  echo $time->timeAgoInWords($job['Job']['created'])." <br><br>";?>							
								</div>	
                                <div style="float:right">
                                    <?php	echo $this->Html->link('Read More', '/jobs/jobDetail/'.$job['Job']['id']); ?>
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
	</div>
	<!-- middle section end -->
</div>
