<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<?php echo $this->element('side_menu');?>
		</div>
	</div>
	<!-- left section end -->
	<!-- middle section start -->
	<div class="rightBox" >
		<!-- middle content top menu start -->
		<div class="topMenu">
			<?php echo $this->element('top_menu');?>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
			<div class="middleBox">
				<div class="networker_data">
					<?php if(count($networkerData)>0){ ?>
					<div class="networker_data_row">
						<div class="nr_data_field">All Networkers:</div>
						<div class="nr_data_value"></div>
					</div>
					<div class="networker_data_row">
						<div class="nr_data_field">Total </div>
						<div class="nr_data_value"><?php echo array_sum($networkerData);?></div>
					</div>
					<?php foreach($networkerData as $degree=>$totalNetworkers){?>
					<div class="networker_data_row">
						<div class="nr_data_field"><?php	$networkDegree = $degree+1;
									  	if($networkDegree==1){
											$suffix = "st";
									  	}elseif($networkDegree==2){
											$suffix = "nd";
									  	}elseif($networkDegree==3){
											$suffix = "rd";
									  	}else{
											$suffix = "th";
									  	}
										echo $networkDegree."<sup>".$suffix."<sup>&omicron;</sup></sup>";?></div>
						<div class="nr_data_value" style="margin-top:10px">
							<?php echo $totalNetworkers;?>
						</div>
					</div>
					<?php }} else{?>
							<div class="empty_concats_msg"> No Data To Show..</div>
			  		<?php }?>
				</div>
				<div style="width:330px;float:left;padding:10px;">
				<div style="font-weight:bold;font-size:18px;text-align:center;">
					<span>1<sup>&omicron;</sup></sup> Networkers</span>
				</div>
				<div style="text-align:center;"><?php echo $paginator->first(' << ', null, null, array("class"=>"disableText"))." ".$this->Paginator->prev(' < ', null, null, array("class"=>"disableText"))." ".$this->Paginator->numbers(array('modulus'=>4))." ".$this->Paginator->next(' > ', null, null, array("class"=>"disableText"))." ".$paginator->last(' >> ', null, null, array("class"=>"disableText"));?></div>
				<table>
					<tr>
						<th>Name</th>
						<th>Network</th>
					</tr>
					<?php if(isset($firstDegreeNetworkers)):?>
					<?php foreach($firstDegreeNetworkers as $key => $value): ?>
					<tr>
						<td><?php echo (empty($value['Networker']['contact_name']))?'----':$value['Networker']['contact_name'];?></td>
						<td><?php echo $value[0]['count'];?></td>
					</tr>
					<?php endforeach;?>
					<?php endif;?>
				</table>
				<div style="text-align:center;"><?php echo $paginator->numbers(array('modulus'=>4));?></div>
				</div>
			</div>
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->
</div>
