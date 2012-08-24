<div class="middle">
	<div class="job_top-heading">
	<?php if($this->Session->read('Auth.User.id')):
		if($this->Session->read('welcomeName') && ($this->Session->read('UserRole'))):?>
			<h2>WELCOME <?php echo strtoupper($this->Session->read('welcomeName'));?>!</h2>
		<?php endif;
		endif;
		$status = array("Pending","Accepted");
	?>
	</div>
    <div class="job_container">
    	<div class="job_container_top_row">
    		<?php echo $this->element('side_menu');?>
    		<div class="job_right_bar">
            	<div class="job-right-top-content1">
                	<div class="job-right-top-left"> 
                    	<h2>NETWORKER STATS</h2>
                    	<p>Total: <span>678</span></p>
                    	<p>1st°: <span>20</span></p>
                    	<p>2nd°: <span>105</span></p>
                    	<p>3rd°: <span>367</span></p>
                    	<p>4th°: <span>400</span></p>
                    </div>
                    <div class="job-right-top-right" >
                    	<h2>INVITATIONS</h2>
                    	<div class="job-list-head">
                        <ul class="job-list-heading job-list-head-margin">
                        	<li class="job-list-name">NAME/EMAIL</li>
                            <li class="job-list-status">STATUS</li>
                            <li class="job-list-origin">ORIGIN</li>
                    	</ul>
                        </div>
                        <?php $i=0;?>
                        <?php foreach($invitations AS $contact):?>	
						<div class="job-list-subhead">
		                    <ul class="job-list-subcontent" >
			                   	<li class="<?php if($i%2==0) echo'dark';?>"><?php echo $contact['Invitation']['name_email']?></li>
								<li class="center-align <?php if($i%2==0) echo'dark';?>">
								<?php echo $status[ $contact['Invitation']['status'] ]; ?></li>
								<li class="margin-last-child-job <?php if($i%2==0) echo'dark';?>"><?php echo $contact['Invitation']['from']?></li>
								
		                	</ul>
                    	</div>
                    	<?php $i++;?>
					<?php endforeach;?>
						<?php	if($invitations == null){?>
						<div class="job-list-subhead">
				            <div class="inviation-message job-empty-message">
				            	No Invitaion Found.
				            </div>
                    	</div>
					<?php	} ?>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="job-right-bottom-right" >
                	<h2>MY NETWORKERS</h2>
                    <div class="job-table-heading">
                    		<ul>
                            	<li class="job-table-name job-table-align">Name/Email</li>
                                <li class="job-table-netw job-table-align">Networkers</li>
                                <li class="job-table-degree job-table-align">Degree</li>
                                <li class="job-table-points job-table-align">Points</li>
                                <li class="job-table-reward job-table-align">Reward</li>
                                <li class="job-table-level job-table-level-align job-table-align">Level</li>
                            </ul>
                    </div>
                    <div class="networkers-message job-empty-message">
                    	No Networkers Found.
                    </div>
                </div>
            </div>
        <div class="clr"></div>
    </div>
    <div class="job_pagination_bottm_bar"></div>
 	<div class="clr"></div>
</div>
</div>
</div>
<!======================================================>

