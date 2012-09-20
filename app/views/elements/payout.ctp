<script type="text/javascript">
$(document).ready(function(){
	$("a#close").click(function(){
		$("#about-dialog" ).dialog( "close" );
		return false;
	});
	function getPosition(who){
		var T= 0,L= 0;
		while(who){
		    L+= who.offsetLeft;
		    T+= who.offsetTop;
		    who= who.offsetParent;
		}
		return [L,T];    
	}
	$(".howPayoutWorks" ).click(function(){
		$.ajax({
			type: 'POST',
			url: '/users/isLoggedIn',
			data: "&invitaionUrl="+window.location.href,
			dataType: 'json',
			success: function(response){
				if(response['status'] == 1){
					$( "#about-dialog").show();
					$( "#about-dialog").dialog({
						hide: "explode",
						width:800,
						height:610,
						closeOnEscape: false,
						modal:true,
					});
					
		
					$( "#about-dialog" ).parent("div").css({"padding":"0","margin":"50px 0px 0px 0px","opacity":"0.9","height":"600px","background":"none","border":"none"});
					//var xpositions =getPosition(this) ;
					//alert(xpositions[0]);
					//$( "#about-dialog" ).parent("div").css({"top":});
				}
				if(response['status'] == 0){
					window.location.href= "/users/login" ;
				}
				return;				
			}
		});
		
	});
	
});
</script>

	<div class="payout-main-content">
    	<div class="about_popup_cancel_bttn_row1">
           	<div class="payment_popup_cancel_bttn"><a href="#" id ="close"></a></div>
   		</div>
     <div class="payout-content">
        <div class="payout-left">
        	<h2>PAYOUT SYSTEM</h2>
            <p>How it Works</p>
        	<h3> <span>50%</span> - Networker(s)</h3>
            <h3><span>25%</span> - Hire Routes</h3>
            <h3><span>15%</span> - Job Seeker</h3>
            <h3><span>5%</span> - Charity</h3>
            <h3><span>5%</span> - Bonus Pool</h3>
            
        </div>
        <div class="payout-right">
        	<div class="payout-right-ch">5%</div>
            <div class="payout-right-bo">5%</div>
            <div class="payout-right-co">$</div>
        	<div class="payout-right-net">50%</div>
            <div class="payout-right-1">25%</div>
            <div class="payout-right-jo">15%</div>
            <div class="clr"></div>
        </div>
        	<div class="clr"></div>
      </div>
        <div class="payout-condition">The 50% payout to the Networker(s) is only true if the Job Seeker gets hired for the specific job the Networker(s) shared with him or her.  If the Job Seeker signs up through a shared job but gets hired for a different job or signs up via an invite the last Networker - who shared the job or invited the Job Seeker - will receive 15% of the reward.  Remember you also get <a href="/networkerPointInfo">15 points!</a></div>
    </div>
    
    <style>
.ui-dialog-titlebar { display:none; }
.ui-dialog .ui-widget .ui-widget-content .ui-corner-all .ui-draggable .ui-resizable{
	display: block;
    height: 525px;
    left: 350px;
    outline: 0 none;
    position: absolute;
    top: 200px;
    visibility: visible;
    width: 700px;
    z-index: 1004;
}
.ui-widget-overlay{
    background: none repeat scroll 0 0 #000000;
    opacity: 0.6;
}
</style>
