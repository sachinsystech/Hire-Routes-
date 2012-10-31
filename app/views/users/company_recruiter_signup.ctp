<script>
  function checkform() {
    var isAgreeCondition = $('input:checkbox[id=UserAgreeCondition]:checked').val();
    if(!isAgreeCondition){
      $("#agree_condition_error").removeClass().addClass("error_input_message").html("This field is required..");
      return false;
    }
    if(isAgreeCondition){
      $("#agree_condition_error").removeClass().html("");  
    }
  }
  $(document).ready(function(){
/*  jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
    phone_number = phone_number.replace(/\s+/g, ""); 
	return this.optional(element) || phone_number.length > 9 &&
		phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
}, "Please specify a valid phone number");*/
  
	$("#UserCompanyRecruiterSignupForm").validate({
		  errorClass: 'error_input_message',
		  rules: {
			'data[User][password]': "required",
			'data[User][repeat_password]': {
			  equalTo: "#UserPassword"
			}
		  },
		  errorPlacement: function (error, element) {
		  	if($(element).attr("type")== "radio"){
		  		error.insertAfter(element.parent("div").parent());
		  	}else{
			  	if($(".placehcss").length){
					error.insertAfter(element.parent());
				}else{
					error.insertAfter(element);
				}
			}
		  }
	});
	  
  });
      
</script>

<h1 class="title-emp">Companies/Recruiters Registration</h1>
    <div class="sub-title-cs">Please fill the registration request below, we will analyze your data and get back with in next 24 hours.</div>
    
	<?php echo $form->create('User', array('action' => 'companyRecruiterSignup','onsubmit'=>'return checkform();')); ?>
    <div class="login_middle_main"> 
		<div class="login_middle_left_box" style="float:none;margin:auto;"> 
        	<div class="company-recruiter-checkbox signup_middle_topallign">
        		<div class="company-recruiter-radio">
        		<?php  echo $form -> input('Companies.role',array(
                                                 //'before' => '<div>',
                                                 //'after' => '</div>',
                                                 'legend' => false,
                                                 'type'=>'radio',
                                                 'div'=> false,
                                                 'class' => 'required company-recruiter-radio-input',
                                                 'label'=>'',
                                                 'options'=>array('company'=>"I'm a company <div class='clr'></div>",'recruiter'=>"I'm a recruiter"),
										),
										array('checked'=>0)
							);
			    ?>
        		</div>
        		
        		<!----------
        		<div class="cross-button bottom-margin">
        			<input id="CompaniesRoleCompany" name="data[Companies][role]" type="radio" value="" class = 'required'/>
        		</div>
                <div class="comp-recruiter-text">I'm a Company</div>
                <div class="clr"></div>
                <div class="cross-button bottom-margin">
					<input id="CompaniesRoleRecruiter" name="data[Companies][role]" type="radio" value="" class='required'/>
                </div>
                <div class="comp-recruiter-text">I'm a Recruiter</div>
                
                --->
			</div>
			<span style="position: absolute; color:#847A6C; margin-top: 13px; font-size: 13px;">* Required</span>
			<div class="text-box signup_middle_allign">
				<?php	echo $form->input('Companies.company_name', array('label' => false,
                                           			'type'  => 'text',
                                           			'div' 	=>false,
													'class' => 'required alphabets',
													'minlength' => '3',
													'placeholder'=>'Company Name*',
                                           			)
                                 );
			    ?>
			</div>
            <div class="text-box text-box-below signup_middle_allign ">
				<?php	echo $form->input('Companies.contact_name', array('label' => false,
				                                   			'type'  => 'text',
				                                   			'div'	=> false,
															'class' => 'required alphabets',
															'minlength' => '3',
															'placeholder'=>'Contact Name*',
															'value'	=>"",
				                                   			)
				                         );
				?>
            
            </div>
			<div class="text-box text-box-below signup_middle_allign ">
				<?php	echo $form->input('Companies.contact_phone', array('label' => false,
								                       			'type'  => 'text',
								                       			'div'	=>false,
																'class' => 'required phoneUS',
																'minlength' => '10',
																'placeholder'=>'Contact Phone*',
																'value' =>"",
								                       			)
								             );
				?>
            </div>            
		    <div class="text-box text-box-below signup_middle_allign ">
				<?php	echo $form->input('Companies.company_url', array('label' => false,
						                               			'type'  => 'text',
						                               			'div'=> false,
																'class' => 'url',
																//'minlength' => '8',
																'placeholder'=> 'Company Website',
																'value' =>"",
						                               			)
						                     );
				?>
            
            </div>
		    <div class="text-box text-box-below signup_middle_allign ">
				<?php	echo $form->input('account_email', array('label' => false,
						                               			'type'  => 'text',
						                               			'div' 	=>false,
																'class' => 'required email',
																'placeholder'=> 'Email*',
																'value' =>"",
						                               			)
						                     );
				?>
            
            </div>
		    <div class="text-box text-box-below signup_middle_allign ">
            <?php	echo $form->input('password', array('label' => false,
                                           			'type'  => 'password',
                                           			'div'	=> false,
													'name'  => "data[User][password]",
													'class' => 'password',
													'minlength' => '6',
													'placeholder'=> 'Password*',
                                           			)
                                 );
		    ?>
            </div>
		    <div class="text-box text-box-below signup_middle_allign ">
				<?php	echo $form->input('repeat_password', array('label' => false,
                                           			'type'  => 'password',
													'name'  => "data[User][repeat_password]",
													'class' => 'required',
													'div' => false,
													'placeholder'=> 'Repeat Password*',
                                           			)
                                 );
			    ?>
            </div>
     		<div class="check-button signup_middle_allign">
				<div class="cross-button">
					<?php	echo $form->input('agree_condition', array('label' => false,
		                                       			'type'  => 'checkbox',
														'name'  => "data[User][agree_condition]",
														'div' =>false,
		                                       			)
		                             );
					?>
				</div>
                <div class="remember-me agree-with">Agree with <a href="/termsOfUse">Terms & Conditions</a></div>
                <div id="agree_condition_error"></div>
				<?php if(isset($errors)): ?>
					<div class="error-message" ><?php echo $errors;?></div>
				<?php endif; ?>
        	    </div>
        	    <div class="login-button">
        	    	<?php echo $form->submit('SEND REQUEST',array('div'=>false,)); ?>
				</div>
				
    	        <div class="forgot-password dont-know-width signup_middle_forget_txt"><a href="/companyInformation">Don't know about Companies/Recruiters?</a></div>
			</div>
		</div>
		<?php echo $form->end(); ?>	
	</div>
