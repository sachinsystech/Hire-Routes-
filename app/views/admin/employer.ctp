<?php
	/**
	 *	Employer Data page
	 */
?>
<div id="page-heading"><h1>Employer data</h1></div>
<div class="dataBorder">
	<?php if($this->Paginator->numbers()):?>
		<div class="employerPaginatorBar">
			<?php echo $paginator->first('First  |'); ?>
			<?php echo $paginator->prev('  '.__('Previous', true), array(),null,array('class'=>'disabled'));?>
			<?php echo " < ".$this->Paginator->numbers(array('modulus'=>4))."  > "; ?>
			<?php echo $paginator->next(__('Next', true).' ', array(), null, array('class'=>'disabled')); ?>
			<?php echo $paginator->last(' |  Last'); ?>
		</div>
	<?php endif;?>
	<div class="employerData">
		<div class="employerDataHeading">
			<div class="networkersDataOrigin" style="width:125px;">
				<?php echo $this->Paginator->sort('Company','Companies.company_name')?>
			</div>
			<div class="networkersDataOrigin" style="width:125px;">
				<?php echo $this->Paginator->sort('Contact Name','Companies.contact_name')?>
			</div>
			<div class="networkersDataEmail" style="text-align:center;">
				<?php echo $this->Paginator->sort('Email','email')?>
			</div>
			<div class="networkersDataEmail" style="width:205px;text-align:center;">URL</div>
			<div class="networkersData">
				<?php echo $this->Paginator->sort('Job posted','jobPosted')?>
			</div>
			<div class="networkersData">
				<?php echo $this->Paginator->sort('Job Filled','jobFilled')?>
			</div>
			<div class="networkersData" style="width:100px;">
				<?php echo $this->Paginator->sort('Award Posted','awardPosted')?>
			</div>
			<div class="networkersData" style="width:100px;">
				<?php echo $this->Paginator->sort('Award Paid','awardPaid')?>
			</div>
		</div>
		<?php
			$sn=0;
			foreach($employers as $key =>$employer):
				$class=($sn++%2==0)?"employerDataBarEven":"employerDataBarOdd"
		?>
		<div class="<?php echo $class;?>">
			<div class="networkersDataOrigin" style="width:125px;">
				<?php echo $employer['Companies']['company_name']; ?>&nbsp;
			</div>
			<div class="networkersDataOrigin" style="width:125px;">
				<?php echo $employer['Companies']['contact_name']; ?>&nbsp;
			</div>
			<div class="networkersDataEmail">
				<?php echo $employer['User']['account_email']; ?>&nbsp;
			</div>
			<div class="networkersDataEmail"  style="width:205px;">
				<?php echo $employer['Companies']['company_url']; ?>&nbsp;
			</div>
			<div class="networkersData" style="text-align:center">
				<?php echo $employer['0']['jobPosted']; ?>&nbsp;
			</div>
			<div class="networkersData" style="text-align:center">
				<?php echo $employer['0']['jobFilled']; ?>&nbsp;
			</div>
			<div class="networkersData" style="width:100px;text-align:right">
				<?php echo $this->Number->format(
												$employer['0']['awardPosted']/1000,
												array(
													'places' => 2,
													'before' => '$',
													'decimals' => '.',
													'thousands' => ',')
												)." K"; ?>&nbsp;
			</div>
			<div class="networkersData" style="text-align:right;width:100px;">
				<?php echo $this->Number->format(
												$employer['0']['awardPaid']/1000,
												array(
													'places' => 2,
													'before' => '$',
													'decimals' => '.',
													'thousands' => ',')
												)." K";?>&nbsp;
			</div>
		</div>
		<?php
			endforeach;
		?>
	</div>
</div>
