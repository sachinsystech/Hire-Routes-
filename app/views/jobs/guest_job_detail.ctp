<?php $job_array = array('1'=>'Full Time',
                                 '2'=>'Part Time',
								 '3'=>'Contract',
								 '4'=>'Internship',
								 '5'=>'Temporary'); 
?>
<div class="job_top-heading_guest">
   	<div class="job_top_one">
   		<div class="job_top_heading1">Share this post with your network
       		<div class="job_top_share_job">
            	<div class="button-blue1">
					<input type="button" value="SHARE JOB" onclick='window.location.href="/jobs/shareJob/jobId=<?php echo $job['Job']['id'];?>";'>
					<div class="clr"></div>
				</div>
            </div>
        	<a href="/networkerInformation">How it works</a>
        </div>
	</div>
	<div class="job_top_two">OR</div>
    	<div class="job_top_one">
			<div class="job_top_heading1">Apply for the job yourself
				<div class="job_top_apply">
					<div class="login-button job-apply-button">
						<input type="button" value="APPLY FOR JOB" onclick='window.location.href="/jobs/applyJob/<?php echo $job['Job']['id'];?>"'>
						<div class="clr"></div>
					</div>
                    <div class="clr"></div>
				</div>
			<div class="job_apply_color"><a href="/jobseekerInformation">How it works</a></div>
		</div>
		<div class="clr"></div>
	</div>
    <div class="clr"></div>
</div>
<div class="job_container1">
	<div class="job_container_top_row job_guest_container">
		<div class="job_left_bar job_detail_guest_left">
			<h2>5 REASONS TO USE HIRE ROUTES</h2>
            <ul>
            	<li>Help a Friend Find a Job</li>
                <li>Find a Job for Yourself</li>
                <li>Charity (2% of Revenue goes to charitable organizations.)</li>
                <li>Help Hire Routes grow so we can help more people!</li>
                <li>Help a Friend Find a Job</li>
            </ul>
		</div>
		<div class="job_right_bar job_detail_guest_right job_right_bar_position">
			<div class="job_right_rightmost">
				<div class="job-right-reward-text job_reward_text">Reward: 
            		<span> <?php echo $this->Number->format(
										$job['Job']['reward'],
										array(
											'places' => 0,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?> </span>
				</div>
                <a href="#" id="howPayoutWorks">How payouts work</a>
			</div>
            <div class="job-right-text">
				<div class="job_backtosearch"><a href="/jobs" >BACK TO SEARCH</a></div>
                <div class="job-right-text-heading"><a href="#"><?php echo strtoupper($job['Job']['title']); ?></a>
                </div>
                <p><span>Company:</span> <?php echo ucwords($job['comp']['company_name']);?></p>
                <p><span>Website:</span> <?php	echo $this->Html->link($job['comp']['company_url'], 'http://'.$job['comp']['company_url']); ?></p>
                <p><span>Published:</span> <?php echo $job['ind']['industry_name']." - ".$job['spec']['specification_name']." Aid on ".date('d/m/Y', strtotime($job['Job']['created']) ); ?>
                <p><span>Salary:</span> 
                 <?php echo $this->Number->format(
										$job['Job']['salary_from'],
										array(
											'places' => 0,
											'before' => '$',
											//'decimals' => '.',
											'thousands' => ',')
										)." - ".$this->Number->format(
										$job['Job']['salary_to'],
										array(
											'places' => 0,
											'before' => '$',
											//'decimals' => '.',
											'thousands' => ',')
				)." / Year";?>
                    <!--- 35,000 - $45,000 / Year-->
                </p>
                <p><span>Location:</span> <?php
												if(!empty($job['city']['city']))
												echo $job['city']['city'].",&nbsp;";
											?>
											<?php echo $job['state']['state']; ?>
				</p>
                <p><span>Type:</span> <?php echo $job_array[$job['Job']['job_type']]; ?></p>
                <br />
                <p><span>Job Description:</span></p>
                <p>											
		            <div class="description" id="short_description">
						<?php $desc = $job['Job']['description'];
									if($desc!=''){
		                            	$explode = explode(' ',$desc);
										$string  = '';
										$dots = '...';
										if(count($explode) <= 130){
											$dots = '';
										}
										$count  = count($explode)>= 130 ? 130 :count($explode) ;
										for($i=0;$i<$count;$i++){
											$string .= $explode[$i]." ";
										}
										if($dots){
											$string = substr($string, 0, strlen($string));
										}
										echo $string.$dots;
									}?>
					</div>
					<div class="description" id="full_description" style="display:none;">
						<?php echo $job['Job']['description'];?>
					</div>
					<?php if(str_word_count($desc)>130){?>
						<div id="more_info">
							<a onclick="showDescription();">More Info</a>
						</div>
					<?php }?>
				</p>
			</div>
		</div>
		<div class="clr"></div>
	</div>
	<div class="job_pagination_bottm_bar"></div>
	<div class="clr"></div>
</div>
<div >
	<?php echo $this->element('share_job');?>
</div>
<script type="text/javascript"> 
	
    function showDescription(){
		$('#full_description').show();
		$('#short_description').hide();
		$('#more_info').hide();
	}
</script>
<!--------------Dialog box for how payout works ----------->
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
<script type="text/javascript">
$(document).ready(function(){
	$("a#close").click(function(){
		$("#about-dialog" ).dialog( "close" );
		return false;
	});
	$("#howPayoutWorks" ).click(function(){
		$( "#about-dialog").show();
		$( "#about-dialog").dialog({
			hide: "explode",
			width:700,
			height:590,
			closeOnEscape: false,
			modal:true,
		});
		$( "#about-dialog" ).parent("div").css({"padding":"0","margin":"50px 0px 0px 0px","opacity":"0.9","height":"600px","top":"0","background":"none","border":"none"});
	});
	
});
</script>
<div style="display:none;" id = "about-dialog">
	<div class="job-share-content">
    	<div class="about_popup_cancel_bttn_row1">
           	<div class="payment_popup_cancel_bttn"><a href="#" id ="close"></a></div>
   		</div>
     <div class="payout-content">
        <div class="payout-left">
        	<h2>PAYOUT SYSTEM</h2>
            <p>How it Works</p>
        	<h3> <span>50%</span> - Networker(s)</h3>
            <h3><span>25%</span> - Hire Routes</h3>
            <h3><span>15%</span> - Hiree</h3>
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
        <div class="payout-condition">*Various Charitable Organizations</div>
    </div>
</div>
