<?php
	/**
	 * Job Specific Data
	 */
?>
<div id="page-heading"><h1>Specific Job Data</h1></div>
<div class='dataBorder' style='font-size:12px;'>
	<div class='specificJobDetail'>
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
				<?php echo (empty($jobData['Specification']['name']))?"":$jobData['Specification']['name'].", ";?>
				<?php echo $jobData['Industry']['name']; ?>
			</div>
		</div>
		<div>
			<div class='jobRowHeading'>
				Location
			</div>
			<div class='jobRowData'>
				<?php echo (empty($jobData['City']['city']))?"":$jobData['City']['city'].", ";?>
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
				<?php echo ucfirst($jobData['Job']['short_description']); ?>
			</div>
		</div>
		<?php if(isset($jobData['Job']['requirements'])){?>
		<div style='clear:both;height:auto;overflow:auto;'>
			<div class='jobRowHeading'>
				Requirements
			</div>
			<div class='jobRowData'>
				<?php echo $jobData['Job']['requirements'];?>
			</div>
		</div>
		<?php } ?>
		<?php if(isset($jobData['Job']['benefits'])){?>
		<div style='clear:both;height:auto;overflow:auto;'>
			<div class='jobRowHeading'>
				Benefits
			</div>
			<div class='jobRowData'>
				<?php echo $jobData['Job']['benefits'];?>
			</div>
		</div>
		<?php } ?>
		<?php if(isset($jobData['Job']['keywords'])){?>
		<div style='clear:both;height:auto;overflow:auto;'>
			<div class='jobRowHeading'>
				Keywords
			</div>
			<div class='jobRowData'>
				<?php echo $jobData['Job']['keywords'];?>
			</div>
		</div>
		<?php } ?>
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
	<div class='jobApplyers'>
		<?php
			if(empty($jobApplyers)):
		?>
		<div style='text-align:center;'>No one applied to this Job!</div>
		<?php else:?>
		<div style='height:20px;'><h2>Jobseekers :</h2></div>
		<?php if($this->Paginator->numbers()): ?>
			<?php $this->Paginator->options(array('url' =>array($jobData['Job']['id'])));?>
		<div class='paginator'>
			<?php echo $paginator->first('First  |'); ?>
			<?php echo $paginator->prev('  '.__('Previous', true), array(),null,array('class'=>'disabled'));?>
			<?php echo " < ".$this->Paginator->numbers(array('modulus'=>4))."  > "; ?>
			<?php echo $paginator->next(__('Next', true).' ', array(), null, array('class'=>'disabled')); ?>
			<?php echo $paginator->last(' |  Last'); ?>
		</div>
		<?php endif;?>
		<div class='headingBar'>
			<div class='dataContactName' style='margin-left:5px;text-align:center;'>Name</div>
			<div class='dataAccountEmail' style='text-align:center;'>Email</div>
			<div class='dataContact' style='text-align:center;'>Contact</div>
			<div class='dataStatus'>Status</div>
		</div>
		<?php $sn=0;?>
		<?php
			foreach($jobApplyers as $key=>$applyer):
		?>
		<?php if($sn++ % 2 == 0) $class='even'; else $class='odd';?>
		<div class="dataBar <?php echo $class;?>">
			<div class='dataContactName' style='margin-left:5px;'>
				<?php echo (empty($applyer['Jobseeker']['contact_name']))?'&nbsp;':$applyer['Jobseeker']['contact_name'];?>
			</div>
			<div class='dataAccountEmail'>
				<?php echo $applyer['User']['account_email'];?>
			</div>
			<div class='dataContact'>
				<?php echo (empty($applyer['Jobseeker']['contact_phone']))?'&nbsp;':$applyer['Jobseeker']['contact_phone'];?>
			</div>
			<div class='dataStatus'>
				<?php $status=array('0'=>'Applied','1'=>'Selected','2'=>'Rejected');?>
				<?php echo $status[$applyer['JobseekerApply']['is_active']];?>
			</div>
		</div>
		<?php
			endforeach;
		?>
	</div>
	<?php endif;?>
</div>
