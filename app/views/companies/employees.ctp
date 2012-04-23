<?php $shortBy="";?>
<?php echo $html->css('datepicker');?>
<script>
	$(document).ready(function(){
		$("#CompaniesEmployeesForm").validate();
	});     
</script>
<script>
	$('document').ready(function(){
		$("#CompaniesFromDate").datepicker({ minDate: new Date(2012,2,1), maxDate:'+0'});
		$("#CompaniesToDate").datepicker({ minDate: new Date(2012,2,1), maxDate:'+0'});
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
</script>
<script>
	function goTo(){
		window.location.href="/companies/postJob";			
	}
</script>
<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<?php echo $this->element('side_menu');?>
		</div>
	</div>
	<!-- left section end -->
	<!-- middle section start -->
	<div class="rightBox" style=width:860px;">
		<!-- middle conent top menu start -->
		<div class="topMenu">
			<?php echo $this->element('top_menu');?>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
			<div class="middleBox">
			<table style="width:100%">
				<tr>
					
						<?php echo $form->create('Companies',array('action'=>'employees','type'=>'get'),
															array('onsubmit'=>'return validateForm();')
															)?>
						</div>
						<?php
							$from_date=isset($from_date)?$from_date:'03/01/2012';
							$to_date=isset($to_date)?$to_date:date('m/d/Y');
							$findUrl=array("contact_name"=>isset($contact_name)?$contact_name:"",
										   "contact_phone"=>isset($contact_phone)?$contact_phone:"",
										   "account_email"=>isset($account_email)?$account_email:"",
										   "from_date"=>date("Ymd",strtotime($from_date)),
										   "to_date"=>date("Ymd",strtotime($to_date)),
										   "page"=>isset($this->params['named']['page'])?$this->params['named']['page']:"1",
										   );
					
							if($this->Paginator->numbers()){?>
								<td colspan='100%'>
									<div style="float:right;width:55%;text-align:right;">
								<?php	
								$this->Paginator->options(array('url' =>$findUrl));
								echo $paginator->first('First  | '); 
								echo $paginator->prev(' '.__(' Previous ', true), array(), null, array('class'=>'disabled'));
								echo "  <  ".$this->Paginator->numbers(array('modulus'=>4))."   >   ";
								echo $paginator->next(__('  Next ', true).' ', array(), null, array('class'=>'disabled'));
								echo $paginator->last('  |  Last'); 
								echo "</td></div>";	
								}
							?>
						</div>
					
				</tr>
				<tr>
					<th style="width:5%">#</th>
					<th style="width:15%;text-align:center;">
						<?php echo $paginator->sort('Name','js.contact_name');?>
					</th>
					<th style="width:20%;text-align:center;">Address</th>					
					<th style="width:25%;text-align:center;">Email</th>
					<th style="width:20%;text-align:center;">Contact no.</th>
					<th style="width:20%;text-align:center;"><?php echo $paginator->sort('Date', 'paid_date');?></th>
					<th></th>
				</tr>
				<tr>
					<th></th>
					<th>											
						<?php
							echo $form->input(" ",array("name"=>"contact_name",
														"value"=>isset($contact_name)?$contact_name:"",
														"class"=>'text_field_employee',
														"title"=>'Enter Name',
											));
						?>
					</th>
					<th style="width:20%;text-align:center;">
						<?php
							echo $form->input("",array("name"=>"state",
													   "value"=>isset($state)?$state:"",
													   "class"=>'text_field_employee ',
													   "title"=>'Enter State,city',
											));
						?>
					</th>
					<th style="width:25%;text-align:center;">
						<?php
							echo $form->input("",array("name"=>"account_email",
												   	   "value"=>isset($account_email)?$account_email:"",
													  // "class"=>'text_field_bg  email',
												  		'class' => 'text_field_bg required email',
													   "style"=>'width:200px;',
													   "title"=>'Enter Email',	
											));
						?>
					
					</th>
					<th style="width:20%;text-align:center;">
						<?php
							echo $form->input("",array("name"=>"contact_phone",
												   	   "value"=>isset($contact_phone)?$contact_phone:"",
													   "class"=>'text_field_employee number',
													   "title"=>'Enter Contact Number',
											));
						?>
					</th>
					<th >
						<div style="margin-left:10px;float:left;margin-right:5px;">
							<font size='2px'>From</font>
						</div>
						<div style="width:130px;">
							<?php 
								echo $this->Form->input('from_date',array(
														'label'=>'',
														'type'=>'text',
														'readonly'=>"true",
														'class' => 'date_field_employee',
														'title'=>'From Date',
														'value'=>isset($from_date)?date("m/d/Y",strtotime($from_date)):'03/01/2012'
														));
							?>
						</div>
						<div style="margin-left:10px;margin-right:2px;float:left;clear:both;width:35px;">
							<font size='2px'>To:</font>
						</div>
						<div style="width:130px;">
							<?php 
								echo $this->Form->input('to_date',array(
														'label'=>'',
														'type'=>'text',
														'readonly'=>"true",
														'class' => 'date_field_employee',
														'title'=>'To Date',
														'value'=>isset($to_date)?date("m/d/Y",strtotime($to_date)):date('m/d/Y'),												));
							?>
						</div>
					</th> 
					<th style="width:10%">
						<?php echo $form->submit("Find", array('name'=>'find','style'=>'width:40px;')); 	
						?>
					</th>
				</tr>
				<?php if(empty($employees)){ ?>
				<tr>
					  <td colspan="7" style="line-height:20px;text-align:center;">Sorry no result.</td>
				</tr>
				<?php } ?>
				<?php $count=1; foreach($employees as $employee):?>	
				<tr>
					<td><? echo $count++; ?></td>
					<?php if(!empty($employee['js']['contact_name']) ):?>
					<td><?php echo ucFirst($employee['js']['contact_name']);?></td>
						<?php else:?>
						<td> -- -- -- </td>
						<?php endif;?>
					<td><?php echo $employee['js']['state'].' , '.$employee['js']['city'];?></td>
					<td><?php echo $employee['users']['account_email'];?></td>
					<td><?php echo $employee['js']['contact_phone'];?></td>
					<td><?php echo $this->Time->format('m/d/Y', $employee['PaymentHistory']['paid_date']);?></td>
					<!--<td><?php /*echo $this->Html->image("/img/icon/delete.png",
														array(
															"alt" => "image",
															"width"=>"24","height"=>"24",
															'url'=>'javascript:void(0);',
														    'title'=>'Delete',
															)
													);
 						*/?>
					</td>-->
				</tr>
				<?php endforeach; ?>	
				<?php echo $form->end();?>		
			</table>
		</div>
		<div class="postNewJob" onclick="goTo();">POST NEW JOB</div>
		<!-- middle conyent list -->
		</div>
	<!-- middle section end -->
</div>

