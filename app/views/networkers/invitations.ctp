<h2>INVITATIONS</h2>
<?php if($this->Paginator->numbers()){?>
<div id="pagination">
	<div class="networker_right_invitaion_pagination">
		<div>
			<?php echo $paginator->first("<<",array("class"=>"arrow_margin" )); ?>	
	  
		<ul>
			<?php echo $this->Paginator->numbers(array('modulus'=>8,
														'tag'=>'li',
														'separator'=>false,)); ?>
		</ul>
			<?php echo $paginator->last(">>", array("class"=>"arrow_margin",
													));?>
		</div>
	</div>
	<div class="networker_invitaion_preview_bttn"><?php echo $paginator->prev('  '.__('', true), array(), null, array('class'=>'disabled'));?></div>
	<div class="networker_invitaion_next_bttn"><?php echo $paginator->next(__('', true).' ', array(), null, array('class'=>'disabled'));?></div>
</div>
<?php } ?> 
<div class="clr"></div>
<div class="job-list-head invitaionHeading">
<ul class="job-list-heading job-list-head-margin">
	<li class="job-list-name"><?php echo $paginator->sort('NAME/EMAIL','name_email')?></li>
    <li class="job-list-status"><?php echo $paginator->sort('STATUS','from');?></li>
    <li class="job-list-origin"><?php echo $paginator->sort('ORIGIN','created');?></li>
</ul>
</div>
<?php $i=0;
	$status = array("Pending","Accepted");
?>
<?php foreach($invitations AS $contact):?>	
<div class="job-list-subhead">
    <ul class="job-list-subcontent" >
       	<li class="<?php if($i%2==0) echo'dark';?>"><?php echo $contact['Invitation']['name_email']?></li>
		<li class="center-align <?php if($i%2==0) echo'dark';?>">
		<?php echo $status[ $contact['Invitation']['status'] ]; ?></li>
		<li class="margin-last-child-job <?php if($i%2==0) echo'dark';?>"><?php echo $contact['Invitation']['from']?></li>
		
	</ul>
</div>
<?php $i++;?>
<?php endforeach;?>
<?php	if($invitations == null){?>
<div class="job-list-subhead">
    <div class="inviation-message job-empty-message" style="width:400px;">
    	You have not invited any of your friends yet. 
    </div>
</div>
<?php	} ?>

