<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Admin | <?php echo $title_for_layout; ?></title>
<link rel="stylesheet" href="/css/screen.css" type="text/css" media="screen" title="default">
<!--[if IE]>
<link rel="stylesheet" media="all" type="text/css" href="css/pro_dropline_ie.css" />
<![endif]-->

<?php
	echo $html->meta('icon', 'favicon.ico');
	
	echo $html->css('screen');
	echo $html->css('jquery-ui-1.8.18.custom');
	
	echo $html->script('admin.js');
	echo $html->script('jquery_min.js');	
	echo $html->script('jquery-ui.min.js');
	echo $html->script('jquery.validate.js');
?>
<script>
	function hideMessage(){
		$('.message').delay(5000).animate({ height: 'toggle', opacity: 'toggle' }, 'slow').hide('.message');
		$('.success').delay(5000).animate({ height: 'toggle', opacity: 'toggle' }, 'slow').hide('.success');
		$('.warning').delay(5000).animate({ height: 'toggle', opacity: 'toggle' }, 'slow').hide('.warning');
	}
	$(document).ready(function(){
			$('.NewTab').click(function() {
    	    $(this).target = "_blank";
    	    window.open($(this).prop('href'));
    	    return false;
	   });
	
	});
</script>

</head>
<body onload="hideMessage();"> 
<!-- Start: page-top-outer -->
<div id="page-top-outer">    

<!-- Start: page-top -->
<div id="page-top">
<style>
.nav li ul {
    display: none;
    width: 154px;
}
</style>
	<!-- start logo -->
	<div id="logo">
		Hire Routes
	</div>
	<?php if($this->Session->read('Auth.User.id')==1):?>
	
	<?php endif;?>
	<!--<div class="logoutClass"><?php echo $databaseMenus->auth_links(); ?></div>-->
	<!-- end logo -->
	<div class="logoutClass">admin&nbsp;| <a href="/users/logout">Logout</a></div>
	
	<!--  start top-search -->
	
 	<!--  end top-search -->
 	<div class="clear"></div>

</div>
<!-- End: page-top -->

</div>
<!-- End: page-top-outer -->
	
<div class="clear">&nbsp;</div>
 
<!--  start nav-outer-repeat................................................................................................. START -->
<div class="nav-outer-repeat"> 
<!--  start nav-outer -->
<div class="nav-outer"> 

		<!-- start nav-right -->
		
		<!-- end nav-right -->

        
		<!--  start nav -->
		<div class="nav">
		<div class="table">
		<ul class="<?php echo $this->params['action']=='adminHome'?'current':'select'; ?>"><li><a href="/admin"><b>Home</b><!--[if IE 7]><!--></a><!--<![endif]-->

		</li>
		</ul>

		<div class="nav-divider">&nbsp;</div>
		                    
		<ul class="<?php echo $this->params['controller']=='sliders' && $this->params['action']=='add'?'current':'select'; ?>">
			<li><a href="/admin/companiesList"><b>Employer Request</b><!--[if IE 7]><!--></a><!--<![endif]-->

		</ul>
		
		<div class="nav-divider">&nbsp;</div>
		
		<ul class="<?php echo $this->params['controller']=='howto' ?'current':'select'; ?>">
			<li><a ><b>Code</b></a>
				<ul>
					<li><a href="/admin/codes/"><b>Registration Code</b><!--[if IE 7]><!--></a><!--<![endif]--></li>
					<li><a href="/admin/invitationCode/"><b>Invite's Code</b><!--[if IE 7]><!--></a><!--<![endif]--></li>
				</ul>
			</li>
		</ul>
		
		
		<div class="nav-divider">&nbsp;</div>
		
		<ul class="<?php echo $this->params['controller']=='howto' ?'current':'select'; ?>">
			<li><a href="/admin/userList/"><b>Users</b></a>
				<ul >
					<li>
						<a href="/admin/employer/">
							<b>Employer</b>
						<!--[if IE 7]><!--></a><!--<![endif]-->
					</li>
					<li>
						<a href="/admin/networkerData/">
							<b>Networker</b>
						<!--[if IE 7]><!--></a><!--<![endif]-->
					</li>
					<li>
						<a href="/admin/jobseeker/">
							<b>Jobseeker</b>
						<!--[if IE 7]><!--></a><!--<![endif]-->
					</li>
					<li>
						<a href="/admin/deactiveUsers/">
							<b>Pending Request</b>
						<!--[if IE 7]><!--></a><!--<![endif]-->
					</li>
				</ul>
			</li>
		</ul>
		<div class="nav-divider">&nbsp;</div>
		
		<ul class="<?php echo $this->params['controller']=='howto' ?'current':'select'; ?>">
			<li><a href="/admin/jobs/"><b>Job</b><!--[if IE 7]><!--></a><!--<![endif]--></li>
		</ul>
		
		<div class="nav-divider">&nbsp;</div>
		
		<ul class="<?php echo $this->params['controller']=='howto' ?'current':'select'; ?>">
			<li><a ><b>Rewards</b></a>
				<ul>
					<li><a href="/admin/rewardPayment/"><b>Payments</b><!--[if IE 7]><!--></a><!--<![endif]--></li>
					<li><a href="/admin/points/"><b>Points</b><!--[if IE 7]><!--></a><!--<![endif]--></li>
				</ul>
			</li>
		</ul>

		<div class="nav-divider">&nbsp;</div>
		
		<ul class="<?php echo $this->params['controller']=='howto' ?'current':'select'; ?>">
			<li>
				<a href="/users/changePassword/">
					<b>Change password</b>
				</a>
			</li>
		</ul>
		
		
		<div class="clear"></div>
		</div>
		<div class="clear"></div>
		</div>
		<!--  start nav -->
		</div><div class="clear"></div><!--  start nav-outer -->
		</div><!--  start nav-outer-repeat................................................... END -->
		<!-- start content-outer --><div id="content-outer">
		<!-- start content -->
		<div id="content">
		<?php echo $this->Session->flash(); ?>
		<?php echo $content_for_layout; ?>
		</div>
		<!--  end content -->
		<div class="clear">&nbsp;</div>
		</div>
		<!--  end content-outer -->
 <div class="clear">&nbsp;</div>
    
<!-- start footer -->         

<!-- end footer -->
 

<div style="display: none;" id="tooltip"><h6></h6><div class="body"></div><div class="url"></div></div></body></html>
