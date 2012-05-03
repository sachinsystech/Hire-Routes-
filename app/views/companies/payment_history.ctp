<?php ?>
<script>

function paymentHistoryInfo(user_id,transaction_id){
		//alert("ddd");
		$.ajax({
		url:"/companies/paymentHistoryInfo",
		type:"post",
	    dataType:"json",
	 	async:false,
		data: {id:user_id,tid:transaction_id},
		success:function(response){
			
			$("#paymentHistoryInfo").dialog({
				height:400,
				width:477,
				modal:true,
				resizable: false ,
				draggable: false,
				show: { 
						effect: 'drop', 
						direction: "up" 
				},
				buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
				}
			}
			});
			if(response['error']===1){
				$( "#paymentHistoryInfo" ).dialog({ height: 200 });
				$("#paymentHistoryInfo").html(response['message']);
				return ;
			}
			$("#paymentHistoryInfo").html(
			'<div>'+
				'<div style="font-weight: bold;margin:10px;"><u>PAYMENT INFO</u> ::</div>'+
				'<table class="phi_table">'+
					'<tr >'+
						'<td style="width: 32%;"><b>Transaction id : </b></td><td>'+response['transaction_id']+'</td>'+
					'</tr>'+
					'<tr>'+
						'<td><b>Paid Date : </b></td><td>'+response['paid_date']+'</td>'+
					'</tr>'+
					'<tr>'+
						'<td><b>amount : </b></td><td>'+response['amount']+'</td>'+
					'</tr>'+
				'</table>'+
				'<div style="clear:both;font-weight: bold;margin:10px;"><u>JOB INFO</u> ::</div>'+
				'<table class="phi_table">'+
					'<tr>'+
						'<td style="width: 32%;"><b>Jobseeker : </b></td><td>'+response['contact_name']+'</td>'+
					'</tr>'+
					'<tr>'+
						'<td style="width: 32%;"><b>Job Title : </b></td><td>'+response['job_title']+'</td>'+
					'</tr>'+
					'<tr>'+
						'<td><b>Description : </b></td><td>'+response['description']+'</td>'+
					'</tr>'+
					'<tr>'+
						'<td><b>Industry : </b></td><td>'+response['industry']+'</td>'+
					'</tr>'+
					'<tr>'+
						'<td><b>location : </b></td><td>'+response['location']+'</td>'+
					'</tr>'+
				'</table>'+		
			'</div>');
		}
	}); 
}


</script>

<div id="paymentHistoryInfo" style="display:none;">

</div>

<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<?php echo $this->element('side_menu');?>
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
				<div class="job_data">
					<table style="width:100%">
						<tr >
							<td colspan="100%">
								<div style="float:right;width:50%;text-align: right;">
								<?php echo $paginator->first(' << ', null, null, array("class"=>"disableText"));?>
								<?php echo $this->Paginator->prev(' < ', null, null, array("class"=>"disableText")); ?>
								<?php echo $this->Paginator->numbers(array('modulus'=>4)); ?>
								<?php echo $this->Paginator->next(' > ', null, null, array("class"=>"disableText")); ?>		
								<?php echo $paginator->last(' >> ', null, null, array("class"=>"disableText"));?>
						</div>
					</td>
					</tr>
						<tr>
							<td style="text-align:center;"><strong>#</strong></td>
							<td style="text-align:center;"><strong>Transaction-Id</strong></td>
							<td style="text-align:center;"><strong>Date</strong></td>
							<td style="text-align:center;width: 25%;"><strong>Payment Amount</strong></td>
						</tr>
						<?php $sn=1;?>
						<?php if(empty($PaymentHistory)){ ?>
						<tr>
							<td colspan="100%">Sorry, No Payment History found.</td>
						</tr>
						<?php } ?>
						<?php foreach($PaymentHistory as $PH):?>	
						<tr>
							<td style="text-align:center;"><?php echo $sn++; ?></td>
							<td style="text-align:center;"> 
							<a href="#" 
onclick="return paymentHistoryInfo(<?php echo $PH['PaymentHistory']['id'] ;?>,
'<?php echo $PH['PaymentHistory']['transaction_id'];?>');"> <?php echo $PH['PaymentHistory']['transaction_id'] ?> </a> </td>
							<td style="text-align:center;"><?php echo $this->Time->format('m/d/Y',$PH['PaymentHistory']['paid_date']); ?></td>
							<td><span style="float: right; margin-right: 30px;"><?php echo $this->Number->format(
										$PH['PaymentHistory']['amount'],
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?></span></td>
						</tr>
						<?php endforeach; ?>
					</table>
				</div>
			</div>	
		<div class="postNewJob" onclick="goTo();">POST NEW JOB</div>
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->

</div>

<script>
function goTo(){
	window.location.href="/companies/postJob";			
}
</script>
