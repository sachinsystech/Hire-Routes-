<?php
/**
 * Payment information for admin
 */
?>
<?php echo $this->Session->flash();?>
<div id="page-heading"><h1>Payment Information</h1></div>
<table class="content-table" border="0" cellpadding="0" cellspacing="0" width="100%">
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
		<div class="clearBoth">&nbsp;</div>
		    <table width ="100%" cellspacing='0'>
				<tr>
					<td COLSPAN="5">
						<div class="code_pagination">
							<?php /* echo $paginator->first('First '); ?>	
							<?php echo $paginator->prev('<< '.__('Previous Page', true), array(), null, array('class'=>'disabled'));?>
							< <  <?php echo $this->Paginator->numbers(); ?>  > >
							<?php echo $paginator->next(__('Next Page', true).' >>', array(), null, array('class'=>'disabled'));?>
							<?php echo $paginator->last(' Last');*/ ?>
						</div>
					</td>
				</tr>	
			    <tr class="tableHeading"> 
				    <th>Company Name</th>
				    <th>Employ Name</th>
					<th>Job title</th>
				    <th>Payment</th>
				    <th>Transection</th>
			    </tr>
                <?php 
                	if(1>0){
						$sno = 0;
                		//foreach($codes as $code):
                    	$class = $sno++%2?"odd":"even";
                ?>
				<tr class="<?php echo $class; ?>"> 
					<td align="center" width="20%">Static text1</td> 
					<td align="center" width="20%">Static text2</td> 
					<td align="center" width="20%">Static text3</td> 
					<td align="center" width="40%">Static text4</td>
					<td align="center" width="40%">Static text5</td> 
			    </tr> 
      	<?php 
	    //endforeach; 
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
		    // echo $this->Paginator->numbers(); 
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

