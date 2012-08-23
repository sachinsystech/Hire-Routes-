<?php
	/*
	 * Archived Job for Jobseeker
	 */
?>
	<div class="job_top-heading">
	<?php if($this->Session->read('Auth.User.id')):?>
		<?php if($this->Session->read('welcomeName') && ($this->Session->read('UserRole'))):?>
				<h2>WELCOME <?php echo strtoupper($this->Session->read('welcomeName'));?>!</h2>
		<?php endif; ?>
	<?php endif; ?>
	</div>
    <div class="job_container">
    	<div class="job_container_top_row">
            <?php echo $this->element("side_menu"); ?>
            <div class="job_right_bar">
               <?php if(isset($invitations)&&!empty($invitations)):?>
                <div class="job_right_top_bar">
                    <div class="job_right_sortby">
                        <div class="job_right_shortby_txt">Invitations</div>
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
	                <div class="job_next_bttn"><?php echo $paginator->next(__('', true).' ', array(), null, array('class'=>'disabled'));?></div>
					<?php } ?> 
					<div class="clr"></div>
					<div class="job_right_pagination job-sort-by contacts-sort-by">
	                   	<div class="job_sort">Sort By:</div>
						<ul>
							<li style="width:16px;"><a class="link-button" href="/jobseekers/invitations">All</a></li>
							<?php
								foreach($alphabets AS $alphabet=>$count){
									$class = 'link-button';
									$url = "/jobseekers/invitations/alpha:$alphabet";
									$urlLink = "<a href=".$url.">". $alphabet ."</a>";
									if($startWith ==$alphabet || $count<1){
										$class = 'current';
										$urlLink = $alphabet;
									}
							?>
							<li class="<?php echo $class; ?>" style="font:15px Arial,Helvetica,sans-serif;"><?php echo $urlLink; ?></a></li>
							<?php
							}
							?>
						</ul>
					</div>
				</div>
    	        <div class="clr"></div>
			<div class="job-table-heading job-table-heading-border">
				<ul>
					<li class="job-table-name job-table-align2">Email</li>
					<li class="job-table-source job-table-align2">Source</li>
					<li class="job-table-status job-table-align2">Status</li>
				</ul>
	        </div>
		    <?php
				$status = array("Pending","Accepted");
				$i=0;
			?>
		    <?php foreach($invitations AS $contact):?>
		    <?php $i++;?>
    	    <div class="job-table-subheading job-table-heading-border <?php if($i%2==0) echo 'light';else echo 'dark'; ?>">
				<ul >
					<li class="job-table-name"><?php echo $contact['Invitation']['name_email']?></li>
				
					<li class="job-table-source">
						<?php echo $contact['Invitation']['from']?>
					</li>
					<li class="job-table-status"><?php echo $status[ $contact['Invitation']['status'] ];?></li>
				</ul>
    	    </div>
    	   	<?php endforeach;?>
    	    <div class="clr"></div>
    	    <?php else:?>
			<div id='NoJobMessage'><h4>There are no invited friends.</h4></div>
			<?php endif;?>
		</div>
	</div>
	<div class="job_pagination_bottm_bar">
	</div>
	<div class="clr"></div>
</div>
<div class="clr"></div>
<style>
.contacts-sort-by div {float:left;}
</style>

