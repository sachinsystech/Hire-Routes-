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
            	<div class="job-right-top-content1">
                	<div class="job-right-top-left job-profile">
                    	<h2>PROFILE</h2>
                    	<?php if(isset($jobseeker['contact_name'])):?>
                    	<p><span>Name:</span>
							<?php echo ucfirst($jobseeker['contact_name']);?>
							<a href="/jobseekers/editProfile">edit</a>
						</p>
						<?php endif; ?>
						
                   		<?php if(isset($jobseeker['address'])): ?>
                    	<p><span>Address:</span> 
							<?php echo $jobseeker['address'];?>
							<a href="/jobseekers/editProfile">edit</a>
						</p>
						<?php endif;?>

						<?php if(isset($jobseeker['city'])):?>						
                    	<p><span>City:</span> 
                    		<?php echo $jobseeker['city'];?>
							<a href="/jobseekers/editProfile">edit</a>
						</p>
						<?php endif;?>

						<?php if(isset($jobseeker['state'])): ?>
                    	<p><span>State:</span> 
							<?php echo $jobseeker['state']; ?>
                    		<a href="/jobseekers/editProfile">edit</a>
                    	</p>
						<?php endif;?>
			                    	
   						<?php if(isset($jobseeker['contact_phone'])):?>
                    	<p><span>Phone:</span> 
							<?php echo $jobseeker['contact_phone'];?>
	                    	<a href="/jobseekers/editProfile">edit</a>
	                    </p>
      					<?php endif;?>                        

                        <?php if(isset($jobseeker['university_id']) && $jobseeker['university_id'] != 0 ): ?>
						<p><span>University:</span>
							<?php echo $user['Universities']['name'];?>
							<a href="/jobseekers/editProfile">edit</a>
						</p>
						<?php endif;?>
					
					
                        <?php if(isset($jobseeker['graduate_degree_id']) && $jobseeker['graduate_degree_id'] != null ): ?>
						<p><span>Graduate Degree::</span>
							<?php echo $user['GraduateDegrees']['degree'];?>
							<a href="/jobseekers/editProfile">edit</a>							
						</p>
						<?php endif;?>
					
						<?php if(isset($user['GUB']['graduate_college']) && $user['GUB'] != null): ?>
						<p><span>Graduate College:</span>
							<?php echo $user['GUB']['graduate_college'];?>
							<a href="/jobseekers/editProfile">edit</a>
						</p>
						<?php endif;?>                    

                        <p><span>Email:</span> 
                        	<a href="mailto:<?php echo $user['UserList']['account_email'];?>"><span><?php echo $user['UserList']['account_email'];?></span></a>
						</p>
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

