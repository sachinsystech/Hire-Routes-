<?php $config_url = Configure::read('httpRootURL');?>
<b>Hire Routes</b>
<div>
	<div align='center'>
		<P>[EMPOWERING SOCIAL NETWORKS TO HELP PEOPLE FIND JOB]<br>
		   [CONNECTING EMPLOYERS TO JOBSEEKERS WITH HIRE ROUTES]</P>
		<P><h2>HERE ARE YOUR NEW JOB POSTS!</h2></P>
	</div>
	<div id='job_detail' align='center'>
		<table style="border:solid 1px #000;">
			<tr>
				<td><strong>JOB DESCRIPTION</strong></td>
				<td><strong>REWARD</strong></td>
			</tr>
			<?php foreach($job as $job):?>
			<tr>
				<td>
					<?php	echo $this->Html->link($job['Job']['title'], $config_url.'jobs/jobDetail/'.$job['Job']['id']); ?><br>
					<?php	echo $job['comp']['company_name'].", ".$job['city']['city'].", ".$job['state']['state']."<br>";?>
			    </td>
				<td><?php echo $job['Job']['reward'];?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
	<div align='center'>
		<P>If you want to change your frequency of emails from HR go to your<br>
			networker setting page and select what your want!</P>
		<P><h2>NEED HELP? HAVE FEEDBACK? PLEASE FEEL FREE TO <a href="<?php echo $config_url;?>contact_us">CONTACT US</a>!</h2></P>
	</div>
</div>

