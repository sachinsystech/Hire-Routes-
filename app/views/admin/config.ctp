<?php echo $this->Session->flash();?>
<div id="page-heading"><h1>Global Configuration</h1></div>

<div style="clear:both"></div>
<div class="configuration_content"> 
	<div style="width:340px">
		<?php echo $form->create('Config',array('url'=>array('controller'=>'admin','action'=>'config')))?>
		<div class="required" style="float:left">
			<?php
				echo $form->input('rewardPercent',array(
									'label' => 'Reward <span> <b>%</b></span>',
									'type'  => 'text',
									'class' => 'reward_pc required number',
									'value' => $rewardPercent,
									'maxlength' => '5',
									'max' =>100,
									'min' =>1,
									'after'=>'<br>'
								)
				);
			?>
		</div>
		<div style="float:right">
			<?php echo $form->submit('Save');?>
		</div>
		<?php echo $form->end();?>
	</div>
</div>		
<script>
	$(document).ready(function(){
		$("#ConfigConfigForm").validate();
	});     
</script>
