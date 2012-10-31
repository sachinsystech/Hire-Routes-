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
                    	<p><span>Company:</span>
			    <?php echo ucfirst($company['company_name']);?>
			    <a href="/companies/editProfile">edit</a>
			</p>
												
                    	<p><span>Company Name:</span> 
			    <?php echo $company['contact_name'];?>
			    <a href="/companies/editProfile">edit</a>
			</p>
                    	<p><span>Contact Phone:</span> 
			   <?php echo $company['contact_phone'];?>
			    <a href="/companies/editProfile">edit</a>
			</p>
            <p><span>Contact Url:</span> 
			     <?php if(isset($company['company_url']))echo $company['company_url'];?>
			    <a href="/companies/editProfile">edit</a>
			</p>            <p><span>Email:</span> 
                            <?php echo $user['account_email'];?>
				<!--<a href="/companies/editProfile">edit</a>-->
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

