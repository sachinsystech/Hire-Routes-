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
	font-size:27px;
}
.info_block
{
	width:450px;
	margin-left:10px;
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
	float:left;
	text-align:right;
	width:125px;
}
</style>
<?php echo $this->Session->flash();?>
<?php $networker_count=count($networkers);
?>
<div id="page-heading"><h1>Payment Details</h1></div>
<table class="content-table" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<th rowspan="4" class="sized"></th>
			<th class="topleft"></th>
			<td id="tbl-border-top">&nbsp;</td>
			<th class="topright"></th>
			<th rowspan="4" class="sized"></th>
		</tr>
		<tr>
			<td id="tbl-border-left"></td>
			<td>
				<div style="float:left;width:50%;">
					<div style="width:450px;float:left;font-size:20px;margin:10px;">
						<div class='heading'>
							<u>Reward Details</u>
						</div>
						<div class='info_block'>
							<div style="margin:5px 0 5px 0;clear:both">
								<div class='sub_heading' style="font-size:24px;margin:5px 5px 5px 0px;">
									Scenario <?php switch($payment_detail['PaymentHistory']['scenario']){
														case 1:
															echo "I";
															break;
														case 2:
															echo "II";
															break;
														case 3:
															echo "III";
															break;
													}
									?>:
								</div>
							</div>
							
							<div style="margin:5px 0 5px 0;clear:both">
								<div class='sub_heading' style="font-size:20px;">
									Networker(s) :
								</div>
								<div style="float:left;">
									<span class='reward'>
										<?php echo $this->Number->format(
											($payment_detail['PaymentHistory']['amount']*($payment_detail['PaymentHistory']['networker_reward_percent']))/100,
												array(
													'places' => 2,
													'before' => '$',
													'decimals' => '.',
													'thousands' => ',')
												);	
										?>
									</span>
								</div>
								<div>
									<?php
										 echo "(".$payment_detail['PaymentHistory']['networker_reward_percent']."%)";
									?>
								</div>
							</div>
							<div style="clear:both"></div>
							<div style="margin:5px 0 5px 0;clear:both">
								<div class='sub_heading' style="font-size:20px;">
									Jobseeker :
								</div>
								<div style="float:left;">
									<span class='reward'>
										<?php echo $this->Number->format(
												($payment_detail['PaymentHistory']['amount']*($payment_detail['PaymentHistory']['jobseeker_reward_percent']))/100,
													array(
														'places' => 2,
														'before' => '$',
														'decimals' => '.',
														'thousands' => ',')
													);
										?>
									</span>
								</div>
								<div>
									<?php
										 echo "(".$payment_detail['PaymentHistory']['jobseeker_reward_percent']."%)";
									?>
								</div>
							</div>	
							<div style="clear:both"></div>
							<div style="margin:5px 0 5px 0;clear:both">
								<div class='sub_heading' style="font-size:20px;">
									Hire Routes :
								</div>
								<div style="float:left;">
									<span class='reward'>
										<?php echo $this->Number->format(
												($payment_detail['PaymentHistory']['amount']*$payment_detail['PaymentHistory']['hr_reward_percent'])/100,
													array(
														'places' => 2,
														'before' => '$',
														'decimals' => '.',
														'thousands' => ',')
												);
										?>
									</span>
								</div>
								<div>
									<?php
										 echo "(".$payment_detail['PaymentHistory']['hr_reward_percent']."%)";
									?>
								</div>
							</div>
							<div style="clear:both"></div>
							<hr style="width:350px;margin:10px 0px 10px 0px;">
							<div class='sub_heading' style="font-size:20px;">
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
												);
									?>
								</span>
							</div>
							<div>
									<?php
										 echo "(100%)";
									?>
								</div>
						</div>
					</div>
				</div>
				<div style="float:left;width:50%;">
					<div style="width:550px;float:left;">
						<div style="clear:both"></div>
						<div style="width:450px;float:left;font-size:20px;margin:10px;">
							<div class='heading'><u>Company Details</u></div>
							<div class='info_block'>
								<div class='sub_heading'>
									Name :
								</div>
							<div style="float:left;">
								<?php echo $html->link(empty($payment_detail['Company']['company_name'])?'----':ucfirst($payment_detail['Company']['company_name']), array('controller' => 'admin','action'=>'employerSpecificData',$payment_detail['Company']['user_id'] ));?>
							</div>
							<div style="clear:both"></div>
							<div class='sub_heading'>
								Contact :
							</div>
							<div style="float:left;">
								<?php echo ucfirst($payment_detail['Company']['contact_name']);?>
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
								Email :
							</div>
							<div style="float:left;">
								<?php echo $payment_detail['CompanyUser']['account_email'];?>
							</div>
							<div style="clear:both"></div>
						</div>
					</div>
					<div style="clear:both"></div>
					<div style="width:450px;float:left;font-size:20px;margin:10px;">
						<div class='heading'><u>Jobseeker Details</u></div>
						<div class='info_block'>
							<div class='sub_heading'>
								Name :
							</div>
							<div style="float:left;">
								<?php echo $html->link(ucfirst($payment_detail['Jobseeker']['contact_name']), array('controller' => 'admin','action'=>'jobseekerSpecificData',$payment_detail['Jobseeker']['user_id'] ));?>
							</div>
							<div style="clear:both"></div>
							<div class='sub_heading'>
								Reward :
							</div>
							<div style="float:left;">
								<span>
									<?php
										echo $this->Number->format(
											($payment_detail['PaymentHistory']['amount']*($payment_detail['PaymentHistory']['jobseeker_reward_percent']))/100,
											array(
												'places' => 2,
												'before' => '$',
												'decimals' => '.',
												'thousands' => ',')
											);
									?>
								</span>
							</div>
							<div style="clear:both"></div>							
							<div class='sub_heading'>
								Check Status :
							</div>
							<div style="float:left;">
								<?php
									switch($payment_detail['RewardsStatus']['status']):
										case 0:
											echo "Unpaid";
								?>
											<a href='#' onclick="updatePaymentStatus(<?php echo $payment_detail['PaymentHistory']['id'].','.$payment_detail['Jobseeker']['user_id'];?>,this);">Pay</a>
								<?php			
											break;
										case 1:
											echo "Paid";
											break;
									endswitch;
								?></br>
							</div>
							<div style="clear:both"></div>
							<div class='sub_heading'>
								Email :
							</div>
							<div style="float:left;">
								<?php echo $payment_detail['JobseekerUser']['account_email'];?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</td>
		<td id="tbl-border-right"></td>
	</tr>
	<tr>
		<td id="tbl-border-left"></td>
		<td>
			<div class='heading'>
				<u>Networkers Reward Details</u>
			</div>
			<div style="width:800px;">
				<?php 
					if($networker_count>0):
				?>
				<div class="code_pagination">
					<?php $this->Paginator->options(array('url' =>$payment_detail['PaymentHistory']['id']));?>
					<?php if($this->Paginator->numbers()){ echo $paginator->first('First '); ?>	
					<?php echo $paginator->prev('<< '.__('Previous Page', true), array(), null, array('class'=>'disabled'));?>
					< <  <?php echo $this->Paginator->numbers(); ?>  > >
					<?php echo $paginator->next(__('Next Page', true).' >>', array(), null, array('class'=>'disabled'));?>
					<?php echo $paginator->last(' Last');} ?>
				</div>
				<div class="networkerDataHeading">
					<div class="networkerRewardDataHeading">Networker</div>
					<div class="networkerRewardDataHeadingEmail">Email</div>
					<div class="networkerRewardDataHeading">Reward</div>
					<div class="networkerRewardDataHeading">Check Status</div>
				</div>
				<?php
						$sno=0;
						foreach($networkers as $key=>$networker):
						$class = $sno++%2?"networkerDataBarOdd":"networkerDataBarEven";
				?>
				<div class="<?php echo $class;?>">
					<div class="networkerRewardData">
						<?php echo $html->link(empty($networker['Networkers']['contact_name'])?'----':ucfirst($networker['Networkers']['contact_name']), array('controller' => 'admin','action'=>'networkerSpecificData',$networker['Networkers']['user_id'] ));?>
					</div>
					<div class="networkerRewardDataEmail">
						<?php echo $html->link($networker['User']['account_email'], array('controller' => 'admin','action'=>'networkerSpecificData',$networker['Networkers']['user_id'] ));?>
					</div>
					<div class="networkerRewardData">
						<span class='reward'>
							<?php echo $this->Number->format(
									($payment_detail['PaymentHistory']['amount']*($payment_detail['PaymentHistory']['networker_reward_percent']))/(($networker_count)*100),
									array(
										'places' => 2,
										'before' => '$',
										'decimals' => '.',
										'thousands' => ',')
									);?>
						</span>
					</div>
					<div class="networkerRewardData" style="text-align:center">
						<?php
							switch($networker['RewardsStatus']['status']):
								case 0:
									echo "Unpaid";
								?>
								<a href='#' onclick="updatePaymentStatus(<?php echo $payment_detail['PaymentHistory']['id'].','.$networker['Networkers']['user_id'];?>, this);">Pay</a>
								<?php
									break;
								case 1:
									echo "Paid";
									break;
							endswitch;
						?>
					</div>
				</div>
						<?php 
							endforeach;
						?>
						<div class="networkerDataBar" style="clear:both">
							<div>
								<span style="float: right; margin-right: 290px;">
								<?php echo "<b>Total </b> ".$this->Number->format(
										($payment_detail['PaymentHistory']['amount']*($payment_detail['PaymentHistory']['networker_reward_percent']))/100,
													array(
														'places' => 2,
														'before' => '$',
														'decimals' => '.',
														'thousands' => ',')
													);	
											?>
								</span>
							</div>
						</div>
					<?php	
						else:
					?>
					<div class="networkerDataBarOdd" style='text-align:center;width:350px;'>			
				    	There is no networker for this Reword!
					</div>
					<?php
						endif;	
					?>
					<div>
	    				<?php
	    					echo $this->Paginator->numbers(); 
	 					?>
					</div>
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
<script>
function updatePaymentStatus(paymentHistoryId,userId,field)
{
	$.ajax({
		url: "/admin/updatePaymentStatus/",
	 	async:false,
	 	type:'POST',
	 	data:{'payment_history_id':paymentHistoryId,'user_id':userId },
  		success: function(response){ if(response==1) $(field).parent().html("Paid"); else alert('Something went wrong! Try again');	}
  	});
}
</script>
