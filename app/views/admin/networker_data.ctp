<?php
	/**
	 *	To display all networker data
	 */
?>
<div id="page-heading"><h1>Networker Data</h1></div>
<?php if(empty($levelInformation)):?>
<div class="networkerData">
	<div style="height:20px;font-weight:bold;font-size:20px;padding:5px;text-align:center;">
		There is No Networker.
	</div>
</div>
<?php else:?>
<?php $selectedLevel; ?>
<div class="dataBorder">
	<div class="networkerData">
		<div class="levelInfo">
			<div class="levelDataHeading">
				<div class="levelHeading">Total</div>
				<div class="levelHeading"><?php echo array_sum($levelInformation);?></div>
			</div>
			<?php foreach($levelInformation as $level => $networkers): ?>
				<?php if(($level+1)==$selectedLevel){?>
					<div class="levelDataActiveBar">
				<?php }else{?>
					<div style="cursor:pointer;" class="levelDataBar" onclick="getNetworkerForLevel(<?php echo ($level+1);?>);">
				<?php }?>
				<div class="levelData">
					<?php echo "Level ".($level+1); ?>
				</div>
				<div class="levelData">
					<?php echo $networkers; ?>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
		<div class="networkerInfo">
			<div style="width:730px;height:70px;float:left;">
				<div style="height:30px;font-weight:bold;font-size:20px;padding:5px;">
					<?php echo "Level $selectedLevel"?>
					<?php if($this->Paginator->numbers()): ?>
						<div class="networkerDataPaginatorBar">
							<?php $this->Paginator->options(array('url' =>array('level'=>$selectedLevel)));?>
							<?php echo $paginator->first('First  |'); ?>
							<?php echo $paginator->prev('  '.__('Previous', true), array(),null,array('class'=>'disabled'));?>
							<?php echo " < ".$this->Paginator->numbers(array('modulus'=>4))."  > "; ?>
							<?php echo $paginator->next(__('Next', true).' ', array(), null, array('class'=>'disabled')); ?>
							<?php echo $paginator->last(' |  Last'); ?>
						</div>
					<?php endif; ?>
				</div>
				<div Class="networkerDataHeading">
					<div class="networkersDataEmail" style="text-align:center">
						<?php echo $this->Paginator->sort('User','User.account_email')?>
					</div>
					<div class="networkersData">&nbsp;</div>
					<div class="networkersData">Networkers</div>
					<div class="networkersData">
						Jobseekers
					</div>
					<div class="networkersDataOrigin">Origin</div>
					<div class="networkersData">Rewards</div>
					<div class="networkersData">
						Job Shared
					</div>
					<div class="networkersData">
						Subscription
					</div>
				</div>
			</div>
			<?php $count=1;?>
			<?php foreach($networkersData as $key => $networkerInfo): ?>
			<div class="<?php if($count%2==0) echo 'networkerDataBarEven'; else echo 'networkerDataBarOdd'; ?>" onclick="networkerSpecificData(<?php echo $networkerInfo['User']['id'];?>);" >
				<div class="networkersDataEmail"><?php echo $networkerInfo['User']['account_email'];?></div>
				<div class="networkersData">&nbsp;</div>
				<div class="networkersData"><?php echo $networkerInfo['networkersCount'];?></div>
				<div class="networkersData"><?php echo $networkerInfo['0']['jobseekerCount'];?></div>
				<div class="networkersDataOrigin">
					<?php 
						if($networkerInfo['origin']===HR)
							echo "HR";
						elseif($networkerInfo['origin']===RANDOM)
							echo "Random";
						else
							echo $networkerInfo['origin'];
					?>
				</div>
				<div class="networkersData" style="text-align:right;"><?php 
												echo $this->Number->format(
												$networkerInfo['networkerRewards'],
												array(
													'places' => 2,
													'before' => '$',
													'decimals' => '.',
													'thousands' => ',')
												);
											?>
				</div>
				<div class="networkersData"><?php echo $networkerInfo['0']['sharedJobsCount'];?></div>
				<div class="networkersData">
					<?php 
						if($networkerInfo['Networker']['notification']>0)
							echo "Y";
						else
							echo "N";
					?>
				</div>
			</div>
			<?php $count++;?>
			<?php endforeach;?>
		</div>
	</div>
</div>
<?php endif;?>
<script>
	function networkerSpecificData(networker){
		window.location.href='/admin/networkerSpecificData/'+networker;
	}
	function getNetworkerForLevel(level){
		window.location.href='/admin/networkerData/level:'+level;
	}
</script>
