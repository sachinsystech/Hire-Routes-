

<!-- ------------------------ ALL JOBS LISTING -------------------------->
<script>
	$(document).ready(function(){
	    $("#switch_display").change(onSelectChange);
		$("#short_by").change(onSelectShortByChange);
		$("#slider").slider();
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
	
	$(function() {
		$( "#slider-range" ).slider({
			range: true,
			min: 10,
			max: 200,
			values: [ 20, 100 ],
			slide: function( event, ui ) {
				$( "#amount" ).val( ui.values[ 0 ] +"K"+ " - " + ui.values[ 1 ]+"K" );
			}
		});
		$( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 ) +"K"+
			" - " + $( "#slider-range" ).slider( "values", 1 )+"K" );
	});

</script>
<script type="text/javascript"> 
	$(document).ready(function(){
		$(".flip_industry").click(function(){
			$(".panel_industry").slideToggle("slow");
			$a = $(".flip_industry").text();
			if($a=="+"){
			   $(".flip_industry").text("-");
			}
			if($a=="-"){
			   $(".flip_industry").text("+");
			}
	  });
	});
</script>
<script type="text/javascript"> 
	$(document).ready(function(){
		$(".flip_location").click(function(){
			$(".panel_location").slideToggle("slow");
			$a = $(".flip_location").text();
			if($a=="+"){
			   $(".flip_location").text("-");
			}
			if($a=="-"){
			   $(".flip_location").text("+");
			}
	  });
	});
</script>
<script type="text/javascript"> 
	$(document).ready(function(){
		$(".flip_jobtype").click(function(){
			$(".panel_jobtype").slideToggle("slow");
			$a = $(".flip_jobtype").text();
			if($a=="+"){
			   $(".flip_jobtype").text("-");
			}
			if($a=="-"){
			   $(".flip_jobtype").text("+");
			}
	  });
	});
</script>
<script type="text/javascript"> 
	$(document).ready(function(){
		$(".flip_company").click(function(){
			$(".panel_company").slideToggle("slow");
			$a = $(".flip_company").text();
			if($a=="+"){
			   $(".flip_company").text("-");
			}
			if($a=="-"){
			   $(".flip_company").text("+");
			}
	  });
	});

    function showDescription(){
	    $('#full_description').show();
            $('#short_description').hide();
            $('#more_info').hide();
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
			<div class="joblist_sideMenu">
				<div><div style="float:left;padding:5px;margin:5px"><b>Industries</b></div><div class="flip_industry"  style="float:right;padding:5px;cursor: pointer;">-</div></div>
				<div style="clear:both"></div>
				
				<div class="narrowby_industry panel_industry" >
					<?php  foreach($industries as $industry):?>
						<div>
							<?php	echo $form->input('', array('label' => "<span>$industry</span>",
														'type'  => 'checkbox',
														'name'  => "data[User][agree_condition]",
														)
									 );
							?>
						</div>
						<div style="clear:both"></div>
					<?php endforeach; ?>
				</div>				
			</div>
			<div style="margin:5px;">
				<div><span style="float:left;margin:5px"><b>Salary Range</b></span></div>
				<div style="clear:both"></div>
				<div class="demo" style="padding:0px;">
					<p>
						<label for="amount"></label>
						<input type="text" id="amount" style="border:0; color:#f6931f; font-weight:bold;" />
					</p>
					<div id="slider-range"></div>
				</div>
			</div>
			<div>
				<div><div style="float:left;padding:5px"><b>Location</b></div><div class="flip_location" style="float:right;padding:5px;cursor: pointer;">+</div></div>
				<div style="clear:both"></div>
		
				<div class="narrowby_city panel_location" style="display:none;">
					<?php  foreach($cities as $city):?>
						<div>
							<?php	echo $form->input('', array('label' => "<span>$city</span>",
														'type'  => 'checkbox',
														)
									 );
							?>
						</div>
						<div style="clear:both"></div>
					<?php endforeach; ?>
				</div>				
			</div>
			<div>
				<div><div style="float:left;padding:5px"><b>Job Type</b></div><div class="flip_jobtype" style="float:right;padding:5px;cursor: pointer;">+</div></div>
				<div style="clear:both"></div>
		
				<div class="narrowby_jobtype panel_jobtype" style="display:none;">
					<?php $jobtypes = array('1'=>'Full Time','2'=>'Part Time','3'=>'Contract','4'=>'Internship','5'=>'Temporary'); ?>
					<?php  foreach($jobtypes as $jobtype):?>
						<div>
							<?php	echo $form->input('', array('label' => "<span>$jobtype</span>",
														'type'  => 'checkbox',
														)
									 );
							?>
						</div>
						<div style="clear:both"></div>
					<?php endforeach; ?>
				</div>				
			</div>
		
			<div>
				<div><div style="float:left;padding:5px"><b>Company</b></div><div class="flip_company" style="float:right;padding:5px;cursor: pointer;">+</div></div>
				<div style="clear:both"></div>
		
				<div class="narrowby_company panel_company" style="display:none;">
					<?php  foreach($companies as $company):?>
						<div>
							<?php	echo $form->input('', array('label' => "<span>$company</span>",
														'type'  => 'checkbox',
														)
									 );
							?>
						</div>
						<div style="clear:both"></div>
					<?php endforeach; ?>
				</div>				
			</div>
			
			<div>
				<div><div class="go_button" style="float:right;"> Go </div></div>
				<div style="clear:both"></div>
			</div>			
			
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
                                                             if($desc!='')
                                                              {
                                                             $explode = explode(' ',$desc);
    $string  = '';

    $dots = '...';
    if(count($explode) <= 20){
        $dots = '';
    }
	$count  = count($explode)>= 20 ? 20 :count($explode) ;
    for($i=0;$i<$count;$i++){
        $string .= $explode[$i]." ";
    }
    if ($dots) {
        $string = substr($string, 0, strlen($string));
    }
    echo $string.$dots;}?></div>
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
	
