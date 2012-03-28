<?php
	/**
	 * Payment information for admin
	 */
?>
<?php echo $html->css('datepicker');?>
<script>
	$('document').ready(function(){
		$("#filterFromDate").datepicker({ dateFormat: 'yy-mm-dd',minDate: new Date(2012,2,1), maxDate:'+0'});
		$("#filterToDate").datepicker({ dateFormat: 'yy-mm-dd',minDate: new Date(2012,2,1), maxDate:'+0'});
	});
</script>
<script type='text/javascript'>	
	function validateDate(datefield)
	{
		var date1=datefield.value.split('-');
		if(date1.length==3&&date1[0].match('\^2[0-9]{3}\$')&&date1[1].match('\^[0-1]{1}[0-9]{1}\$')&&date1[2].match('\^[0-3]{1}[0-9]{1}\$'))
			return true;
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
		date1=from.value.split('-');
		date2=to.value.split('-');
		var from_date=new Date(date1[0],date1[1],date1[2]);
		var to_date= new Date(date2[0],date2[1],date2[2]);
		if(from_date>to_date)
		{
			alert("Invalid period");
			return false;
		}
		return true;
	}

	function validateForm()
	{
		var from_date=document.getElementById('filterFromDate');
		var to_date=document.getElementById('filterToDate');
		if(from_date.value==""||to_date.value=="")
		{
			alert('empty');
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
		<?php
			echo $this->Form->create('filter',array('url'=>array('controller'=>'admin','action'=>'filterPayment'),'onsubmit'=>'return validateForm();'));
		?>
		<tr>
			<td>
				<?php echo "<font size='3px'>From :</font>";?>
			</td>
			<td>
				<?php 
					echo $this->Form->input('from_date',array(
						'label'=>'',
						'type'=>'text',
						'value'=>'2012-03-01'
						)
					);
				?>
			</td>
			<td>
				<?php echo "<font size='3px'>To :</font>";?>
			</td>
			<td>
				<?php 
					echo $this->Form->input('to_date',array(
						'label'=>'',
						'type'=>'text',
						'value'=>date('Y-m-d')
						)
					);
				?>
			</td>
		</tr>
		<tr>
			<td>
				<font size='3px'>Status</font>
			</td>
			<td>
				<?php 
					echo $this->Form->input('status',
						array(
							'label'=>'',
							'type'=>'select',
							'empty'=>'All',
							'options'=>array('0'=>'Pending','1'=>'Done')
						)
					);
				?>
			</td>
			<td>
				<?php echo $this->Form->submit('GO');?>
			</td>
		</tr>
		<?php echo $this->Form->end(); ?>
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
								<?php  echo $paginator->first('First '); ?>	
								<?php echo $paginator->prev('<< '.__('Previous Page', true), array(), null, array('class'=>'disabled'));?>
								< <  <?php echo $this->Paginator->numbers(); ?>  > >
								<?php echo $paginator->next(__('Next Page', true).' >>', array(), null, array('class'=>'disabled'));?>
								<?php echo $paginator->last(' Last'); ?>
								</div>
							</td>
						</tr>	
						<tr class="tableHeading"> 
						    <th>Company Name</th>
						    <th>Employ Name</th>
							<th>Job title</th>
						    <th>Payment</th>
						    <th>Date</th>
						    <th>Transection Id</th>
						    <th>Action</th>
					    </tr>
        			        <?php 
        		        		if($paymentHistories){
									$sno = 0;
        		        			foreach($paymentHistories as $paymentHistory):
        			            		$class = $sno++%2?"odd":"even";
        			        ?>
						<tr class="<?php echo $class; ?>"> 
							<td align="center" width="15%">
								<?php echo $paymentHistory['Company']['company_name'];?>
							</td> 
							<td align="center" width="15%">
								<?php echo $paymentHistory['Jobseeker']['contact_name'];?>
							</td>
							<td align="center" width="20%">
								<?php echo $paymentHistory['Job']['title'];?>
							</td> 
							<td align="center" width="10%">
								<?php echo $paymentHistory['PaymentHistory']['amount'];?>
							</td>
							<td align="center" width="15%">
								<?php echo date('Y/M/d',strtotime($paymentHistory['PaymentHistory']['paid_date']))."&nbsp;";?>
							</td>
							<td align="center" width="15%">
								<?php echo $paymentHistory['PaymentHistory']['transaction_id'];?>
							</td>
							<td align="center" width="10%">
								<?php echo $html->link("View Details", array('action' => 'admin','action'=>'paymentDetails', $paymentHistory['PaymentHistory']['id']));?>
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
									echo $this->Paginator->numbers(); 
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
