<script type="text/javascript">
	function VaildPointInfo(){
		var flag = true;
		$(".pointLevelTo input[type=text]").each(function (i){
			var point_from = $(this).parents(".pointLevelTo").prev(".pointLevelFrom").find("input[type=text]").val() ;
			if( parseInt($(this).val()) <=  parseInt(point_from) ){
				alert("Point_From value must be less than to Point_To value");
				$(this).css({'color':'red','border':'1px solid red'});
				flag = false;
				return false;
			}
			var point_level = $(this).parents(".pointLevelTo").next(".pointLevelLevel").find("input[type=text]") ;

			var next_point_level = $(this).parents(".pointDataRow").next(".pointDataRow").find(".pointLevelLevel input[type=text]").val() ;
			if( parseInt($(point_level).val()) >= parseInt(next_point_level) ){
				alert("Point_Level value must be less than to next Point_Level value");
				$(point_level).css({'color':'red','border':'1px solid red'});
				flag = false;
				return false;
			}else{
				$(this).css({'color':'','border':''});
			}
	
			var point_bonus = $(this).parents(".pointLevelTo").next("div").next(".pointLevelBonus").find("input[type=text]") ;
			var next_point_bonus = $(this).parents(".pointDataRow").next(".pointDataRow").find(".pointLevelBonus input[type=text]").val() ;
			if( parseInt($(point_bonus).val()) >= parseInt(next_point_bonus) ){
				alert("Point_Bonus value must be less than to next Point_Bonus value");
				$(point_bonus).css({'color':'red','border':'1px solid red'});
				flag = false;									
				return false;
			}else{	
				$(this).css({'color':'','border':''});
			}
		return true;
		});
		return flag;
	}
		
	function editPointsInfo(){
		$(document).ready(function(){
			$("#editPointInfo").click(function(){
				$.validator.messages.required = 'All fields are required';
			});	

			$("#dialog-form").dialog({
				height:450,
				width:600,
				modal:true,
				resizable: false ,
				draggable: true,
				title:"Edit Points Level Information",
				show: { 
					effect: 'drop', 
					direction: "up" 
				},
				buttons: {
					"Save": function() {
							var i=0;
							var flag = true;
							$("input[type=text]").css({'color':'','border':''});
							$("input[type=submit]").click();
					},
					"Cancel": function() {
						$(this).dialog( "close" );
					}
				},
				close: function() {
					//$( this ).dialog( "close" );
				}
			});
			$("#PointLabels0PointTo").focus();
		});
		
	}	
	
	$(document).ready(function(){
		
		
		$("#EditPointsLevelInfoPointsForm").submit(function(){ 
							if(! VaildPointInfo()){
								return false;		
							}
		});
		
		$(".pointLevelTo input[type=text]").blur(function(){
			var point_from = $(this).parents(".pointLevelTo").prev(".pointLevelFrom").find("input[type=text]").val() ;
			if( parseInt($(this).val()) <=  parseInt(point_from) ){
				$(this).css({'color':'red','border':'1px solid red'});
				return false;
			}else{
				if($(this).val() != ''){
					$(this).parents(".pointDataRow").next(".pointDataRow").find(".pointLevelFrom input[type=text]").val( parseInt( $(this).val() )+1 );
					$(this).css({'color':'','border':''});
				}
			}
			
		});
		
		$(".pointLevelLevel input[type=text]").blur(function(){
			var prev_point_level = $(this).parents(".pointDataRow").prev(".pointDataRow").find(".pointLevelLevel input[type=text]").val() ;
			var next_point_level = $(this).parents(".pointDataRow").next(".pointDataRow").find(".pointLevelLevel input[type=text]").val() ;
			if( parseInt($(this).val()) >= parseInt(next_point_level) || parseInt($(this).val()) <= parseInt(prev_point_level) ){
				$(this).css({'color':'red','border':'1px solid red'});
				return false;
			}else{
				$(this).css({'color':'','border':''});
			}
			
		});
		
		$(".pointLevelBonus input[type=text]").blur(function (){
			var prev_point_bonus = $(this).parents(".pointDataRow").prev(".pointDataRow").find(".pointLevelBonus input[type=text]").val() ;		
			var next_point_bonus = $(this).parents(".pointDataRow").next(".pointDataRow").find(".pointLevelBonus input[type=text]").val() ;
			if( parseInt($(this).val()) >= parseInt(next_point_bonus) || parseInt($(this).val()) <= parseInt(prev_point_bonus)){
				$(this).css({'color':'red','border':'1px solid red'});
				return false;
			}else{	
				$(this).css({'color':'','border':''});
			}
		
		});
		
		$("#configData").click(function(){
			$.validator.messages.required = 'This field are required';
		});
	
		$("#CompaniesPointsForm").validate({
			  errorClass: 'error_input_message',
			   errorPlacement: function (error, element) {
			       error.insertAfter(element)
			       error.css({'overflow':'auto','width':'208px'});
            	}
		});
		
		$("#EditPointsLevelInfoPointsForm").validate({
			errorClass: 'error_input_message',
			errorPlacement: function (error, element) {
				element.css({'color':'red','border':'1px solid red'});
				error.appendTo($("#editFormError").html(" "));
           	},
		});
	});
	
