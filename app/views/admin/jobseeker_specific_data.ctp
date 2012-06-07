<?php
	/**
	 * Jobseeker Specific Data
	 */
?>
<div id="page-heading"><h1>Jobseeker Specific Data</h1></div>
<div class='dataBorder'>
	<div class='jobseekerSpecificData'>
		<div class='JSPersonalInfo'>
			<div style="font-size:18px;font-weight:bold;margin-bottom:10px;text-decoration:underline;">
				Profile
			</div>
			<div class="JSDInfo" style="font-weight:bold">
				<?php echo ucfirst($jobseekerData['Jobseeker']['contact_name']);?>
			</div>
			<div class="JSDInfo"><?php echo $jobseekerData['User']['account_email'];?></div>
			<div class="JSDInfo"><?php echo $jobseekerData['Jobseeker']['address'];?></div>
			<div class="JSDInfo">
				<?php echo !empty($jobseekerData['Jobseeker']['city'])?$jobseekerData['Jobseeker']['city'].",":"";?>
				<?php echo $jobseekerData['Jobseeker']['state'];?>
			</div>
			<div class="JSDInfo"><?php echo $jobseekerData['Jobseeker']['contact_phone'];?></div>
		</div>
		<div style="float:left;border-left:1px solid #cccccc;height:70px;margin-top:55px;">&nbsp;</div>
		<div class="JSJobProfile">
			<div style="font-size:18px;font-weight:bold;margin-bottom:10px;">
				&nbsp;
			</div>
			<?php if(empty($jobseekerData['JobseekerProfile']['answer1'])):?>
			<div class="left" style="font-size:14px;border:1px solid black;text-align:center;padding:1px;">
				Job profile not filled yet!
			</div>
			<?php else:?>
			<div class="left">
				<div class="heading">Qualification :</div>
				<div class="info">
					<?php echo $jobseekerData['JobseekerProfile']['answer1']; ?>
				</div>
			</div>
			<div class="right">
				<div class="heading">Experience :</div>
				<div class="info">
					<?php echo $jobseekerData['JobseekerProfile']['answer2']; ?>
				</div>
			</div>
			<div class="left">
				<div class="heading">Current CTC :</div>
				<div class="info">
					<?php echo $jobseekerData['JobseekerProfile']['answer3']; ?>
				</div>
			</div>
			<div class="right">
				<div class="heading">Expected CTC :</div>
				<div class="info">
					<?php echo $jobseekerData['JobseekerProfile']['answer4']; ?>
				</div>
			</div>
			<div class="left">
				<div class="heading">Job Type :</div>
				<div class="info">
					<?php $jobtypes = array(
							'1'=>'Full Time',
							'2'=>'Part Time',
							'3'=>'Contract',
							'4'=>'Internship',
							'5'=>'Temporary'
						);
					?>
					<?php if(isset($jobseekerData['JobseekerProfile']['answer5'])&&!empty($jobseekerData['JobseekerProfile']['answer5'])):?>
					<?php 	echo $jobtypes[$jobseekerData['JobseekerProfile']['answer5']]; ?>
					<?php endif;?>
				</div>
			</div>
			<div class="right">
				<div class="heading">University/College :</div>
				<div class="info">
					<?php echo $jobseekerData['University']['name']; ?>
				</div>
			</div>
			<div class="left">
				<div class="heading">Shifts Availability :</div>
				<div class="info">
					<?php echo $jobseekerData['JobseekerProfile']['answer7']; ?>
				</div>
			</div>
			<div class="right">
				<div class="heading">Passport Availability :</div>
				<div class="info">
					<?php echo $jobseekerData['JobseekerProfile']['answer8']; ?>
				</div>
			</div>
			<div class="left">
				<div class="heading">Travel Ability :</div>
				<div class="info">
					<?php echo $jobseekerData['JobseekerProfile']['answer9']; ?>
				</div>
			</div>
			<div class="right">
				<div class="heading">Training Needs :</div>
				<div class="info">
					<?php echo $jobseekerData['JobseekerProfile']['answer10']; ?>
				</div>
			</div>
			<?php endif;?>
		</div>
	</div>
</div>
<div class='dataBorder'>
	<div class="JSJobData">
		<div style="text-align:left;"><?php echo "<b>Applied Job: </b>".$jobseekerData['0']['appliedJob'];?></div>
		<?php if(isset($jobsData) && !empty($jobsData)):?>
			<?php if($this->Paginator->numbers()): ?>
				<div class="paginatorBar">
					<?php $this->Paginator->options(array('url' =>array($jobseekerData['Jobseeker']['user_id'])));?>
					<?php echo $paginator->first('First  |'); ?>
					<?php echo $paginator->prev('  '.__('Previous', true), array(),null,array('class'=>'disabled'));?>
					<?php echo " < ".$this->Paginator->numbers(array('modulus'=>4))."  > "; ?>
					<?php echo $paginator->next(__('Next', true).' ', array(), null, array('class'=>'disabled')); ?>
					<?php echo $paginator->last(' |  Last'); ?>
				</div>
			<?php endif; ?>
			<div class="headingBar">
				<div class="job" style='text-align:center;'>
					Job	
				</div>
				<div class="data">
					Applicants
				</div>
				<div class="data">
					Views
				</div>
				<div class="date">
					Date Posted
				</div>
				<div class="reward">
					Reward
				</div>
			</div>
			<?php $sn=0;?>
			<?php foreach($jobsData as $key => $jobData):?>
				<?php if($sn++ % 2 == 0) $class='even'; else $class='odd';?>
				<div class="dataBar <?php echo $class;?>">
					<div class="job">
						<?php echo "<a href=/admin/jobSpecificData/".$jobData['Job']['id'].">".$jobData['Job']['title']."</a></br>";?>
						<?php 
							echo $jobData['Specification']['name'].", ".$jobData['Industry']['name']."</br>";
						?>
						<?php 
							echo !empty($jobData['City']['city'])? $jobData['City']['city'].", ":"";
						?>
						<?php
							echo $jobData['State']['state']."</br>";
						?>
					</div>
					<div class="data">
						<?php echo $jobData['0']['applicants'];?>
					</div>
					<div class="data">
						<?php echo $jobData['0']['views'];?>
					</div>
					<div class="date">
						<?php echo date('m/d/Y',strtotime($jobData['Job']['created']));?>
					</div>
					<div class="reward">
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
			<?php endforeach;?>
		<?php else: ?>
			<div style="border:1px solid #000000;padding:2px;">
				This jobseeker does not applied to any job!
			</div>
		<?php endif; ?>
	</div>
</div>
