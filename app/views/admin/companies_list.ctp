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
		    	<th width="3%"> # </th>
			    <th width="12%"><?php echo $this->Paginator->sort('Employer','Companies.company_name');?></th> 
			    <th width="12%"><?php echo $this->Paginator->sort('Contact Name','Companies.contact_name')?></th>
			    <th width="18%"><?php echo $this->Paginator->sort('Site URL','Companies.company_url')?></th>
			    <th width="10%"><?php echo $this->Paginator->sort('Phone','Companies.contact_phone')?></th>
			    <th width="18%"><?php echo $this->Paginator->sort('E-Mail','Users.account_email')?></th>
			    <th width="6%">Type</th>
			    <th width="15%"><?php echo $this->Paginator->sort('Date','Users.created')?></th>
			    <th width="9%"> Action </th>
		    </tr>
            <?php $page=0;
            	if(isset($this->params['named']['page'])){
            		$page = $this->params['named']['page']-1;
            	}
               	if(count($Companies)>0){
              		foreach($Companies as $company):
            	       	$class = $sno%2?"odd":"even";
            ?>
			<tr class="<?php echo $class; ?>"> 
				<td align="center"><?php echo $page*10+$sno;?></td>
				<td style="padding:3px;"><?php echo $company["Companies"]["company_name"]; ?></td> 
				<td style="padding:3px;"><?php echo ucfirst($company["Companies"]["contact_name"]); ?></td>
				<td >
					<a href='<?php echo $company["Companies"]["company_url"]; ?>'>
						<?php echo $company["Companies"]["company_url"];?>
					</a>
				</td>
				<td align="center" ><?php echo $company["Companies"]["contact_phone"]; ?></td> 
				<td ><?php echo $company["User"]["account_email"]; ?></td> 
				<td align="center" ><?php echo $company["Companies"]["act_as"]; ?></td>
				<td align="center" ><?php echo $company["User"]["created"]; ?></td>
				<td>
					<?php echo $html->link($html->image("active.jpg",array('alt'=>'Accept','url')), array('action' => 'processCompanyRequest',$company['Companies']['user_id'],"accept"),
													 array('escape' => false, 
													 'onclick'=>"return disableLinks('accept');"));?>
					<?php echo $html->link($html->image("de-activate.jpg"), array('action' => 'processCompanyRequest',
																		$company['Companies']['user_id'],"decline"
															), 
													  array('escape' => false,
													  'onclick'=>"return disableLinks('decline');")); ?></td>
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
<script>
	function disableLinks(process){
		var ret=confirm("Do you want to "+process+" the request ?");
		$('a').attr('disabled','disabled');
		return ret;
	} 
</script>
