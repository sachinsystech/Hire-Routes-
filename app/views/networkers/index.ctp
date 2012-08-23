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
       	 					<?php if(isset($user['Networkers']['contact_name'])): 
									echo ucfirst($user['Networkers']['contact_name']);
								endif;
							?>
							<a href="/networkers/editProfile">edit</a>
						</p>
						<!---<div style="display:none;" class="edit-profile-text-box">
							<?php	$name = "";
                                if(isset($fbinfo)){ $name = $fbinfo['first_name']." ".$fbinfo['last_name']; }
                                if(isset($networker) && $user['contact_name']!=""){ $name = $user['contact_name']; } 
                                echo $form->input('Networkers.contact_name', array('label' => false,
											'type'  => 'text',
											'class' => 'required',
											'value' => $name,
											'div' => false,
											'placeholder' =>'Contact Name',
											)
							 	);
							 ?>
							 <a href="#" id="cancel">cancel</a>
						</div>
						---->							
                    	<p><span>Address:</span> 
                    		<?php if(isset($user['Networkers']['address'])): echo $user['Networkers']['address'];
								endif;
							?>
							<a href="/networkers/editProfile">edit</a>
						</p>
                    	<p><span>City:</span> 
                    		<?php if(isset($user['Networkers']['city'])):echo $user['Networkers']['city'];
								endif;
							?>
							<a href="/networkers/editProfile">edit</a>
						</p>
                    	<p><span>State:</span> 
   							<?php if(isset($user['Networkers']['state'])): echo $user['Networkers']['state'];
								endif;?>
                    		<a href="/networkers/editProfile">edit</a>
                    	</p>
                    	<p><span>Phone:</span> 
      						<?php if(isset($user['Networkers']['contact_phone'])):
      								echo $user['Networkers']['contact_phone'];
      						 	endif;
      						 ?>
	                    	<a href="/networkers/editProfile">edit</a>
	                    </p>
                        <p><span>University:</span> 
           					<?php if(isset($user['Universities']['name'])):
           							echo $user['Universities']['name'];
								endif;?>
                        	<a href="/networkers/editProfile">edit</a>
                        </p>
                        <p><span>Graduate Degree:</span> 
							<?php if(isset($user['GraduateDegrees']['degree'])):
								 echo $user['GraduateDegrees']['degree'];
							endif;?>
                        	<a href="/networkers/editProfile">edit</a>
                        </p>                        
                        <p><span>Graduate University:</span> 
							<?php if(isset($graduateUniversity) && $graduateUniversity != "" ):
								 echo $graduateUniversity;
							endif;?>
                        	<a href="/networkers/editProfile">edit</a>
                        </p>                        
                        
                        
                        <p><span>Email:</span> 
                        	<a href="mailto:<?php echo $user['UserList']['account_email']; ?>"><span><?php echo $user['UserList']['account_email']; ?></span></a>
                        	<!--<a href="/networkers/editProfile">edit</a>-->
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

