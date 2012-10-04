<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		
		<?php __('Hire Routes'); ?>
		<?php echo $title_for_layout; ?>
		 
	</title>
<link href="/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
	<?php

		echo $this->Html->css('cake.generic');
		$time = time();
		echo $this->Html->css('default.css?'.$time);
		echo $this->Html->css('template.css?'.$time);
		//echo $this->Html->css('jquery_accordion');
		echo $this->Html->css('jquery-ui');
		echo $html->script('hr.js');
		echo $html->script('hr_ajax.js');
		echo $html->script('jquery_min.js');	
		echo $html->script('jquery-ui.min.js');
		echo $html->script('jquery.validate.js');
		echo $html->script('html5placeholder.jquery.js');		
		echo $scripts_for_layout;
	?>
<script type="text/javascript" charset="utf-8">
 var is_ssl = ("https:" == document.location.protocol);
 var asset_host = is_ssl ? "https://d3rdqalhjaisuu.cloudfront.net/" : "http://d3rdqalhjaisuu.cloudfront.net/";
 document.write(unescape("%3Cscript src='" + asset_host + "javascripts/feedback-v2.js' type='text/javascript'%3E%3C/script%3E"));
</script>

<script type="text/javascript" charset="utf-8">
 var feedback_widget_options = {};

 feedback_widget_options.display = "overlay";  
 feedback_widget_options.company = "hire-routes";
 feedback_widget_options.placement = "left";
 feedback_widget_options.color = "#222";
 feedback_widget_options.style = "idea";
 
 var feedback_widget = new GSFN.feedback_widget(feedback_widget_options);
</script>
<script >
(function($) {
  $.fn.ezMark = function(options) {
	options = options || {}; 
	var defaultOpt = { 
		checkboxCls   	: options.checkboxCls || 'ez-checkbox' , radioCls : options.radioCls || 'ez-radio' ,	
		checkedCls 		: options.checkedCls  || 'ez-checked'  , selectedCls : options.selectedCls || 'ez-selected' , 
		hideCls  	 	: 'ez-hide'
	};
    return this.each(function() {
    	var $this = $(this);
    	var wrapTag = $this.attr('type') == 'checkbox' ? '<div class="'+defaultOpt.checkboxCls+'">' : '<div class="'+defaultOpt.radioCls+'">';
    	// for checkbox
    	if( $this.attr('type') == 'checkbox') {
    		$this.addClass(defaultOpt.hideCls).wrap(wrapTag).change(function() {
    			if( $(this).is(':checked') ) { 
    				$(this).parent().addClass(defaultOpt.checkedCls); 
    			} 
    			else {	$(this).parent().removeClass(defaultOpt.checkedCls); 	}
    		});
    		
    		if( $this.is(':checked') ) {
				$this.parent().addClass(defaultOpt.checkedCls);    		
    		}
    	} 
    	else if( $this.attr('type') == 'radio') {

    		$this.addClass(defaultOpt.hideCls).wrap(wrapTag).change(function() {
    			// radio button may contain groups! - so check for group
   				$('input[name="'+$(this).attr('name')+'"]').each(function() {
   	    			if( $(this).is(':checked') ) { 
   	    				$(this).parent().addClass(defaultOpt.selectedCls); 
   	    			} else {
   	    				$(this).parent().removeClass(defaultOpt.selectedCls);     	    			
   	    			}
   				});
    		});
    		
    		if( $this.is(':checked') ) {
				$this.parent().addClass(defaultOpt.selectedCls);    		
    		}    		
    	}
    });
  }
})(jQuery);
</script>
<script type="text/javascript" charset="utf-8">

	function hideMessage(){
		$('.message').delay(5000).animate({ height: 'toggle', opacity: 'toggle' }, 'slow').hide('.message');
		$('.success').delay(5000).animate({ height: 'toggle', opacity: 'toggle' }, 'slow').hide('.success');
		$('.warning').delay(5000).animate({ height: 'toggle', opacity: 'toggle' }, 'slow').hide('.warning');
	}

</script>
<script type="text/javascript">
$(document).ready(function(){
	$(function() {
		$('input[type=radio]').ezMark();
		var checkboxObj = $('input[type=checkbox]');
		$(checkboxObj).each(function(){
		if(!$(this).parent().hasClass("job_menus_submenu") && !$(this).parent().hasClass("js-check-box-popup") && 
		!$(this).parents("div").hasClass("contact_checkbox")){
			$('input[type=checkbox]').ezMark({checkboxCls: 'ez-checkbox-green', checkedCls: 'ez-checked'})
			}
		});
	});	


})
</script>

</head>
<body onload="hideMessage();">
	<div id="wrapper-top"> 
	  <!-- main-nav -->
	  <?php include("site_header.ctp");?>
	</div>
	<!-- Wrapper-middle -->
	<div id="wrapper-middle">
		<div class="middle">
		<!-- Hire Route -->
			
			<!-----------------------  Content for layout ---------------------------->
				<!-- ******		welcome User **** -->
				<!-- ******		End welcome User **** -->
				<?php echo $content_for_layout; ?>
			<!--------------------- End content for layout -------------------------->
		</div>
	</div>
	<!-- wrapper-middle end -->
	<div class="footer-wrap"> 
		<!-- footer-content-->
		<?php include("site_footer.ctp");?>
		<!-- footer-content --> 
	</div>
	<div style= "display:none;"> 
		<?php echo $this->element('invite_friend');?>
	</div>
	
	<script type="text/javascript">
   $("document").ready(function(){
		$(".feedback").click(function(){
			$("#fdbk_tab").click();
		});
		
		//$("#menu_show").click();
	});
	$(function(){
		$(':input[placeholder]').placeholder();
	}); 
</script>
</body>
</html>


