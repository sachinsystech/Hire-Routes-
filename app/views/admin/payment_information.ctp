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
						echo $this->Form->create('paymentInformation',array('url'=>array('controller'=>'admin','action'=>'paymentInformation'),'onsubmit'=>'return validateForm();'));
					?>
					<div style="float:left;width:100px;margin: 2px;">
						<?php echo "<font size='3px'>From :</font>";?>
					</div>
					<div style="float:left;width:300px;margin: 2px;">
						<?php 
							echo $this->Form->input('from_date',array(
								'label'=>'',
								'type'=>'text',
								'value'=>isset($from_date)?$from_date:'03/01/2012'
								)
							);
						?>
					</div>
					<div style="float:left;width:100px;margin: 2px;">
						<?php echo "<font size='3px'>To :</font>";?>
					</div>
					<div style="float:left;width:300px;margin: 2px;">
					<?php 
						echo $this->Form->input('to_date',array(
							'label'=>'',
							'type'=>'text',
							'value'=>isset($to_date)?$to_date:date('m/d/Y')
							)
						);
					?>
					</div>
					<div style="clear:both"></div>
					<div style="float:left;width:100px;margin: 2px;">
						<font size='3px'>Status</font>
					</div>
					<div style="float:left;width:300px;margin: 2px;">
					<?php 
						echo $this->Form->input('status',
							array(
								'label'=>'',
								'type'=>'select',
								'empty'=>'All',
								'options'=>array('0'=>'Pending','1'=>'Done'),
								'style'=>'background:none;scroll:0 0 #FFFFFF;color:#393939;border:1px solid;',
							)
						);
					?>
					</div>
					<div style="float:left;width:100px;margin: 2px;">
						<?php echo $this->Form->submit('GO',array('style'=>'background:#1E90FF;color:#FFFFFF'));?>
					</div>
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
					<div class="clearBoth">&nbsp;</div>
				    <table width ="100%" cellspacing='0'>
						<tr>
							<td COLSPAN="7">
								<div class="code_pagination">
								<?php if($this->Paginator->numbers()){ echo $paginator->first('First '); ?>	
								<?php echo $paginator->prev('<< '.__('Previous Page', true), array(), null, array('class'=>'disabled'));?>
								<?php echo "< < ".$this->Paginator->numbers(array('modulus'=>4))."  > >"; ?>
								<?php echo $paginator->next(__('Next Page', true).' >>', array(), null, array('class'=>'disabled'));?>
								<?php echo $paginator->last(' Last'); }?>
								</div>
							</td>
						</tr>	
						<tr class="tableHeading"> 
						    <th>Company Name</th>
						    <th>Employ Name</th>
							<th>Job title</th>
						    <th>Payment</th>
						    <th>Date</th>
						    <th>Transaction Id</th>
						    <th>Action</th>
					    </tr>
        			        <?php 
        		        		if($paymentHistories){
									$sno = 0;
        		        			foreach($paymentHistories as $paymentHistory):
        			            		$class = $sno++%2?"odd":"even";
        			        ?>
						<tr class="<?php echo $class; ?>"> 
							<td align="center" width="15%" style="padding:10px;">
								<?php echo $paymentHistory['Company']['company_name'];?>
							</td> 
							<td align="center" width="15%">
								<?php echo $paymentHistory['Jobseeker']['contact_name'];?>
							</td>
							<td align="center" width="20%">
								<?php echo $paymentHistory['Job']['title'];?>
							</td> 
							<td align="right" width="10%">
								<?php
									echo $this->Number->format(
										$paymentHistory['PaymentHistory']['amount'],
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?>
							</td>
							<td align="center" width="15%">
								<?php echo date('m/d/Y',strtotime($paymentHistory['PaymentHistory']['paid_date']))."&nbsp;";?>
							</td>
							<td align="center" width="15%">
								<?php echo $paymentHistory['PaymentHistory']['transaction_id'];?>
							</td>
							<td align="center" width="10%">
								<?php echo $html->link("View Details", array('controller' => 'admin','action'=>'paymentDetails', $paymentHistory['PaymentHistory']['id']));?>
							</td>
					    </tr>
		      			<?php 
				    			endforeach; 
				    		}else{
						?>
						<tr class="odd">			
				    		<td colspan="7" align="center">Sorry no result found.</td>
						</tr>
						<?php
				    		}
						?>
						<tr>
	    					<td colspan="7" align="center">
								<?php
									echo $this->Paginator->numbers(array('modulus'=>4)); 
								 ?>
		    				</td>
						</tr>
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
