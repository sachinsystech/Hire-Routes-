<?php 
/*
 * Change Password
 */
?>
<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<?php echo $this->element('side_menu'); ?>
		</div>
	</div>
	<!-- left section end -->
	<!-- middle section start -->
	<div class="rightBox" >
		<!-- middle conent top menu start -->
		<div class="topMenu">
			<?php echo $this->element('top_menu');?>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
			<div class="middleBox">                                 
                <div class="setting_profile">
                	<?php echo $form->create('User',array('action'=>'changePassword'))?>
					<div>
						<?php echo $form->input('User.oldPassword',array(
												'label' => 'Old Password:',
												'type'  => 'password',
												'class' => 'text_field_bg required',
												)
								 );
						?>
					</div>
					<div style="clear:both"></div>
					<div>
						<?php	echo $form->input('password', array('label' => 'Password',
													'type'  => 'password',
													'name'  => "data[User][password]",
													'class' => 'text_field_bg password',
													'minlength' => '6',
                                           			)
                                 );
    					?>
    				</div>
    				<div style="clear:both"></div>
    				<div>
						<?php	echo $form->input('repeat_password', array('label' => 'Repeat Password',
                                           			'type'  => 'password',
													'name'  => "data[User][repeat_password]",
													'class' => 'text_field_bg required'
                                           			)
                                 );
						?>
					</div>
					<div style="clear:both"></div>
					<div>
						<div >
							<?php
								echo $form->button('Change',array(
													'lable'=>'',
													'type'=>'submit',
													'value'=>'Change',
													'style'=>'float:left;'
													))
							?>
							<?php
								echo $form->button('Cancel',array(
													'lable'=>'',
													'type'=>'Reset',
													'value'=>'Cancel',
													'style'=>'float:right;'
													))
							?>
						</div>
						<?php $form->end();?>
					</div>
					<div style="clear:both"></div>
				</div>
			</div>
			
		<!-- middle conyent list -->
	</div>
	<!-- middle section end -->


</div>
<script>
	$(document).ready(function(){
		$("#UserChangePasswordForm").validate();
	});     
</script>
