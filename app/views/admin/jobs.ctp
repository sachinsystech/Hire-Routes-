<?php 
	/**
	 *	Job data page
	 */
?>
<div class='dataBorder'>
	<div class="JSJobData">
		<div style="padding:1px;float:left;">
		SORT BY
		<select  id="short_by">
			<option value="" <?php if(empty($sortBy)) echo "selected"; ?>>Select</option>
			<option value="title" <?php echo $sortBy=="company_name"?"selected":""?> >Title</option>
			<option value="industry_name" <?php echo $sortBy=="industry_name"?"selected":"" ?> >Industry</option>
			<option value="specification_name" <?php echo $sortBy=="specification_name"?"selected":"" ?> >Specification</option>
			<option value="city_name" <?php echo $sortBy=="city_name"?"selected":"" ?> >City</option>
			<option value="state_name" <?php echo $sortBy=="state_name"?"selected":"" ?> >State</option>
		</select>
		</div>
		<?php if(isset($jobs) && !empty($jobs)):?>
			<?php if($this->Paginator->numbers()): ?>
				<div class="paginatorBar">
					<?php echo $paginator->first('First  |'); ?>
					<?php echo $paginator->prev('  '.__('Previous', true), array(),null,array('class'=>'disabled'));?>
					<?php echo " < ".$this->Paginator->numbers(array('modulus'=>4))."  > "; ?>
					<?php echo $paginator->next(__('Next', true).' ', array(), null, array('class'=>'disabled')); ?>
					<?php echo $paginator->last(' |  Last'); ?>
				</div>
			<?php endif; ?>
			<div class="heading">
				<div class="job">
					Job	
				</div>
				<div class="data">
					<?php echo $this->Paginator->sort('Employer','Job.company');?>
				</div>
				<div class="date">
					<?php echo $this->Paginator->sort('Date Posted','Job.created');?>
				</div>
				<div class="reward">
					<?php echo $this->Paginator->sort('Reward','Job.reward');?>
				</div>
				<div class="data">
					<?php echo $this->Paginator->sort('Status','Job.is_active');?>
				</div>
			</div>
			<?php $sn=0;?>
			<?php foreach($jobs as $key => $job):?>
				<?php if($sn++ % 2 == 0) $class='even'; else $class='odd';?>
				<div class="JSJobDataBar <?php echo $class;?>">
					<div class="job">
						<?php echo "<a href=#>".ucfirst($job['Job']['title'])."</a></br>";?>
						<?php 
							echo !empty($job['Specification']['name'])? $job['Specification']['name'].", ":"";
							echo $job['Industry']['name']."</br>";
						?>
						<?php 
							echo !empty($job['City']['city'])? $job['City']['city'].", ":"";
						?>
						<?php
							echo $job['State']['state']."</br>";
						?>
					</div>
					<div class="data">
						<?php echo ucfirst($job['Company']['company_name']);?>
					</div>
					<div class="date">
						<?php echo date('m/d/Y',strtotime($job['Job']['created']));?>
					</div>
					<div class="reward">
						<?php echo $this->Number->format(
												$job['Job']['reward'],
												array(
													'places' => 2,
													'before' => '$',
													'decimals' => '.',
													'thousands' => ',')
												);?>
					</div>
					<div class="data">
						<?php $status=array(0=>'Archived', 1=>'Activated', 2=>'Deleted', 3=>'Unpublished');?>
						<?php echo $status[$job['Job']['is_active']];?>
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
<script>
	$(document).ready(function(){
		$("#short_by").change(function sortBy(){
			window.location.href='/admin/jobs/page:1/sort:'+$('#short_by option:selected').val()+'/direction:asc';
		});
	});
</script>
