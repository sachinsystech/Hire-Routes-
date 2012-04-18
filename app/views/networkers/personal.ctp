<?php ?>

<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<?php echo $this->element('side_menu');?>
		</div>
	</div>
	<!-- left section end -->
	<!-- middle section start -->
	<div class="rightBox" >
		<!-- middle content top menu start -->
		<div class="topMenu">
			<?php echo $this->element('top_menu');?>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
		
			<div class="network_contact_middleBox">
			  <?php if(count($contacts)):?>
				<?php echo $this->Form->create('deleteContacts', array('onsubmit'=>'return checkMultipleDelete();',
																	   'url' => array('controller' => 'networkers',
																					  'action' => 'deleteContacts',
																					  
																					  ),
																	   
																	   )
											   );
				?>
				<div style="margin: auto; font-weight: bold; width: 570px; font-size: 88%;">
					<a class="button" href="/networkers/personal">All</a>
					<?php
						
						foreach($alphabets AS $alphabet=>$count){
							$class = 'button';
							$url = "/networkers/personal/alpha:$alphabet";
							$urlLink = "<a href=".$url.">". $alphabet ."</a>";
							if($startWith ==$alphabet || $count<1){
								$class = 'current';
								$urlLink = $alphabet;
							}
							?>
							<span class="<?php echo $class; ?>" > <?php echo $urlLink; ?></a> </span>
							<?php
							if($alphabet !="Z"){
								echo " | ";
							}	
						}
					?>
				</div>
				<table style="width:85%;margin: auto;" class="contacts">
					<tr>
						<th style="width:8%;text-align:center"><input type="checkbox" onclick="toggleChecked(this.checked)"></th>
						<th style="width:35%;text-align:center"> Name </th>
						<th style="width:50%;text-align:center"> E-Mail </th>
						<th style="width:7%;text-align:center"></th>
					</tr>
					<?php $i=0;?>
					
					<?php foreach($contacts AS $contact):?>	
					<tr>
						<td>
							<?php	$i++;
									echo $form->input($contact['NetworkerContact']['id'], array(
																						'label' => "$i",
																						'type'  => 'checkbox',
																						'value' => $contact['NetworkerContact']['id'],
																						'class' => 'contact_checkbox'
																						)
													  );
							?>
						</td>
						<td><?php echo $contact['NetworkerContact']['contact_name']?></td>
						<td><?php echo $contact['NetworkerContact']['contact_email']?></td>
						<td>
							<img src="/img/media/b_edit.png" alt="Edit" onclick="return edit(<?php echo $contact['NetworkerContact']['id'] ?>)" style="cursor:pointer" />
							<img src="/img/media/b_drop.png" alt="Delete" onclick="return drop(<?php echo $contact['NetworkerContact']['id'] ?>)" style="cursor:pointer" />							
						</td>
					</tr>
					<?php endforeach;?>
				</table>
				<?php echo $form->submit('Delete Selected',array('div'=>false,)); ?>
				<?php echo $form->end(); ?>
				<div style="clear:both;"></div>
				<div style="float:right;font-size: 93%;margin-right:50px">
					
				 <?php if($this->Paginator->numbers()){ echo $paginator->first('First '); ?>	
				 <?php echo $paginator->prev('<< '.__('Previous Page', true), array(), null, array('class'=>'disabled'));?>
				 < <  <?php echo $this->Paginator->numbers(array('class'=>'numbers','modulus'=>4)); ?>  > >
				 <?php echo $paginator->next(__('Next Page', true).' >>', array(), null, array('class'=>'disabled'));?>
				 <?php echo $paginator->last(' Last'); ?>
				 <?php }?>
				</div>
			  <?php else:?>
				<div class="empty_concats_msg"> No Contacts added..</div>
			  <?php endif;?>
			</div>
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->

</div>


<script>

function edit(id){
	window.location.href="/networkers/editPersonalContact/"+id;
}
function drop(ids){
	var r=confirm("Do you really want to delete this?");
	if (r==true){
		window.location.href="/networkers/deleteContacts/"+ids;
	}
	else
	{
		return false;
	}
}

function checkMultipleDelete(){
	var flag = false;
	var msg = "";
	$(".contact_checkbox").each( function() {
		if($(this).attr("checked")){
			//msg += "\n"+$(this).val();
			flag  = true;
		}
	})
	if(!flag){
		alert("You did not select any contact.");
		return false;
	}
	if(flag){
		var r = confirm("Do you really want to delete selected contact(s)?");
		if (r==true){
			window.location.href="/networkers/deleteContacts/"+ids;
		}
		else
		{
			return false;
		}
	}
}

function toggleChecked(status) {
	$(".contact_checkbox").each( function() {
		$(this).attr("checked",status);
	})
}
</script>
