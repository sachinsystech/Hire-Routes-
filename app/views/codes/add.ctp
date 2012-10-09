<?php echo $this->Session->flash();?>
<div id="page-heading"><h1>Code For User Sign-Up Request</h1></div>
<?php $isError = count($codeValue->validationErrors);  ?>
<div style="clear:both"></div>

<!--		Start Code-Generat-Form		-->


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
			<div style="text-align: center;cursor:pointer" class="flip">Add New Code</div>
			<?php
				$display = "";
				if(!$isError){
					$display="display:none";
				}	
			?>
			<div class="content-table-inner panel" style="<?php echo $display; ?>" >
				<div class="clearBoth">&nbsp;</div>
					<table width ="100%" cellspacing='0' >
						<tr>			
							<td>
								<div>
									<div style="float:left">
										<?php echo $form->create('Code', array('action' => '/add','onsubmit'=>'return checkSubmitForm();')); ?>
										<div style="float:left;width:300px;margin: 2px;">
											<?php 
													$userType = array('Jobseeker'=>"Jobseeker",'Networker'=>"Networker");
													echo $form->input( 'user_type', array
																						(
																						'label'=>"<span style='float:left;margin-right: 5px;'> User Type ",	
																						'type' => 'select',
																						'options' => $userType,
																						'empty' => 'Select',
																						'class' => 'code_user_select_box',
																						'error' => array('wrap' => 'span', 'class' => 'code_page_error')
																						 )
														   );
											?>
										</div>
										<div style="clear:both"></div>
										<div style="float:left;width:320px;margin: 2px;">
											<?php 
													echo $form->input( 'signups', array
																					(
																					'label'=>"<span style='float:left;margin-right: 8px;'> Signups ",
																					'type' => 'text',
																					'class' => 'code_signups_txt',
																					'error' => array('wrap' => 'span', 'class' => 'code_page_error'),
																					'title' => 'No. of Signups'
																					 )
														   );
											?>
										</div>
										<div style="clear:both"></div>
										<div style="float:left;width:320px;margin: 2px;">
											<?php 
													echo $form->input( 'code', array
																					(
																					'label'=>"<span style='float:left;margin-right: 8px;'> Code ",	
																					'type' => 'text',
																					'class' => 'code_restrict',
																					'error' => array('wrap' => 'span', 'class' => 'code_page_error')
																					 )
														   );
											?>
										</div>
										<div style="clear:both"></div>									
										
									</div>
									<div style="float:left">
										<?php  echo $form->submit('Add Code',array('div'=>false));   ?>
										<?php echo $form->end(); ?>
									</div>	
								</div>
								
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
<!--		End Code-Generat-Form		-->

<div class="table_seperator"></div>
	


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
		<div style="float:right;margin:5px;">
							<?php if($this->Paginator->numbers()){ echo $paginator->first('First |  '); ?>	
							<?php echo $paginator->prev('  '.__('Previous Page', true), array(), null, array('class'=>'disabled'));?>
							 <  <?php echo $this->Paginator->numbers(array('modulus'=>4)); ?>  >
							<?php echo $paginator->next(__('Next Page', true).'  ', array(), null, array('class'=>'disabled'));?>
							<?php echo $paginator->last('  |  Last'); }?>
		</div>
		    <table width ="100%" cellspacing='0' class="userTable">
				
			    <tr class="tableHeading">
			    	<th>#</th> 
				    <th>User Type</th>
				    <th>No of Sign-Ups</th>
					<th>Remaining Sign-Ups</th>
				    <th>Code</th>
				    <th>Action</th>
			    </tr>
                <?php 
                 	$page=0;
					if(isset($this->params['named']['page'])){
						$page = $this->params['named']['page']-1;
					}
                	if(count($codes)>0){
						$sno = 0;
                		foreach($codes as $code):
                    	$class = $sno++%2?"odd":"even";
                ?>
				<tr class="<?php echo $class; ?>"> 
					<td align="center" width="5%"><?php echo $page*10+$sno;?></td>
					<td align="center" width="20%"><?php echo $code["Code"]["user_type"]; ?></td> 
					<td align="center" width="20%"><?php echo $code["Code"]["signups"]; ?></td> 
					<td align="center" width="20%"><?php echo $code["Code"]["remianing_signups"]; ?></td> 
					<td align="center" width="40%"><?php echo $code["Code"]["code"]; ?></td> 
					<td align="center" width="10%">
						<?php echo $this->Html->image("/img/icon/delete.png", array(
															"alt" => "D","width"=>"24","height"=>"24",
															"style"=>"margin-left:2px;",
															"url" => "/codes/delete/".$code["Code"]["id"],
															"onclick" => "return drop();",
															));;
						?>
					</td>
			    </tr> 
      	<?php 
	    endforeach; 
	    }else{
			?>
			
	<tr class="odd">			
	    <td colspan="6" align="center" style="line-height: 30px;">Sorry no result.</td>
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

<script>
function checkSubmitForm(){
}
function drop(){
	var r=confirm("Do you really want to delete this?");
	if (!r){
		return false;
	}
}
$(document).ready(function(){
	$(".flip").click(function(){
		$(".panel").slideToggle("slow");
	});
});	

</script>
