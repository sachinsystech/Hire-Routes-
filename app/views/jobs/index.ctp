
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
        function showDescription(){
	    $('#full_description').show();
            $('#short_description').hide();
            $('#more_info').hide();
	}
</script>

<!-- ------------------------ ALL JOBS LISTING -------------------------->

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
			Industries
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
							<!-- <div>
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
                                                        <div> -->

                                             <div>
                                               <div style="float:left;width:150px;height:90px;">
                                                  <img src="" alt="Company Logo" title="company logo" />
                                               </div>
                                               <div>
                                                  <div style="font-size:20px;"><strong><?php echo ucfirst($job['title']); ?>
                                                   </strong>
                                                  </div>
                                                  <div style="font-size:13px;line-height:22px;">
                                                      <strong>By Company :</strong> <?php echo $job['company_name']."<br>"; ?>
                                                      <strong>Website : </strong><?php	echo $this->Html->link($urls[$job['company_id']], 'http://'.$urls[$job['company_id']]); ?><br>
                                                      <strong>Published in :</strong> <?php echo $industries[$job['industry']]." - ".$specifications[$job['specification']].", "; ?>
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
                                               </div>
                                               
                                               <div>
                                                    <div style="font-size:15px;padding-left:15px;"><strong>About the Job</strong></div>
                                                    <div style="font-size:13px;padding-left:15px;line-height:22px;">
                                                       <strong>Location :</strong> <?php echo $job['city'].", ".$states[$job['state']]."<br>"; ?>
                                                       <strong>Annual Salary Range :</strong> <?php echo $job['salary_from']." - ".$job['salary_to']."<br>"; ?>
                                                       <strong>Type :</strong> <?php echo $job_array[$job['job_type']]."<br>"; ?>                                                       
                                                    </div>
                                                    <div style="font-size:13px;padding:10px 15px 25px 15px;"><?php echo $job['short_description']."<br>";?></div>
                                               </div>
                                               <div style="padding-left:15px;">
                                                  <span style="font-size:15px;"><strong>
                                                     <?php echo $job['company_name']; ?></strong>
                                                  </span> - <?php echo $job['city'].", ".$states[$job['state']]."<br>"; ?>
                                                     <?php	echo $this->Html->link($urls[$job['company_id']], 'http://'.$urls[$job['company_id']]); ?><br><br>
                                                  <div id="short_description" style="font-size:13px;">
                                                       <?php $desc = $job['description'];
                                                             $explode = explode(' ',$desc);
    $string  = '';

    $dots = '...';
    if(count($explode) <= 20){
        $dots = '';
    }
    for($i=0;$i<20;$i++){
        $string .= $explode[$i]." ";
    }
    if ($dots) {
        $string = substr($string, 0, strlen($string));
    }
    echo $string.$dots;?></div>
                                                  <div id="full_description" style="display:none;font-size:13px;"><?php echo $job['description'];?></div>
                                                   
                                                </div>
                                                <?php if(str_word_count($desc)>20){?>
                                                <div id="more_info" align="center" style="font-size:13px;font-weight:normal;">
                                                    <a onclick="showDescription();" style="cursor:pointer">More Info</a>
                                                </div>
                                                <?php }?>
                                            </div>
                                            <div>
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
	
