<?php echo $this->Session->flash();?>
<div id="page-heading"><h1>Invitation code for guest users.</h1></div>
<?php $isError =0 ;//= count($codeValue->validationErrors);  ?>
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
			<div style="text-align: center;cursor:pointer" class="flip"><span>Add New Codes</span></div>
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
									<div style="float:left;width:440px;*width:480px;">
										<?php echo $form->create('', array('action' => 'invitationCode')); ?>
										<div style="float:left;width:320px;margin: 2px;">
											<?php 
													echo $form->input( 'InvitaionCode.signups', array
																					(
																					'label'=>"<span style='float:left;margin-right: 8px;'> No. of Code</span>",
																					'type' => 'text',
																					'class' => 'code_signups_txt required number',
																					'error' => array('wrap' => 'label', 'class' => 'error'),
																					 )
														   );
											?>
										</div>
										<div style="float:right;">
											<?php  echo $form->submit('Genrate Code',array('div'=>false));   ?>
										</div>
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
				    <th>Invitation Url</th>
				    <th>Action</th>
			    </tr>
                <?php   $page=0;
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
				<!--<td align="center" width="20%"><?php echo $code["InvitaionCode"]["invitaion_code"]; ?></td>--> 
					<td width="85%">
						<input class="invitationUrl <?php echo $class; ?>" value= '<?php echo Configure::read('httpRootURL').'?inviteCode='.$code["InvitaionCode"]["invitaion_code"]; ?>' readonly="readonly">
					</td> 
					<td align="center" width="10%">
						<?php echo $this->Html->image("/img/icon/delete.png", array(
															"alt" => "D","width"=>"24","height"=>"24",
															"style"=>"margin-left:2px;",
															"url" => "/admin/invitationCodeDelete/".$code["InvitaionCode"]["id"],
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
	$(document).ready(function(){
		$("#CompaniesInvitationCodeForm").validate({
			errorClass: 'error_input_message',
			errorPlacement: function (error, element) {
				error.insertAfter(element)
				error.css({'margin-left':'103px','width':'230px'});
			}
		});
	});
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
