<script>
d = <?php echo $gD; ?>

	function checkForm(){
		var NS_I = parseFloat($("#ConfigNrRewardPcForScenario1").val());
		var HS_I = parseFloat($("#ConfigHrRewardPcForScenario1").val());
		var JS_I = parseFloat($("#ConfigJsRewardPcForScenario1").val());
		
		var NS_II = parseFloat($("#ConfigNrRewardPcForScenario2").val());
		var HS_II = parseFloat($("#ConfigHrRewardPcForScenario2").val());
		var JS_II = parseFloat($("#ConfigJsRewardPcForScenario2").val());
		
		var NS_III = parseFloat($("#ConfigNrRewardPcForScenario3").val());
		var HS_III = parseFloat($("#ConfigHrRewardPcForScenario3").val());
		var JS_III = parseFloat($("#ConfigJsRewardPcForScenario3").val());
		
		if((NS_I+HS_I+JS_I) !=100 ){
			$(".rp-error").html('Sum for scenario-I should be 100.');
			$(".sc1 fieldset").css({'border-color':'#FF0000'});
			return false;
		}
		
		if((NS_II+HS_II+JS_II) !=100){
			$(".rp-error").html('Sum for scenario-II should be 100.');
			$(".sc2 fieldset").css({'border-color':'#FF0000'});
			return false;
		}
		
		if((NS_III+HS_III+JS_III) !=100){
			$(".rp-error").html('Sum for scenario-III should be 100.');
			$(".sc3 fieldset").css({'border-color':'#FF0000'});
			return false;
		}	
	}
	
	
	function extractNumber(obj, decimalPlaces, allowNegative)
{
	var temp = obj.value;
	
	// avoid changing things if already formatted correctly
	var reg0Str = '[0-9]*';
	if (decimalPlaces > 0) {
		reg0Str += '\\.?[0-9]{0,' + decimalPlaces + '}';
	} else if (decimalPlaces < 0) {
		reg0Str += '\\.?[0-9]*';
	}
	reg0Str = allowNegative ? '^-?' + reg0Str : '^' + reg0Str;
	reg0Str = reg0Str + '$';
	var reg0 = new RegExp(reg0Str);
	if (reg0.test(temp)) return true;

	// first replace all non numbers
	var reg1Str = '[^0-9' + (decimalPlaces != 0 ? '.' : '') + (allowNegative ? '-' : '') + ']';
	var reg1 = new RegExp(reg1Str, 'g');
	temp = temp.replace(reg1, '');

	if (allowNegative) {
		// replace extra negative
		var hasNegative = temp.length > 0 && temp.charAt(0) == '-';
		var reg2 = /-/g;
		temp = temp.replace(reg2, '');
		if (hasNegative) temp = '-' + temp;
	}
	
	if (decimalPlaces != 0) {
		var reg3 = /\./g;
		var reg3Array = reg3.exec(temp);
		if (reg3Array != null) {
			// keep only first occurrence of .
			//  and the number of places specified by decimalPlaces or the entire string if decimalPlaces < 0
			var reg3Right = temp.substring(reg3Array.index + reg3Array[0].length);
			reg3Right = reg3Right.replace(reg3, '');
			reg3Right = decimalPlaces > 0 ? reg3Right.substring(0, decimalPlaces) : reg3Right;
			temp = temp.substring(0,reg3Array.index) + '.' + reg3Right;
		}
	}
	
	obj.value = temp;
}
function blockNonNumbers(obj, e, allowDecimal, allowNegative)
{
	var key;
	var isCtrl = false;
	var keychar;
	var reg;
		
	if(window.event) {
		key = e.keyCode;
		isCtrl = window.event.ctrlKey
	}
	else if(e.which) {
		key = e.which;
		isCtrl = e.ctrlKey;
	}
	
	if (isNaN(key)) return true;
	
	keychar = String.fromCharCode(key);
	
	// check for backspace or delete, or if Ctrl was pressed
	if (key == 8 || isCtrl)
	{
		return true;
	}

	reg = /\d/;
	var isFirstN = allowNegative ? keychar == '-' && obj.value.indexOf('-') == -1 : false;
	var isFirstD = allowDecimal ? keychar == '.' && obj.value.indexOf('.') == -1 : false;
	
	return isFirstN || isFirstD || reg.test(keychar);
}

