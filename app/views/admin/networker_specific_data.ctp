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
			<div class="NSDInfo"><?php echo ucfirst($networkerData['Networker']['contact_name']);?></div>
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
			<div class="NSDInfo">
				<?php 
					echo $this->Number->format(
					$networkerData['networkerRewards'],
					array(
						'places' => 2,
						'before' => '$',
						'decimals' => '.',
						'thousands' => ',')
					);
				?>
			</div>
		</div>
		<div class="NSDRowLeft">
			<div class="NSDInfoHeading">Origin:</div>
			<div class="NSDInfo">
			<?php 
				if($networkerData['origin']===HR)
					echo "Hire Routes";
				elseif($networkerData['origin']===RANDOM)
					echo "Random";
				else
					echo $networkerData['origin'];
			?>
			</div>
		</div>
		<div class="NSDRowRight">
			<div class="NSDInfoHeading">Jobseekers:</div>
			<div class="NSDInfo"><?php echo $networkerData['0']['jobseekerCount'];?></div>
		</div>
		<?php if(isset($networkerData['GraduateDegree']['degree'])){ ?>
			<div class="NSDRowLeft" >
				<div class="NSDInfoHeading">Graduate Degree:</div>
				<div class="NSDInfo"><?php echo $networkerData['GraduateDegree']['degree'];?></div>
			</div>
			<div class="NSDRowRight">
				<div class="NSDInfoHeading">Graduate University:</div>
				<div class="NSDInfo"><?php echo $networkerData['GraduateUniversity']['name'];?></div>
			</div>
		<?php } ?>
		<?php if(isset($networkerData['University']['name'])){ ?>
			<div class="NSDRowLeft">
				<div class="NSDInfoHeading">University:</div>
				<div class="NSDInfo"><?php echo $networkerData['University']['name'] ;?></div>
			</div>	
		<?php }?>
	</div>
</div>
<div class="dataBorder">
	<div class="NSData">
		<?php if(empty($networkersLevelInfo)): ?>
			<div style="height:20px;font-size:16px;padding:5px;text-align:center;">
				No Networker Level Exist!
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
				<div style="cursor:pointer;" class="levelDataBar levelDataBarHover" onclick="getNetworkersNetworkerForLevel(<?php echo ($networkerData['User']['id'].','.($level+1));?>);">
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
			<div class="NSInfo">
				<?php if(empty($networkersNetworkerData)):?>
					<div style="height:30px;font-size:16px;padding:5px;text-align:center;">
						There is no networker at this Level!
					</div>
				<?php else:?>
					<div style="height:auto;float:left;width:inherit;">
						<div style="height:30px;font-weight:bold;font-size:20px;padding:5px;text-align:left;">
							<?php echo "Level $selectedLevel"?>
							<?php $this->Paginator->options(array('url' =>array($networkerData['User']['id'])));?>
							<?php if($this->Paginator->numbers()): ?>
								<?php $this->Paginator->options(array('url' =>array($networkerData['User']['id'],'level'=>$selectedLevel)));?>
								<div class="NSDataPaginatorBar">
									<?php echo $paginator->first('First  |'); ?>
									<?php echo $paginator->prev('  '.__('Previous', true), array(),null,array('class'=>'disabled'));?>
									<?php echo " < ".$this->Paginator->numbers(array('modulus'=>4))."  > "; ?>
									<?php echo $paginator->next(__('Next', true).' ', array(), null, array('class'=>'disabled')); ?>
									<?php echo $paginator->last(' |  Last'); ?>
								</div>
							<?php endif; ?>
						</div>
						<div Class="headingBar">
							<div class="networkersDataEmail" style="text-align:center">
								<?php echo $this->Paginator->sort('User','User.account_email')?>
							</div>
							<div class="networkersDataOrigin">
								<?php echo $this->Paginator->sort('University','university');?>
							</div>
							<div class="networkersData" style="width:50px;">Level</div>
							<div class="networkersData">Networkers</div>
							<div class="networkersData">
								<?php echo $this->Paginator->sort('Jobseekers','jobseekerCount');?>
							</div>
							<div class="networkersDataOrigin">Origin</div>
							<div class="networkersData">Rewards</div>
							<div class="networkersData" style="width:50px;">
								<?php echo $this->Paginator->sort('Job Shared','sharedJobsCount');?>
							</div>
							<div class="networkersData">
								<?php echo $this->Paginator->sort('Subscription','notification');?>
							</div>
							<div class="networkersData" style='margin-right:5px;'>
								<?php echo $this->Paginator->sort('Created','User.created');?>
							</div>
						</div>
					</div>
					<?php $count=1;?>
					<?php foreach($networkersNetworkerData as $key => $networkerInfo): ?>
						<div class="dataBar <?php if($count%2==0) echo 'even'; else echo 'odd'; ?> networkerDataHover" onclick="networkerSpecificData(<?php echo $networkerInfo['User']['id'];?>);" >
							<div class="networkersDataEmail">
								<?php echo $networkerInfo['User']['account_email'];?>
							</div>
							<div class="networkersDataOrigin">
								<?php echo $networkerInfo['University']['name'];?>
							</div>
							<div class="networkersData" style="width:50px;">
								<?php echo $networkerInfo['level'];?>
							</div>
							<div class="networkersData">
								<?php echo $networkerInfo['networkersCount'];?>
							</div>
							<div class="networkersData">
								<?php echo $networkerInfo['0']['jobseekerCount'];?>
							</div>
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
							<div class="networkersData" style="text-align:right;">
								<?php 
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
							<div class="networkersData" style="width:50px;">
								<?php echo $networkerInfo['0']['sharedJobsCount'];?>
							</div>
							<div class="networkersData">
								<?php 
									if($networkerInfo['Networker']['notification']>0)
										echo "Y";
									else
										echo "N";
								?>
							</div>
							<div class="networkersData">
								<?php echo $networkerInfo['User']['created'];?>
							</div>
						</div>
						<?php $count++;?>
					<?php endforeach;?>
				<?php endif;?>
			</div>
		<?php endif;?>
	</div>
