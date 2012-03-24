
<b>Congratulations !!</b>
<p>
Welcome <?php echo $emailMsgInfo['jobseker']['name'];?>,
<p></p>

<div style="clear: both; margin-left: 15px;>
  <div style="clear: both;">							
	  <div style="clear: both;font-weight: bold;">Company: <?php echo $emailMsgInfo['company']['name'];?></div>
	  <div><?php echo $emailMsgInfo['company']['url'];?></div>
	  <div><?php  echo $emailMsgInfo['job']['reward'];?></div>
  </div>
  <div style="clear: both;"><hr></div>
  <div style="clear: both;">							
	  <div style="font-weight: bold; width: 130px;"><?php echo $emailMsgInfo['job']['title'];?></div>
	  <div><?php  echo $emailMsgInfo['job']['industry'].", ". $emailMsgInfo['job']['specification'];?></div>
	  <div><?php  echo $emailMsgInfo['job']['state'].", ".$emailMsgInfo['job']['city'];?></div>
	  <div>Salary Range :: <?php  echo $emailMsgInfo['job']['salary_range'];?></div>
	  <div><?php  echo $emailMsgInfo['job']['type'];?></div>
	  <div>You applied on :: [<?php  echo $emailMsgInfo['job']['applied_on'];?>]</div>
	  <div><?php  echo $emailMsgInfo['job']['description'];?></div>
  </div>
</div>

<p><p>--<br>
Thank you again,<br>
Hire Routes

