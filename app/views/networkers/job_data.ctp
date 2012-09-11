	<div class="job_top-heading">
		<?php echo $this->element("welcome_name"); ?>
	</div>
    <div class="job_container">
    	<div class="job_container_top_row">
           <?php echo $this->element('side_menu');?>
            <div class="job_right_bar">
            	<div class="job-right-top-content1">
                	<div class="job-right-top-left job-profile job-data">
                    	<h2>Jobs Data</h2>
                    	<div><span>Job Received:</span>
       	 					<?php echo $NewJobs;?>
						</div>
						<div class="clr"></div>
                    	<div><span>Job Shared:</span> 
                    		<?php echo $SharedJobs;?>
						</div>
						<!--<div class="clr"></div>
                    	<div><span>Job Filled:</span>
						</div>
						-->
						<div class="clr"></div>
                    	<div><span>Rewards:</span> 
		   					<?php echo $this->Number->format(
										$TotalReward,
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
							);?>
                    	</div>
                    	<div class="clr"></div>
                    </div>
               </div>
			</div>
			<div class="clr"></div>
		</div>
		<div class="job_pagination_bottm_bar"></div>
		<div class="clr"></div>
	</div>	
<script>
$(document).ready(function(){
	$("#edit").click(function(){
		$(this).parent("p").next("div").show();
		$(this).parent("p").hide();
		return false;
	});
	$("#cancel").click(function(){
		$(this).parent("p").next("div").hide();
		$(this).parent("p").show();
		return false;
	});
	
});
</script>

