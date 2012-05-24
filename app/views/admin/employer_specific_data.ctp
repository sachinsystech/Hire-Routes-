<?php
	/**
	 * Payment information for admin
	 */
?>
<script>

	function jobDetail(jobId){
	
		$.ajax({
				url:"/admin/companyjobdetail",
				type:"post",
				dataType:"json",
				async:false,
				data:{jobId:jobId},
				success:function(response){
					if(response['error']== true){
						alert(response['message']);
						return;
					}
				
					$("#companyJobDetail").dialog({
						height:200,
						width:450,
						modal:true,
						resizable: false ,
						draggable: true,
						title:"Job Detail",
						show: { 
							effect: 'drop', 
							direction: "up" 
						},
					});
					$('.ui-icon').css({'float': 'right'});
					
					$('.ui-dialog-titlebar-close').css({'position': 'inherit'});
					$("#companyJobDetail").html(
	'<div style="font-size:20px;height:15px;margin:10px;"><b>'+ucfirst(response['Job']['title'])+'</b></div>'+
	'<div style="margin-left:20px;">'+
	'<div class="jobDetail"><span><b>By Company:</b></span><span class="jobDetailContent">'+
	response['comp']['company_name']+'</span></div>'+
	'<div class="jobDetail"><span><b>Website:</b></span><span class="jobDetailContent">'+
	response['comp']['company_url']+'</span></div>'+
	'<div class="jobDetail" style="widht:425px"><span><b>Published In:</b></span><span class="jobDetailContent">'+
	response['ind']['industry_name']+' , '+response['spec']['specification_name']+'</span></div>'+
	'</div>'+
	'<div style="margin-left:20px;">'+
	'<div class="jobDetail"><span><b>Location:</b></span><span class="jobDetailContent">'+
	response['state']['state']+' , '+response['city']['city']+'</span></div>'+
	'<div class="jobDetail"><span><b>Anual Salary Range($):</b></span><span  class="jobDetailContent">'+response['Job']['salary_from']+'k -'+response['Job']['salary_to']+'k</div>'+
	'<div class="jobDetail"><span><b>Type:</b></span><span class="jobDetailContent">'+
	response['Job']['job_type']+'</span></div>'+
	'<div class="jobDetail"><span><b>Description:</b></span><span class="jobDetailContent">'+response['Job']['description']+'</span></div>'+
	'</div>');
				
				},
				error:function(response){
					alert("Something went wrong, please try again.");
				}
		});	
	
	}
	
</script>
	
<div id="companyJobDetail" style="display:none;padding:12px">

