
<div class="job_top-heading">
<?php if($this->Session->read('Auth.User.id')):?>
	<?php if($this->Session->read('welcomeName') && ($this->Session->read('UserRole'))):?>
			<h2>WELCOME <?php echo strtoupper($this->Session->read('welcomeName'));?>!</h2>
	<?php endif; ?>
<?php endif; ?>
</div>

<div class="job_container">
    <div class="job_container_top_row">
		<?php echo $this->element('side_menu');?>

		<div class="job_right_bar">
            	<div class="new_job data_h2_margin">
            		<h2>DATA</h2>
                   
                        <div class="job_right_section_left">
                        <h2>
                        <a href="#"><?php echo $job['title']?></a>
                        </h2>
                        <p class="job-right-section-p">Posted: <?php echo $time->timeAgoInWords($job['created'],'m/d/Y');?></p>
                        <p class="job-submission-margin">
							<?php echo $job['short_description'];?>
                        </p>
                        <div class="clr"></div>
                     </div>
                    <div class="clr"></div>
                    <div class="data_table">
                    	<ul>
                        	<li>&nbsp;</li>
                            <li class="data_table_font">ALL THE TIME</li>
                            <li class="data_table_font">Last Month</li>
                            <li class="data_table_font">Last Week</li>
                        </ul>
                        <ul>
                        	<li class="data_table_font">Applicants</li>
                            <li class="dark"><?php echo $jobStatusArray['aat'];?></li>
                            <li class="dark"><?php echo $jobStatusArray['alm'];?></li>
                            <li class="dark"><?php echo $jobStatusArray['alw'];?></li>
                        </ul>
                        <ul>
                        	<li class="data_table_font">Shares</li>
                            <li class="dark"><?php echo $jobStatusArray['sat'];?></li>
                            <li class="dark"><?php echo $jobStatusArray['slm'];?></li>
                            <li class="dark"><?php echo $jobStatusArray['slw'];?></li>
                        </ul>
                        <ul>
                        	<li class="data_table_font">Views</li>
                            <li class="dark"><?php echo $jobStatusArray['vat'];?></li>
                            <li class="dark"><?php echo $jobStatusArray['vlm'];?></li>
                            <li class="dark"><?php echo $jobStatusArray['vlw'];?></li>
                        </ul>
                    </div>
                </div>
            </div>
	</div>
<div class="clr"></div>
<div class="job_pagination_bottm_bar"></div>									


<div class="clr"></div>
</div>
</div>






