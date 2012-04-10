<?php echo $this->Session->flash();?>

<script>
	$(document).ready(function(){
		$("#short_by").change(onSelectShortByChange);
		
	});
	function onSelectShortByChange(){
	    var selected = $("#short_by option:selected");    
	    if(selected.val() != 0){
	    	window.location.href="/admin/userList/filter:"+selected.val();
	    }else{
	    	window.location.href="/admin/userList";
	    }
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
			<?php echo $form -> input('short_by',array(
									  'type'=>'select',
									  'label'=>'',
									  'options'=>array('0'=>'Filter By','company'=>'Company', 'networker'=> 'Networker', 'jobseeker' => 'Jobseeker'),
									  'class'=>'job_select_shortby',
									  'selected'=>isset($filter)?$filter:'All',));?>
		</div>
    	<td id="tbl-border-left"></td>
    	<td>
			<div class="content-table-inner">
				<div style="float:right;margin:15px;">
					<?php if($this->Paginator->numbers()){ echo $paginator->first('First '); ?>	
					<?php echo $paginator->prev('<< '.__('Previous Page', true), array(), null, array('class'=>'disabled'));?>
					<?php echo "< < ".$this->Paginator->numbers()."  > >"; ?>
					<?php echo $paginator->next(__('Next Page', true).' >>', array(), null, array('class'=>'disabled'));?>
					<?php echo $paginator->last(' Last'); }?>
					<?php 
						isset($this->params['named']['page'])?$page="page:".$this->params['named']['page']:$page="";
						isset($this->params['named']['filter'])?$filter="filter:".$this->params['named']['filter']:$filter="";
					?>
				</div>
				    <table width ="100%" cellspacing='0' class='userTable'>
				    	<tr>
				    		<th COLSPAN="8">
								
							</th>
				    	</tr>
					    <tr class="usertableHeading"> 
						    <th width="5%">SN</th> 
						    <th width="12%">Name</th>				    
						    <th width="25%">E-Mail</th>
						    <th width="12%">User Group</th>
						    <th width="15%">Telephone</th>
						    <th width="20%"><?php echo $this->Paginator->sort('User Since','UserList.created')?></th>
						    <th width="15%"><?php echo $this->Paginator->sort('User Activated','UserList.is_active')?></th>
   						    <th width="5%"></th>
					    </tr>
    		            <?php 
							if(count($userArray)>0){
    		            		foreach($userArray as $user):
    		                	$class = $sno%2?"odd":"even";
    			        ?>
						<tr class="<?php echo $class; ?>" > 
							<td style="padding:10px;text-align:center;" ><?php echo $sno++; ?></td> 
							<td><?php echo $user['contact_name'];?></td> 
							<?php if($user['account_email']=='fb'):
											echo "<td title='Facebook User'> </td>";
								  else:
							?>
							<td>
								
								<?php echo $user['account_email']?>
								
							</td>
							<? endif;?>
							<td style="text-align:center;"> <?php echo $user['role'];?> </td> 
							<td style="text-align:center;"> <?php echo $user['contact_phone'];?> </td>
							<td style="text-align:center;"> <?php echo $user['created'];?> </td>
							<?php if($user['is_active']==1 ):?>
								<td style="text-align:center;">Yes</td>
								<td>
								<?php  echo $html->link($html->image("de-activate.jpg"),  array( 'action' => 'userAction','deactive:'.$user['id'],$page,$filter), array('escape' => false,'title'=>'De-Activate','onclick'=>"return confirm('Do you want to de-activate this account ?');")); ?>
								</td>
								<?php else:?>
								<td style="text-align:center;">No</td>
								<td>
								<?php	echo $html->link($html->image("activate.png"), array('action' => 'userAction','active:'.$user['id'],$page,$filter), array('escape' => false,'title'=>'Activate','onclick'=>"return confirm('Do you want to activate this account ?');")); ?>
								</td>
							<?php endif; ?>
			    		</tr> 
      					<?php
	    				endforeach; 
	    			}else{
					?>	
					<tr class="odd">			
					    <td colspan="8" align="center">Sorry no result.</td>
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
