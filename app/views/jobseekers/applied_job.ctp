<script>
	$(document).ready(function(){
	    $("#switch_display").change(onSelectChange);
		$("#short_by").change(onSelectShortByChange);
		
	});
	function onSelectChange(){
	    var selected = $("#switch_display option:selected");    
	    if(selected.val() != 0){
			window.location.href="/jobseekers/appliedJob/display:"+selected.text();
	    }
	}
	function onSelectShortByChange(){
	    var selected = $("#short_by option:selected");    
	    if(selected.val() != 0){
			window.location.href="/jobseekers/appliedJob/shortby:"+selected.val();
	    }
	}
	
	
</script>
<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<ul>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers/newJob"><span>New Jobs</span></a></li>
                <li class="active"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers/appliedJob"><span>Applied Jobs</span></a></li>
				<li><span><a style="color: #000000;text-decoration: none;font-weight: normal;" href=""><span>My Network</span></li>
				<li><span><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers">My Account</a></span></li>
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
			<ul style="float:left">
				<li><a href="#">Job Profile</a></li>	
				<li><a href="/jobseekers/setting">Settings/Subscription</a></li>	
                <li class="active"><a href="/jobseekers">Profile</a></li>
			</ul>
			<ul style="float:right">
				<li style="background-color: #3DB517;"><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers/editProfile"><span>Edit</span></a></li>
			</ul>
		</div>
        <div class="jobs_topMenu">
			<div style="margin-top:10px;">
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
									<div> <?php	echo $this->Html->link($job['title'], '/jobs/'.$job['id']); ?></div>									
								</div>
								<div style="clear:both">
                                <div style="float:right"> Job Status <br><?php	echo $this->Html->link('Delete', '/jobseekers/delete/'.$job['id']); ?></div>		
								<div>
									<?php	echo $job['company_name']."- ".$job['city'].",".$states[$job['state']]."<br>";
											echo $industries[$job['industry']].", ".$specifications[$job['specification']]."<br>";
											echo $job_array[$job['job_type']]."<br>";
											echo $job['short_description']."<br>";
									?>
                                 </div>
                                 
                                 <div style="float:left">
									Posted 
                                   <?php  $start  = strtotime($job['created']);
                                                             $end    = strtotime(date('Y-m-d H:i:s'));

                                                             if(!$end) { $end = time(); }
                                                             if(!is_numeric($start) || !is_numeric($end)) { return false; }
                                                              // Convert $start and $end into EN format (ISO 8601)
                                                             $start  = date('Y-m-d H:i:s',$start);
                                                             $end    = date('Y-m-d H:i:s',$end);
                                                             $d_start    = new DateTime($start);
                                                             $d_end      = new DateTime($end);
                                                             $diff = $d_start->diff($d_end);
                                                                // return all data
                                                             $year=""; $month=""; $day=""; $hour=""; $min=""; $sec="";
                                                             
                                                             $y    = $diff->format('%y');
                                                             if($y>0)
                                                              {
                                                                 if($y==1)
                                                                  {
                                                                    $year = $y." year ";
                                                                  }else{
                                                                    $year = $y." years ";
                                                                  }
                                                              }
                                                              $m = $diff->format('%m');
                                                              if($m>0)
                                                              {
                                                                 if($m==1)
                                                                  {
                                                                    $month = $m." month ";
                                                                  }else{
                                                                    $month = $m." months ";
                                                                  }
                                                              }
                                                              $d = $diff->format('%d');
                                                              if($d>0)
                                                              {
                                                                 if($d==1)
                                                                  {
                                                                    $day = $d." day ";
                                                                  }else{
                                                                    $day = $d." days ";
                                                                  }
                                                              }
                                                              $h = $diff->format('%h');
                                                              if($h>0)
                                                              {
                                                                 if($h==1)
                                                                  {
                                                                    $hour = $h." hour ";
                                                                  }else{
                                                                    $hour = $h." hours ";
                                                                  }
                                                              }
                                                              $i = $diff->format('%i');
                                                              if($i>0)
                                                              {
                                                                 if($i==1)
                                                                  {
                                                                    $min = $i." minute ";
                                                                  }else{
                                                                    $min = $i." minutes ";
                                                                  }
                                                              }
                                                              $s = $diff->format('%s');
                                                              if($s>0)
                                                              {
                                                                 if($s==1)
                                                                  {
                                                                    $sec = $s." second ";
                                                                  }else{
                                                                    $sec = $s." seconds ";
                                                                  }
                                                              }
                                                             $diff = $year.$month.$day.$hour;
                                                             echo $diff."ago<br><br>";?>							
								</div>	
                                <div style="padding-left:550px;">
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
	<!-- middle section end -->

</div>

<script>
	function goTo(){
		window.location.href="/companies/postJob";			
	}
	$(document).ready(function(){
		$("#UserEditProfileForm").validate();
	});     
</script>
