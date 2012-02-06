
<div style="margin: auto; width: 500px;">
	<?php echo $form->create('Coupon');?>
		<fieldset>
			<legend><?php __('Add Coupon');?></legend>
			<?php echo $form->input('code'); ?>	
		</fieldset>
	<?php echo $form->end('Submit');?>
</div>

<?php //echo "<pre>"; print_r($coupon); exit;?>
