<?php ?>
<div style="clear:both;margin-top:5px;padding: 5px;">
					<img src="/img/mail_it.png" style="float: left;cursor:pointer" onclick='showView(4);'/>
				</div>
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
				&nbsp;
				
			</div>
		<!-- middle conyent list -->

	</div>
	<!-- middle section end -->

</div>

<?php echo $this->element('invite_friend');?>

<script>
    $(document).ready(function() {
        showView(4);
    });
</script>

