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
.ui-widget-overlay{
    background: none repeat scroll 0 0 #000000;
    opacity: 0.6;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$("a#close").click(function(){
		$("#about-dialog" ).dialog( "close" );
		return false;
	});
	$("#read-more-austin" ).click(function(){
		$( "#about-dialog").show();
		$( "#about-dialog").dialog({
			hide: "explode",
			width:548,
			height:1000,
			closeOnEscape: false,
			modal:true,
		});
		$( "#about-dialog" ).parent("div").css({"padding":"0","margin":"50px 0px 0px 0px","opacity":"0.9","height":"1000px","top":"0","width":"581px", "background":"none","border":"none"});
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
			<p class="text">Hire Routes was originally conceived on a napkin in Fanelli Cafe - a rustic landmark pub nestled in the historic Soho district of New York City - back in April of 2011.  While enjoying their fine pints of Guinness the founder of Hire Routes began discussing an idea with a friend on how to monetize social networks by helping others.  Scribbling down his idea on the napkin he described how a website could help people connect to others and how it could really harness the power of social networks via email, LinkedIn, Facebook, and Twitter by reaching people beyond that first degree of separation. 
That idea has since then evolved into what you see today; a social recruiting website that provides companies and recruiters with a platform that allows them to really harness the power of social networks by posting jobs with cash rewards and sharing those jobs with their own personal and professional networks as well as with new, select and otherwise inaccessible networks being built here at Hire Routes. 
Hire Routes wants to build the world's largest hub of networkers to help companies find and hire the best talent for them.  Please help us build a strong global network and let's get everyone working again and reduce unemployment!.</p>
		</div>
	<!-- left --> 
	<!-- right -->
	<div class="right"> 
		<!-- Team member -->
		<div class="team-member">
			<div class="about-border" id="read-more-austin"> 
				<a href="#"> <img src="/images/about/about.jpg" /> <span class="link-mouseover">READ MORE</span> </a> 
			</div>
			<div class="clr"></div>
  			<!-- member-info -->
  			<div class="member-info">
				<h3>AUSTIN ROOT</h3>
				<span>Head Hire Router</span>
				<ul>
					<li class="member-twitter"> <a href="https://www.twitter.com/aroot1977" class="NewTab">twitter</a> </li>
					<li class="member-facebook"> <a href="https://www.facebook.com/aroot1977" class="NewTab">facebook</a> </li>
					<li class="member-linkedin"> <a href="https://www.linkedin.com/pub/austin-root/8/b29/163" class="NewTab">linkedin</a> </li>
				</ul>
			</div>
			<!-- member-info --> 
		</div>
		<!-- Team member --> <!-- Team member -->
		<div class="team-member">
			<div class="about-border" >
				<a href="#"> <img src="/images/about/Tim_img.jpg" /><!--<span class="link-mouseover">READ MORE</span> --></a> 
			</div>
			<div class="clr"></div>
			<!-- member-info -->
			<div class="member-info">
				<h3>TIM RODGERS</h3>
				<span></span>
				<ul>
					<li class="member-twitter"> <a href="http://www.twitter.com/timnotjim" class="NewTab">twitter</a> </li>
					<li class="member-facebook"> <a href="http://www.facebook.com/timnotjim" class="NewTab">facebook</a> </li>
					<li class="member-linkedin"> <a href="http://www.linkedin.com/in/timnotjim" class="NewTab">linkedin</a> </li>
				</ul>
			</div>
			<!-- member-info --> 
		</div>
		<!-- Team member --> <!-- Team member -->
		<div class="team-member">
			<div class="about-border">
				<a href="#"> <img src="/images/about/sjat.jpg" /><!-- <span class="link-mouseover">READ MORE</span>--></a>
			</div>
			<div class="clr"></div>
			<!-- member-info -->
			<div class="member-info">
				<h3>SACHIN</h3>
				<span>Tech. Team Member</span>
				<ul>
					<li class="member-twitter"> <a href="<?php echo $tw_url ;?>" class="NewTab">twitter</a> </li>
					<li class="member-facebook"> <a href="<?php echo $fb_url ;?>" class="NewTab">facebook</a> </li>
					<li class="member-linkedin"> <a href="#" class="NewTab">linkedin</a> </li>
				</ul>
			</div>
			<!-- member-info --> 
		</div>
		<!-- Team member --> <!-- Team member -->
		
      <!-- right -->
      <div class="clr"></div>
    </div>
    </div>
    <div class="clr"></div>
  </div>
  <div class="clr"></div>
</div>
<style>
	#about-dialog{
		padding: 0 !impotant;
		height:1100px;
		overflow:hidden;
	}
	.about_popup_cancel_bttn {
		background: url("../images/popup_cancel_bttn.png") no-repeat scroll 0 0 transparent;
		height: 72px;
		position: absolute;
		right: -33px;
		top: -14px;
		width: 72px;
	}
</style>

<div style="display:none;" id = "about-dialog">
	<div class="about_popup">
    	<div class="about_popup_cancel_bttn_row">
        	<div class="about_popup_cancel_bttn"><a href="#" id="close"></a></div>
        </div>
            <div class="about_popup_img_row">
            	<div class="about_popup_img"><img src="images/about.jpg" alt="" border="0" /></div>
                <h2>AUSTIN ROOT</h2>
                <p>- Head Hire Router</p>
                <p class="space2">We are based in New rough any of your active channels. Take the Hire routes to get where you're going. Take the Hire routes to get where. We are based in New York but we live online.</p>
                
                <h3>Hire Routes Role:</h3>
                <p>Honestly, I feel it's different everyday but I generally just try to keep people going, keep them happy, help them out when I can and just keep on innovating</p>
                
                <h3>Inspirations:</h3>
                <p>My friends and family keep me going and from the long list of historical figures.....mmmm.... I would have to go with Leonardo da Vinci and Lao- Tzu.</p>
				
                <h3>Favorite Quote:</h3>
                <p>"Humility is the solid foundation of all Virtues." - Confucius </p>
                
                <h3>Favorite Books:</h3>
                <p>"The Count of Monte Cristo","The Fountain Head" and "The Catcher in the Rye"</p>

				<h3>What you love:</h3>
                <p>People, soccer, sweating to some form of physical activity, food & drink and exploring exciting new cultures and all the marvelous places this wonderful world of ours has to offer.</p>
                
                <div class="clr"></div>
            </div>
        <div class="clr"></div>
    </div>
</div>
