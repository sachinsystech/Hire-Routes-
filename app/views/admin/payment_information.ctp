<?php
	/**
	 * Payment information for admin
	 */
?>
<?php echo $html->css('datepicker');?>
<script>
	$('document').ready(function(){
		$("#paymentInformationFromDate").datepicker({ minDate: new Date(2012,2,1), maxDate:'+0'});
		$("#paymentInformationToDate").datepicker({ minDate: new Date(2012,2,1), maxDate:'+0'});
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
		var from_date=document.getElementById('paymentInformationFromDate');
		var to_date=document.getElementById('paymentInformationToDate');
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
	
	function resetFields(){
	
	
	}
</script>
<?php echo $this->Session->flash();?>
<div id="page-heading"><h1>Payment Information</h1></div>
<div class="table_seperator"></div>


<table class="content-table" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<th rowspan="3" class="sized"></th>
			<th class="topleft"></th>
			<td id="tbl-border-top">&nbsp;</td>
			<th class="topright"></th>
			<th rowspan="3" class="sized"></th>
		</tr>
		<tr>
			<td id="tbl-border-left"></td>
			<td>
				<div style="float:left">
					<?php
						echo $this->Form->create('paymentInformation',array('url'=>array('controller'=>'admin','action'=>'paymentInformation'),'type'=>'get','onsubmit'=>'return validateForm();'));
										
					?>
					<div style="float:left;width:100px;margin: 2px;">
						<?php echo "<font size='3px'>From :</font>";?>
					</div>
					<div style="float:left;width:150px;margin: 2px;">
						<?php 
							$date = new DateTime();
							$date->modify(-30 . ' days');
							$last_month= $date->format("m/d/Y");
							$from_date=isset($from_date)?$from_date:$last_month;
							$to_date=isset($to_date)?$to_date:date('m/d/Y');
							$findUrl=array(
									   "from_date"=>date("Ymd",strtotime($from_date)),
									   "to_date"=>date("Ymd",strtotime($to_date)),
									   "status"=>isset($status)?$status:"",
									   );
							echo $this->Form->input('from_date',array(
								'label'=>'',
								'type'=>'text',
								'class'=>'date_field_employee',
								'readonly'=>'true',
								'style'=>'width:75px;',
								'value'=>isset($from_date)?date("m/d/Y",strtotime($from_date)):$date->format("m/d/Y")
								)
							);
						?>
					</div>
					<div style="float:left;width:75px;margin: 2px;">
						<?php echo "<font size='3px'>To :</font>";?>
					</div>
					<div style="float:left;width:150px;margin: 2px;">
					<?php 
						echo $this->Form->input('to_date',array(
							'label'=>'',
							'type'=>'text',
							'readonly'=>'true',
							'class'=>'date_field_employee',
							'style'=>'width:75px;',
							'value'=>isset($to_date)?date("m/d/Y",strtotime($to_date)):date('m/d/Y')
							)
						);
					?>
					</div>
					<div style="clear:both"></div>
					<div style="float:left;width:100px;margin: 2px;">
						<font size='3px'>Status</font>
					</div>
					<div style="float:left;width:150px;margin: 2px;">
					<?php 
						echo $this->Form->input('status',
							array(
								'label'=>'',
								'type'=>'select',
								'empty'=>'--select--',
								'value'=>isset($status)?$status:"",
								'options'=>array('0'=>'Pending','1'=>'Done'),
								'style'=>'background:none;scroll:0 0 #FFFFFF;color:#393939;border:1px solid;',
							)
						);
					?>
					</div>
					<div style="float:left;width:100px;margin: 2px;">
						<?php echo $this->Form->submit('GO',array('name'=>'find','style'=>'width:60px;'));?>
						
					</div>
					<!--
					<div style="float:left;">
						<button class="clear_button div_hover"  style="margin-top:4px;height:25px;"type="Reset" onclick ="resetFields();">Clear</button>
						
					</div>
					-->
					<div style="clear:both"></div>
					<?php echo $this->Form->end(); ?>
				</div>
			</td>	
			<td id="tbl-border-right"></td>
		</tr>
		<tr>
			<th class="sized bottomleft"></th>
			<th id="tbl-border-bottom">&nbsp;</th>
			<th class="sized bottomright"></th>
		</tr>
	</tbody>
</table>
<div class="table_seperator"></div>
<table class="content-table" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<th rowspan="3" class="sized"></th>
			<th class="topleft"></th>
			<td id="tbl-border-top">&nbsp;</td>
			<th class="topright"></th>
			<th rowspan="3" class="sized"></th>
		</tr>
		<tr>
			<td id="tbl-border-left"></td>
		    <td>
				<div class="content-table-inner">
					<div class="code_pagination">
								<?php if($this->Paginator->numbers()){ echo $paginator->first('First  |  '); 
										//$this->Paginator->options(array('url' =>$findUrl));
									
										echo $paginator->prev('  '.__('Previous ', true), array(), null, array('class'=>'disabled'));	
										echo " < ".$this->Paginator->numbers(array('modulus'=>4))." > ";
										echo $paginator->next(__('Next ', true).' ', array(), null, array('class'=>'disabled'));
										echo $paginator->last('  |  Last'); }
								?>
					</div>
					
				    <table width ="100%" cellspacing='0' class="userTable">
						<tr class="tableHeading">
						    <th>Employer</th>
							<th>Job Title</th>
							<th>Date Posted</th>
							<th><?php echo $this->Paginator->sort('Reward($)','PaymentHistory.amount')?></th>
						    <th><?php echo $this->Paginator->sort('Date Paid','PaymentHistory.paid_date')?></th>
						    <th>Transaction Id</th>
						    <th> </th>
					    </tr>
						<?php 
							if($paymentHistories){
								$sno = 0;
								foreach($paymentHistories as $paymentHistory):
									$class = $sno++%2?"odd":"even";
						?>
						<tr class="<?php echo $class; ?>">
							<!-- td align="center" width="4%"> <?php //echo $sno;?></td --> 
							<td  width="13%" style="padding:7px;padding-left:18px">
								<?php echo $paymentHistory['Company']['company_name'];?>
							</td> 
							<!-- td align="center" width="15%">
								<?php //echo $paymentHistory['Jobseeker']['contact_name'];?>
							</td -->
							<td  width="17%" style="padding-left:18px">
								<?php echo $paymentHistory['Job']['title'];?>
							</td>
							<td align="center" width="12%">
								<?php echo date('m/d/Y',strtotime($paymentHistory['Job']['created']))."&nbsp;";?>
							</td>
							<td align="right" width="10%" style="padding-right:5px;">
								<?php
									echo $this->Number->format(
										$paymentHistory['PaymentHistory']['amount'],
										array(
											'places' => 2,
											//'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?>
							</td>
							<td align="center" width="12%">
								<?php echo date('m/d/Y',strtotime($paymentHistory['PaymentHistory']['paid_date']))."&nbsp;";?>
							</td>
							<td align="center" width="15%">
								<?php echo $paymentHistory['PaymentHistory']['transaction_id'];?>
							</td>
							<td align="center" width="10%" style="font-size:12px;">
								<?php echo $html->link("View Details", array('controller' => 'admin','action'=>'paymentDetails', $paymentHistory['PaymentHistory']['id']));?>
							</td>
					    </tr>
		      			<?php 
				    			endforeach; 
				    		}else{
						?>
						<tr class="odd">			
				    		<td colspan="8" align="center" style="line-height: 25px;">Sorry no result found.</td>
						</tr>
						<?php
				    		}
						?>
					</table>
				</div>
			</td>
			<td id="tbl-border-right"></td>
		</tr>
		<tr>
			<th class="sized bottomleft"></th>
			<th id="tbl-border-bottom">&nbsp;</th>
			<th class="sized bottomright"></th>
		</tr>
	</tbody>
</table>
<?php
//	echo $this->element('sql_dump');
?>
