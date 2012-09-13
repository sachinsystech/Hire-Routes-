	<?php if($this->Session->read('Auth.User.id')):?>
		<?php if($this->Session->read('welcomeName') && ($this->Session->read('UserRole'))):?>
				<h2>WELCOME <?php echo strtoupper($this->Session->read('welcomeName'));?></h2>
		<?php endif; ?>
		<?php 
			$userName = $this->Session->read("welcomeName");
			
    		if($userName== null || $userName ==""){
    			if( $this->Session->read('UserRole') == NETWORKER){
		    		echo "<span>Please fill your&nbsp<a href='/Networkers/editProfile'>Profile</a></span>";
    			}
    			if( $this->Session->read('UserRole') == JOBSEEKER){
		    		echo "<span>Please fill your&nbsp<a href='/jobseekers/editProfile'>Profile</a></span>";
    			}

    		}
    	?>
	<?php endif; ?>
