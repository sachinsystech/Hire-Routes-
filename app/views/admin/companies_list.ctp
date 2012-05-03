<?php echo $this->Session->flash();?>
<div id="page-heading"><h1>Companies/Recruiters  Registration Requests </h1></div>
<?php 
     
      $sno = 1;

?>
<table id="content-table" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
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
		<div class="code_pagination">
							<?php if($this->Paginator->numbers()){?>
							<?php echo $paginator->first('First  |  '); ?>	
							<?php echo $paginator->prev('  '.__('Previous Page', true), array(), null, array('class'=>'disabled'));?>
							<  <?php echo $this->Paginator->numbers(array('modulus'=>4)); ?>  > 
							<?php echo $paginator->next(__('Next Page', true).' ', array(), null, array('class'=>'disabled'));?>
							<?php echo $paginator->last('  |  Last');?>
							<?php } ?>
		</div>
	    <table width ="100%" cellspacing='0' class="userTable">
		    <tr class="tableHeading"> 
		    	<th>SN</th>
			    <th>Company/Recruiter name</th> 
			    <th>Name</th>
			    <th>Phone</th>
			    <th>Email</th>
			    <th>Company/Recruiter</th>
			    <th>Action</th>
		    </tr>
            <?php 
               	if(count($Companies)>0){
              		foreach($Companies as $company):
            	       	$class = $sno%2?"odd":"even";
            ?>
			<tr class="<?php echo $class; ?>"> 
				<td align="center" width="3%"><?php echo $sno;?></td>
				<td width="20%" style="padding:7px;"><?php echo $company["Companies"]["company_name"]; ?></td> 
				<td width="20%"><?php echo $company["Companies"]["contact_name"]; ?></td> 
				<td align="center" width="20%"><?php echo $company["Companies"]["contact_phone"]; ?></td> 
				<td width="40%"><?php echo $company["User"]["account_email"]; ?></td> 
				<td align="center" width="10%"><?php echo $company["Companies"]["act_as"]; ?></td>
				<td align="center" width="10%"><?php echo $html->link("Accept", array('action' => 'acceptCompanyRequest',$company['Companies']['user_id']), array('escape' => false)); ?>/<?php echo $html->link("Decline", array('action' => 'declineCompanyRequest',$company['Companies']['user_id']), array('escape' => false)); ?></td>
			</tr> 
      	<?php 
      		$sno++;
	    endforeach; 
	    }else{
			?>
		<tr class="odd">			
		    <td colspan="7" align="center">Sorry no result.</td>
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
</tbody></table>
