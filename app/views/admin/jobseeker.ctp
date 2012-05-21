<?php echo $this->Session->flash();?>
<div id="page-heading"><h1>Jobseekers</h1></div>
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
						    <th width="30%">
						    	<div><?php echo $this->Paginator->sort('E-Mail','UserList.account_email')?></div>
						    </th>
   						   	<th width="15%">
   						   		<div><?php echo $this->Paginator->sort('Telephone','Jobseekers.contact_phone')?>
   						   		</div>
   						   	</th>
						    <th width="20%">
						    	<div><?php echo $this->Paginator->sort('Created','UserList.created')?></div>
						    </th>
						    <th width="10%">
						    	<?php echo $this->Paginator->sort('Activated','UserList.is_active')?>
						    </th>
   						</tr>
	    		            <?php 
								if(count($jobseekers)>0){
	    		            		foreach($jobseekers as $jobseeker):
	    		                	$class = $sno%2?"odd":"even";
	    			        ?>
						<tr class="<?php echo $class; ?>" > 
							<td style="padding:7px;text-align:center;" ><?php echo $sno++; ?></td> 
							<td><?php echo ucfirst($jobseeker['Jobseekers']['contact_name']);?></td> 
							<td><?php echo $jobseeker['UserList']['account_email']?></td>
							<td style="text-align:center;"> <?php echo $jobseeker['Jobseekers']['contact_phone'];?> </td>
							<td style="text-align:center;"> <?php echo $jobseeker['UserList']['created'];?> </td>
							<?php if($jobseeker['UserList']['is_active']==1):?>
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
