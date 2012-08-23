<?php ?>
<style>
.ui-dialog-titlebar { display:none; }
.ui-dialog .ui-widget .ui-widget-content .ui-corner-all .ui-draggable .ui-resizable{
display: block;
    height: auto;
    left: 350px;
    outline: 0 none;
    position: absolute;
    visibility: visible;
    width: 510px;
    z-index: 1004;
}
.ui-widget-overlay{
    background: none repeat scroll 0 0 #000000;
    opacity: 0.6;
}
#paymentHistoryInfo {
    background: url("../images/about_popup_bg.png") repeat scroll 0 0 transparent;
    height: 328;
    overflow: hidden;
}
.pi_popup_cancel_bttn {
    background: url("../images/popup_cancel_bttn.png") no-repeat scroll 0 0 transparent;
    height: 72px;
    position: absolute;
    right: 31px;
    top: -14px;
    width: 72px;
}
</style>

<script>

function paymentHistoryInfo(user_id,transaction_id){
		
		$.ajax({
		url:"/companies/paymentHistoryInfo",
		type:"post",
	    dataType:"json",
	 	async:false,
		data: {id:user_id,tid:transaction_id},
		success:function(response){
			
			$("#paymentHistoryInfo").dialog({
				height:335,
				width:477,
				top:20,
				modal:true,
				resizable: false ,
				draggable: false,
				show: { 
						effect: 'drop', 
						direction: "up" 
				},
				
			});
			
			if(response['error']===1){
				$( "#paymentHistoryInfo" ).dialog({ height: 200 });
				$("#paymentHistoryInfo").html(response['message']);
				return ;
			}
			$("#paymentHistoryInfo").html(
			'<div class="about_popup_cancel_bttn_row">'+
				'<div class="pi_popup_cancel_bttn">'+
					'<a id="close" href="#"></a>'+
				'</div>'+
			'</div>	'+
			'<div>'+
				'<div class="job-right-top-left job-profile" style="margin-top: 15px;">'+
					'<h2>PAYMENT INFO</h2>'+
					'<p><span>Transaction id : </span>'+response['transaction_id']+
					'<p><span>Paid Date : </span>'+response['paid_date']+
					'<p><span>Amount : </span>'+response['amount']+
				'</div>'+	

				'<div class="job-right-top-left job-profile" style="margin-top: 15px;">'+
					'<h2>JOB INFO</h2>'+
					'<p><span>Jobseeker : </span>'+response['contact_name']+
					'<p><span>Job Title : </span>'+response['job_title']+
					'<p><span>Description : </span>'+response['description']+
					'<p><span>Industry : </span>'+response['industry']+
					'<p><span>Location : </span>'+response['location']+
				'</div>'+
			'</div>');
			$("#paymentHistoryInfo" ).parent("div").css({"padding":"0","margin":"50px 0px 0px 0px","opacity":"0.9","top":"0"});
			
		}
	});

}
</script>


<div id="paymentHistoryInfo" style="display:none;">
	
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#paymentHistoryInfo").click(function(){
		$("#paymentHistoryInfo" ).dialog("close");
	});	
});
</script>
<!--	Payment History  -->
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
                    	<h2>PAYMENT HISTORY</h2>
                    	<div class="job-list-head">
                        <ul class="job-list-heading job-list-head-margin">
                        	<li class="job-list-name">TRANSACTION-ID</li>
                            <li class="job-list-status">DATE</li>
                            <li class="job-list-origin">AMOUNT</li>
                    	</ul>
                        </div>
                        <?php $i=0;?>
                        <?php foreach($PaymentHistory AS $PH):?>	
						<div class="job-list-subhead">
		                    <ul class="job-list-subcontent" >
			                   	<li class="<?php if($i%2==0) echo'dark';?>">
									<a href="#" 
onclick="return paymentHistoryInfo(<?php echo $PH['PaymentHistory']['id'] ;?>,
'<?php echo $PH['PaymentHistory']['transaction_id'];?>');"> <?php echo $PH['PaymentHistory']['transaction_id'] ?> </a> 
								</li>
								<li class="center-align <?php if($i%2==0) echo'dark';?>">
									<?php echo $this->Time->format('m/d/Y',$PH['PaymentHistory']['paid_date']); ?>
								</li>
								<li class="margin-last-child-job <?php if($i%2==0) echo'dark';?>">
									<?php echo $this->Number->format(
										$PH['PaymentHistory']['amount'],
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?>
								</li>
								
		                	</ul>
                    	</div>
                    	<?php $i++;?>
						<?php endforeach;?>
						<?php	if($PaymentHistory == null){?>
						<div class="job-list-subhead">
				            <div class="inviation-message">
				            	No History Found.
				            </div>
                    	</div>
						<?php	} ?>
                    </div>
                    <div class="clr"></div>
                </div>
            </div>
        <div class="clr"></div>
    </div>
    <div class="job_pagination_bottm_bar"></div>
 	<div class="clr"></div>
</div>
</div>