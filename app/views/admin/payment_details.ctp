<?php echo $this->Session->flash();?>
<div id="page-heading"><h1>Payment Details</h1></div>
<?php //echo $this->element('sql_dump');?>
<?php //pr($payment_detail);?>
<div style="background: url(/img/admin/border_bit.jpg) top repeat-x;overflow:auto;padding:10px;">
<div style="border-right:solid 1px black;width:300px;height:150px;float:left;">
	<font size=5px><center><b><u>Company Details</u></b></center></font></br>
	<font size=3px><b>Name :</b>
	<?php echo $payment_detail['Company']['company_name'];?></br>
	<b>Phone :</b>
	<?php echo $payment_detail['Company']['contact_phone'];?></br>
	<b>Web address :</b>
	<a href="<?php echo $payment_detail['Company']['company_url'];?>"><?php echo $payment_detail['Company']['company_url'];?></a>
	</font>
</div>
<div style="border-left:solid 1px black;width:300px;height:150px;float:right;padding-left:10px;">
	<font size=5px><center><b><u>Employee Details</u></b></center></font></br>
	<font size=3px><b>Name :</b>
	<?php echo $payment_detail['Jobseeker']['contact_name'];?></br>
	<b>Phone :</b>
	<?php echo $payment_detail['Jobseeker']['contact_phone'];?></br>
	<b>Email :</b>
	<?php echo $payment_detail['User']['account_email'];?>
	</font>
</div>
<div style="text-align:center;">
	<font size=5px><b><u>Reward Details</u></b></font></br></br>
	<font size=4px><b>Total Reward :</b>
	<?php echo "$".$payment_detail['PaymentHistory']['amount'];?></br>
	<b>Hire Routes :</b>
	<?php echo "$".$payment_detail['PaymentHistory']['amount']*0.25;?></br>
	<b>Post Reward :</b>
	<?php echo "$".$payment_detail['PaymentHistory']['amount']*0.75;?>
	</font>
</div>
<div style="background: url(/img/admin/border_bit.jpg) top repeat-x;width:98%;float:left;margin-top:10px;padding:10px;">
	<h3><font size=5px><center><b><u>Networkers Reward Details</u></b></center></font></h3>
</div>
<div class="table_seperator"></div>
<table class="content-table" border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td COLSPAN="3">
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
			<th>Networker</th>
			<th>Email</th>
			<th>Reward</th>
		</tr>
	<?php
		$networker_count=count($networkers);
		if($networker_count>0)
		{
			$sno=0;
			foreach($networkers as $key=>$networker):
			$class = $sno++%2?"odd":"even";
	?>
			<tr class="<?php echo $class; ?>">
			<td>
				<?php echo $networker['Networkers']['contact_name'];?>
			</td>
			<td>
				<?php echo $networker['User']['account_email'];?>
			</td>
			<td>
				<?php echo "$".$payment_detail['PaymentHistory']['amount']*0.75/($networker_count);?></br>
			</td>
		</tr>
		<?php 
			endforeach;
		}else
		{
		?>
		<tr class="odd">			
		    <td colspan="3" align="center">Sorry no result found.</td>
		</tr>
		<?php
		}	
		?>
		<tr>
	    <td colspan="3" align="center">
	        <?php
		    	echo $this->Paginator->numbers(); 
		 	?>
	    </td>
	</tr>
	</table>
</div>
