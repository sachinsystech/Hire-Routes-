<?php ?>
<style>
.ui-dialog-titlebar { display:none; }
.ui-widget-overlay{
    background: none repeat scroll 0 0 #000000;
    opacity: 0.6;
}
#paymentHistoryInfo{
    margin: 50px;
    overflow:visible;
}
.pi_popup_cancel_bttn a {
    display: block;
    height: 50px;
    margin: 7px 0 0 8px;
    width: 50px;
}
.japdiv {
    background: url("/images/about_popup_bg.png") repeat scroll 0 0 transparent;
    height: 400px;
    overflow: visible;
}
.pi_popup_cancel_bttn {
    background: url("/images/popup_cancel_bttn.png") no-repeat scroll 0 0 transparent;
    height: 72px;
    position: absolute;
    right: 38px;
    top: -24px;
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
				modal:true,
				resizable: false ,
				draggable: false,
				
			});
			
			if(response['error']===1){
				$( "#paymentHistoryInfo" ).dialog({ height: 200 });
				$("#paymentHistoryInfo").html(response['message']);
				return ;
			}
			$(".japdiv").html(
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
			$( "#paymentHistoryInfo" ).parent("div").css({"padding":"0","opacity":"0.9","height":"500px","top":"100px","left":"222px","width":"574px", "background":"none","border":"none"});
		
		}
	});

}
</script>


<div id="paymentHistoryInfo" style="display:none;">
	<div class="japdiv"></div>
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
                	
					<div class="job-right-top-left">
                        <h2>PAYMENT HISTORY</h2>
						
                        <?php if($this->Paginator->numbers()):?>
						<div class="ph_pagination">
							<div class="job_next_bttn pagination_next"><?php echo $paginator->next('  '.__('', true), array(), null, array('class'=>'disabled'));?></div>
							<div class="job_preview_bttn pagination_pre"><?php echo $paginator->prev(__('', true).' ', array(), null, array('class'=>'disabled'));?>
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
						
                         <div class="ph-head">
                            <ul>
                                <li class="job-list-name app-trans">TRANSACTION-ID</li>
                                <li class="app-date">DATE</li>
                                <li class="app-amount">AMOUNT</li>
                            </ul>
                        </div>
                        
						<?php $i=0;?>
                        <?php foreach($PaymentHistory AS $PH):?>
						
						<div class="ph-subhead">
                                <ul>
                                    <li class="app-trans <?php if($i%2==0) echo'dark';?>">
                                    <a href="#" 
onclick="return paymentHistoryInfo(<?php echo $PH['PaymentHistory']['id'] ;?>,
'<?php echo $PH['PaymentHistory']['transaction_id'];?>');"> <?php echo $PH['PaymentHistory']['transaction_id'] ?> </a> 
                                    </li>
                                    <li class="<?php if($i%2==0) echo'dark';?>"> <?php echo $this->Time->format('m/d/Y',$PH['PaymentHistory']['paid_date']); ?> </li>
                                    <li class="margin-last-child-job <?php if($i%2==0) echo'dark';?>"> <?php echo $this->Number->format(
										$PH['PaymentHistory']['amount'],
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?> </li>
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
