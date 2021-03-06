
<?php
    function unhtmlspecialchars( $string ){
        $string = str_replace ( '&#039;', '\'', $string );
        $string = str_replace ( '&quot;', '\"', $string );
        $string = str_replace ( '&lt;', '<', $string );
        $string = str_replace ( '&gt;', '>', $string );
       
        return $string;
    }
?>

<script>
	$(document).ready(function(){
		//$("#slider").slider();
	    //$("#switch_display").change(onSelectChange);

		$("#short_by").change(function(){
			onSelectChange( $("#short_by option:selected").val() );
		});
		$("#short_by2").change(function(){
			onSelectChange( $("#short_by2 option:selected").val() );
		});
		$("input[type=checkbox]").click(function(){
			if ($(this).attr("checked")) {
				$(this).next("label").css("color","#50A64E");
			}else{
				$(this).next("label").css("color","#1D1D1D");
			}
		});
			
	});
	function onSelectChange(shortSelected){
	    var displaySelected = 6;//$("#switch_display option:selected");
		//window.location.href="/jobs/index/display:"+displaySelected+"/shortby:"+shortSelected;
		window.location.href="/jobs/index/shortby:"+shortSelected;		
	}	
	$(function() {
		$( "#slider-range" ).slider({
			range: true,
			min: 1,
			max: 500,
			values: [ "<?php echo $salaryFrom; ?>","<?php echo $salaryTo; ?>"],
			slide: function( event, ui ) {
				$( "#from_amount" ).val( ui.values[ 0 ] +"K");
				$( "#to_amount" ).val( ui.values[ 1 ]+"K" );
				/*
				$( "#slider-range" ).mouseleave(function(){
					document.forms["FilterJobIndexForm"].submit();			
				});
				*/				
			}
		});
		$( "#from_amount" ).val( $( "#slider-range" ).slider( "values", 0 ) +"K");
		$( "#to_amount" ).val( $( "#slider-range" ).slider( "values", 1 )+"K" );
		
		
	});
</script>
<link type="text/css" href="/css/jquery.jscrollpane.css" rel="stylesheet" media="all" />
<script type="text/javascript" src="/js/jquery.jscrollpane.js"></script>
<script type="text/javascript" src="/js/jquery.mousewheel.js"></script>
<?php $job_array = array('1'=>'Full Time','2'=>'Part Time','3'=>'Contract','4'=>'Internship','5'=>'Temporary'); ?>
<div class="middle">
	<div class="job_top-heading">
		<?php if($this->Session->read('Auth.User.id')):?>
			<?php if($this->Session->read('welcomeName') && ($this->Session->read('UserRole'))):?>
					<h2 class="h2_float">WELCOME <?php echo strtoupper($this->Session->read('welcomeName'));?>!</h2>
			<?php endif; ?>
		<?php endif; ?>
		 <?php  echo $this->Form->create('FilterJob', array('url' => array('controller' => 'Jobs', 'action' => 'index')));?>
    	<div class="net_sl_right">
        	<div class="net_sl_textbox">
        		<?php echo $form->input('what', array('label' => false,
							                         'type'  => 'text',
                                                     'value' => isset($what)?$what:"",
                                                     'id'    => 'what',
                                                     'placeholder'=>"What",
                                                     'div'=>false,
                                                     'class' => ''));?>
			</div>
            <div class="net_sl_textbox">
            <?php echo $form->input('where', array('label' =>false,
            										  'placeholder'=> 'Where',
							                          'type'  => 'text',
                                                      'value' => isset($where)?$where:"",
                                                      'div'=>false,
                                                      'id'    => 'where',
                                                      'class' => 'text_field_bg'));?>
			</div>
            <div class="find_clr_button net_sl_bttn">
            	<?php echo $form->submit('FIND',array('div'=>false,'name'=>'search','value'=>'Find Job'));?>
            </div>
        </div>
        <?php echo $form->end();?>
	</div>
	
    <div class="job_container">
    	<div class="job_container_top_row">
        
        
      <!---  left part start --->
			<div class="job_left_bar">
		      <?php echo $this->Form->create('NarrowJob', array('url' => array('controller' => 'Jobs', 'action' => 'index'))); ?>

                <div class="job_left_menu">
                    <ul>
                        <li><a class="HrMenu <?php echo isset($industry)?'minus_icon':'plus_icon';?>" id="Industries" href="javascript:void(0);">Industries</a>
                            <div style="<?php echo isset($industry)?'':'display:none;' ?>" id="Industries_submenu" class="job_menus_submenu_main">
                            
                            	<div class="scroll-pane">
                                	<p>
                                	
                            		<?php	echo $form->input("industry", array('label' => false,
                                                                        'type' => 'select',
                                                                        'multiple' => 'checkbox',
														                'options'  => $industries,
														                'div'=> false,

														                'class'	=>'job_menus_submenu',
                                                                        'selected' => isset($industry)?$industry:null
                                                      ));?>
                                     
                                  </p>
                                </div>
                                
                            </div>
                        </li>
                        

                        <li><a class="HrMenu <?php echo isset($salaryFrom)?'minus_icon':'plus_icon';?>" id="Salary" href="javascript:void(0);">Salary</a>
                        	<div style="height:65px;" id="Salary_submenu" class="job_menus_submenu_main">