</div>
<div class="NSDOrigin">
	<div style="height:20px;font-weight:bold;font-size:20px;padding:5px;">
		Origin:
	</div>
	<div class="NSDoriginData">
		<?php if(empty($networkerData['Networker']['contact_name'])) echo $networkerData['User']['account_email']; else echo ucfirst($networkerData['Networker']['contact_name']);?>
	</div>
	<?php if($networkerData['origin']===RANDOM):?>
		<?php foreach($originData as $key => $userData):?>
			<div class="NSDOriginConnector">
				&nbsp;
			</div>
			<?php if(empty($userData['User']['parent_user_id'])):?>
				<div class="NSDoriginData">
					<?php echo "Hire Routes";?>
				</div>
			<?php elseif(!empty($userData['Company']['id'])):?>
				<div class="NSDoriginData">
					<?php if(empty($userData['Company']['company_name'])) echo $userData['Parent']['account_email']; else echo ucfirst($userData['Company']['company_name']);?>
				</div>
			<?php else:?>
				<div class="NSDoriginData">
					<?php if(empty($userData['Networker']['contact_name'])) echo $userData['Parent']['account_email']; else echo ucfirst($userData['Networker']['contact_name']);?>
				</div>
			<?php endif;?>
		<?php endforeach;?>
	<?php else:?>	
		<?php foreach($originData as $key => $origin):?>
			<div class="NSDOriginConnector">
				&nbsp;
			</div>
			<div class="NSDoriginData">
				<?php if(empty($origin)) echo "N/A"; else echo ucfirst($origin);?>
			</div>
		<?php endforeach;?>
	<?php endif;?>
</div>
<script>
	function getNetworkersNetworkerForLevel(id,level){
		window.location.href='/admin/networkerSpecificData/'+id+'/level:'+level;
	}
	function networkerSpecificData(networker){
		window.location.href='/admin/networkerSpecificData/'+networker;
	}
</script>
