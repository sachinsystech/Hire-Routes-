<?php
	/**
	 * Job Specific Data
	 */
?>
<div id="page-heading"><h1>Specific Job Data</h1></div>
<div class='dataBorder' style='font-size:14px;'>
	<div class='jobDetail'>
		<div class='jobTitle'>
			<?php echo ucfirst($jobData['Job']['title']); ?>
		</div>
		<div>
			<div class='jobRowHeading'>
				Posted by
			</div>
			<div class='jobRowData'>
				<?php echo ucfirst($jobData['Company']['company_name']);?>
			</div>
		</div>
		<div>
			<div class='jobRowHeading'>
				Posted In
			</div>
			<div class='jobRowData'>
				<?php echo $jobData['Specification']['name'].", ";?>
				<?php echo $jobData['Industry']['name']; ?>
			</div>
		</div>
		<div>
			<div class='jobRowHeading'>
				Location
			</div>
			<div class='jobRowData'>
				<?php echo $jobData['City']['city'].", ";?>
				<?php echo $jobData['State']['state']; ?>
			</div>
		</div>
		<div>
			<div class='jobRowHeading'>
				Posted On
			</div>
			<div class='jobRowData'>
				<?php echo date('m/d/Y',strtotime($jobData['Job']['created']));?>
			</div>
		</div>
		<div>
			<div class='jobRowHeading'>
				Status
			</div>
			<div class='jobRowData'>
				<?php $status = array('0'=>'Archive', '1'=>'Active', '2'=>'Deleted',  '3'=>'Inactive');?>
				<?php echo $status[$jobData['Job']['is_active']];?>
			</div>
		</div>
		<div>
			<div class='jobRowHeading'>
				Type
			</div>
			<div class='jobRowData'>
				<?php $job_array = array(
								'1'=>'Full Time',
                                '2'=>'Part Time',
								'3'=>'Contract',
								'4'=>'Internship',
								'5'=>'Temporary'
							); 
				?>
				<?php echo $job_array[$jobData['Job']['job_type']];?>
			</div>
		</div>
		<div>
			<div class='jobRowHeading'>
				Reward
			</div>
			<div class='jobRowData'>
				<?php echo $this->Number->format(
										$jobData['Job']['reward'],
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?>
			</div>
		</div>
		<div style='clear:both;height:auto;overflow:auto;'>
			<div class='jobRowHeading'>
				Annual salary($)
			</div>
			<div class='jobRowData'>
				<?php echo number_format($jobData['Job']['salary_from']/(1000),1)." <b> K</b> - ".number_format($jobData['Job']['salary_to']/(1000),1)." <b>K</b>";?>
			</div>
		</div>
		<div style='clear:both;height:auto;overflow:auto;'>
			<div class='jobRowHeading'>
				Description
			</div>
			<div class='jobRowData'>
				<?php echo $jobData['Job']['short_description']; ?>
			</div>
		</div>
	</div>
	<div class='jobViewData'>
		<div style='width:250px;margin:auto;'>
			<div style='width:125px;float:left;'>
				<div class='jobViewHeading'>
					<h3>NETWORKER</h3>
				</div>
				<div class='JVSpecificaion'>
					Viewed &nbsp;: 
				</div>
				<div class='JVData'>
					<?php echo $jobData['0']['networkerViews']; ?>
				</div>
				<div class='JVSpecificaion'>
					Shared &nbsp;: 
				</div>
				<div class='JVData'>
					<?php echo $jobData['0']['sharedJobs']; ?>
				</div>
			</div>
			<div style='width:125px;float:left;'>
				<div class='jobViewHeading'>
					<h3>JOBSEEKER</h3>
				</div>
				<div class='JVSpecificaion'>
					Viewed &nbsp;: 
				</div>
				<div class='JVData'>
					<?php echo $jobData['0']['jobseekerViews']; ?>
				</div>
				<div class='JVSpecificaion'>
					Applied : 
				</div>
				<div class='JVData'>
					<?php echo $jobData['0']['appliedJobs']; ?>
				</div>
			</div>
		</div>
	</div>
</div>