<p>
						<label for="amount"></label>
						<!--input type="text" id="amount" style="border:0; color:#f6931f; font-weight:bold;" / -->
						<div>
							<div class="job_salary_txt_row">
                                	<div class="job_salary_txt1"><?php	echo $form->input('salary_from', array('label' => '',
															'type'  => 'text',
															'id' => 'from_amount',
															'class'=> 'job_salary_txt1',
															'readonly'=>'true',
															 'div'=>false
															)
										 );
								?></div>
                                    <div class="job_salary_txt2"><?php	echo $form->input('salary_to', array('label' => '',
															'type'  => 'text',
															'id' => 'to_amount',
															'class'=> 'job_salary_txt2',
															'readonly'=>'true',
	                                                        'div'=>false							
															)
										 );
								?></div>
                                </div>
							
							
						</div>
					</p>
					<div style="clear:both"></div>
						
					<div id="slider-range" ></div>
                            </div>
                        </li>
                        
                        <li><a class="HrMenu <?php echo isset($location)?'minus_icon':'plus_icon';?>" id="Location" href="javascript:void(0);">Location</a>
                        	<div style="height:150px;<?php echo isset($location)?'':'display:none;' ?>" id="Location_submenu" tyle="s" class="job_menus_submenu_main">
                            <div class="scroll-pane scroll-pane_location">
                               	<p>
                            
        	                    	<?php	echo $form->input("state", array('label' => false,
                                                                     'type' => 'select',
                                                                     'multiple' => 'checkbox',
                                                                     'options'  => $states,
                                                                     'div'=> false,
                                                                     'class'=> 'job_menus_submenu',
                                                                     'selected' => isset($location)?$location:null
                                                      ));
									?>
                                 
                                 </p>
                                </div>
                                
                             </div>
                         </li>
                         <?php $jobtypes = array('1'=>'Full Time',
                         						'2'=>'Part Time',
                         						'3'=>'Contract',
												'4'=>'Internship',
												'5'=>'Temporary'); ?>
                        <li><a class="HrMenu <?php echo isset($job_type)?'minus_icon':'plus_icon';?>" id="Job_type" href="javascript:void(0);">Job Type</a>
                        	<div style="height:115px;<?php echo isset($job_type)?'':'display:none;' ?>" id="Job_type_submenu" style="" class="job_menus_submenu_main">
                            <div class="">
                              <p>
                        		<?php	echo $form->input("job_type", array('label' => false,
                                                                        'type' => 'select',
                                                                        'multiple' => 'checkbox',
                                                                        'div'	=> false,
                                                                        'class'=>'job_menus_submenu',
                                                                        'options'  => $jobtypes,
                                                                        'selected' =>  isset($job_type)?$job_type:null
                                  ));?>
                                 
                                 </p>
                               </div>
                                 
                             </div>
                        </li>
                        
                        <li><a id="Company" class="HrMenu <?php echo isset($company_name)?'minus_icon':'plus_icon';?>" href="javascript:void(0);">Company</a>
                        	<div style="height:68px;<?php echo isset($company_name)?'':'display:none;' ?>" id="Company_submenu" style="display:none" class="job_menus_submenu_main">
                            <div class="scroll-pane scroll-pane_company">
                              <p>
                                 <?php	echo $form->input("company_name", array('label' => false,
                                                                            'type' => 'select',
                                                                            'multiple' => 'checkbox',
                                                                            'class'=>'job_menus_submenu',
                                                                            'div'=>false,
														                    'options'=>$companies,
                                                                            'selected' =>  isset($company_name)?$company_name:null
                                                      ));?>
                                 
                                 </p>
                               </div>
                                 
                            </div>    
                        </li>
                    </ul>
                </div>
               
               <div class="job_left_search_row">
               		<div class="search_bttn">
               			<?php echo $form->submit('SEARCH',array('div'=>false,'name'=>'save','value'=>'fillter')); ?>
               		</div>
                    <div class="search_text">
                    	<?php echo $form->submit('Reset Settings',array('div'=>false,'name'=>'save'));?>
                    	<a href="#">Reset Settings</a>
                    </div>
               </div> 
                
            </div>
            <?php echo $form->end(); ?>
            
            
     <!---   right part start ---->
     
                 
            <div class="job_right_bar">
                <div class="job_right_top_bar">
                    <div class="job_right_sortby">
                    	<?php if($jobs):?>
                        <div class="job_right_shortby_txt">Sort By:</div>
                        <div class="job_right_shortby_field">
						<?php echo $form -> input('short_by',array(
												'type'=>'select',
												'label'=>false,
												'div'	=> false,
												'options'=>array('date-added' => 'Date Added', 'company-name' => 'Company Name', 'industry' => 'Industry', 'salary' => 'Salary'),
												'selected'=>isset($shortBy)?$shortBy:'date-added',));?>
                         </div>
           				<?php endif;?>
                    </div>
					<?php if($this->Paginator->numbers()){?>
                    <div class="job_right_pagination">
		               <!--         <a class="arrow_margin" href="#">&lt;&lt; </a>-->
                        <div>
								<?php echo $paginator->first("<<",array("class"=>"arrow_margin" )); ?>	
				          
				            <ul>
								<?php echo $this->Paginator->numbers(array('modulus'=>8,
																			'tag'=>'li',
																			'separator'=>false,)); ?>
							</ul>
				            <?php echo $paginator->last(">>", array("class"=>"arrow_margin",
				            											));?>
                        <!---<a class="arrow_margin" href="#">&gt;&gt;</a>-->
                        </div>
                    </div>
                    <div class="job_preview_bttn"><?php echo $paginator->prev('  '.__('', true), array(), null, array('class'=>'disabled'));?></div>
                    <div class="job_next_bttn"><?php echo $paginator->next(__('', true).' ', array(), null, array('class'=>'disabled'));?>
                    </div>
					<?php } ?>                    
                </div>
                
                <?php foreach($jobs as $job):?>	

                <div class="job_right_section">
                    <div class="job_right_section_left">
                        <h2><?php	echo $this->Html->link(strtoupper(unhtmlspecialchars($job['Job']['title'])), '/jobs/jobDetail/'.$job['Job']['id']); ?></h1>
                        <p><?php
	                        	echo $job['ind']['industry'].", ".$job['spec']['specification'] ;
	                        	?>
	                     </p>
	                     <p>
	                     	<?php
	                        	if(!empty($job['city']['city']))
									echo $job['city']['city'].",&nbsp;";
								echo $job['state']['state']
							?>
                        </p>
                        <p><?php echo $job_array[$job['Job']['job_type']]; ?></p>
                        <p>Posted: <?php echo date('m/d/Y',strtotime($job['Job']['created'])) ;?></p>
                    </div>
                    <div class="job_right_section_right body1">
                        <div>Reward: <span><?php echo $this->Number->format(
										$job['Job']['reward'],
										array(
											'places' => 0,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?></span>
						</div>
						<?php if($this->Session->read('Auth.User.id')>2 ||$this->Session->read('Auth.User.id')==1){?>
							<div style="font-weight:normal;"><a href="JavaScript:void(0);" class="howPayoutWorks" >How payouts work</a></div>	
						<?php } ?>
									
                    </div>
                </div>
                <?php endforeach; ?>
                <?php if(!$jobs):?>
					<div class="job-empty-message">There is no job found for this search.</div>
				<?php endif;?>
            </div>
        </div>
        <div class="job_pagination_bottm_bar">
        	<div class="job_right_sortby">
            	<div class="job_right_shortby_txt">Sort By:</div>
                <div class="job_right_shortby_field">
					<?php echo $form -> input('short_by',array(
											'type'=>'select',
											'id'=>'short_by2',
											'label'=>false,
											'div'	=> false,
											'options'=>array('date-added' => 'Date Added', 'company-name' => 'Company Name', 'industry' => 'Industry', 'salary' => 'Salary'),
											'selected'=>isset($shortBy)?$shortBy:'date-added',));?>
                </div>
			</div>
            <div class="job_right_pagination">
               	<div>
	            	<?php if($this->Paginator->numbers()){?>
					<?php echo $paginator->first("<<",array("class"=>"arrow_margin" )); ?>	
	                <ul>
					<?php echo $this->Paginator->numbers(array('modulus'=>8,
																'tag'=>'li',
																'separator'=>false,)); ?>
					</ul>
	                <?php echo $paginator->last(">>", array("class"=>"arrow_margin",
	                    											));?>
	                 <!---<a class="arrow_margin" href="#">&gt;&gt;</a>-->
                 </div>
			</div>
            <div class="job_preview_bttn"><?php echo $paginator->prev('  '.__('', true), array(), null, array('class'=>'disabled'));?>
            </div>
			<div class="job_next_bttn"><?php echo $paginator->next(__('', true).' ', array(), null, array('class'=>'disabled'));?>
			</div>
				<?php } ?>
           </div>
        </div>
        <div class="clr"></div>
    </div>
 	<div class="clr"></div>
</div>
</div>
<div style="display:none;" id = "about-dialog">
	<?php echo $this->element("payout");?>
</div>
<script type="text/javascript" id="sourcecode">

	$(function()
	{
		var api = $('.scroll-pane').jScrollPane(
			{
				showArrows:true,
				maintainPosition: false
			}
		).data('jsp');
		
		$("#Industries").click(function(){
			$(this).next().slideToggle();			
			var api = $('.scroll-pane').jScrollPane(
					{
						showArrows:true,
						maintainPosition: false
					}
				).data('jsp');		
		});

		$("#Salary").click(function(){
			$(this).next().slideToggle();	
		});

		$("#Location").click(function(){
			$(this).next().slideToggle();			
			var api = $('.scroll-pane').jScrollPane(
					{
						showArrows:true,
						maintainPosition: false
					}
				).data('jsp');		
		});

		$("#Job_type").click(function(){
			$(this).next().slideToggle();
		});

		$("#Company").click(function(){
			$(this).next().slideToggle();			
			var api = $('.scroll-pane').jScrollPane(
					{
						showArrows:true,
						maintainPosition: false
					}
				).data('jsp');		
		});
		
	});
	$(".HrMenu").click(function(){
		if($(this).hasClass("plus_icon")){
			$(this).removeClass("plus_icon").addClass("minus_icon");		
		}else{
			$(this).removeClass("minus_icon").addClass("plus_icon");
		}
	});
</script>

<style type="text/css" id="page-css">

.scroll-pane
{
	width: 100%;
	height: 192px;
	overflow: auto;
	outline:none;
}
.scroll-pane_location
{
	width: 100%;
	height: 150px !important;
}
.scroll-pane_company
{
	width: 100%;
	height: 66px !important;
}

.job_top-heading { height:35px; width:920px; padding:20px 0 0 15px;}
.job_top-heading h2 {color:#4fa34b; font:bold 20px 'OpenSansCondensedBold';}
.job_container {width:935px; height:895px;}
.job_container_top_row {width:935px; height:857px;}
.job_left_bar {width:222px; background:#faf8f4; border-left:solid 1px #d6d2cc; border-bottom:solid 1px #d6d2cc; height:857px; float:left; border-top:1px solid #D6D2CC;}
.job_left_menu { width:222px; height:auto;}
.job_left_menu ul {margin:0; padding:0;}
.job_left_menu ul li {list-style:none; display:block; background:url(/images/left_bar_menu_bg.png) no-repeat; height:auto; width:222px;}
.job_left_menu ul li:hover {background:url(/images/left_bar_menu_bg.png) no-repeat 0 -44px;}
.job_left_menu ul li a {width:auto; height:25px; display:block; font:bold 15px Arial, Helvetica, sans-serif; color:#1d1d1d; padding:5px 0 0 10px; text-decoration:none;} 
.plus_icon { background:url(/images/plus_icon.png) no-repeat 200px 11px;}
.minus_icon { background:url(/images/minus_icon.png) no-repeat 200px 14px;}
.job_submenu_active {color:#4fa149 !important; text-decoration:underline !important;}

.job_menus_submenu_main {width:222px; background:#eee7d9; height:195px; padding:2px 0;}
.job_menus_submenu {width:190px; list-style:none; display:block; background:none; height:auto; padding:0;clear:both;}
.job_menus_submenu label {
    color: #1D1D1D;
    float: left;
    font:normal 13px Arial,Helvetica,sans-serif !important;
    height: auto;
    padding: 5px 0 0 10px;
    text-decoration: none;
    width: 159px;
	word-wrap: break-word;
}
.job_menus_submenu label:hover {color:#4fa149; text-decoration:underline;}
.job_menus_submenu input {float:right; margin-top:5px;}
.job_menus_last {
   height: 763px !important;
}


.job_left_search_row {
	width:222px;
	height:auto;
}
.job_left_search_row .search_bttn {
	width:210px;
	height:53px;
	margin:10px auto 0;
	padding:9px 0 0 0;
	background:url("/images/bttn_sprite.png") no-repeat 0 0;
}
.job_left_search_row .search_bttn input {
	width:181px;
	height:36px;
	display:block;
	font:bold 20px "OpenSansCondensedBold";
	text-align:center;
	text-shadow: 1px 1px 1px #444343;
	color:#fff;
	text-decoration:none;
	line-height:40px;
	margin:2px 0 0 11px;
	background:url("/images/bttn_sprite.png") no-repeat scroll -11px -80px transparent;
	border:none;
	cursor:pointer;
}
.job_left_search_row .search_bttn a:hover {
	background:url(/images/left_bar_menu_bg.png) no-repeat -14px -159px;
}
.job_left_search_row .search_bttn a:active {
	background:url(/images/left_bar_menu_bg.png) no-repeat -14px -205px;
}
.job_left_search_row .search_text {
	width:222px;
	height:20px;
	text-align:center;
}
.job_left_search_row .search_text a {
	font:normal 15px Arial, Helvetica, sans-serif;
	color:#3a9031;
	text-decoration:underline;
}

.job_salary_txt_row {
	width:192px;
	height:20px;
	margin:10px auto 0;
	font:bold 15px Arial, Helvetica, sans-serif;
	color:#4fa34b;
}
.job_salary_txt_row .job_salary_txt1 {
	width:auto;
	height:20px;
	float:left;
}
.job_salary_txt_row .job_salary_txt2 {
	width:auto;
	height:20px;
	float:right;
}
	
.job_salary_bar {
	width:192px;
	background: url(/images/salary_bar.png) no-repeat;
	height:20px;
	margin:0 auto;
}


.job_right_bar {width:710px; border:solid 1px #d6d2cc; float:left; height:857px;}
.job_right_top_bar {width:710px; background:#eae6d7; height:35px;}
.job_right_sortby {width:220px; height:20px; float:left; margin:8px 0 0 20px;}
.job_right_shortby_txt {width:auto; font:bold 15px Arial, Helvetica, sans-serif; color:#1d1d1d; margin:2px 20px 0 0; float:left;}
.job_right_shortby_field {float:left;}
.job_right_pagination {width:320px; height:auto; float:left; margin:8px 10px 0 60px;}
.job_right_pagination div {float:right;}
.job_right_pagination a { float:left; text-decoration:none; color:#1d1d1d; font:normal 15px Arial, Helvetica, sans-serif;}
.job_right_pagination ul {margin:0; padding:0; float:left;}
.job_right_pagination ul li {list-style:none; display:block; margin:2px 0; padding:0 5px; border-left:solid 1px #000; float:left; width:16px; text-align:center;}
.job_right_pagination ul li a { text-decoration:none; font:normal 15px Arial, Helvetica, sans-serif; color:#1d1d1d; width:16px;}
.job_right_pagination ul li a:hover, .job_right_pagination ul li a:active {font-weight:bold; text-decoration:underline;} 
.job_right_pagination ul li:first-child {border:none;}
.arrow_margin {margin:2px 10px 0;}
.job_preview_bttn {width:28px; height:28px; background:url(/images/job_prev_next_bttn.png) no-repeat -6px -6px; float:left;  margin:3px 8px 0 10px;}
.job_preview_bttn a {width:25px; height:25px; display:block; }
.job_preview_bttn a:hover {background:url(/images/job_prev_next_bttn.png) no-repeat -6px -45px;}
.job_preview_bttn a:active {background:url(/images/job_prev_next_bttn.png) no-repeat -6px -86px;}
.job_next_bttn {width:28px; height:28px; background:url(/images/job_prev_next_bttn.png) no-repeat -41px -6px; float:left; margin-top:3px;}
.job_next_bttn a {width:25px; height:25px; display:block;}
.job_next_bttn a:hover {background:url(/images/job_prev_next_bttn.png) no-repeat -41px -45px;}
.job_next_bttn a:active {background:url(/images/job_prev_next_bttn.png) no-repeat -41px -86px;}

.job_right_section {
	width:688px;
	min-height:116px;
	border-top:solid 1px #d6d2cc;
	padding:10px 0 10px 22px;
}
.job_right_section_left {
	width:350px;
	height:auto;
	float:left;
}
.job_right_section_left h2 a {
	color:#50a64e;
	text-decoration:none;
	margin-bottom:5px;
}
.job_right_section_left h2 a:hover {
	color:#50a64e;
	text-decoration:underline;
}
.job_right_section_left p {
	font:normal 15px Arial, Helvetica, sans-serif;
	color:#1d1d1d;
	line-height:normal;
}
.job_right_section_right {
	width:150px;
	height:30px;
	float:right;
	margin:0 20px 0 0;
	text-align:right;
	font-weight:bold;
}
.job_right_section_right span {
	font-size:20px; 
	line-height: normal; 
	text-transform: uppercase; 
	color:#50a64e;  
	font-family: 'OpenSansCondensedBold';
}

.body1 {
	font-size:15px;
	line-height:normal;
	color:#1d1d1d;
	font-family:Arial, Helvetica, sans-serif;
}

.job_pagination_bottm_bar {width:713px; border-left:solid 1px #d6d2cc; border-right:solid 1px #d6d2cc; border-bottom:solid 1px #d6d2cc; background:#eae6d7; height:36px; padding:0 0 0 220px;}
.job_left_search_row .search_bttn input:hover {
	background:url("/images/bttn_sprite.png") no-repeat scroll -11px -121px transparent;
}
.job_left_search_row .search_bttn input:active {
	background:url("/images/bttn_sprite.png") no-repeat scroll -11px -165px transparent;
}
.job_left_search_row .search_text {
	width:222px;
	height:20px;
	position:relative;
	text-align:center;
}
.job_left_search_row .search_text input {
    cursor: pointer;
    height: 23px;
    opacity: 0;
    position: absolute;
    width: 103px;
	filter:alpha(opacity=0);
}
.job_left_search_row .search_text a {
	font:bold 15px Arial, Helvetica, sans-serif;
	color:#3a9031;
	text-decoration:underline;
}

.job_salary_txt_row {
	width:192px;
	height:20px;
	margin:10px auto 0;
	font:bold 15px Arial, Helvetica, sans-serif;
	color:#4fa34b;
}
.job_salary_txt_row .job_salary_txt1 {
	width:auto;
	height:20px;
	float:left;
}
.job_salary_txt_row .job_salary_txt2 {
	width:auto;
	height:20px;
	float:right;
}
	
.job_salary_bar {
	width:192px;
	background: url(/images/salary_bar.png) no-repeat;
	height:20px;
	margin:0 auto;
}
<!----------------------------Css for salery slider.-------------------------------------------->
/* Component containers
----------------------------------*/
.ui-widget { font-family: Verdana,Arial,sans-serif/*{ffDefault}*/; font-size: 1.1em/*{fsDefault}*/; }
.ui-widget .ui-widget { font-size: 1em; }
.ui-widget input, .ui-widget select, .ui-widget textarea, .ui-widget button { font-family: Verdana,Arial,sans-serif/*{ffDefault}*/; font-size: 1em; }
.ui-widget-content { border:none !important; background: url(/images/slider_dark_bg.png) repeat-x/*{bgContentRepeat}*/; color: #222222/*{fcContent}*/;height:8px !important; }
.ui-widget-content a { color: #222222/*{fcContent}*/; }
.ui-widget-header {border:none !important; background:url(/images/slider_light_bg.png) repeat-x ; color: #222222/*{fcHeader}*/; font-weight: bold; height:8px !important;}
.ui-widget-header a { color: #222222/*{fcHeader}*/; }

/* Interaction states
----------------------------------*/
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default { border:none 
!important;background:url("/images/slider_bttn.png") no-repeat scroll 0 -1px transparent/*{bgDefaultRepeat}*/; font-weight: normal/*{fwDefault}*/; color: #555555/*{fcDefault}*/; }
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited { color: #555555/*{fcDefault}*/; text-decoration: none; }
.ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus {background: url("/images/slider_bttn.png") no-repeat scroll 0 -1px transparent; font-weight: normal/*{fwDefault}*/; color: #212121/*{fcHover}*/; }
.ui-state-hover a, .ui-state-hover a:hover {background: url("/images/slider_bttn.png") no-repeat scroll 0 -1px transparent;text-decoration: none; }
.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active { background: /*{bgColorActive}*/ url("/images/slider_bttn.png") no-repeat scroll 0 -1px transparent; font-weight: normal/*{fwDefault}*/; color: #212121/*{fcActive}*/; }
.ui-state-active a, .ui-state-active a:link, .ui-state-active a:visited { color: #212121/*{fcActive}*/; text-decoration: none; }
.ui-widget :active { outline: none; }
<!----------------------------End css for slider      --------->
.placehcss{
	position : absolute\0/IE8+9;
	left:-138px\0/IE8+9;
	top:3px\0/IE8+9;
	z-index:999\0/IE8+9;
	*position : absolute;
	*left:-138px;
	*top:3px;
	*z-index:999;
}
</style>