</script>     
<div id="page-heading"><h1>Points </h1></div>
<div class="networkerPointContent">
	<div style="float:left;width:170px;">
		<?php echo $this->Form->create('', array('url' => array('controller' => 'admin', 'action' => 'points'))); ?>
		<div class="pointsInputBox">
			<?php	echo $form->input('Config.jobseekers_point_number', array('label' => 'Jobseekers:',
					'type'  => 'text',
					'class' => 'text_field_bg required number',
					'minlength' => '1',
					'value' =>isset($config[1]['Config']['value'])?$config[1]['Config']['value']:"",
					)
			);?>
		</div>
		<div class="pointsInputBox">
			<?php	echo $form->input('Config.company_point_number', array('label' => 'Company / Recruiter:',
					'type'  => 'text',
					'class' => 'text_field_bg required number',
					'minlength' => '1',
					'value' =>isset($config[0]['Config']['value'])?$config[0]['Config']['value']:"",
					)
			);	?>	
		</div>
		<?php if(isset($error)){ ?>
			<div class="pointsInputBox error_input_message points_error" >
				<?php echo $error;?>
			</div>
		<?php } ?>
		<?php echo $form->submit('Save Changes',array('div'=>false,'id'=>'configData')); ?>	
		<?php echo $form->end(); ?>
	</div>
	<div style="float:right;width:375px;height:200px;" class="invitationData">
		<div class="pointsInfo" >
			Your Total Experience
			<div style="float:right;"><button style="height:25px;padding:2px 8px;margin-right: 20px;" onclick ="editPointsInfo()"> Edit</button> </div>
		</div>
		<div class="pointsData">
			<div class ="pointsLevelHeading invitaionHeading">
				<div  class = "networkerPoints" >
					Points
				</div>
				<div class = "networkerLevel" style="font-weight:bold;">
					Level
				</div>
				<div class="networkerBonus" style="font-weight:bold;">
					Bonus %
				</div>
				<div class="networkerTitle" style="font-weight:bold;">
					Networker Title
				</div>			
			</div>
			<?php $count=1;?>
			<?php
				foreach($pointLables as $key=>$data){ //print_r($data);exit;
			?>
				<div class="dataBar <?php if($count%2==0) echo 'even'; else echo 'odd'; ?> pointsLevelHeading" >
					<div class = "networkerPoints">
						<?php echo $data['PointLabels']['point_from'];?>
						<?php echo $data['PointLabels']['point_to']!= null ? " - ".$data['PointLabels']['point_to']: "+" ; ?>
					</div>
					<div class = "networkerLevel">
						<?php echo $data['PointLabels']['level']; ?>
					</div >
					<div class="networkerBonus">
						<span>+ <?php echo $data['PointLabels']['bonus']; ?> %</span>
					</div>
					<div class="networkerTitle" >
						<?php echo $data['PointLabels']['networker_title']; ?>	
					</div>			
				</div>
			<?php $count++;?>
			<?		
			}
			?>
		</div>
	</div>
	<div class="pointscontent" >
		<div class="pointsInfo">Undergraduate University Breakdown:</div>
		<div class="invitaionHeading">
			<div class="gubData"><a href="#" >Rank </a></div>
			<!--<div class="gubData"><a href="#" >Type </a></div>-->
			<div class="gubData" style="width:155px;"><a href="#" >Name </a></div>		
			<div class="gubData"><a href="#" >Points </a></div>						
		</div>
<?php $count=1;?>
		<div style="height:300px;overflow:scroll;">
			<?php
				foreach($universities as $key=>$data){
			?>
			<div class="dataBar <?php if($count%2==0) echo 'even'; else echo 'odd'; ?> pointsLevelHeading" >
				<div class = "networkerPoints">
					<?php echo $data['University']['id'] ;?>
				</div>
				<!--
				<div class = "networkerLevel">
					<?php //echo $data['University']['id'] ;?>
				</div >-->
				<div class="networkerBonus" style="width:155px;">
					<?php echo $data['University']['name'] ;?>
				</div>
				<div class="networkerTitle" style="text-align:center;" >
					<?php echo $data['University']['points'] ;?>					
				</div>			
			</div>
			
			<?php $count++;?>
			<?		
			}
			?>
		</div>
	</div>
	<div class="pointscontent" style="margin-top:10px;">
		<div class="pointsInfo">Graduate University Breakdown:</div>
		<div class="invitaionHeading">
			<div class="gubData"><a href="#" >Rank </a></div>
			<div class="gubData"><a href="#" >Type </a></div>			
			<div class="gubData"><a href="#" >Name </a></div>		
			<div class="gubData"><a href="#" >Points </a></div>						
		</div>
		<?php $count=1;?>
		<div style="height:300px;overflow:scroll;">
			<?php
				foreach( $graduateUniversity as $key=>$data){
			?>
			<div class="dataBar <?php if($count%2==0) echo 'even'; else echo 'odd'; ?> pointsLevelHeading" >
					<div class = "networkerPoints">
						<?php echo $data['GraduateUniversityBreakdown']['id'] ;?>
					</div>
					<div class = "networkerLevel">
						<?php echo $data['GraduateDegrees']['degree'] ;?>					
					</div >
					<div class="networkerBonus">
						<?php echo $data['GraduateUniversityBreakdown']['graduate_college'] ;?>
					</div>
					<div class="networkerTitle" style="text-align:center;">
						<?php echo $data['GraduateUniversityBreakdown']['points'] ;?>					
					</div>			
				</div>
			<?php $count++;?>
			<?		
			}
			?>
		</div>
	</div>
	
