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
									  'options'=>array('0'=>'Filter By',COMPANY=>'Company', NETWORKER=> 'Networker', JOBSEEKER => 'Jobseeker'),
									  'class'=>'job_select_shortby',
									  'selected'=>isset($filter)?$filter:'All',));?>
    	<td id="tbl-border-left"></td>
    	<td>
			<div class="content-table-inner">
				<div class="clearBoth">&nbsp;</div>
				    <table width ="100%" cellspacing='0' class='userTable'>
				    	<tr>
				    		<th COLSPAN="8">
								<div class="code_pagination">
								<?php if($this->Paginator->numbers()){ echo $paginator->first('First '); ?>	
								<?php echo $paginator->prev('<< '.__('Previous Page', true), array(), null, array('class'=>'disabled'));?>
								<?php echo "< < ".$this->Paginator->numbers()."  > >"; ?>
								<?php echo $paginator->next(__('Next Page', true).' >>', array(), null, array('class'=>'disabled'));?>
								<?php echo $paginator->last(' Last'); }?>
								</div>
							</th>
				    	</tr>
					    <tr class="usertableHeading"> 
						    <th style="width=5%;">SN</th> 
						    <th width="15%">Name</th>				    
						    <th width="28%">E-Mail</th>
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
							<td>
								<a href="/admin/userDetail/id:<?echo $user['id'];?>">
									<?php echo $user['account_email'];?>
								</a>
							</td>
							<td style="text-align:center;"><?php echo $user['role'];?></td> 
							<td style="text-align:center;"><?php echo $user['contact_phone'];?></td>
							<td style="text-align:center;"><?php echo $user['created'];?></td>
							<?php if($user['is_active']==1 ):?>
								<td style="text-align:center;">Yes</td>
								<td>
								<?php  echo $html->link($html->image("activate.png"),  array( 'action' => 'userAction','deactive:'.$user['id']), array('escape' => false)); ?>
								</td>
								<?php else:?>
								<td style="text-align:center;">No</td>
								<td>
								<?php	echo $html->link($html->image("de-activate.jpg"), array('action' => 'userAction','active:'.$user['id']), array('escape' => false)); ?>
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
				<tr>
				    <td colspan="8" style ="padding:10px;text-align:center">
	    	    	<?php
			  			echo $this->Paginator->numbers();
					?>	
	    			</td>
				</tr>
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