</script>


<?php echo $this->Session->flash();?>

<div id="page-heading"><h1>Reward Payment </h1></div>
<div style="clear:both"></div>

<div class="configuration_content">
 <div class="inner-content">	
  <span class="rp-error" style="clear:both;color:#FF0000;color: #FF0000;font-size: 13px;margin-left: 62px;"></span>
  <?php echo $form->create('Config',array('url'=>array('controller'=>'admin','action'=>'rewardPayment'),'onSubmit'=>'return checkForm()'))?>

	<div style="float:left">
		<div class="required rp_user_list">
			<?php echo "<pre> </pre>";?>
		</div>
		<div class="required rp_user_list">
			<?php echo "Networker ";?>
		</div>
		
		<div class="required rp_user_list">
			<?php echo "Hireroutes ";?>
		</div>
		<div class="required rp_user_list">
			<?php echo "Jobseeker ";?>
		</div>
		
	</div>
	
	<!-- start of scenario-I-->
	<div style="float:left" class="sc1">	
		
		<div class="pr_scenario_heading">
			<?php	echo "Scenario-I"; ?>
		</div>
		
		<div class="required" style="float:none;padding: 5px;">
				
			<?php
				echo $form->input('nr_reward_pc_for_scenario_1',array(
									'label' => '',
									'type'  => 'text',
									'class' => 'reward_pc required number',
									'value' => number_format($rewardPercent[1]['nr_reward_pc_for_scenario_1'],'2'),
									'maxlength' => '5',
									'max' =>100,
									'min' =>1,
									'onkeyup'=>"extractNumber(this,2,true);",
									'onkeypress'=>"return blockNonNumbers(this, event, true, true);",
									'before'=>'<fieldset style="width: 66px;">',
									'after'=>' % </fieldset>'
								)
				);
			?>
		</div>
		
		<div class="required" style="float:none;padding: 5px;">
			<?php
				echo $form->input('hr_reward_pc_for_scenario_1',array(
									'label' => '',
									'type'  => 'text',
									'class' => 'reward_pc required number',
									'value' => number_format($rewardPercent[2]['hr_reward_pc_for_scenario_1'],'2'),
									'maxlength' => '5',
									'max' =>100,
									'min' =>1,
									'onkeyup'=>"extractNumber(this,2,true);",
									'onkeypress'=>"return blockNonNumbers(this, event, true, true);",
									'before'=>'<fieldset style="width: 66px;">',
									'after'=>' % </fieldset>'
								)
				);
			?>
		</div>
		<div class="required" style="float:none;padding: 5px;">
			<?php
				echo $form->input('js_reward_pc_for_scenario_1',array(
									'label' => '',
									'type'  => 'text',
									'class' => 'reward_pc required number',
									'value' => number_format($rewardPercent[3]['js_reward_pc_for_scenario_1'],'2'),
									'maxlength' => '5',
									'max' =>100,
									'min' =>1,
									'onkeyup'=>"extractNumber(this,2,true);",
									'onkeypress'=>"return blockNonNumbers(this, event, true, true);",
									'before'=>'<fieldset style="width: 66px;">',
									'after'=>' % </fieldset>'
								)
				);
			?>
		</div>
		
	</div>
	<!-- end of scenario-I-->
	
	<!-- start of scenario-II-->	
	<div style="width:auto;float:left" class="sc2">	
		<div class="pr_scenario_heading">
			<?php	echo "Scenario-II"; ?>
		</div>
		<div class="required" style="float:none;padding: 5px;">
			<?php
				echo $form->input('nr_reward_pc_for_scenario_2',array(
									'label' => '',
									'type'  => 'text',
									'class' => 'reward_pc required number',
									'value' => number_format($rewardPercent[4]['nr_reward_pc_for_scenario_2'],'2'),
									'maxlength' => '5',
									'max' =>100,
									'min' =>1,
									'onkeyup'=>"extractNumber(this,2,true);",
									'onkeypress'=>"return blockNonNumbers(this, event, true, true);",
									'before'=>'<fieldset style="width: 66px;">',
									'after'=>' % </fieldset>'
								)
				);
			?>
		</div>
		
		<div class="required" style="float:none;padding: 5px;">
			<?php
				echo $form->input('hr_reward_pc_for_scenario_2',array(
									'label' => '',
									'type'  => 'text',
									'class' => 'reward_pc required number',
									'value' => number_format($rewardPercent[5]['hr_reward_pc_for_scenario_2'],'2'),
									'maxlength' => '5',
									'max' =>100,
									'min' =>1,
									'onkeyup'=>"extractNumber(this,2,true);",
									'onkeypress'=>"return blockNonNumbers(this, event, true, true);",
									'before'=>'<fieldset style="width: 66px;">',
									'after'=>' % </fieldset>'
								)
				);
			?>
		</div>
		<div class="required" style="float:none;padding: 5px;">
			<?php
				echo $form->input('js_reward_pc_for_scenario_2',array(
									'label' => '',
									'type'  => 'text',
									'class' => 'reward_pc required number',
									'value' => number_format($rewardPercent[6]['js_reward_pc_for_scenario_2'],'2'),
									'maxlength' => '5',
									'max' =>100,
									'min' =>1,
									'onkeyup'=>"extractNumber(this,2,true);",
									'onkeypress'=>"return blockNonNumbers(this, event, true, true);",
									'before'=>'<fieldset style="width: 66px;">',
									'after'=>' % </fieldset>'
								)
				);
			?>
		</div>
	
	</div>
	<!-- end of scenario-II -->

	<!-- start of scenario-III-->	
	<div style="width:auto;float:left" class="sc3">	
		<div class="pr_scenario_heading">
			<?php	echo "Scenario-III"; ?>
		</div>
		<div class="required" style="float:none;padding: 5px;">
			<?php
				echo $form->input('nr_reward_pc_for_scenario_3',array(
									'label' => '',
									'type'  => 'text',
									'class' => 'reward_pc required number',
									'value' => number_format($rewardPercent[7]['nr_reward_pc_for_scenario_3'],'2'),
									'maxlength' => '5',
									'max' =>100,
									'min' =>1,
									'onkeyup'=>"extractNumber(this,2,true);",
									'onkeypress'=>"return blockNonNumbers(this, event, true, true);",
									'before'=>'<fieldset style="width: 66px;">',
									'after'=>' % </fieldset>'
								)
				);
			?>
		</div>
		
		<div class="required" style="float:none;padding: 5px;">
			<?php
				echo $form->input('hr_reward_pc_for_scenario_3',array(
									'label' => '',
									'type'  => 'text',
									'class' => 'reward_pc required number',
									'value' => number_format($rewardPercent[8]['hr_reward_pc_for_scenario_3'],'2'),
									'maxlength' => '5',
									'max' =>100,
									'min' =>1,
									'onkeyup'=>"extractNumber(this,2,true);",
									'onkeypress'=>"return blockNonNumbers(this, event, true, true);",
									'before'=>'<fieldset style="width: 66px;">',
									'after'=>' % </fieldset>'
								)
				);
			?>
		</div>
		<div class="required" style="float:none;padding: 5px;">
			<?php
				echo $form->input('js_reward_pc_for_scenario_3',array(
									'label' => '',
									'type'  => 'text',
									'class' => 'reward_pc required number',
									'value' => number_format($rewardPercent[9]['js_reward_pc_for_scenario_3'],'2'),
									'maxlength' => '5',
									'max' =>100,
									'min' =>1,
									'onkeyup'=>"extractNumber(this,2,true);",
									'onkeypress'=>"return blockNonNumbers(this, event, true, true);",
									'before'=>'<fieldset style="width: 66px;">',
									'after'=>' % </fieldset>'
								)
				);
			?>
		</div>
	
	</div>
	<!-- end of scenario-III -->
	
	<!-- start of submit-->	
	<div style="clear:both">
		<?php echo $form->submit('Save',array('style'=>'width:227px;margin-left: 82px;width: 227px;'));?>
	</div>
	<!-- end of submit-->	
  <?php echo $form->end();?>
 </div>		
