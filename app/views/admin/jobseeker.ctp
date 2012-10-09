<?php echo $this->Session->flash();?>
<div id="page-heading"><h1><?php echo $jobseekerCount;?> Jobseeker's</h1></div>
<?php 
     $sno = 1;
?>
<table id="content-table" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody><tr>
		<th rowspan="3" class="sized"></th>
		<th class="topleft"></th>
		<th id="tbl-border-top">&nbsp;</th>
		<th class="topright"></th>
		<th rowspan="3" class="sized"></th>
	</tr>
	<tr>
	 	<td id="tbl-border-left"></td>
    	<td>
			<div class="content-table-inner">
				<div style="float:right;margin:10px;">
					<?php
						if($this->Paginator->numbers()){ 
							echo $paginator->first('First  |'); 
							echo $paginator->prev('  '.__('Previous', true), array(), null, array('class'=>'disabled'));
							echo " < ".$this->Paginator->numbers(array('modulus'=>4))."  > ";
							echo $paginator->next(__('Next', true).' ', array(), null, array('class'=>'disabled'));
							echo $paginator->last(' |  Last'); 
						}
					?>
				</div>
				    <table width ="100%" cellspacing='0' class='userTable'>
					    <tr class="usertableHeading userTableLeftRadius" style="border:1px solid;padding:5px;"> 
						    <th width="5%" style="line-height:25px;">#</th> 
						    <th width="15%">
						    	<div><?php echo $this->Paginator->sort('Name','Jobseekers.contact_name')?></div></th>
						    <th width="24%">
						    	<div><?php echo $this->Paginator->sort('E-Mail','User.account_email')?></div>
						    </th>
							<th width="24%">
						    	<div><?php echo $this->Paginator->sort('Ancestor','Parent_User.account_email')?></div>
						    </th>
   						   	<th width="12%">
   						   		<div><?php echo $this->Paginator->sort('Telephone','Jobseekers.contact_phone')?>
   						   		</div>
   						   	</th>
						    <th width="18%">
						    	<div><?php echo $this->Paginator->sort('Created','User.created')?></div>
						    </th>
						    <th width="8%">
						    	<?php echo $this->Paginator->sort('Activated','User.is_active')?>
						    </th>
   						</tr>
	    		            <?php $page=0;
	    		            	if(isset($this->params['named']['page'])){
	    		            		$page = $this->params['named']['page']-1;
	    		            	}
								if(count($jobseekers)>0){
	    		            		foreach($jobseekers as $jobseeker):
	    		                	$class = $sno%2?"odd":"even";
	    			        ?>
						<tr class="<?php echo $class; ?>" > 
							<td style="padding:7px;text-align:center;" ><?php echo $page*10+$sno++; ?></td> 
							<td>
								<div class="employerLoginStatusBar" style="float:left;margin-top:2px" id="<?php echo "user_".$jobseeker['Jobseekers']['user_id'];?>" idfield="<?php echo $jobseeker['Jobseekers']['user_id']; ?>">	
								</div>
								<a href="/admin/jobseekerSpecificData/<?php echo $jobseeker['Jobseekers']['user_id'];?>/">
									<?php echo ucfirst($jobseeker['Jobseekers']['contact_name']);?>
								</a>
							</td> 
							<td>
								<a href="/admin/jobseekerSpecificData/<?php echo $jobseeker['Jobseekers']['user_id'];?>/">
									<?php echo $jobseeker['User']['account_email']?>
								</a>
							</td>
							<td>
								<a href="/admin/networkerSpecificData/<?php echo $jobseeker['Parent_User']['id'];?>/">
									<?php echo $jobseeker['Parent_User']['account_email']?>
								</a>
							</td>
							<td style="text-align:center;"> <?php echo $jobseeker['Jobseekers']['contact_phone'];?> </td>
							<td style="text-align:center;"> <?php echo date("m/d/Y h:m:s", strtotime( $jobseeker['User']['created']));?> </td>
							<?php if($jobseeker['User']['is_active']==1):?>
								<td style="text-align:center;">Yes</td>
							<?php else:?>
								<td style="text-align:center;">No</td>
							<?php endif; ?>
			    		</tr> 
      					<?php
	    				endforeach; 
	    			}else{
					?>	
					<tr class="odd">			
					    <td colspan="8" align="center" style="line-height: 40px;">Sorry , No result found.</td>
					</tr>
					<?php
				    }
					?>
					
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
	<?php echo $form->end();?>	
	
	
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
	setInterval('reloadLoginStatus()',30*1000);
}
reloadLoginStatus();

setTimeout(function(){
   window.location.reload(1);
}, 1000*60*2);

</script>

