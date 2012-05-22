<?php
	/**
	 *	Employer Data page
	 */
?>


<?php

function login_status($l1,$l2){
	$status = false;
	if($l1==null){
		return $status;
	}
	else{
		if($l2==null){
			if((strtotime(date('Y:m:d H:i:s'))-strtotime($l1))<=20*60){
				$status = true;
				return $status;
			}
			else{
				return $status;
			}
		}
		if((strtotime($l2)-strtotime($l1))>0){
			return $status;
		}
		if((strtotime(date('Y:m:d H:i:s'))-strtotime($l1))<=20*60){
			$status = true;
			return $status;
		}
	}
}	

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
				<?php echo $this->Paginator->sort('Employer','Companies.company_name')?>
			</div>
			<div class="networkersDataOrigin" style="width:125px;">
				<?php echo $this->Paginator->sort('Name','Companies.contact_name')?>
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
		<div class="employerDataBar">
			<div class="<?php echo $class;?>" onclick="specificEmployer(<?php echo $employer['Companies']['user_id'];?>);">
				<div class="networkersDataOrigin" style="width:125px;">
					<div class="employerLoginStatusBar" style="float:left" id="<?php echo "user_".$employer['Companies']['user_id'];?>" idfield="<?php echo $employer['Companies']['user_id'];?>">	
					</div>	
					<div style="float:left">
						<?php echo $employer['Companies']['company_name']; ?>&nbsp;
					</div>	
				</div>
				<div class="networkersDataOrigin" style="width:125px;">
					<?php echo ucfirst($employer['Companies']['contact_name']); ?>&nbsp;
				</div>
				<div class="networkersDataEmail">
					<?php echo $employer['User']['account_email']; ?>&nbsp; 
				</div>
				<div class="networkersDataEmail"  style="width:205px;">
					&nbsp;<?php echo $employer['Companies']['company_url']; ?>&nbsp;
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



<script>

function login_status(l1,l2){
	status = 0;
	var currentTime =new Date();
	currentTime = currentTime.getTime()/1000;
	
	if(l1==false){
		return status;
	}
	else{
		if(l2==false){
			if((currentTime-l1)<=20*60){
				status = 1;
				return status;
			}
			else{
				return status;
			}
		}
		if((l2-l1)>0){
			return status;
		}
		if((currentTime-l1)<=20*60){
			status = 1;
			return status;
		}
		else{
			return status;
		}
		
	}
}	

function reloadLoginStatus() {
	var ids = jQuery.makeArray();
	var user_ids = jQuery.makeArray();
	$('.employerLoginStatusBar').each(function(index){
		ids[index] = $(this).attr('idfield');
		user_ids[index] = $(this).attr('id');
	});
	
	$.ajax({
		url:"/admin/employerLoginStatus/",
		type:"post",
		dataType:"json",
		async:false,
		data: {ids:ids},
		success:function(response){
			response['data'];
			$.each(response['data'], function(index,value) {
				x = login_status(value['last_login'],value['last_logout']);
				if(x==1){
					$("#user_"+index).html('<img src="/images/login.png">');
				}
				else{
					$("#user_"+index).html('<img src="/images/logout.png">');
				}
            });
		}		
		
	});
	setInterval('reloadLoginStatus()',10*1000);
}
reloadLoginStatus();

setTimeout(function(){
   window.location.reload(1);
}, 1000*60*1);



//clearConsole();
</script>
