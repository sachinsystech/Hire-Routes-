<script>

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

<style>
#graph img {
	display:none;
}
</style>
<?php echo $this->Session->flash();?>


<div id="page-heading"><h1>Reward Payment </h1></div>
<div style="clear:both"></div>

<div class="configuration_content">
 <div class="inner-content"  style="width:610px;">	
 
   <span class="rp-error" style="clear:both;color:#FF0000;color: #FF0000;font-size: 13px;margin-left: 62px;">
  
	<?php if(isset($scenario)){
		echo $rp_error;?>
		<style>
		.sc<?php echo $scenario; ?> fieldset{
      		border-color:#FF0000;
    	}
		</style>
	<?php } ?>

  </span>
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
			<span style="margin-left:18px;">$ Paid</span>		
		</div>
		
		<div class="required senarioPersantage">
			<div class="senarioReward">
				<?php 
					echo "$".number_format($configuration['scenario'][1],2);
				?>
			</div>
			<?php
				echo $form->input('nr_reward_pc_for_scenario_1',array(
									'label' => '',
									'type'  => 'text',
									'class' => 'reward_pc required number',
									'value' => number_format($configuration[1],'2'),
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
		
		<div class="required senarioPersantage" >
			<div class="senarioReward"><?php 
					echo "$".number_format($configuration['scenario'][2],2);
				?>
			</div>
			<?php
				echo $form->input('hr_reward_pc_for_scenario_1',array(
									'label' => '',
									'type'  => 'text',
									'class' => 'reward_pc required number',
									'value' => number_format($configuration[2],'2'),
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
		<div class="required senarioPersantage" >
			<div class="senarioReward">
			<?php 
					echo "$".number_format($configuration['scenario'][3],2);
				?>
			</div>
			<?php
				echo $form->input('js_reward_pc_for_scenario_1',array(
									'label' => '',
									'type'  => 'text',
									'class' => 'reward_pc required number',
									'value' => number_format($configuration[3],'2'),
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
			<span style="margin-left:18px;">$ Paid</span>		
		</div>
		<div class="required senarioPersantage">
			<div class="senarioReward"><?php 
					echo "$".number_format($configuration['scenario'][4],2);
				?></div>
			<?php
				echo $form->input('nr_reward_pc_for_scenario_2',array(
									'label' => '',
									'type'  => 'text',
									'class' => 'reward_pc required number',
									'value' => number_format($configuration[4],'2'),
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
		
		<div class="required senarioPersantage" >
			<div class="senarioReward"><?php 
					echo "$".number_format($configuration['scenario'][5],2);
				?></div>
			<?php
				echo $form->input('hr_reward_pc_for_scenario_2',array(
									'label' => '',
									'type'  => 'text',
									'class' => 'reward_pc required number',
									'value' => number_format($configuration[5],'2'),
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
		<div class="required senarioPersantage" >
			<div class="senarioReward"><?php 
					echo "$".number_format($configuration['scenario'][6],2);
				?>
			</div>
			<?php
				echo $form->input('js_reward_pc_for_scenario_2',array(
									'label' => '',
									'type'  => 'text',
									'class' => 'reward_pc required number',
									'value' => number_format($configuration[6],'2'),
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
			<span style="margin-left:18px;">$ Paid</span>		
		</div>
		<div class="required senarioPersantage" >
			<div class="senarioReward"><?php 
					echo "$".number_format($configuration['scenario'][7],2);
				?></div>
			<?php
				echo $form->input('nr_reward_pc_for_scenario_3',array(
									'label' => '',
									'type'  => 'text',
									'class' => 'reward_pc required number',
									'value' => number_format($configuration[7],'2'),
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
		
		<div class="required senarioPersantage" >
			<div class="senarioReward"><?php 
					echo "$".number_format($configuration['scenario'][8],2);
				?></div>
			<?php
				echo $form->input('hr_reward_pc_for_scenario_3',array(
									'label' => '',
									'type'  => 'text',
									'class' => 'reward_pc required number',
									'value' => number_format($configuration[8],'2'),
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
		<div class="required senarioPersantage" >
			<div class="senarioReward"><?php 
					echo "$".number_format($configuration['scenario'][9],2);
				?></div>
			<?php
				echo $form->input('js_reward_pc_for_scenario_3',array(
									'label' => '',
									'type'  => 'text',
									'class' => 'reward_pc required number',
									'value' => number_format($configuration[9],'2'),
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
		<?php echo $form->submit('Save',array('style'=>'width:227px;margin-left:225px;'));?>
	</div>
	<!-- end of submit-->	
  <?php echo $form->end();?>
 </div>		
</div>


<!--  Start Employer data -->
<div class="table_seperator"></div>
<table class="content-table" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<th rowspan="3" class="sized"></th>
			<th class="topleft"></th>
			<td id="tbl-border-top">&nbsp;</td>
			<th class="topright"></th>
			<th rowspan="3" class="sized"></th>
		</tr>
		<tr>
			<td id="tbl-border-left"></td>
		    <td>
				<div class="content-table-inner">
				<div style="float:left">
					<?php
						echo $this->Form->create('paymentInformation',array('url'=>array('controller'=>'admin','action'=>'rewardPayment'),'type'=>'get','onsubmit'=>'return validateForm();'));
			
					?>
					<div style="float:left;width:45px;margin: 2px;">
						<?php echo "<font size='2px'>From :</font>";?>
					</div>
					<div style="float:left;width:95px;">
						<?php 
							/*$date = new DateTime();
							$date->modify(-30 . ' days');
							$last_month= $date->format("m/d/Y");
							$from_date=isset($from_date)?$from_date:$last_month;
							$to_date=isset($to_date)?$to_date:date('m/d/Y');
							*/
							$findUrl=array(
										"from_date"=>isset($from_date)?date("Ymd",strtotime($from_date)):"",
										"to_date"=>isset($to_date)?date("Ymd",strtotime($to_date)):"",
									   );
							echo $this->Form->input('from_date',array(
								'label'=>'',
								'type'=>'text',
								'class'=>'date_field_employee',
								'readonly'=>'true',
								'style'=>'width:75px;',
								'value'=>isset($from_date)?date("m/d/Y",strtotime($from_date)):""
								)
							);
						?>
					</div>
					<div style="float:left;width:30px;margin: 2px;">
						<?php echo "<font size='2px'>To :</font>";?>
					</div>
					<div style="float:left;width:85px;">
					<?php 
						echo $this->Form->input('to_date',array(
							'label'=>'',
							'type'=>'text',
							'readonly'=>'true',
							'class'=>'date_field_employee',
							'style'=>'width:75px;',
							'value'=>isset($to_date)?date("m/d/Y",strtotime($to_date)):"",
							)
						);
					?>
					</div>
					<div style="float:left;width:60px;">
						<?php echo $this->Form->submit('GO',array('name'=>'find','style'=>'width:40px;
height:20px;float:right;'));?>
					</div>
						<button class="button_field div_hover" style="width:50px;height:20px;margin-top:2px;" 
						onclick="return clear_fields();">Clear</button>
					<?php echo $this->Form->end(); ?>
				</div>
					<div class="code_pagination">
								<?php if($this->Paginator->numbers()){ echo $paginator->first('First  |  '); 
										$this->Paginator->options(array('url' =>$findUrl));
									
										echo $paginator->prev('  '.__('Previous ', true), array(), null, array('class'=>'disabled'));	
										echo " < ".$this->Paginator->numbers(array('modulus'=>4))." > ";
										echo $paginator->next(__('Next ', true).' ', array(), null, array('class'=>'disabled'));
										echo $paginator->last('  |  Last'); }
								?>
					</div>
					
				    <table width ="100%" cellspacing='0' class="userTable">
						<tr class="tableHeading">
							<th><?php echo $this->Paginator->sort('Employer','PaymentHistory.employer')?></th>
							<th><?php echo $this->Paginator->sort('Job Title','PaymentHistory.jobTitle')?></th>
							<th><?php echo $this->Paginator->sort('Date Posted','PaymentHistory.datePosted')?></th>
							<th><?php echo $this->Paginator->sort('Reward($)','PaymentHistory.amount')?></th>
						    <th><?php echo $this->Paginator->sort('Date Paid','PaymentHistory.paid_date')?></th>
						    <th>Transaction Id</th>
						    <th> </th>
					    </tr>
						<?php 
							if($paymentHistories){
								$sno = 0;
								foreach($paymentHistories as $paymentHistory):
									$class = $sno++%2?"odd":"even";
						?>
						<tr class="<?php echo $class; ?>">
							<!-- td align="center" width="4%"> <?php //echo $sno;?></td --> 

							<td width="15%" style="padding:7px;">
								<a href="/admin/employerSpecificData/<?php echo $paymentHistory['Company']['user_id'];?>">
									<?php echo $paymentHistory['Company']['company_name'];?>
								</a>								
							</td> 
							<!-- td align="center" width="15%">
								<?php //echo $paymentHistory['Jobseeker']['contact_name'];?>
							</td -->
							<td  width="17%" style="padding-left:18px">
								<?php echo ucfirst($paymentHistory['Job']['title']);?>
							</td>
							<td align="center" width="12%">
								<?php echo date('m/d/Y',strtotime($paymentHistory['Job']['created']))."&nbsp;";?>
							</td>
							<td align="right" width="10%" style="padding-right:5px;">
								<?php
									echo $this->Number->format(
										$paymentHistory['PaymentHistory']['amount'],
										array(
											'places' => 2,
											//'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?>
							</td>
							<td align="center" width="12%">
								<?php echo date('m/d/Y',strtotime($paymentHistory['PaymentHistory']['paid_date']))."&nbsp;";?>
							</td>
							<td align="center" width="15%">
								<?php echo $paymentHistory['PaymentHistory']['transaction_id'];?>
							</td>
							<td align="center" width="10%" style="font-size:12px;">
								<?php echo $html->link("View Details", array('controller' => 'admin','action'=>'paymentDetails', $paymentHistory['PaymentHistory']['id']));?>
							</td>
					    </tr>
		      			<?php 
				    			endforeach; 
				    		}else{
						?>
						<tr class="odd">			
				    		<td colspan="8" align="center" style="line-height: 25px;">Sorry no result found.</td>
						</tr>
						<?php
				    		}
						?>
					</table>
				</div>
			</td>
			<td id="tbl-border-right"></td>
		</tr>
		<tr>
			<th class="sized bottomleft"></th>
			<th id="tbl-border-bottom">&nbsp;</th>
			<th class="sized bottomright"></th>
		</tr>
	</tbody>
</table>
<!-- 	End Employer data --	>



<!-- Graph :: REWARD Vs. TIME -->

<div class="graph_content">

 <div class="graph_inner_content" style="clear:both">
	<div id="graph">Loading graph...</div>
		<?php echo($javascript->link("jscharts.js")); ?>
	</div>
	<div id ="graphYear" style="clear:both;margin: auto;width: 0px;padding-bottom: 8px;">
	<?php 
		$j=0;
		$currentYear=Date("Y"); 
		for($i=2011;$i<=$currentYear;$i++,$j++){ ?>
			<div style="float:left">
			   <div style="float:left">
			   <?php if($j%5!=0)echo "<span> <b>| </b></span>";echo $i?></div>
			   <div class="nav_year <?php echo ($currentYear == $i)?'active_year':'';?>"
			   	onclick="return paymentRewardGraph(<?php echo $i?> ,this);"> </div>
		   </div>
	<?}
		echo "<script> $('#graphYear').width(".(55*$j).");</script>";
	?>
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
	var colors = ['#7979DB','#7979DB', '#7952E9', '#7952E9', '#792BC8', '#792BC8', '#792BA1',  '#792BA1', '#792BA1', '#792BA1', '#792B79','#792B79'];
	var myChart = new JSChart('graph', 'bar');
	
	myChart.setDataArray(myData);
	myChart.colorizeBars(colors);
	myChart.setDataArray(myData);
	myChart.setTitle('Reward in Thousand [ Year-'+year+' ] ');
	myChart.setAxisColor('#9D9F9D');
	myChart.setAxisWidth(1);
	myChart.setAxisNameX('');
	myChart.setAxisNameY('$ Reward');
	myChart.setAxisNameColor('#655D5D');
	myChart.setAxisNameFontSize(9);
	myChart.setAxisPaddingLeft(66);
	myChart.setAxisPaddingBottom(30);
	myChart.setAxisValuesDecimals(1);
	myChart.set3D(true);
	
	$.each(months, function(key, value) { 
		if(value){
			myChart.setTooltip([key, 'Total Rward = $'+number_format(value*1000,2), 1], callback);
		}	
	});
	
	myChart.setAxisValuesColor('#9C1919');
	myChart.setTextPaddingLeft(20);
	myChart.setTextPaddingBottom(13);
	myChart.setBarValuesColor('#0000FF');
	myChart.setBarBorderWidth(1);
	myChart.setTitleColor('#FF0000');
	myChart.setTitleFontSize(15);
	myChart.setGridColor('#5D5F5D');
	myChart.setSize(616, 321);
	myChart.setBarSpacingRatio(40);
	myChart.setBackgroundImage('/chart_bg.jpg');
	myChart.draw();
}
function callback(){
	
}

	function paymentRewardGraph(yearReward , field){ 
		if(field){
			$(".active_year").removeClass("active_year");
			$(field).addClass("active_year");
		}
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
	
	paymentRewardGraph((new Date).getFullYear());
</script>



<?php echo $html->css('datepicker');?>
<script>
	$('document').ready(function(){
		$("#paymentInformationFromDate").datepicker({ minDate: new Date(2012,2,1), maxDate:'+0'});
		$("#paymentInformationToDate").datepicker({ minDate: new Date(2012,2,1), maxDate:'+0'});
	});
</script>
<script type='text/javascript'>	
	function validateDate(datefield)
	{
		var date1=datefield.value.split('/');
		if(date1.length==3&&date1[2].match('\^2[0-9]{3}\$')&&date1[0].match('\^[0-1]{1}[0-9]{1}\$')&&date1[1].match('\^[0-3]{1}[0-9]{1}\$'))
		{
			return true;
		}
		else
		{
			alert('Invalid Date');
			datefield.value="";
			datefield.focus();
			return false;
		}
	}
	
	function validateDateRange(from,to)
	{
		date1=from.value.split('/');
		date2=to.value.split('/');
		var from_date=new Date(date1[2],date1[0],date1[1]);
		var to_date= new Date(date2[2],date2[0],date2[1]);
		if(from_date>to_date)
		{
			alert("Invalid period");
			return false;
		}
		return true;
	}

	function validateForm()
	{
		var from_date=document.getElementById('paymentInformationFromDate');
		var to_date=document.getElementById('paymentInformationToDate');
		if(from_date.value==""||to_date.value=="")
		{
		}
		else
		{
			if(validateDate(from_date)&&validateDate(to_date)&&validateDateRange(from_date,to_date))
				return true;
			else
				return false;
		}
	}
	
	function resetFields(){
	
	
	}
</script>