</div>
<meta charset="utf-8">
	<style>
		body { font-size: 70%; }
		
		#ui-dialog-title-dialog-form { padding:5px; }
		
		fieldset { padding:0; border:0; margin-top:25px; }
		
		div#users-contain { width: 350px; margin: 20px 0; }
		div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
		div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
		.ui-dialog .ui-state-error { padding: .3em; }
		.validateTips { border: 1px solid transparent; padding: 0.3em; }
	</style>
	
<div id="dialog-form" style="display:none;padding:12px">
	<?php echo $this->Form->create('EditPointsLevelInfo', array('url' => array('controller' => 'admin', 'action' => 'editPointsLevelInfo'))); ?>
	<fieldset>
		<div style="width:430px;height:250px;margin:auto;">
			<div class="">
				<div id="editFormError" >
				
				</div>
				<div class ="pointEditHeading" >
					<div class="pointInfoDataDiv" style="width:85px;">
						Point- From
					</div>
					<div class="pointInfoDataDiv">
						Point-to
					</div>
					<div class="pointInfoDataDiv">
						Level
					</div>				
					<div class="pointInfoDataDiv">
						Bouns
					</div>
					<div class="pointInputTitle" style="width:120px;">
						Networker Title
					</div>
				</div>				
				<?php
					foreach($pointLables as $key=>$data){ //print_r($data);exit;
						$count=1;
						$inputName = "point".$key;
				?>
					<div class="pointDataRow" style="clear:both;">
						<div style ="display:none;">
							<?php	echo $form->input("PointLabels.".$key.".id",
										 array('type'  => 'text',
										   'value' => $data['PointLabels']['id'],
											)
							);?>
						</div>
						<?php $class = ($key == 9)? "pointLastFromInput" : "";?>
						<div class = "pointInfoDataDiv pointLevelFrom <?php echo $class ?>" >
							<?php	echo $form->input("PointLabels.".$key.".point_from",
									 array('label' => ($key != 9)?'-':"+",
											'type'  => 'text',
											'readonly'=>'readonly',
											'class' => 'text_field_bg required number pointInputData',
											'value' => $data['PointLabels']['point_from'],
											)
							);?>
						</div>
						<?php $class = ($key == 9)? "pointLastToInput" :"pointInfoDataDiv"; ?>
						<div class = " pointLevelTo <?php echo $class ?>" >
							<?php	if($key != 9){
										echo $form->input("PointLabels.".$key.".point_to", array('label' => '',
										'type'  => 'text',
										'class' => 'text_field_bg required number pointInputData',
										'value' => $data['PointLabels']['point_to'],
										));
									}
									else{
										echo $form->input("PointLabels.".$key.".point_to", array('label' => '',
										'type'  => 'hidden',
										'class' => 'text_field_bg required number',
										'value' => "",
										));
									}
									
									$count++;
							?>
						</div>
						<div class = "pointInfoDataDiv pointLevelLevel" >
							<?php	echo $form->input("PointLabels.".$key.".level", array('label' => '',
									'type'  => 'text',
									'class' => 'text_field_bg required number pointInputData',
									'value' => $data['PointLabels']['level'],
									)
							);?>
						</div >
						<div class="pointInfoDataDiv pointLevelBonus" >
							<?php	echo $form->input("PointLabels.".$key.".bonus", array('label' => '%',
									'type'  => 'text',
									'width' => '50px',
									'class' => 'text_field_bg required number pointInputData',
									'value' => $data['PointLabels']['bonus'],
									)
							);?>
						</div>
						<div class="pointInfoDataDiv " style="width:120px;" >
							<?php	echo $form->input("PointLabels.".$key.".networker_title", array('label' => '',
									'type'  => 'text',
									'class' => 'text_field_bg required pointInputTitle',
									'value' => $data['PointLabels']['networker_title'],
									)
							);?>
						</div>			
					</div>
				<?php $count++;?>
				<?		
				}
				?>
				<?php echo $form->submit('Save',array('div'=>false,'style'=>'display:none;','id'=>'editPointInfo')); ?>
			</div>
		</div>
	</fieldset>
	<?php echo $form->end(); ?>
</div>



