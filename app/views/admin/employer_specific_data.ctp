<?php
	/**
	 * Payment information for admin
	 */
?>
<script>

	function ucfirst(str) {
		var f = str.charAt(0).toUpperCase();
		return f + str.substr(1);
	}


	function jobDetail(jobId){
		//alert(jobId);
		
		$.ajax({
				url:"/admin/companyjobdetail",
				type:"post",
				dataType:"json",
				async:false,
				data:{jobId:jobId},
				success:function(response){
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
	'<div class="jobDetail"><span style="font-size:14px;"><b>By Company:</b></span><span class="jobDetailContent">'+
	response['comp']['company_name']+'</span></div>'+
	'<div class="jobDetail"><span style="font-size:14px;"><b>Website:</b></span><span class="jobDetailContent">'+
	response['comp']['company_url']+'</span></div>'+
	'<div class="jobDetail"><span style="font-size:14px;"><b>Published In:</b></span><span class="jobDetailContent">'+
	response['ind']['industry_name']+' , '+response['spec']['specification_name']+'</span></div>'+
	'</div>'+
	'<div style="margin-left:20px;">'+
	'<div class="jobDetail"><span style="font-size:14px;"><b>Location:</b></span><span class="jobDetailContent">'+
	response['state']['state']+' , '+response['city']['city']+'</span></div>'+
	'<div class="jobDetail"><span style="font-size:14px;"><b>Anual Salary Range($):</b></span><span  class="jobDetailContent">'+response['Job']['salary_from']+'k -'+response['Job']['salary_to']+'k</div>'+
	'<div class="jobDetail"><span style="font-size:14px;"><b>Type:</b></span><span class="jobDetailContent">'+
	response['Job']['job_type']+'</span></div>'+
	'<div class="jobDetail"><span style="font-size:14px;"><b>Description:</b></span><span class="jobDetailContent">'+response['Job']['description']+'</span></div>'+
	'</div>');
				
				}
		});	
	
	}
	
</script>
	
<div id="companyJobDetail" style="display:none;padding:12px">

</div>
<?php echo $this->Session->flash();?>
<div id="page-heading"><h1>Employer Specific data</h1></div>
<table class="content-table" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<th rowspan="3" class="sized"></th>
			<th class="topleft"></th>
			<td id="tbl-border-top">&nbsp;</td>
			<th class="topright"></th>
			<th rowspan="3" class="sized"></th>
		</tr>
		<tr>
			<td id="tbl-border-left"></td>
		    <td>
				<div class="content-table-inner">
					<div style="">
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
			</td>
			<td id="tbl-border-right"></td>
		</tr>
		<tr>
			<th class="sized bottomleft"></th>
			<th id="tbl-border-bottom">&nbsp;</th>
			<th class="sized bottomright"></th>
		</tr>
	</tbody>
	</table>
	<table class="content-table" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<th rowspan="3" class="sized"></th>
			<th class="topleft"></th>
			<td id="tbl-border-top">&nbsp;</td>
			<th class="topright"></th>
			<th rowspan="3" class="sized"></th>
		</tr>
		<tr>
			<td id="tbl-border-left"></td>
		    <td>
			<div style="margin:auto;clear:both;">
		    	<table class="employerListTable">
					<tr>
						<th align="center" style="width:3%" ># </th>
						<th style="width:27%">Job description</th>
						<th style="width:12%">Applicants</th>
						<th style="width:7%" >Views</th>
						<th style="width:20%" >Date Posted</th>
						<th style="width:10%" align="center" >Rewards</th>	
						<th style="width:15%" align="center">Total Reward</th>				
					</tr>
					<?php if(empty($jobs)){ ?>
					<tr>
						<td colspan="100%">Sorry, No job found.</td>
					</tr>
					<?php }else{ ?>
					<?php $sno=0; 
						foreach($jobs as $job):?>	
					<tr>
						<td align="center"><?php echo ++$sno; ?></td>
						<td>
							<a href="javascript:void(0);" onclick="jobDetail(<?php echo $job['Job']['id'] ;?>)" >
								<?php echo ucfirst($job['Job']['title']); ?>
							</a>
						</td>
						<td><?php echo $job['0']['submission']; ?></td>
						<td> <?php echo $job['0']['views'];?></td>
						<td><?php echo $job['Job']['created'];?></td>
						<td align="right" width="10%" style="padding-right:5px;">
								<?php
									echo $this->Number->format(
										 $job['Job']['reward'],
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?>
						</td>
						<td align="right" width="10%" style="padding-right:5px;">
								<?php
									echo $this->Number->format(
										 ($job['Job']['reward']* $job['0']['submission']),
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?>
						</td>
						
					</tr>
					<?php endforeach; 
						}?>			
				</table>
			</div>
			</td>			
			<td id="tbl-border-right"></td>
		</tr>
		<tr>
			<th class="sized bottomleft"></th>
			<th id="tbl-border-bottom">&nbsp;</th>
			<th class="sized bottomright"></th>
		</tr>
	</tbody>
	</table>
	
<?php
	//echo "<pre>";	print_r($companyDetail);
	//echo $this->element('sql_dump');
?>

