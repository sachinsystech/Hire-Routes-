<?php
	/**
	 * Networker Specific Data
	 */
?>
<div id="page-heading"><h1>Networker Specific Data</h1></div>
<div class="networkerSpecificData">
	<div class="specificData">
		<div class="NSDRowLeft">
			<div class="NSDInfoHeading">NAME:</div>
			<div class="NSDInfo"><?php echo $networkerData['Networker']['contact_name'];?></div>
		</div>
		<div class="NSDRowRight">
			<div class="NSDInfoHeading">Job Shared:</div>
			<div class="NSDInfo"><?php echo $networkerData['0']['sharedJobsCount'];?></div>
		</div>	
		<div class="NSDRowLeft">
			<div class="NSDInfoHeading">Email:</div>
			<div class="NSDInfo"><?php echo $networkerData['User']['account_email'];?></div>
		</div>
		<div class="NSDRowRight">
			<div class="NSDInfoHeading">Rewards:</div>
			<div class="NSDInfo"><?php echo $networkerData['networkerRewards'];?></div>
		</div>
		<div class="NSDRowLeft">
			<div class="NSDInfoHeading">Origin:</div>
			<div class="NSDInfo"><?php echo $networkerData['origin'];?></div>
		</div>
		<div class="NSDRowRight">
			<div class="NSDInfoHeading">Jobseekers:</div>
			<div class="NSDInfo"><?php echo $networkerData['0']['jobseekerCount'];?></div>
		</div>
	</div>
</div>
<div class="networkerData">
	<?php if(empty($networkersLevelInfo)): ?>
		<div style="height:20px;font-weight:bold;font-size:20px;padding:5px;text-align:center;">
			No Networker Level Exist
		</div>
	<?php else:?>
		<div style="height:20px;font-weight:bold;font-size:20px;padding:5px;">
			Networkers Level
		</div>
		<div class="levelInfo">
			<div class="levelDataHeading">
				<div class="levelHeading">Total</div>
				<div class="levelHeading"><?php echo array_sum($networkersLevelInfo);?></div>
			</div>		
			<?php foreach($networkersLevelInfo as $level => $networkers): ?>
				<?php if(($level+1)==$selectedLevel):?>
			<div class="levelDataActiveBar">
				<?php else:?>
			<div style="cursor:pointer;" class="levelDataBar" onclick="getNetworkersNetworkerForLevel(<?php echo ($networkerData['User']['id'].','.($level+1));?>);">
				<?php endif;?>
				<div class="levelData">
					<?php echo "Level ".($level+1); ?>
				</div>
				<div class="levelData">
					<?php echo $networkers; ?>
				</div>
			</div>
			<?php endforeach;?>
		</div>
		<div class="networkerInfo">
			<?php if(empty($networkersNetworkerData)):?>
				<div style="height:30px;font-weight:bold;font-size:20px;padding:5px;text-align:center;">
					There is no networker at this Level.
				</div>
			<?php else:?>
				<div style="width:730px;height:70px;float:left;">
					<div style="height:30px;font-weight:bold;font-size:20px;padding:5px;">
						<?php echo "Level $selectedLevel"?>
						<?php if($this->Paginator->numbers()): ?>
							<div class="networkerDataPaginatorBar">
								<?php $this->Paginator->options(array('url' =>array($networkerData['User']['id'],'level'=>$selectedLevel)));?>
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
						<div class="networkersData">Level</div>
						<div class="networkersData">Networkers</div>
						<div class="networkersData">Jobseekers</div>
						<div class="networkersDataOrigin">Origin</div>
						<div class="networkersData">Rewards</div>
						<div class="networkersData">Job Shared</div>
						<div class="networkersData">Subscription</div>
					</div>
				</div>
				<?php $count=1;?>
				<?php foreach($networkersNetworkerData as $key => $networkerInfo): ?>
					<div class="<?php if($count%2==0) echo 'networkerDataBarEven'; else echo 'networkerDataBarOdd'; ?>" onclick="networkerSpecificData(<?php echo $networkerInfo['User']['id'];?>);" >
						<div class="networkersDataEmail">
							<?php echo $networkerInfo['User']['account_email'];?>
						</div>
						<div class="networkersData">
							<?php echo $networkerInfo['level'];?>
						</div>
						<div class="networkersData">
							<?php echo $networkerInfo['networkersCount'];?>
						</div>
						<div class="networkersData">
							<?php echo $networkerInfo['0']['jobseekerCount'];?>
						</div>
						<div class="networkersDataOrigin">
							<?php echo $networkerInfo['origin'];?>
						</div>
						<div class="networkersData">
							<?php echo $networkerInfo['networkerRewards'];?>
						</div>
						<div class="networkersData">
							<?php echo $networkerInfo['0']['sharedJobsCount'];?>
						</div>
						<div class="networkersData">
							<?php echo $networkerInfo['Networker']['notification'];?>
						</div>
					</div>
					<?php $count++;?>
				<?php endforeach;?>
			<?php endif;?>
		</div>
	<?php endif;?>
</div>
<div class="NSDOrigin">
	<div style="height:20px;font-weight:bold;font-size:20px;padding:5px;">
		Origin:
	</div>
	<div class="NSDoriginData">
		<?php if(empty($networkerData['Networker']['contact_name'])) echo "N/A"; else echo $networkerData['Networker']['contact_name'];?>
	</div>	
	<?php foreach($originData as $key => $origin):?>
		<div class="NSDOriginConnector">
			&nbsp;
		</div>
		<div class="NSDoriginData">
			<?php if(empty($origin)) echo "N/A"; else echo $origin;?>
		</div>
	<?php endforeach;?>
</div>
<script>
	function getNetworkersNetworkerForLevel(id,level){
		window.location.href='/admin/networkerSpecificData/'+id+'/level:'+level;
	}
	function networkerSpecificData(networker){
		window.location.href='/admin/networkerSpecificData/'+networker;
	}
</script>
