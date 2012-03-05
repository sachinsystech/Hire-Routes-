<script>
	$(document).ready(function(){
	    $("#switch_display").change(onSelectChange);
		$("#short_by").change(onSelectShortByChange);
		
	});
	function onSelectChange(){
	    var selected = $("#switch_display option:selected");    
	    if(selected.val() != 0){
			window.location.href="/networkers/newJob/display:"+selected.text();
	    }
	}
	function onSelectShortByChange(){
	    var selected = $("#short_by option:selected");    
	    if(selected.val() != 0){
			window.location.href="/networkers/newJob/shortby:"+selected.val();
	    }
	}	
</script>
<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul>
				<li>My Jobs</li>
				<li class='active'><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/newJob"><span>New Jobs</span></a></li>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/personal"><span>My Network</span></a></li>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/"><span>My Account</span></a></li>
			</ul>
		</div>
		<div>Feed Back</div>
		<div><textarea class="feedbacktextarea"></textarea></div>	
		<div class="feedbackSubmit">Submit</div>
	</div>
	<!-- left section end -->
	<!-- middle section start -->
    
	<div class="rightBox" >
		<!-- middle conent top menu start -->
		<div class="topMenu">
			<ul>
				<li><a href="/networkers/setting">Settings/Subscription</a></li>	
				<li class="active"><a href="/networkers">Profile</a></li>			
                        </ul>
			<ul style="float:right">
				<li style="background-color: #3DB517;"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/networkers/editProfile"><span>Edit</span></a></li>
			</ul>
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
				
				<div style="padding-left:350px;">
					<?php $display_page_no = array('5' => '5', '10' => '10', '15' => '15', '20' => '20');?>
					<?php echo $form -> input('switch_display',array(
												'type'=>'select',
												'label'=>"< < <".$this->Paginator->numbers()."> > > DISPLAYING </span>",
												'options'=>$display_page_no,
												'class'=>'job_select_diplay',
												'selected'=>isset($displayPageNo)?$displayPageNo:5,
												));?>
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
									<div style="float:left"> <?php	echo $this->Html->link($job['title'], '/jobs/'.$job['id']); ?></div>
									<div style="float:right"><?php echo $job['reward'];?>$
</div>									
								</div>
								<div style="clear:both"></div>
                                <div>
									<?php	echo $job['company_name']."- ".$job['city'].",".$states[$job['id']]."<br>";
											echo $industries[$job['industry']].", ".$specifications[$job['specification']]."<br>";
											echo $job_array[$job['job_type']]."<br>";
											echo $job['short_description']."<br>";
									?>
                                 </div>
                                 
                                 <div style="float:left">
				                 	Posted <?php  echo $time->timeAgoInWords($job['created'])." <br><br>";?>							
								</div>	
                                <div style="padding-left:480px;">
                                    <?php	echo $this->Html->link('Read More', '/jobs/'.$job['id']); ?>
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

