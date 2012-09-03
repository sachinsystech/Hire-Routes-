<script>
	$(document).ready(function(){
		$("#UserChangePasswordForm").validate({
			rules: {
				'data[User][password]': "required",
				'data[User][repeat_password]': {
				  equalTo: "#UserPassword"
				}
			  },
			errorClass: 'error_input_message',
				errorPlacement: function (error, element) {
					error.insertAfter(element)
			}
			});
		$("#clear_all").click(function(){ 
			$("input[type=password]").val("");		
			return false;
		});
	});
</script>
<div class="job_top-heading">
	<?php if($this->Session->read('Auth.User.id')):?>
		<?php if($this->Session->read('welcomeName') && ($this->Session->read('UserRole'))):?>
			<h2>WELCOME <?php echo strtoupper($this->Session->read('welcomeName'));?>!</h2>
		<?php endif; ?>
	<?php endif; ?>
</div>
<div class="job_container">
	<div class="job_container_top_row">
      <!-- Job- Left - Sidebar -->
      <?php echo $this->element('side_menu');?>
	 <!-- Job - left- sidebar Ends --> 
		<div class="job_right_bar">
		<div class="job_network_password">
			<h2>CHANGE PASSWORD</h2>
			<?php echo $form->create('User',array('action'=>'changePassword'))?>
			<div class="job-text-box"> 
			<?php
				echo $form->input('User.oldPassword',array(
									'label' => false,
									'type'  => ($facebookUserData!=null)?'hidden':'password',
									'class' => 'required',
									'div'	=> false,
									'minlength' => '6',
									'placeholder'=>"Old Password",
								)
				);
			?>
			</div>
			<?php if(isset($old_password_error)):?>
			<label class="error">
				<?php echo $old_password_error;?>
			</label>
			<?php endif;?>
			<div class="job-text-box"> 
				<?php echo $form->input('User.password', array('label' => false,
												'type'  => 'password',
												'name'  => "data[User][password]",
												'class' => 'required',
												'minlength' => '6',
												'div'	=> false,
												'placeholder'	=> "New Password",
                                          			)
                                );
    				?>
			</div>
			<div class="job-text-box text-box-below"> 
			<?php echo $form->input('repeat_password', array('label' => false,
                                       			'type'  => 'password',
												'name'  => "data[User][repeat_password]",
												'class' => 'required',
												'div'	=> false,
												'placeholder'	=> "Repeat Password",
                                          		)
                                );
			?>
			</div>
			</div>
			<div class="job-clear-all"><a href="#" id="clear_all">Clear All</a></div>
			<div class="login-button job-login">
			<?php echo $form->submit('CHANGE',array('type'=>'submit',
												'value'=>'Change',
												'div'	=>false,
												)
											);
			?>
			</div>
			<?php echo $form->end();?>
			<div class="clr"></div>
		</div>
	</div>
    <div class="clr"></div>
</div>
    <div class="job_pagination_bottm_bar"></div>
 	<div class="clr"></div>
</div>
</div>
</div>

