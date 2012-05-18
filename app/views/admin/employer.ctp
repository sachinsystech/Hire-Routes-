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
			<div style="width:300px;float:left;">
				Employer
			</div>
			<div class="networkersData">
				Job posted
			</div>
			<div class="networkersData">
				<?php echo $this->Paginator->sort('Job Filled','jobFilled')?>
			</div>
			<div class="networkersData" style="width:100px;">
				Award Posted
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
			<div style="width:300px;float:left;">
				<?php echo $html->link(empty($employer['Companies']['company_name'])?'----':ucfirst($employer['Companies']['company_name']), array('controller' => 'admin','action'=>'employerSpecificData',$employer['Companies']['user_id'] )).", ";?>
				<?php echo ucfirst($employer['Companies']['contact_name']); ?></br>
				<?php echo $employer['User']['account_email']; ?></br>
				<?php echo "<a href='".$employer['Companies']['company_url']."' >".$employer['Companies']['company_url']."</a>";?>
			</div>
			<div class="networkersData" style="text-align:center">
				<?php echo $employer['0']['jobPosted']; ?>&nbsp;
			</div>
			<div class="networkersData" style="text-align:center">
				<?php echo $employer['0']['jobFilled']; ?>&nbsp;
			</div>
			<div class="networkersData" style="width:100px;text-align:right">
				<?php echo $this->Number->format(
												$employer['0']['awardPosted'],
												array(
													'places' => 2,
													'before' => '$',
													'decimals' => '.',
													'thousands' => ',')
												); ?>&nbsp;
			</div>
			<div class="networkersData" style="text-align:right;width:100px;">
				<?php echo $this->Number->format(
												$employer['0']['awardPaid'],
												array(
													'places' => 2,
													'before' => '$',
													'decimals' => '.',
													'thousands' => ',')
												);?>&nbsp;
			</div>
		</div>
		<?php
			endforeach;
		?>
	</div>
</div>
<script>
	function specificEmployer(employer){
		window.location.href='/admin/employerSpecificData/'+employer;
	}
</script>
