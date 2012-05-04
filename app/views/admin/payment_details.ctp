<?php
	/**
	 * Payment Details
	 */
?>
<style>
.heading
{
	font-weight: bold;
	margin:10px;
}
.info_block
{
	width:450px;
	margin-left:50px;
	font-size:80%;
}
.sub_heading
{
	font-weight:bold;
	float:left;
	width:180px;
	margin:1px;
}
.reward
{
	display:block;
	text-align:right;
	width:110px;
}
</style>
<?php echo $this->Session->flash();?>
<?php $hrRewardPercent=(isset($payment_detail['PaymentHistory']['amount'])&&!empty($payment_detail['PaymentHistory']['hr_reward_percent']))?$payment_detail['PaymentHistory']['hr_reward_percent']:$hrRewardPercent;
?>
<div id="page-heading"><h1>Payment Details</h1></div>
<div style="clear:both;display:block;"></din>
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
				<div style="float:left;width:50%;">
				<div style="width:450px;float:left;font-size:2em;margin:10px;">
					<div class='heading'><u>Reward Details</u></div>
					<div class='info_block'>
						<div class='sub_heading'>
							Total Reward :
						</div>
						<div style="float:left;">
							<span class='reward'>
								<?php echo $this->Number->format(
										$payment_detail['PaymentHistory']['amount'],
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?>
							</span>
						</div>
						<div style="clear:both"></div>
						<div class='sub_heading'>
							Hire Routes :
						</div>
						<div style="float:left;">
							<span class='reward'>
								<?php echo $this->Number->format(
										($payment_detail['PaymentHistory']['amount']*$hrRewardPercent)/100,
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?>
							</span>
						</div>
						<div style="clear:both"></div>
						<div class='sub_heading'>
							Post Reward :
						</div>
						<div style="float:left;">
							<span class='reward'>
								<?php echo $this->Number->format(
										($payment_detail['PaymentHistory']['amount']*(100-$hrRewardPercent))/100,
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?>
							</span>
						</div>
						<div style="clear:both"></div>
						<div class='sub_heading'>
							Payment Status :
						</div>
						<div style="float:left;">
							<?php echo ($payment_detail['PaymentHistory']['payment_status'])?"Done":"Pending";?>
						</div>
						<div style="clear:both"></div>
						<div class='sub_heading'>
							<?php echo $this->Form->create('PaymentHistory',array('url'=>array('controller'=>'admin','action'=>'updatePaymentStatus')));?>
							<?php echo $this->Form->input('id',array('type'=>'hidden','value'=>$payment_detail['PaymentHistory']['id']));?>
							<?php echo $this->Form->input('hrRewardPercent',array('type'=>'hidden','value'=>$hrRewardPercent));?>
						</div>
						<div style="float:left;">
							<?php if(!$payment_detail['PaymentHistory']['payment_status'])echo $this->Form->submit('Update status');?>
							<?php echo $this->Form->end();?>
						</div>
						<div style="clear:both"></div>
					</div>
					<hr>
				</div>
				<div style="clear:both"></div>
				<div style="width:450px;float:left;font-size:2em;margin:10px;">
					<div class='heading'><u>Company Details</u></div>
					<div class='info_block'>
						<div class='sub_heading'>
							Name :
						</div>
						<div style="float:left;">
							<?php echo $payment_detail['Company']['company_name'];?>
						</div>
						<div style="clear:both"></div>
						<div class='sub_heading'>
							Phone :
						</div>
						<div style="float:left;">
							<?php echo $payment_detail['Company']['contact_phone'];?>
						</div>
						<div style="clear:both"></div>
						<div class='sub_heading'>
							Web address :
						</div>
						<div style="float:left;">
							<a href="<?php echo $payment_detail['Company']['company_url'];?>"><?php echo $payment_detail['Company']['company_url'];?></a>
						</div>
						<div style="clear:both"></div>
					</div>
					<hr>
				</div>
				<div style="clear:both"></div>
				<div style="width:450px;float:left;font-size:2em;margin:10px;">
					<div class='heading'><u>Employee Details</u></div>
					<div class='info_block'>
						<div class='sub_heading'>
							Name :
						</div>
						<div style="float:left;">
							<?php echo $payment_detail['Jobseeker']['contact_name'];?>
						</div>
						<div style="clear:both"></div>
						<div class='sub_heading'>
							Phone :
						</div>
						<div style="float:left;">
							<?php echo $payment_detail['Jobseeker']['contact_phone'];?></br>
						</div>
						<div style="clear:both"></div>
						<div class='sub_heading'>
							Email :
						</div>
						<div style="float:left;">
							<?php echo $payment_detail['User']['account_email'];?>
						</div>
						<div style="clear:both"></div>
						<div class='sub_heading'>
						<?php
							$networker_count=count($networkers);
							if(!$networker_count>0)
							{
						?>
								Reward :
						</div>
						<div style="float:left;">
							<span class='reward'>
								<?php
									echo $this->Number->format(
										($payment_detail['PaymentHistory']['amount']*(100-$hrRewardPercent))/100,
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);
								?>
							</span>
						<?php
							}
						?>
						</div>
					</div>
				</div>
				</div>
				<div style="float:left;width:50%;">
				<div style="width:480px;float:left;margin-top:10px;padding:10px;">
	<h3><font size=5px><center><u>Networkers Reward Details</u></center></font></h3>
				</div>
				<div class="table_seperator"></div>
				<table class="content-table" border="0" cellpadding="0" cellspacing="0" width="480px;">
					<tr>
						<td COLSPAN="3">
							<div class="code_pagination">
								<?php $this->Paginator->options(array('url' =>$payment_detail['PaymentHistory']['id']));?>
								<?php if($this->Paginator->numbers()){ echo $paginator->first('First '); ?>	
								<?php echo $paginator->prev('<< '.__('Previous Page', true), array(), null, array('class'=>'disabled'));?>
								< <  <?php echo $this->Paginator->numbers(); ?>  > >
								<?php echo $paginator->next(__('Next Page', true).' >>', array(), null, array('class'=>'disabled'));?>
								<?php echo $paginator->last(' Last');} ?>
							</div>
						</td>
					</tr>
					<tr class="tableHeading">
						<th>Networker</th>
						<th>Email</th>
						<th>Reward</th>
					</tr>
					<?php
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
							<span class='reward'>
								<?php echo $this->Number->format(
										($payment_detail['PaymentHistory']['amount']*(100-$hrRewardPercent))/(($networker_count)*100),
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?>
							</span>
						</td>
					</tr>
						<?php 
								endforeach;
							}else
							{
						?>
						<tr class="odd">			
						    <td colspan="3" align="center" style="line-height: 25px;">Sorry no result found.</td>
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
