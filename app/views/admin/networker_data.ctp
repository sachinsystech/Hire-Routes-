<?php
	/**
	 *	To display all networker data
	 */
?>
<?php $selectedLevel; ?>
<div style="width:902px;height:auto;overflow:auto;margin:auto;">
	<div style="width:200px;height:auto;overflow:auto;float:left;border:1px solid black;">
	<div style="height:40px;background-color:green;border-bottom:1px solid black;">
		<div style="font-weight:bold;font-size:20px;width:100px;float:left;">Total</div>
		<div style="width:100px;font-size:20px;float:left;"><?php echo array_sum($levelInformation);?></div>
	</div>
	<?php foreach($levelInformation as $level => $networkers): ?>
		<div style="height:40px;background-color:green;cursor:pointer;border-bottom:1px solid black;" onclick="getNetworkerForLevel(<?php echo ($level+1);?>);">
			<div style="font-weight:bold;font-size:15px;width:100px;float:left;">
				<?php echo "Level ".($level+1); ?>
			</div>
			<div style="width:100px;font-size:20px;float:left;">
				<?php echo $networkers; ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>
<div style="width:696px;height:auto;overflow:auto;float:right;border:1px solid black;">
	<div style="width:696px;height:70px;float:left;">
		<div style="width:696px;height:40px;font-weight:bold;font-size:20px;">
			<?php echo "Level $selectedLevel"?>
		</div>
		<div style="width:696px;height:30px;font-size:13px;border-bottom:1px solid black;">
			<div style="width:240px;float:left;text-align:center;">
				<?php echo $this->Paginator->sort('User','User.account_email')?>
			</div>
			<div style="width:70px;float:left;text-align:center;">Networkers</div>
			<div style="width:70px;float:left;text-align:center;">
				Jobseekers
			</div>
			<div style="width:100px;float:left;text-align:center;">Origin</div>
			<div style="width:70px;float:left;text-align:center;">Rewards</div>
			<div style="width:70px;float:left;text-align:center;">
				Shared Job
			</div>
			<div style="width:70px;float:left;text-align:center;">
				Subscription
			</div>
		</div>
	</div>
	<div style="width:696px;height:20px;float:left;border-bottom: 1px solid black;text-align:right;">
		<?php if($this->Paginator->numbers()): ?>
			<?php $this->Paginator->options(array('url' =>array('level'=>$selectedLevel)));?>
			<?php echo $paginator->first('First  |'); ?>
			<?php echo $paginator->prev('  '.__('Previous', true), array(),null,array('class'=>'disabled'));?>
			<?php echo " < ".$this->Paginator->numbers(array('modulus'=>4))."  > "; ?>
			<?php echo $paginator->next(__('Next', true).' ', array(), null, array('class'=>'disabled')); ?>
			<?php echo $paginator->last(' |  Last'); ?>
		<?php endif; ?>
	</div>
	<?php foreach($networkersData as $key => $networkerInfo): ?>
	<div style="width:696px;height:50px;float:left;border-bottom: 1px solid black;background-color:green;font-size:18px;cursor:pointer;" onclick="networkerSpecificData(<?php echo $networkerInfo['User']['id'];?>);" >
		<div style="width:240px;float:left;"><?php echo $networkerInfo['User']['account_email'];?></div>
		<div style="width:70px;float:left;text-align:center;"><?php echo $networkerInfo['networkersCount'];?></div>
		<div style="width:70px;float:left;text-align:center;"><?php echo $networkerInfo['0']['jobseekerCount'];?></div>
		<div style="width:100px;float:left;"><?php echo $networkerInfo['origin'];?></div>
		<div style="width:70px;float:left;text-align:center;"><?php echo $networkerInfo['networkerRewards'];?></div>
		<div style="width:70px;float:left;text-align:center;"><?php echo $networkerInfo['0']['sharedJobsCount'];?></div>
		<div style="width:70px;float:left;text-align:center;"><?php echo $networkerInfo['Networker']['notification'];?></div>
	</div>
	<?php endforeach;?>
</div>
</div>

<script>
	function networkerSpecificData(networker){
		window.location.href='/admin/NetworkerSpecificData/'+networker;
	}
	function getNetworkerForLevel(level){
		window.location.href='/admin/networkerData/level:'+level;
	}
</script>
