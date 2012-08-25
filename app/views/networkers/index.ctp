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
                    	<p><span>Name:</span>
       	 					<?php echo ucfirst($user['Networkers']['contact_name']); ?>
							<a href="/networkers/editProfile">edit</a>
						</p>
                    	<p><span>Address:</span> 
                    		<?php echo $user['Networkers']['address']; ?>
							<a href="/networkers/editProfile">edit</a>
						</p>
                    	<p><span>City:</span> 
                    		<?php echo $user['Networkers']['city'];?>
							<a href="/networkers/editProfile">edit</a>
						</p>
                    	<p><span>State:</span> 
   							<?php echo $user['Networkers']['state'];?>
                    		<a href="/networkers/editProfile">edit</a>
                    	</p>
                    	<p><span>Phone:</span> 
      						<?php echo $user['Networkers']['contact_phone'];?>
	                    	<a href="/networkers/editProfile">edit</a>
	                    </p>
                        <p><span>University:</span> 
           					<?php echo $user['Universities']['name'];?>
                        	<a href="/networkers/editProfile">edit</a>
                        </p>
                        <p><span>Graduate Degree:</span> 
							<?php echo $user['GraduateDegrees']['degree'];?>
                        	<a href="/networkers/editProfile">edit</a>
                        </p>                        
                        <p><span>Graduate University:</span> 
							<?php echo $graduateUniversity;?>
                        	<a href="/networkers/editProfile">edit</a>
                        </p>                        
                        <p><span>Email:</span> 
                        	<a href="mailto:<?php echo $user['UserList']['account_email']; ?>"><span><?php echo $user['UserList']['account_email']; ?></span></a>
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