</div>
<?php echo $this->Session->flash();?>
<div id="page-heading"><h1>Employer Specific data</h1></div>
<div class='dataBorder'>
	<div class="JSJobData"  style="width:700px;text-align:left;">
		<table width ="100%" cellspacing='0' class="employerSpecificDataTable">
			<?php 
		    	if(isset($companyDetail)){
			?>
			<tr>
				<td width="22%"><b>Company Name:<b></td>
				<td width="35%"> <?php echo ucfirst($companyDetail['Companies']['company_name']) ;?> </td>
				<td width="22%"><b>Reward Paid:</b></td>
				<td width="35%">
					<?php echo $this->Number->format($totalPaidReward,
							array(
								'places' => 2,
								'before' => '$',
								'decimals' => '.',
								'thousands' => ',')
							);?> 
				</td> 
			</tr>
				<td ><b>Contact Name:</b></td>
				<td >
					<?php echo ucfirst($companyDetail['Companies']['contact_name']) ;?> 
				</td> 
				<td><b>Reward Posted:</b></td>
				<td>
					<?php 	echo $this->Number->format($totalRewards,
							array(
								'places' => 2,
								'before' => '$',
								'decimals' => '.',
								'thousands' => ',')
							);?> 
				</td> 					
			<tr>
				<td><b>Company Url:</b></td>
				<td>
					<a href= "<?php echo $companyDetail['Companies']['company_url'] ;?>">
						<?php echo $companyDetail['Companies']['company_url'] ;?>
					</a> 
				</td> 
				<td><b>Active Jobs:</b></td>
				<td>
					<?php echo $companyDetail['activeJobCount'] ;?> 
				</td> 
			</tr>
			<tr>
				<td><b>Company Email:</b></td>
				<td>
					<?php echo $companyDetail['UserList']['account_email'];?>
				</td>
				<td><b>Archive Jobs:</b></td>
				<td>
					<?php echo $companyDetail['archJobCount'];?> 
				</td>
			</tr>
				<td><b>Contact Phone:</b></td>
				<td>
					<?php echo $companyDetail['Companies']['contact_phone'];?>
				</td>
			
				<td><b>Applied Jobs:</b></td>
				<td>
					<?php echo $companyDetail['appliedJobCount'];?> 
				</td>
			</tr>
			<?php
				}
			?>
		</table>
	</div>
	</div>
	<div style="height:10px;"></div>
	<div class='dataBorder'>
	<div class="JSJobData"  style="width:700px">
		<?php if(isset($jobs) && !empty($jobs)):?>
				<?php $this->Paginator->options(array('url' =>array($companyDetail['Companies']['user_id'])));?>
			<?php if($this->Paginator->numbers()): ?>
				<div class="paginatorBar">
					<?php echo $paginator->first('First  |'); ?>
					<?php echo $paginator->prev('  '.__('Previous', true), array(),null,array('class'=>'disabled'));?>
					<?php echo " < ".$this->Paginator->numbers(array('modulus'=>4))."  > "; ?>
					<?php echo $paginator->next(__('Next', true).' ', array(), null, array('class'=>'disabled')); ?>
					<?php echo $paginator->last(' |  Last'); ?>
				</div>
			<?php endif; ?>
			<div class="heading"  style="width:700px">
				<div class="job">
					<?php echo $this->Paginator->sort('Job','Job.title')?>
				</div>
				<div class="data">
					<?php echo $this->Paginator->sort('Applicants ','Job.submission')?>
				</div>
				<div class="data">
					<?php echo $this->Paginator->sort('Views ','Job.views')?>
				</div>
				<div class="date">
					<?php echo $this->Paginator->sort('Date Posted','Job.created')?>
				</div>
				<div class="reward" style="text-align:center	;">
					<?php echo $this->Paginator->sort('Reward Posted','Job.Reward')?>
				</div>
				<div class="reward" style="width:140px;text-align:center;">
					<?php echo $this->Paginator->sort('Status','Job.is_active')?>
				</div>
			</div>
			<?php $sn=0; 
				$josStatus= array('0'=>'Archive', '1'=>'Activate', '2'=>'Delete','3'=>'Unpublish');
			?>
				<?php foreach($jobs as $job):?>	
				<?php if($sn++ % 2 == 0) $class='even'; else $class='odd';?>
				<div class="JSJobDataBar <?php echo $class;?>"  style="width:700px">
					<div class="job">
						<a href="javascript:void(0);" onclick="jobDetail(<?php echo $job['Job']['id'] ;?>)" >
								<?php echo ucfirst($job['Job']['title']); ?>
						</a>
					</div>

					<div class="data">
						<?php echo $job['0']['submission'];?>
					</div>
					<div class="data">
						<?php echo $job['0']['views'];?>
					</div>
					<div class="date">
						<?php echo date('m/d/Y',strtotime($job['Job']['created']));?>
					</div>
					<div class="reward" style="width:100px;">
						<?php echo $this->Number->format(
												 $job['Job']['reward'],
												array(
													'places' => 2,
													'before' => '$',
													'decimals' => '.',
													'thousands' => ',')
												);?>
					</div>					
					<div class="data" style="align:center;width:140px;">
						<?php echo  $josStatus[$job['Job']['is_active']]; ?>
					</div>
				</div>
				<?php endforeach;?>
		<?php else: ?>
			<div style="padding:2px;">
				Sorry, No Job found for employer.
			</div>
		<?php endif; ?>
	</div>
	</div>

