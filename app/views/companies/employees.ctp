<?php $shortBy="";?>
<?php echo $html->css('datepicker');?>
<script>
	$(document).ready(function(){
		$("#CompaniesEmployeesForm").validate();
	});     

	$('document').ready(function(){
	  
		$("#CompaniesFromDate").datepicker({ minDate: new Date(2012,0,1), maxDate:'+0'});
		$("#CompaniesToDate").datepicker({ minDate: new Date(2012,0,1), maxDate:'+0'});
	});
</script>
<script type='text/javascript'>	
	function validateDate(datefield)
	{
		var date1=datefield.value.split('/');
		if(date1.length==3&&date1[2].match('\^2[0-9]{3}\$')&&date1[0].match('\^[0-1]{1}[0-9]{1}\$')&&date1[1].match('\^[0-3]{1}[0-9]{1}\$'))
		{
			return true;
		}
		else
		{
			alert('Invalid Date');
			datefield.value="";
			datefield.focus();
			return false;
		}
	}
	
	function validateDateRange(from,to)
	{
		date1=from.value.split('/');
		date2=to.value.split('/');
		var from_date=new Date(date1[2],date1[0],date1[1]);
		var to_date= new Date(date2[2],date2[0],date2[1]);
		
		if(from_date>to_date)
		{
			alert("Invalid period");
			return false;
		}
		return true;
	}

	function validateForm()
	{	
		var from_date=document.getElementById('CompaniesFromDate');
		var to_date=document.getElementById('CompaniesToDate');
		if(from_date.value==""||to_date.value=="")
		{
		}
		else
		{	
			if(validateDate(from_date)&&validateDate(to_date)&&validateDateRange(from_date,to_date))
				return true;
			else
				return false;
		}
	}
	function clear_fields(){
		$('select, :text').val("");
		return false;
	}

	function goTo(){
		window.location.href="/companies/postJob";			
	}
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
    		<?php echo $this->element('side_menu');?>
    		<div class="job_right_bar">
            	<div class="job-right-top-content1">
                	<div class="job-right-top-left" >
                    	<h2>EMPLOYEE</h2>
						<?php echo $form->create('Companies',array('action'=>'employees','type'=>'get',
																   'onsubmit'=>'return validateForm();')
												);
						
						$findUrl=array("contact_name"=>isset($contact_name)?$contact_name:"",
										   "contact_phone"=>isset($contact_phone)?$contact_phone:"",
										   "address"=>isset($address)?$address:"",
										   "account_email"=>isset($account_email)?$account_email:"",
										   "from_date"=>isset($from_date)?date("Ymd",strtotime($from_date)):"",
										   "to_date"=>isset($to_date)?date("Ymd",strtotime($to_date)):"",
										   "page"=>isset($this->params['named']['page'])?$this->params['named']['page']:"1",
										   );
						?>
						<?php if($this->Paginator->numbers()):?>
						<div class="pagination_main">
							<div class="job_next_bttn pagination_next"><?php echo $paginator->prev('  '.__('', true), array(), null, array('class'=>'disabled'));?></div>
							<div class="job_preview_bttn pagination_pre"><?php echo $paginator->next(__('', true).' ', array(), null, array('class'=>'disabled'));?>
							</div>
							
							<div class="pagination_new">
								<div>
									<?php echo $paginator->first("<<",array("class"=>"arrow_margin" )); ?>	
									<ul>
									<?php echo $this->Paginator->numbers(array('modulus'=>8,
																				'tag'=>'li',
																				'separator'=>false,)); ?>
									</ul>
									<?php echo $paginator->last(">>", array("class"=>"arrow_margin",
																					)); ?>
			
								</div>								   
							 </div>  
							<div class="clr"></div>
						</div>  
						<?php endif; ?>
						
                    	
						<div class="list-head-i list-imply-margin">
							<ul class="list-heading">
								 <li><?php echo $paginator->sort('NAME','js.contact_name');?></li>
								 <li class="list-email">EMAIL</li>
								 <li>CONTACT</li>
								 <li><?php echo $paginator->sort('DATE', 'paid_date');?></li>
							</ul> 
							<div class="clr"></div>
						</div>
						<div class="list-head-i">
							<ul class="list-heading">
								 <li>
									<div class="textbox-name">
										<?php
											echo $form->input(" ",array("name"=>"contact_name",
																		"value"=>isset($contact_name)?$contact_name:"",
																		//"class"=>'text_field_employee',
																		"title"=>'Enter Name',
																		'div' =>'false'
															));
										?>
									</div>
								 </li>
								 <li class="list-email">
									<div class="textbox-email">
										<?php
											echo $form->input("",array("name"=>"account_email",
																	   "value"=>isset($account_email)?$account_email:"",
																	   "title"=>'Enter Email',
																	   'div' =>'false'
															));
										?>
									</div>
								 </li>
								 <li>
									<div class="textbox-name">
											<?php
												echo $form->input("",array("name"=>"contact_phone",
																		   "value"=>isset($contact_phone)?$contact_phone:"",
																		   "title"=>'Enter Contact Number',
																		   'div' =>'false'
																));
											?>
									</div>
								 </li>
								 <li class="textbox-date-width">
									<div class="textbox-date">
										<span>FROM</span>
										<?php 
											echo $this->Form->input('from_date',array(
																	'label'=>'',
																	'type'=>'text',
																	'readonly'=>"true",
																	'title'=>'From Date',
																	'value'=>isset($from_date)?date("m/d/Y",strtotime($from_date)):"",
																	'div' =>'false'
																	));
										?>
									</div>
									<div class="textbox-date">
										<span>TO</span>
										<?php 
												echo $this->Form->input('to_date',array(
																		'label'=>'',
																		'type'=>'text',
																		'readonly'=>"true",
																		'title'=>'To Date',
																		'value'=>isset($to_date)?date("m/d/Y",strtotime($to_date)):"",
																		'div' =>'false'
																		));
											?>
									</div>
								 </li>
							</ul> 
						<div class="clr"></div>
						</div>
						<div class="bttn_find_clr">
								<div class="find_clr_button">
									<?php echo $form->submit('FIND',array('div'=>false,'name'=>'find')); ?>	
								</div>
								<div class="find_clr_button">
									<input type="button" value="CLEAR" onclick=" clear_fields();">
								</div>
						
						</div>
						<?php $i=0; ?>
						<?php foreach($employees as $employee):?>
						 <div class="list-head-i">
							<ul class="listing-i <?php if($i%2==0) echo'dark';?>">
								<li>
									<?php if(!empty($employee['js']['contact_name']) ):?>
									<?php echo ucFirst($employee['js']['contact_name']);?>
									<?php else:?>
										-- -- --
									<?php endif;?>
								</li>
								<li class="list-email"><?php echo $employee['users']['account_email'];?></li>
								<li class="employee_contact_row"><?php echo $employee['js']['contact_phone'];?></li>
								<li class="employee_date_row"><?php echo $this->Time->format('m/d/Y', $employee['PaymentHistory']['paid_date']);?></li>
							</ul> 
						 </div>
						 <?php $i++; ?>
						<?php endforeach; ?>
						<?php if(empty($employees)){ ?>
							<?php if(isset($contact_name) || isset($account_email ) || isset($contact_phone) || isset($from_date) || isset($to_date) ){ ?>
							 <div class="list-head-i">
									<div class='job-empty-message'>Sorry, don't have employee for this filter</div>
							 </div>
							<?php }else{?>
							 <div class="list-head-i">
									<div class='job-empty-message'>You have not selected any Employees yet</div>
							 </div>
							 <?php } ?>
						<?php } ?>
						<?php echo $form->end();?>
                    <div class="clr"></div>
                </div>
            </div>
			</div>
        <div class="clr"></div>
    </div>
    <div class="job_pagination_bottm_bar"></div>
 	<div class="clr"></div>
</div>
</div>
