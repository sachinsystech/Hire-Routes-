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
			  <?php if(count($invitations)):?>
				<?php echo $this->Form->create('invitations');
				?>
				<div style="margin: auto; font-weight: bold; width: 570px; font-size: 88%;">
					<a class="button" href="/companies/invitations">All</a>
					<?php
						
						foreach($alphabets AS $alphabet=>$count){
							$class = 'button';
							$url = "/companies/invitations/alpha:$alphabet";
							$urlLink = "<a href=".$url.">". $alphabet ."</a>";
							if($startWith ==$alphabet || $count<1){
								$class = 'current';
								$urlLink = $alphabet;
							}
							?>
							<span class="<?php echo $class; ?>" style="font-size:13px"> <?php echo $urlLink; ?></a> </span>
							<?php
							if($alphabet !="Z"){
								echo " | ";
							}	
						}
					?>
				</div>
				<?php
					$status = array("Pending","Accepted");
				?>
				<table style="width:85%;margin: auto;" class="contacts">
					<tr>
						<th style="width:10%;text-align:center">#</th>
						<th style="width:35%;text-align:center"> Name / E-mail </th>
						<th style="width:35%;text-align:center"> From </th>
						<th style="width:20%;text-align:center">Status</th>
					</tr>
					<?php $i=0;?>
					
					<?php foreach($invitations AS $contact):?>	
					<tr>
						<td>
							<?php $i++;echo $i;
							?>
						</td>
						<td><?php echo $contact['Invitation']['name_email']?></td>
						<td><?php echo $contact['Invitation']['from']?></td>
						<td><?php echo $status[ $contact['Invitation']['status'] ]; ?></td>
					</tr>
					<?php endforeach;?>
				</table>
				<?php echo $form->end(); ?>
				<div style="clear:both;"></div>
				<div style="float:right;font-size: 93%;margin-right:50px">
					
				 <?php if($this->Paginator->numbers()){ echo $paginator->first('First '); ?>	
					 <?php echo $paginator->prev('<< '.__('Previous', true), array(), null, array('class'=>'disabled'));?>
					 < <  <?php echo $this->Paginator->numbers(array('class'=>'numbers','modulus'=>4)); ?>  > >
					 <?php echo $paginator->next(__('Next', true).' >>', array(), null, array('class'=>'disabled'));?>
					 <?php echo $paginator->last(' Last'); ?>
					 <?php 
				 }?>
				</div>
			  <?php else:?>
				<div class="empty_concats_msg"> No Contacts added..</div> 
			  <?php endif;?>
			</div>
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->

</div>

