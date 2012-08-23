<script>
	$(document).ready(function(){
		//$("#slider").slider();
	    //$("#switch_display").change(onSelectChange);

		$("#short_by").change(function(){
			onSelectChange( $("#short_by option:selected").val() );
		});
		$("#short_by2").change(function(){
			onSelectChange( $("#short_by2 option:selected").val() );
		});
			
	});
	function onSelectChange(shortSelected){
	    var displaySelected = 6;//$("#switch_display option:selected");
		window.location.href="/jobs/index/display:"+displaySelected+"/shortby:"+shortSelected;
	}	

</script>
<?php $job_array = array('1'=>'Full Time','2'=>'Part Time','3'=>'Contract','4'=>'Internship','5'=>'Temporary'); ?>
<div class="middle">
	<div class="job_top-heading"><h2>WELCOME SACHIN!</h2></div>
    <div class="job_container">
    	<div class="job_container_top_row">
        
        
      <!---  left part start --->
      
      
            <div class="job_left_bar">
                <div class="job_left_menu">
                    <ul>
                        <li><a class="minus_icon" href="#">Industries</a>
                            <div class="job_menus_submenu">
                                <ul>
                                    <li><a href="#">Advertising</a></li>
                                    <li><a href="#">Admin/Secreterial</a></li>
                                    <li><a href="#">Agricultural</a></li>
                                    <li><a href="#">Banking</a></li>
                                    <li><a href="#">Consulting</a></li>
                                    <li><a href="#">Education</a></li>
                                    <li><a href="#">Finance</a></li>
                                    <li><a href="#">Healthcare</a></li>
                                    <li><a href="#">Management</a></li>
                                    <li><a href="#">Publishing</a></li>
                                    <li><a href="#">Real Estate</a></li>
                                </ul>
                            </div>
                        </li>
                        
                        <li><a class="plus_icon" href="#">Salary</a>
                        	<div style="display:none;" class="job_menus_submenu">
                            	<div class="job_salary_txt_row">
                                	<div class="job_salary_txt1">$1K</div>
                                    <div class="job_salary_txt2">$500K</div>
                                </div>
                                <div class="job_salary_bar"></div>
                            </div>
                        </li>
                        
                        <li><a class="plus_icon" href="#">Location</a>
                        	<div style="display:none;" class="job_menus_submenu">
                        		<ul>
                                    <li><a href="#">Alaska</a></li>
									<li><a href="#">Alabama</a></li>
                                    <li><a href="#">Arkansas</a></li>
                                    <li><a href="#">Arizona</a></li>
                                    <li><a href="#">California</a></li>
                                    <li><a href="#">Colorado</a></li>
                                    <li><a href="#">Connecticut</a></li>
                                    <li><a href="#">District of Columbia</a></li>
                                    <li><a href="#">Delaware</a></li>
                                    <li><a href="#">Florida</a></li>
                                    <li><a href="#">Georgia</a></li>
                            	</ul>
                             </div>
                         </li>
                         
                        <li><a class="plus_icon" href="#">Job Type</a>
                        	<div style="display:none;" class="job_menus_submenu">
                        		<ul>
                                    <li><a href="#">Full Time</a></li>
									<li><a href="#">Part Time</a></li>
                                    <li><a href="#">Contract</a></li>
                                    <li><a href="#">Internship</a></li>
                                    <li><a href="#">Temporary</a></li>
                                </ul>
                             </div>
                        </li>
                        
                        <li><a class="plus_icon" href="#">Company</a>
                        	<div style="display:none;" class="job_menus_submenu">
                            	<ul>
                                        <li><a href="#">Amazon</a></li>
                                        <li><a href="#">Blog Company</a></li>
                                        <li><a href="#">Circus</a></li>
                                        <li><a href="#">Dis is a Company</a></li>
                                        <li><a href="#">Elephant Wines</a></li>
                                        <li><a href="#">Proctor & Gamble</a></li>
                                        <li><a href="#">Google</a></li>
                                        <li><a href="#">Hospital Name</a></li>
                                        <li><a href="#">Amazon</a></li>
                                        <li><a href="#">Blog Company</a></li>
                                        <li><a href="#">Circus</a></li>
                                        <li><a href="#">Dis is a Company</a></li>
                                        <li><a href="#">Elephant Wines</a></li>
                                        <li><a href="#">Proctor & Gamble</a></li>
                                        <li><a href="#">Google</a></li>
                                        <li><a href="#">Hospital Name</a></li>
                                        <li><a href="#">Blog Company</a></li>
                                        <li><a href="#">Circus</a></li>
                                        <li><a href="#">Dis is a Company</a></li>
                                        <li><a href="#">Elephant Wines</a></li>
                                        <li><a href="#">Proctor & Gamble</a></li>
                                        <li><a href="#">Google</a></li>
                                        <li><a href="#">Hospital Name</a></li>
                                        <li><a href="#">Amazon</a></li>
                                        <li><a href="#">Blog Company</a></li>
                                        <li><a href="#">Circus</a></li>
                                        <li><a href="#">Dis is a Company</a></li>
                                        <li><a href="#">Elephant Wines</a></li>
                                        <li><a href="#">Proctor & Gamble</a></li>
                                        <li><a href="#">Google</a></li>
                                        <li><a href="#">Hospital Name</a></li>
                                        <li><a href="#">Amazon</a></li>
                                        <li><a href="#">Blog Company</a></li>
                                        <li><a href="#">Circus</a></li>
                                        <li><a href="#">Dis is a Company</a></li>
                                        <li><a href="#">Elephant Wines</a></li>
                                        <li><a href="#">Proctor & Gamble</a></li>
                                        <li><a href="#">Google</a></li>
                               </ul>
                            </div>    
                        </li>
                    </ul>
                </div>
                
               <div class="job_left_search_row">
               		<div class="search_bttn"><a href="#">SEARCH</a></div>
                    <div class="search_text"><a href="#">Reset Settings</a></div>
               </div> 
                
            </div>
            
            
            
     <!---   right part start ---->
     
                 
            <div class="job_right_bar">
                <div class="job_right_top_bar">
                    <div class="job_right_sortby">
                        <div class="job_right_shortby_txt">Sort By:</div>
                        <div class="job_right_shortby_field">
						<?php echo $form -> input('short_by',array(
												'type'=>'select',
												'label'=>false,
												'div'	=> false,
												'options'=>array('date-added' => 'Date Added', 'company-name' => 'Company Name', 'industry' => 'Industry', 'salary' => 'Salary'),
												'selected'=>isset($shortBy)?$shortBy:'date-added',));?>
                         </div>
                    </div>
					<?php if($this->Paginator->numbers()){?>
                    <div class="job_right_pagination">
		               <!--         <a class="arrow_margin" href="#">&lt;&lt; </a>-->
                        <div>
								<?php echo $paginator->first("<<",array("class"=>"arrow_margin" )); ?>	
				          
				            <ul>
								<?php echo $this->Paginator->numbers(array('modulus'=>8,
																			'tag'=>'li',
																			'separator'=>false,)); ?>
							</ul>
				            <?php echo $paginator->last(">>", array("class"=>"arrow_margin",
				            											));?>
                        <!---<a class="arrow_margin" href="#">&gt;&gt;</a>-->
                        </div>
                    </div>
                    <div class="job_preview_bttn"><?php echo $paginator->prev('  '.__('', true), array(), null, array('class'=>'disabled'));?></div>
                    <div class="job_next_bttn"><?php echo $paginator->next(__('', true).' ', array(), null, array('class'=>'disabled'));?>
                    </div>
					<?php } ?>                    
                </div>
                
                <?php foreach($jobs as $job):?>	

                <div class="job_right_section">
                    <div class="job_right_section_left">
                        <h2><?php	echo $this->Html->link(strtoupper($job['Job']['title']), '/jobs/jobDetail/'.$job['Job']['id']); ?></h1>
                        <p><?php
	                        	echo $job['ind']['industry'].", ".$job['spec']['specification'] ;
	                        	?>
	                     </p>
	                     <p>
	                     	<?php
	                        	if(!empty($job['city']['city']))
									echo $job['city']['city'].",&nbsp;";
								echo $job['state']['state']
							?>
                        </p>
                        <p><?php echo $job_array[$job['Job']['job_type']]; ?></p>
                        <p>Posted: <?php echo date('d/m/Y',strtotime($job['Job']['created'])) ;?></p>
                    </div>
                    <div class="job_right_section_right body1">
                        Reward: <span><?php echo $this->Number->format(
										$job['Job']['reward'],
										array(
											'places' => 0,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?></span>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php if(!$jobs):?>
					<div><h2>There is no job found for this search.</h2></div>
				<?php endif;?>
            </div>
        </div>
        <div class="job_pagination_bottm_bar">
        	<div class="job_right_sortby">
            	<div class="job_right_shortby_txt">Sort By:</div>
                <div class="job_right_shortby_field">
					<?php echo $form -> input('short_by',array(
											'type'=>'select',
											'id'=>'short_by2',
											'label'=>false,
											'div'	=> false,
											'options'=>array('date-added' => 'Date Added', 'company-name' => 'Company Name', 'industry' => 'Industry', 'salary' => 'Salary'),
											'selected'=>isset($shortBy)?$shortBy:'date-added',));?>
                </div>
			</div>
            <div class="job_right_pagination">
               	<div>
	            	<?php if($this->Paginator->numbers()){?>
					<?php echo $paginator->first("<<",array("class"=>"arrow_margin" )); ?>	
	                <ul>
					<?php echo $this->Paginator->numbers(array('modulus'=>8,
																'tag'=>'li',
																'separator'=>false,)); ?>
					</ul>
	                <?php echo $paginator->last(">>", array("class"=>"arrow_margin",
	                    											));?>
	                 <!---<a class="arrow_margin" href="#">&gt;&gt;</a>-->
                 </div>
			</div>
            <div class="job_preview_bttn"><?php echo $paginator->prev('  '.__('', true), array(), null, array('class'=>'disabled'));?>
            </div>
			<div class="job_next_bttn"><?php echo $paginator->next(__('', true).' ', array(), null, array('class'=>'disabled'));?>
			</div>
				<?php } ?>
           </div>
        </div>
        <div class="clr"></div>
    </div>
 	<div class="clr"></div>
</div>
</div>
