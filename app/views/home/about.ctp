<?php 
	$tw_url = "#"; //"https://twitter.com//HireRoutes";
	$fb_url = "#"; //"http://www.facebook.com/HireRoutes";
	$li_url= "#";
?>
<style>
.ui-dialog-titlebar { display:none; }
.ui-dialog .ui-widget .ui-widget-content .ui-corner-all .ui-draggable .ui-resizable{
display: block;
    height: auto;
    left: 350px;
    outline: 0 none;
    position: absolute;
    top: 200px;
    visibility: visible;
    width: 510px;
    z-index: 1004;
}
	</style>
<script type="text/javascript">
$(document).ready(function(){
	$("a#close").click(function(){
		$("#about-dialog" ).dialog( "close" );
	});
	$(".team-member" ).click(function(){
		$( "#about-dialog").show();
		$( "#about-dialog").dialog({
			hide: "explode",
			width:510,
			closeOnEscape: false
		});
		$( "#about-dialog" ).parent("div").css({"height":"1282px","left":"411px","top":"330px","opacity":"0.9"});
		return false;
	});
	
});
</script>
<h1 class="title-emp">Meet the Hire Routes Team & Castlebuilders</h1>
<div id="inner">
	<div class="content"> 
	<!-- left -->
		<div class="left">
			<h2>about</h2>
			<p class="text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
		</div>
	<!-- left --> 
	<!-- right -->
	<div class="right"> 
		<!-- Team member -->
		<div class="team-member">
			<div class="about-border"> 
				<a href="#"> <img src="/images/about/about.jpg" /> <span class="link-mouseover">READ MORE</span> </a> 
			</div>
			<div class="clr"></div>
  			<!-- member-info -->
  			<div class="member-info">
				<h3>AUSTIN ROOT</h3>
				<span>Head Hire Router</span>
				<ul>
					<li class="member-twitter"> <a href="<?php echo $tw_url ;?>">twitter</a> </li>
					<li class="member-facebook"> <a href="<?php echo $fb_url ;?>">facebook</a> </li>
					<li class="member-linkedin"> <a href="#">linkedin</a> </li>
				</ul>
			</div>
			<!-- member-info --> 
		</div>
		<!-- Team member --> <!-- Team member -->
		<div class="team-member">
			<div class="about-border">
				<a href="#"> <img src="/images/about/sjat.jpg" /> <span class="link-mouseover">READ MORE</span> </a> 
			</div>
			<div class="clr"></div>
			<!-- member-info -->
			<div class="member-info">
				<h3>SACHIN</h3>
				<span>Tech. Team Member</span>
				<ul>
					<li class="member-twitter"> <a href="<?php echo $tw_url ;?>">twitter</a> </li>
					<li class="member-facebook"> <a href="<?php echo $fb_url ;?>">facebook</a> </li>
					<li class="member-linkedin"> <a href="#">linkedin</a> </li>
				</ul>
			</div>
			<!-- member-info --> 
		</div>
		<!-- Team member --> <!-- Team member -->
		<div class="team-member">
			<div class="about-border">
				<a href="#"> <img src="/images/about/about.jpg" /> <span class="link-mouseover">READ MORE</span> </a>
			</div>
			<div class="clr"></div>
			<!-- member-info -->
			<div class="member-info">
				<h3>AUSTIN ROOT</h3>
				<span>Head Hire Router</span>
				<ul>
					<li class="member-twitter"> <a href="<?php echo $tw_url ;?>">twitter</a> </li>
					<li class="member-facebook"> <a href="<?php echo $fb_url ;?>">facebook</a> </li>
					<li class="member-linkedin"> <a href="#">linkedin</a> </li>
				</ul>
			</div>
			<!-- member-info --> 
		</div>
		<!-- Team member --> <!-- Team member -->
		<div class="team-member">
			<div class="about-border">
				<a href="#"> <img src="/images/about/sjat.jpg" /> <span class="link-mouseover">READ MORE</span> </a>
			</div>
			<div class="clr"></div>
			<!-- member-info -->
			<div class="member-info">
				<h3>SACHIN</h3>
				<span>Tech. Team Member</span>
				<ul>
					<li class="member-twitter"> <a href="<?php echo $tw_url ;?>">twitter</a> </li>
					<li class="member-facebook"> <a href="<?php echo $fb_url ;?>">facebook</a> </li>
					<li class="member-linkedin"> <a href="#">linkedin</a> </li>
				</ul>
			</div>
			<!-- member-info --> 
		</div>
		<!-- Team member --> <!-- Team member -->
		<div class="team-member">
			<div class="about-border">
				<a href="#"> <img src="/images/about/about.jpg" /> <span class="link-mouseover">READ MORE</span> </a>
			</div>
			<div class="clr"></div>
			<!-- member-info -->
			<div class="member-info">
				<h3>AUSTIN ROOT</h3>
				<span>Head Hire Router</span>
				<ul>
					<li class="member-twitter"> <a href="<?php echo $tw_url ;?>">twitter</a> </li>
					<li class="member-facebook"> <a href="<?php echo $fb_url ;?>">facebook</a> </li>
					<li class="member-linkedin"> <a href="#">linkedin</a> </li>
				</ul>
			</div>
			<!-- member-info --> 
		</div>
		<!-- Team member --> <!-- Team member -->
		<div class="team-member">
			<div class="about-border">
				<a href="#"> <img src="/images/about/sjat.jpg" /> <span class="link-mouseover">READ MORE</span> </a>
			</div>
			<div class="clr"></div>
			<!-- member-info -->
			<div class="member-info">
				<h3>SACHIN </h3>
				<span>Tech. Team Member</span>
				<ul>
					<li class="member-twitter"> <a href="<?php echo $tw_url ;?>">twitter</a> </li>
					<li class="member-facebook"> <a href="<?php echo $fb_url ;?>">facebook</a> </li>
					<li class="member-linkedin"> <a href="#">linkedin</a> </li>
				</ul>
			</div>
			<!-- member-info --> 
		</div>
      </div>
      <!-- right -->
      <div class="clr"></div>
    </div>
    </div>
    <div class="clr"></div>
  </div>
  <div class="clr"></div>
</div>

<div style="display:none;" id = "about-dialog">
	 <a id="close" style="float:right;margin:-10px;">close</a>
	<p class="text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
</div>
