<div style="clear:both;margin-left:100px">
  <div>
	<?php echo $username; ?><br />
	<img src="<?php echo $profilepic; ?>" />
	<br /><br />
  </div> 
</div>

<div style="width:750px">
	<?php echo $this->Form->create('Twitter', array('url' => array('controller' => 'companies', 'action' => 'postTweet'))); ?>
	<div style="border: 1px solid;clear: both;height: 178px;overflow: auto;padding: 5px;width: 300px;">  
		<div style="float:right;width: 200px;">
			<?php $screenNameArray = array();	?>
			<?php
			  foreach($response as $friends):
				$thumb = $friends['profile_image_url'];
				$screenName = $friends['screen_name'];
				$name = $friends['name'];
				$screenNameArray[$screenName]=$name;
				?>
				<a title="<?php echo $name;?>" href="http://www.twitter.com/<?php echo $screenName;?>">
					<img class="photo-img" src="<?php echo $thumb?>" border="0" alt="" width="40" />
				</a>
				<?php echo $name;?><br>
			 <?php endforeach;
			?> 
		</div>
	</div>
	<div style="clear:both;float:left;width:150px">
		<?php	echo $form->input("SendTo", array('label' => false,
												'multiple' => 'checkbox',
												'options'=>$screenNameArray
												
												)
											 );
		?>
	</div>
</div>

<!--	End	-->
<div style="clear:both"></div>
<label>Write Comment:</label>
<div style="width:300px;clear:both">
  <div style="float:left">
	<?php	echo $form->input('msg', array('label' => '',
											'type'  => 'text',
											'class'=>'txt_bg_twiter_tweet'
											)
								 );
	?>
  </div> 
   <div style="float:right;margin-top: -11px;"><?php echo $form->submit('Send..'); ?></div>
</div>

<?php echo $form->end(); ?>