</div>

<!-- Start Employer data-->
<div class="employer_content">
 <div class="inner-content">
 
 </div>
</div>
</script>
<!-- Graph :: REWARD Vs. TIME -->



<div class="graph_content">

 <div class="graph_inner_content" style="clear:both">
	<div id="graph">Loading graph...</div>
		<?php echo($javascript->link("jscharts.js")); ?>
	</div>
	<div style="clear:both;margin: auto;width: 310px;padding-bottom: 8px;">
	   <div style="float:left">
		   <div style="float:left">2011</div>
		   <div class='nav_year' onclick="return paymentRewardGraph(2011);"> </div>
	   </div>
	   <div style="float:left">
		   <div style="float:left"> <span> <b>| </b></span>  2012</div>
		   <div class='nav_year' onclick="return paymentRewardGraph(2012);"> </div>
	   </div>
	   <div style="float:left">
		   <div style="float:left"> <span> <b>| </b></span>  2013</div>
		   <div class='nav_year' onclick="return paymentRewardGraph(2013);"> </div>
	   </div>

	   <div style="float:left">
		   <div style="float:left"> <span> <b>| </b></span>  2014</div>
		   <div class='nav_year' onclick="return paymentRewardGraph(2014);"> </div>
	   </div>
	   <div style="float:left">
		   <div style="float:left"> <span> <b>| </b></span> 2015</div>
		   <div class='nav_year' onclick="return paymentRewardGraph(2015);"> </div>
	   </div>
	</div>
 </div>
