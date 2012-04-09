<?php echo $this->Session->flash();?>
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
	   	<td>
			<div class="content-table-inner">
				<div class="clearBoth">&nbsp;</div>
				    <table width ="100%" cellspacing='0' >
					    <tr class="usertableHeading"> 
						    <th style="padding:10px;width=5%;">SN</th> 
						    <th width="15%">Name</th>				    
						    <th width="28%">E-Mail</th>
						    <th width="12%">User Group</th>
						    <th width="15%">Telephone</th>
						    <th width="20%">User Since</th>
						    <th width="15%">Activated</th>
   						    <th width="5%"></th>
					    </tr>
    		            <tr class="<?php" > 
							<td style="padding:10px;text-align:center;" ><?php echo $sno++; ?></td> 
							<td ><?php echo $user['contact_name'];?></td> 
							<td ><a href="/admin/userDetail/id:<?echo $user['id'];?>"><?php echo $user['account_email'];?></a></td>
							<td style="text-align:center;"><?php echo $user['role'];?></td> 
							<td style="text-align:center;"><?php echo $user['contact_phone'];?></td>
							<td style="text-align:center;"><?php echo $user['created'];?></td>
							<?php if($user['is_active']==1 ):?>
								<td style="text-align:center;">Yes</td>
								<td>
								<?php  echo $html->link($html->image("test-pass-icon.png"),  array( 'action' => 'userAction','deactive:'.$user['id']), array('escape' => false)); ?>
								</td>
								<?php else:?>
								<td style="text-align:center;">No</td>
								<td>
								<?php	echo $html->link("Deactive", array('action' => 'userAction','active:'.$user['id']), array('escape' => false)); ?>
								</td>
							<?php endif; ?>
			    		</tr> 
      					<?php
	    				endforeach; 
	    			}else{
					?>	
					<tr class="odd">			
					    <td colspan="6" align="center">Sorry no result.</td>
					</tr>
					<?php
				    }
					?>
				<tr>
				    <td colspan="6" align="center">
	    	    	<?php
			  			echo $paginator->first(' << ',null, null, array("class"=>"disableText"));
						echo $this->Paginator->prev(' < ',null, null, array("class"=>"disableText"));
						echo $this->Paginator->numbers();
						echo $this->Paginator->next(' > ',null, null, array("class"=>"disableText"));
						echo $paginator->last(' >> ',null, null, array("class"=>"disableText"));
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
