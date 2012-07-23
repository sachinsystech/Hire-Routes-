<div class="dataBorder">
	<div class="invitationData">
		<?php if(empty($invitations)){ ?>
			<div style="height:30px;font-size:16px;padding:5px;text-align:center;">
				No invitations exits.
			</div>
		<?php }else {?>
			<?php
				if (count($invitations)>0) {
					 /* Display paging info */
			?>
			<div id="pagination">
				<div class="NSDataPaginatorBar" style="width: 500px;">
				<?php
					$this->Paginator->options(array('url' =>array($invitations[0]['Invitation']['user_id'])));
					if($this->Paginator->numbers()):
						echo $paginator->first('First  |');
						echo $paginator->prev('  '.__('Previous', true), array(),null,array('class'=>'disabled'));
						echo " < ".$this->Paginator->numbers(array('modulus'=>4))."  > "; 
						echo $paginator->next(__('Next', true).' ', array(), null, array('class'=>'disabled'));
						echo $paginator->last(' |  Last');
					endif;
				?>
				</div>
			</div>
			<div class ="invitaionHeading">
				<div class="invitedName" style="text-align:center">
					<?php echo $paginator->sort('Name / Email','name_email')?>
				</div>
				<div class="invitedSource" >
					<?php echo $paginator->sort('Invitation Source','from');?>
				</div>
				<div class="inviteCreated">
					<?php echo $paginator->sort('Invited','created');?>
				</div>
			</div>
			<?php $count=1;?>
			<?php  foreach($invitations as $key => $data){
			?>
			<div class="dataBar <?php if($count%2==0) echo 'even'; else echo 'odd'; ?>" >
				<div class = "invitedName"> 
					<?php echo $data['Invitation']['name_email']?>
				</div>
				<div class = "invitedSource ">
					<?php echo $data['Invitation']['from']?>
				</div>
				<div class="inviteCreated ">
					<?php echo $data['Invitation']['created']?>
				</div>
			</div>
			<?php $count++;?>
			<?php } 
			?>
			</div>
		<?php }?>
			<div id="imageList">

			</div> 	
	<?php }?>			
	</div>
</div>

