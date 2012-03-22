<?php echo "<b>Hire Routes</b>";?>
<div style='text-align:center'>

	<div style='border:1px solid #000000;overflow:auto;' >
		<?php if(isset($message)&&!is_null($message))echo $message; ?>
	</div>

	<p>
		TAKE THE HIREROUTES SIMPLY BY SHARING THIS JOB POST WITH YOUR TRUSTED NETWORK AND EARN UPTO THE ENTIRE REWARD OF <b>$<?php echo $job_details['Job']['reward']?></b><br/><b>-OR-</b><br/>APPLY FOR THE JOB YOURSELF!
	</p>

	<div class='clear:both'></div>

	<div style='background-color:green;border:1px solid green;width:410px;height:150px;'>
		<div style='float:left;width:250px;border:1px solid;margine:0px;background-color:green;'>
			<strong>JOB DISCRIPTION</strong>
		</div>
		<div style='float:right;width:150px;border:1px solid;margine:0px;background-color:green;'>
			<strong>REWARD</strong>
		</div>
		<div style='float:left;width:250px;text-align:left;background-color:green;'>
			<?php echo"<a href='hireroutes/jobs/jobDetail/".$job_details['Job']['id']."'  style='decoration:none;'>";?>
				<font size='4px' color='black'><b>
				<?php echo $job_details['Job']['title'];?><br/>
				<?php echo $job_details['Job']['company_name'];?>,&nbsp;
				<?php echo $job_details['Job']['city'];?>,&nbsp;
				<?php echo $job_details['Job']['state'];?>
				</b></font>
			</a><br/>
		</div>
		<div style='float:right;width:150px;text-align:left;background-color:green;'>
			<font size='16px'>
				<b>$<?php echo $job_details['Job']['reward'];?></b>
			</font>
		</div>
	</div>
	<div class='clear:both'></div>
	<div>
		<a href='httpRootUrl/how_it_works'><font size='3px'><b>CLICK HERE TO SEE<br/> HOW!</b></font></a>
	</div>
	<div>
		<p>
			Here are <b>5 <font size='4px'>AWESOME</font></b> Things that can happen by taking the HIRE ROUTES!
		</p>
		<p>
			1. Help a Friend Find a Job!<br/>
			2. Find a Job for Yourself<br/>
			3. Charity!<br/>
			4. Help Hire Routes to grow so we can help more people!<br/>
			5. Make upto <b><?php echo $job_details['Job']['reward'];?></b> if you are a connector that helps the candidate get hired for the job posted above!
		</p>
	</div>
	<div>
		<a href='hireroutes/how_it_works'><font size="5px"><b>SEE HOW IT WORKS<br/> HOW!</b></font></a>
	</div>
	<p>
		NEED HELP? HAVE FEEDBACK? PLEASE FILL FREE TO <a href="hireroutes/contact_us"><b>CONTACT US!</b></a>
	</p>
</div>
<p>
	Thank you again, Hire Routes
</p>

