<?php echo "<b>Hire Routes</b>";?>
<?php $base_link = Configure::read('httpRootURL');?>
<div style='text-align:center'>

	<div style='border:1px solid #000000;overflow:auto;padding:5px' >
		<?php if(isset($message['message'])&&!is_null($message['message']))echo $message['message']; ?>
	</div>

	<p>
		TAKE THE HIREROUTES SIMPLY BY SHARING THIS JOB POST WITH YOUR TRUSTED NETWORK AND EARN UPTO THE ENTIRE REWARD OF <b>$<?php echo number_format($message['Job']['reward'],2);?></b><br/><b>-OR-</b><br/>APPLY FOR THE JOB YOURSELF!
	</p>

	<div class='clear:both'></div>

	<div>
		<table width="90%" height="auto" style='background-color:#2AD62A;margin:auto;'>
			<tr>
				<th width="70%">JOB DISCRIPTION</th>
				<th>REWARD</th>
			</tr>
			<tr>
				<td align="left" width="70%">
					<?php 
						echo"<a href=".$message['jobUrl']." style='text-decoration:none;'>";
					?>
						<b>
							<?php echo $message['Job']['title'];?><br/>
							<?php if(!empty($message['Job']['company_name'])) echo $message['Job']['company_name'].",&nbsp;";?>
							<?php if(!empty($message['Job']['city'])) echo $message['Job']['city'].",&nbsp;" ;?>
							<?php echo $message['Job']['state'];?>
						</b>
					</a>
				</td>
				<td align="right">
					<font size='4px' color='black'>
						<span style="padding-right:15px;">
							<b>$<?php echo number_format($message['Job']['reward'],2);?></b>
						</span>
					</font>
				</td>
			<tr>
		</table>
	</div>
	<div class='clear:both'></div>
	<div>
		<a href= "<?php echo $base_link;?>howItWorks"><font size='3px'><b>CLICK HERE TO SEE<br/> HOW!</b></font></a>
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
			5. Make upto <b>$<?php echo number_format($message['Job']['reward'],2);?></b> if you are a connector that helps the candidate get hired for the job posted above!
		</p>
	</div>
	<div>
		<a href="<?php echo $base_link;?>howItWorks"><font size="5px"><b>SEE HOW IT WORKS<br/> HOW!</b></font></a>
	</div>
	<p>
		NEED HELP? HAVE FEEDBACK? PLEASE FILL FREE TO <a href="<?php echo $base_link;?>contactUs"><b>CONTACT US!</b></a>
	</p>
</div>
<p>
	Thank you again, Hire Routes
</p>