</div>

<script>

function drawGraph(data,year){
	
	var myData = new Array(['Jan',data[0]],
						   ['Feb',data[1]],
						   ['Mar',data[2]],
						   ['Apr',data[3]],
						   ['May',data[4]],
						   ['Jun',data[5]],
						   ['Jul',data[6]],
						   ['Aug',data[7]],
						   ['Sep',data[8]],
						   ['Oct',data[9]],
						   ['Nov',data[10]],
						   ['Dec',data[11]]
						);
	var months = {
     				   'Jan':data[0],
					   'Feb':data[1],
					   'Mar':data[2],
					   'Apr':data[3],
					   'May':data[4],
					   'Jun':data[5],
					   'Jul':data[6],
					   'Aug':data[7],
					   'Sep':data[8],
					   'Oct':data[9],
					   'Nov':data[10],
					   'Dec':data[11]	
					};
	var colors = ['#CE0000', '#EF2323', '#D20202', '#A70000', '#850000', '#740000', '#530000', '#850000', '#B00000', '#9C0404', '#CE0000', '#BA0000'];
	var myChart = new JSChart('graph', 'bar');
	
	myChart.setDataArray(myData);
	myChart.colorizeBars(colors);
	myChart.setDataArray(myData);
	myChart.setTitle('Rewards[in thousands] Vs. Time for year-'+year);
	myChart.setAxisColor('#9D9F9D');
	myChart.setAxisWidth(1);
	myChart.setAxisNameX('');
	myChart.setAxisNameY('$ Reward');
	myChart.setAxisNameColor('#655D5D');
	myChart.setAxisNameFontSize(9);
	myChart.setAxisPaddingLeft(66);
	myChart.setAxisPaddingBottom(30);
	myChart.setAxisValuesDecimals(1);
	
	$.each(months, function(key, value) { 
		if(value){
			myChart.setTooltip([key, 'Reward in Thousand', 1], callback);
		}	
	});
	
	myChart.setAxisValuesColor('#9C1919');
	myChart.setTextPaddingLeft(20);
	myChart.setTextPaddingBottom(13);
	myChart.setBarValuesColor('#9C1919');
	myChart.setBarBorderWidth(0);
	myChart.setTitleColor('#8C8382');
	myChart.setGridColor('#5D5F5D');
	myChart.setSize(616, 321);
	myChart.setBarSpacingRatio(40);
	myChart.setBackgroundImage('/chart_bg.jpg');
	myChart.draw();
	
	$("#map_JSChart_graph img").css({"background":"url('/chart_bg.jpg') repeat scroll 0 0 transparent","border": "0 none","left":"365px","position":"absolute","top":"487px","width":"77px","z-index":"10000000","height":"20px"});
}
function callback(){
	
}


function paymentRewardGraph(yearReward){
		$.ajax({
		url:"/admin/fetchRewardTimeGraph",
		type:"post",
	    dataType:"json",
	 	async:false,
		data: {yearReward:yearReward},
		success:function(response){
			drawGraph(response['data'],response['year']);
		}		
			
	});
}
paymentRewardGraph(2012);
</script>
