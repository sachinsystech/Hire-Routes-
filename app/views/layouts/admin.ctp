<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Admin | <?php echo $title_for_layout; ?></title>
<link rel="stylesheet" href="/css/screen.css" type="text/css" media="screen" title="default">
<!--[if IE]>
<link rel="stylesheet" media="all" type="text/css" href="css/pro_dropline_ie.css" />
<![endif]-->


 



<!--  date picker script -->
<link rel="stylesheet" type="text/css" href="/css/datePicker.css"/>


<?php
echo $html->meta('icon', 'favicon.ico');
echo $html->css('screen');
echo $html->script('jquery.js');
echo $html->script('validation.js');
?>

</head>
<body> 
<!-- Start: page-top-outer -->
<div id="page-top-outer">    

<!-- Start: page-top -->
<div id="page-top">

	<!-- start logo -->
	<div id="logo">
		Hire-Routes
	</div>
	<div class="logoutClass"><?php echo $databaseMenus->auth_links(); ?></div>
	<!-- end logo -->
	
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
		<ul class="<?php echo $this->params['action']=='adminHome'?'current':'select'; ?>"><li><a href="/admin"><b>HOME</b><!--[if IE 7]><!--></a><!--<![endif]-->

		</li>
		</ul>

		<div class="nav-divider">&nbsp;</div>
		                    
		<ul class="<?php echo $this->params['controller']=='sliders' && $this->params['action']=='add'?'current':'select'; ?>"><li><a href="/admin/CompaniesList"><b>Companies Request</b><!--[if IE 7]><!--></a><!--<![endif]-->

		</ul>
		
		<div class="nav-divider">&nbsp;</div>
		
		<ul class="<?php echo  $this->params['action']=='config'?'current':'select'; ?>"><li><a href="#"><b>Code</b><!--[if IE 7]><!--></a><!--<![endif]-->
	
		</li>
		</ul>
		
	
		<div class="nav-divider">&nbsp;</div>
		
		<ul class="<?php echo $this->params['controller']=='test' ?'current':'select'; ?>"><li><a href="#"><b>HR</b><!--[if IE 7]><!--></a><!--<![endif]-->
	
		</li>
		</ul>
		<div class="nav-divider">&nbsp;</div>
		
		<ul class="<?php echo $this->params['controller']=='Test' ?'current':'select'; ?>"><li><a href="#"><b>HR</b><!--[if IE 7]><!--></a><!--<![endif]-->

		</li>
		</ul>
		<div class="nav-divider">&nbsp;</div>
		
		<ul class="<?php echo $this->params['controller']=='orders' ?'current':'select'; ?>"><li><a href="/orders"><b>Order</b><!--[if IE 7]><!--></a><!--<![endif]-->

		</li>
		</ul>
		<div class="nav-divider">&nbsp;</div>
		
		<ul class="<?php echo $this->params['controller']=='coupon' ?'current':'select'; ?>"><li><a href="/coupons/add"><b>Coupon</b><!--[if IE 7]><!--></a><!--<![endif]-->

		</li>
		</ul>
		<div class="nav-divider">&nbsp;</div>
		
		<ul class="<?php echo $this->params['controller']=='howto' ?'current':'select'; ?>"><li><a href="/howto/listChangeAddress"><b>Changed Addresses</b><!--[if IE 7]><!--></a><!--<![endif]-->

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
