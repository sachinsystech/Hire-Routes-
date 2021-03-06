<?php echo $this->Session->flash();?>
<?php echo $html->css('datepicker');?>
<script>
	$(document).ready(function(){
		$("#UserListFilter").change(onSelectShortByChange);
	});
	function onSelectShortByChange(){
	    var selected = $("#UserListFilter option:selected");   
	    if(selected.val() == 0){
	    	window.location.href="/admin/userList";
	    }
	}	
	function onDelete(id,userSate)
	{	
		var state;
		if(userSate==0)
			state=confirm('Do you want to De-activate user ?');
		if(userSate==1)
			state=confirm('Do you want to Activate user ?');
		if(state){
		
			$.ajax({
				url: "/admin/userAction",
				type: "post",
				async: false,
				data:{userId:id,action:userSate},
				success: function(response){
					window.location.reload();
				},
				error:function(response)
				{	alert("error");
				
				}
			});
		}
		return false;
	}

</script>
<script>
	$('document').ready(function(){
		$("#from_date").datepicker({ minDate: new Date(2012,0,1), maxDate:'+0'});
		$("#to_Date").datepicker({ minDate: new Date(2012,0,1), maxDate:'+0'});
	});
</script>
<script type='text/javascript'>	
	function validateDate(datefield)
	{
		var date1=datefield.value.split('/');
		if(date1.length==3&&date1[2].match('\^2[0-9]{3}\$')&&date1[0].match('\^[0-1]{1}[0-9]{1}\$')&&date1[1].match('\^[0-3]{1}[0-9]{1}\$'))
		{
			return true;
		}
		else
		{
			alert('Invalid Date');
			datefield.value="";
			datefield.focus();
			return false;
		}
	}
	
	function validateDateRange(from,to)
	{
		date1=from.value.split('/');
		date2=to.value.split('/');
		var from_date=new Date(date1[2],date1[0],date1[1]);
		var to_date= new Date(date2[2],date2[0],date2[1]);
		if(from_date>to_date)
		{
			alert("Invalid period");
			return false;
		}
		return true;
	}

	function validateForm()
	{
		var from_date=document.getElementById('from_date');
		var to_date=document.getElementById('to_date');
		if(from_date.value==""||to_date.value=="")
		{
		}
		else
		{
			if(validateDate(from_date)&&validateDate(to_date)&&validateDateRange(from_date,to_date))
				return true;
			else
				return false;
		}
	}
	function clear_fields(){
		$('select, :text').val("");
		return false;
	}
