<!-- ------------------------ ALL JOBS LISTING -------------------------->
<script>
	$(document).ready(function(){
		$("#slider").slider();
	    $("#switch_display").change(onSelectChange);
		$("#short_by").change(onSelectChange);		
	});
	function onSelectChange(){
	    var displaySelected = $("#switch_display option:selected");
		var shortSelected = $("#short_by option:selected"); 
		window.location.href="/jobs/index/display:"+displaySelected.text()+"/shortby:"+shortSelected.val();
	}	
	$(function() {
		$( "#slider-range" ).slider({
			range: true,
			min: 1,
			max: 500,
			values: [ "<?php echo $salaryFrom; ?>","<?php echo $salaryTo; ?>"],
			slide: function( event, ui ) {
				$( "#from_amount" ).val( ui.values[ 0 ] +"K");
				$( "#to_amount" ).val( ui.values[ 1 ]+"K" );
			}
		});
		$( "#from_amount" ).val( $( "#slider-range" ).slider( "values", 0 ) +"K");
		$( "#to_amount" ).val( $( "#slider-range" ).slider( "values", 1 )+"K" );
		
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
</script>
<?php if(!isset($job)): ?>

<div class="page">
	<div style="height:10px;">		
       <?php  echo $this->Form->create('FilterJob', array('url' => array('controller' => 'Jobs', 'action' => 'index')));?>
 
            <div style="float:left;width: 268px;margin-left: 65px;">
               <?php echo $form->input('what', array('label' => 'What',
							                         'type'  => 'text',
                                                     'value' => isset($what)?$what:"",
                                                     'id'    => 'what',
                                                     'class' => 'text_field_bg'));?></div>
                     
           <div style="float:left;width: 268px;margin-left: 160px;">
               <?php echo $form->input('where', array('label' => 'Where',
							                          'type'  => 'text',
                                                      'value' => isset($where)?$where:"",
                                                      'id'    => 'where',
                                                      'class' => 'text_field_bg'));?></div>
           <div style="float:right;width: 100px;">
			   <button style="float: right; width: 100px; background:rgb(0, 255, 0);" type="submit" name="search" value="Find Job" >Find Job</button>
		   </div>

     <?php echo $form->end();?>
	</div>

	<!-- left section start -->
		<div style="clear:both"></div>
		<div class="joblist_rightBox">
			<div class="joblist_sideMenu">
				<div><div style="float:left;padding:5px;margin:5px"><b>Industries</b></div><div class="flip_industry"  style="float:right;padding:5px;cursor: pointer;">-</div></div>
				<div style="clear:both"></div>
				<?php echo $this->Form->create('NarrowJob', array('url' => array('controller' => 'Jobs', 'action' => 'index'))); ?>
				<div class="narrowby_industry panel_industry" >
				
					<?php // foreach($industries as $key=>$value):?>
						<div>
							<?php	echo $form->input("industry", array('label' => false,
                                                                        'type' => 'select',
                                                                        'multiple' => 'checkbox',
														                'options'  => $industries,
                                                                        'selected' => isset($industry)?$industry:null
                                                      ));?>
						</div>
						<div style="clear:both"></div>
					<?php //endforeach; ?>
				</div>				
			</div>
			<div style="margin:5px;">
				<div><span style="float:left;margin:5px"><b>Salary Range</b></span></div>
				<div style="clear:both"></div>
				<div class="demo" style="padding:0px;">
					<p>
						<label for="amount"></label>
						<!--input type="text" id="amount" style="border:0; color:#f6931f; font-weight:bold;" / -->
						<div>
							<div style="float:left">
								<?php	echo $form->input('salary_from', array('label' => '',
															'type'  => 'text',
															'id' => 'from_amount',
															'class'=> 'salary_range_slider'
															)
										 );
								?>
							</div>
							<div class="salary_range_seperator"> - </div>
							<div style="float:left;">		
								<?php	echo $form->input('salary_to', array('label' => '',
															'type'  => 'text',
															'id' => 'to_amount',
															'class'=> 'salary_range_slider',
															)
										 );
								?>
							</div>
						</div>
					</p>
					<div style="clear:both"></div>
						
					<div id="slider-range"></div>
				</div>
			</div>
			<div>
				<div><div style="float:left;padding:5px"><b>Location</b></div><div class="flip_location" style="float:right;padding:5px;cursor: pointer;"><?php echo isset($location)?'-':'+' ?></div></div>
				<div style="clear:both"></div>
				<div class="narrowby_city panel_location" style="<?php echo isset($location)?'':'display:none;' ?>">
					<?php  //foreach($location as $key=>$value):?>
						<div>
							<?php	echo $form->input("state", array('label' => false,
                                                                     'type' => 'select',
                                                                     'multiple' => 'checkbox',
                                                                     'options'  => $states,
                                                                     'selected' => isset($location)?$location:null
                                                      ));
							?>
						</div>
						<div style="clear:both"></div>
					<?php //endforeach; ?>
				</div>				
			</div>
			<div>
				<div><div style="float:left;padding:5px"><b>Job Type</b></div><div class="flip_jobtype" style="float:right;padding:5px;cursor: pointer;">+</div></div>
				<div style="clear:both"></div>
				<div class="narrowby_jobtype panel_jobtype" style="<?php echo isset($job_type)?'':'display:none;' ?>">
					<?php $jobtypes = array('1'=>'Full Time','2'=>'Part Time','3'=>'Contract','4'=>'Internship','5'=>'Temporary'); ?>
					<?php //$i=0; ?>
					<?php  //foreach($jobtypes as $jobtype):?>
						<div>
							<?php  ?>
							<?php	echo $form->input("job_type", array('label' => false,
                                                                        'type' => 'select',
                                                                        'multiple' => 'checkbox',
                                                                        'options'  => $jobtypes,
                                                                        'selected' =>  isset($job_type)?$job_type:null
                                                       ));?>
						</div>
						<div style="clear:both"></div>
					<?php //endforeach; ?>
				</div>				
			</div>
		
			<div>
				<div><div style="float:left;padding:5px"><b>Company</b></div><div class="flip_company" style="float:right;padding:5px;cursor: pointer;">+</div></div>
				<div style="clear:both"></div>
		
				<div class="narrowby_company panel_company" style="<?php echo isset($company_name)?'':'display:none;' ?>">
						<div>
							<?php	echo $form->input("company_name", array('label' => false,
                                                                            'type' => 'select',
                                                                            'multiple' => 'checkbox',
														                    'options'=>$companies,
                                                                             'selected' =>  isset($company_name)?$company_name:null
                                                      ));?>
						</div>
						<div style="clear:both"></div>
					<?php //endforeach; ?>
				</div>				
			</div>
			
			<div>
				<?php echo $form->submit('Go',array('div'=>false,'name'=>'save','value'=>'fillter')); ?>
				<?php echo $form->end(); ?>
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
												'selected'=>isset($shortBy)?$shortBy:'date-added',));?>
				</div>
				
				<div style="float:right">
					<?php $display_page_no = array('5' => '5', '10' => '10', '15' => '15', '20' => '20');?>
					<?php echo $form -> input('switch_display',array(
												'type'=>'select',
												'label'=>"".($this->Paginator->numbers()) ?$paginator->first(' << ', null, null, array("class"=>"disableText"))." ".$this->Paginator->prev(' < ', null, null, array("class"=>"disableText"))." ".$this->Paginator->numbers(array('modulus'=>4))." ".$this->Paginator->next(' > ', null, null, array("class"=>"disableText"))." ".$paginator->last(' >> ', null, null, array("class"=>"disableText"))." DISPLAYING":" DISPLAYING",
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
									<div style="float:left"> <?php	echo $this->Html->link($job['Job']['title'], '/jobs/jobDetail/'.$job['Job']['id']); ?></div>
									<div style="float:right"> Reward : <?php echo $this->Number->format(
										$job['Job']['reward'],
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?></div>
								</div>
								<div style="clear:both">		
								<div>
									<?php 
										if(!empty($job['company']['company_name']))
											echo $job['company']['company_name']."&nbsp;-&nbsp;";
									?>
									<?php
										if(!empty($job['city']['city']))
											echo $job['city']['city'].",&nbsp;";
									?>
									<?php
											echo $job['state']['state']."<br>";
											echo $job['ind']['industry'].", ".$job['spec']['specification']."<br>";
											echo $job_array[$job['Job']['job_type']]."<br>";
											echo $job['Job']['short_description']."<br>";
                                            echo "Posted : ".$time->timeAgoInWords($job['Job']['created']);
                                    ?>
																
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

<?php  endif; ?>	
	
