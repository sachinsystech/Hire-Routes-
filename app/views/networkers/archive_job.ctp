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
	<div class="job_top-heading">
		<?php echo $this->element("welcome_name"); ?>
	</div>
    <div class="job_container">
    	<div class="job_container_top_row">
            <?php echo $this->element("side_menu"); ?>
            <div class="job_right_bar">
               <?php if(isset($jobs) && !empty($jobs)):?>
                <div class="job_right_top_bar">
                    <div class="job_right_sortby">
                        <div class="job_right_shortby_txt">Sort By:</div>
                        <div class="job_right_shortby_field">
						<?php echo $form -> input('short_by',array(
													'type'=>'select',
													'label'=> false,
													'div'=> false,
													'options'=>array('date-added' => 'Date Added', 'company-name' => 'Company Name', 'industry' => 'Industry', 'salary' => 'Salary'),
													'class'=>'job_select_shortby',
													'selected'=>isset($shortBy)?$shortBy:'date-added',
											)
								);
						?>
                        </div>
                        
                    </div>
					<?php if($this->Paginator->numbers()){?>
                    <div class="job_right_pagination">
                        <div>
								<?php echo $paginator->first("<<",array("class"=>"arrow_margin" )); ?>	
				          
				            <ul>
								<?php echo $this->Paginator->numbers(array('modulus'=>8,
																			'tag'=>'li',
																			'separator'=>false,)); ?>
							</ul>
				            <?php echo $paginator->last(">>", array("class"=>"arrow_margin",
				            											));?>

                        </div>
                    </div>
                    <div class="job_preview_bttn"><?php echo $paginator->prev('  '.__('', true), array(), null, array('class'=>'disabled'));?></div>
                    <div class="job_next_bttn"><?php echo $paginator->next(__('', true).' ', array(), null, array('class'=>'disabled'));?>
                    </div>
					<?php } ?>                    
				</div> 
                <?php $job_array = array('1'=>'Full Time',
									 '2'=>'Part Time',
									 '3'=>'Contract',
									 '4'=>'Internship',
									 '5'=>'Temporary'); ?>
				<?php foreach($jobs as $job):?>										 
                <div class="job_right_section">
                    <div class="job_right_section_left">
                        <h2>
                        	<?php echo strtoupper($job['Job']['title']);?>
						</h2>
                        <p><?php	
								if(!empty($job['comp']['company_name']))
									echo $job['comp']['company_name']."&nbsp;-&nbsp;";
							?>
							<?php
								if(!empty($job['city']['city']))
									echo $job['city']['city'].",&nbsp;";
							?>
							<?php
								echo $job['state']['state'];
							?>
						</p>
						<p>
								<?php
									echo $job['ind']['industry_name'].", ".$job['spec']['specification_name'];
								?>
						</p>
                        <p><?php echo $job_array[$job['Job']['job_type']];?></p>
                        <p>Posted: <?php echo date("d/m/Y" ,strtotime($job['Job']['created']) ) ;?></p>
                    </div>
                    <div class="job_right_section_right body1">
                    </div>
                    <div class="clr"></div>
                </div>
                <?php endforeach; ?>
                <?php else:?>
					<div class='job-empty-message'>There is no job found for this search.</div>
				<?php endif;?>
			</div>
		</div>
        <div class="job_pagination_bottm_bar">
        	
        </div>
        <div class="clr"></div>
    </div>
 	<div class="clr"></div>