</script>
<div id="page-heading"><h1>User List </h1></div>
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
		<div style="float:left;">
			<?php echo $form->create('UserList',array('url'=>array('controller'=>'admin','action'=>'userList'),
														'type'=>"get"),
												array('onsubmit'=>'return validateForm();'))?>
		</div>
    	<td id="tbl-border-left"></td>
    	<td>
			<div class="content-table-inner">
				<div style="float:right;margin:10px;">
					<?php
						/*
						$date = new DateTime();
						$date->modify(-30 . ' days');
						$last_month= $date->format("m/d/Y");
						*/
						//$from_date=isset($from_date)?$from_date:"";
						//$to_date=isset($to_date)?$to_date:"";
						$findUrl=array("contact_name"=>isset($contact_name)?$contact_name:"",
									   "contact_phone"=>isset($contact_phone)?$contact_phone:"",
									   "account_email"=>isset($account_email)?$account_email:"",
									   "from_date"=>isset($from_date)?date("Ymd",strtotime($from_date)):"",
									   "to_date"=>isset($to_date)?date("Ymd",strtotime($to_date)):"",
									   "page"=>isset($this->params['named']['page'])?$this->params['named']['page']:"1",
									   "isActivated"=>isset($isActivated)?$isActivated:"",
									   "filter"=>isset($filter)?$filter:""
									   );
					
						if($this->Paginator->numbers()){ 
							$this->Paginator->options(array('url' =>$findUrl));
							echo $paginator->first('First  |'); 
							echo $paginator->prev('  '.__('Previous', true), array(), null, array('class'=>'disabled'));
							echo " < ".$this->Paginator->numbers(array('modulus'=>4))."  > ";
							echo $paginator->next(__('Next', true).' ', array(), null, array('class'=>'disabled'));
							echo $paginator->last(' |  Last'); 
						}
						isset($this->params['named']['page'])?$pageRedirect="page:".$this->params['named']['page']:$pageRedirect="";	
						isset($this->params['named']['filter'])?$filterRedierct="filter:".$this->params['named']['filter']:$filterRedierct="";
					?>
				</div>
				    <table width ="100%" cellspacing='0' class='userTable'>
					    <tr class="usertableHeading userTableLeftRadius" style="border:1px solid;"> 
						    <th width="5%">#</th> 
						    <th width="12%">Name</th>
						    <th width="25%">
						    	<div><?php echo $this->Paginator->sort('E-Mail','UserList.account_email')?></div>
						    </th>
   						    <th width="12%">Group</th>
   						    <th width="12%">Signup</th>
   						    <th width="15%">Telephone</th>
   						    <th width="10%">Network</th>
						    <th width="20%">
						    	<div><?php echo $this->Paginator->sort('Created','UserList.created')?></div>
						    </th>
						    <th width="15%">
						    	<?php echo $this->Paginator->sort('Activated','UserList.is_active')?>
						    </th>
   						    <th></th>						    						    						    
						</tr>
						<tr class="usertableHeading" style="border:1px solid;"> 
							<th></th>
							<th>

						   	<?php
								echo $form->input(" ",array("name"=>"contact_name",
														"value"=>isset($contact_name)?$contact_name:"",
														"class"=>'text_field_employee',
														"title"=>'Enter Name',
												));
							?>
						    </th>				    
						    <th width="25%">
						    <?php
						    echo $form->input("",array("name"=>"account_email",
												   	   "value"=>isset($account_email)?$account_email:"",
													   "class"=>'text_field_employee',
													   "style"=>'width:200px;',
													   "title"=>'Enter Email',	
											));
						    
						    ?>
						    </th>
						    <th width="10%">
						    	<?php echo $form -> input('',array(
									  'type'=>'select',
									  'label'=>'',
									  'name'=>'filter',
									  'options'=>array(
									  				   'company'=>'Company',
									  				   'networker'=> 'Networker',
									  				   'jobseeker' => 'Jobseeker'),
									  'empty'=>'Select',
									  'style'=>"width:94px",
									  'class'=>'job_select_shortby',
									  'selected'=>isset($filter)?$filter:'All',));
								?>
						    </th>
						    <th></th>
						    <th width="15%">
						    <?php
								echo $form->input("",array("name"=>"contact_phone",
												   	   "value"=>isset($contact_phone)?$contact_phone:"",
													   "class"=>'text_field_employee',
													   "title"=>'Enter Contact Number',
											));
							?>
						    </th>
						    <th></th>
						    <th width="20%">
						    	<div>
						    		<center>	
							    		<div style="margin-left:10px;float:left;">
											<font size='2px'>From:</font>
										</div>
										<div style="width:130px;">
											<?php 
												echo $this->Form->input('',array('name'=>'from_date',
																'type'=>'text',
																'id'=>'from_date',
																'readonly'=>"true",
																'class' => 'date_field_employee',
																'title'=>'From Date',
																'value'=>isset($from_date)?date("m/d/Y",strtotime($from_date)):""
															));
											?>
										</div>
										<div style="margin-left:10px;float:left;clear:both;width:35px;">
											<?php echo "<font size='2px'>To:</font>";?>
										</div>
										<div style="width:130px;">
										<?php 
											echo $this->Form->input('',array(
															'id'=>'to_Date',
															'name'=>'to_date',
															'type'=>'text',
															'readonly'=>"true",
															'class' => 'date_field_employee',
															'title'=>'To Date',
															'value'=>isset($to_date)?date("m/d/Y",strtotime($to_date)):"",	
															));
										?>
										</div>
									</center>
								</div>  
							</th>
							<th>
								<?php echo $form -> input('',array(
												  'type'=>'select',
												  'name'=>'isActivated',
												  'options'=>array('activated'=>'Activated',
												  				   'deactivated'=> 'Deactivated',
												  				   ),
												  'empty'=>'Select',
												  'style'=>"width:105px",
												  'class'=>'job_select_shortby',
												  'selected'=>isset($isActivated)?$isActivated:'All',));
								?>
							</th>
	   						<th width="5%">
	   						    <?php
									echo $form->submit("Find", array('name'=>'find','class'=>'button_field div_hover',
															 'style'=>'width:40px;height:20px')); 
									
								?>
								<button class="button_field div_hover" style="width:40px;height:20px;" 
								onclick="return clear_fields();">Clear</button>
	   						</th>
						</tr>
	    		            <?php 
		    		            $page=0;
	    		            	if(isset($this->params['named']['page'])){
	    		            		$page = $this->params['named']['page']-1;
	    		            	}
								if(count($userArray)>0){
	    		            		foreach($userArray as $user):
	    		                	$class = $sno%2?"odd":"even";
	    			        ?>
						<tr class="<?php echo $class; ?>" > 
							<td style="padding:7px;text-align:center;" ><?php echo $page*10+$sno++;?>
							
							</td>
							<?php
								switch($user['role_id']){
									case COMPANY:
											$urlspecUrlLink = '/employerSpecificData';
											break;
									case JOBSEEKER:
											$urlspecUrlLink = '/jobseekerSpecificData';
											break;
									case NETWORKER:
											$urlspecUrlLink = '/networkerSpecificData';
											break;
								}
							?>
							<td>
								<div class="employerLoginStatusBar" style="float:left;margin-top:2px" id="<?php echo "user_".$user['id'];?>" idfield="<?php echo $user['id']; ?>">	
								</div>
								
								<a href="/admin<?php echo $urlspecUrlLink."/".$user['id'];?>/">
									<?php echo ucfirst($user['contact_name']);?>
								</a>
							</td> 
							<td>
								<a href="/admin<?php echo $urlspecUrlLink."/".$user['id'];?>/">
									<?php echo $user['account_email']?>
								</a>	
							</td>
							<td style="text-align:center;"> <?php echo $user['role'];?> </td> 
							<td style="text-align:center;"> <?php echo $user['sinup_source'];?> </td> 
							<td style="text-align:center;"> <?php echo $user['contact_phone'];?> </td>
							<td style="text-align:center;"> <?php echo $user['networkCount'];?> </td>
							<td style="text-align:center;"> <?php echo $user['created'];?> </td>
							<?php if($user['is_active']==1 ):?>
								<td style="text-align:center;">Yes</td>
								<td>
								<?php  echo $html->link($html->image("de-activate.jpg"), 'javascript:void(0)', array('escape' => false,'title'=>'De-Activate','onclick'=>"return onDelete($user[id],'0')"));
								?>
					
								</td>
								<?php else:?>
								<td style="text-align:center;">No</td>
								<td>
								<?php	echo $html->link($html->image("activate.png"),'javascript:void(0)',array('escape' => false,'title'=>'Activate','onclick'=>"return onDelete($user[id],'1')")); ?>
			
							<?php endif; ?>
			    		</tr> 
      					<?php
	    				endforeach; 
	    			}else{
					?>	
					<tr class="odd">			
					    <td colspan="10" align="center" style="line-height: 40px;">Sorry , No result found.</td>
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
