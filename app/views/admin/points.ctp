
<script type="text/javascript">
	
	function editPointsInfo(){
		$(document).ready(function(){
			$.validator.messages.required = 'All fields are required';
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
							var user = [];
							var last_to , last_level, last_bonus, last_title ,last_from;
							
							$(".pointLevelFrom input[type=text]").each(function (i){
								var o = {};
								var temp = $(this).parent("div").parent("div").children("input").val() ;
								//alert($(temp).children("input").val());
								//alert( $(this).parent("div").parent("div").next("div div input").val() );
								o.id = $(this).attr("value");
								//o.name = $(this).attr("name");
								user.push(o);
							});	
							//alert(JSON.stringify(user));
							return false;
					
						$("#editPointInfo").click(function(){
							$.validator.messages.required = 'All fields are required';						
						});
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
		});
	}	
	

	
	$(document).ready(function(){
		
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
			<div style="float:right;"><button style="height:25px;padding:2px 8px;" onclick ="editPointsInfo()"> Edit</button> </div>
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
		<div class="pointscontent pointsInfo">Undergraduate University Breakdown:</div>
		<div class="invitaionHeading">
			<div class="gubData"><a href="#" >Rank </a></div>
			<div class="gubData"><a href="#" >Type </a></div>			
			<div class="gubData"><a href="#" >Name </a></div>		
			<div class="gubData"><a href="#" >Points </a></div>						
		</div>
<?php $count=1;?>
			<?php
				//foreach($networkersTitles as $key=>$data){
			?>
			<!--<div class="dataBar <?php if($count%2==0) echo 'even'; else echo 'odd'; ?> pointsLevelHeading" >
					<div class = "networkerPoints">
					</div>
					<div class = "networkerLevel">
					</div >
					<div class="networkerBonus">
					</div>
					<div class="networkerTitle" >
					</div>			
				</div>
			-->
			<?php $count++;?>
			<?		
			//}
			?>
	</div>
	<div class="pointscontent" style="margin-top:10px;">
		<div class="pointscontent pointsInfo">Graduate University Breakdown:</div>
		<div class="invitaionHeading">
			<div class="gubData"><a href="#" >Rank </a></div>
			<div class="gubData"><a href="#" >Type </a></div>			
			<div class="gubData"><a href="#" >Name </a></div>		
			<div class="gubData"><a href="#" >Points </a></div>						
		</div>
		<?php $count=1;?>
			<?php
				//foreach($networkersTitles as $key=>$data){
			?>
			<!--<div class="dataBar <?php if($count%2==0) echo 'even'; else echo 'odd'; ?> pointsLevelHeading" >
					<div class = "networkerPoints">
					</div>
					<div class = "networkerLevel">
					</div >
					<div class="networkerBonus">
					</div>
					<div class="networkerTitle" >
					</div>			
				</div>
			-->
			<?php $count++;?>
			<?		
			//}
			?>
	</div>
	
</div>
<meta charset="utf-8">
	<style>
		body { font-size: 70%; }
		
		#ui-dialog-title-dialog-form { padding:5px; }
		
		fieldset { padding:0; border:0; margin-top:25px; }
		h1 { font-size: 1.2em; margin: .6em 0; }
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
					<div class="" style="clear:both;">
						<div style ="display:none;">
							<?php	echo $form->input("PointLabels.".$key.".id",
										 array('type'  => 'text',
										   'value' => $data['PointLabels']['id'],
											)
							);?>
						</div>
						<div class = "pointInfoDataDiv pointLevelFrom" >
							<?php	echo $form->input("PointLabels.".$key.".point_from",
									 array('label' => ($key != 9)?'-':"",
											'type'  => 'text',
											'class' => 'text_field_bg required number pointInputData',
											'value' => $data['PointLabels']['point_from'],
											)
							);?>
						</div>
						
						<div class = "pointInfoDataDiv" >
							<?php	if($key != 9){
										echo $form->input("PointLabels.".$key.".point_to", array('label' => '',
										'type'  => 'text',
										'class' => 'text_field_bg required number pointInputData',
										'value' => $data['PointLabels']['point_to'],
										));
									}else
									$count++;
							?>
						</div>
						<div class = "pointInfoDataDiv" >
							<?php	echo $form->input("PointLabels.".$key.".level", array('label' => '',
									'type'  => 'text',
									'class' => 'text_field_bg required number pointInputData',
									'value' => $data['PointLabels']['level'],
									)
							);?>
						</div >
						<div class="pointInfoDataDiv" >
							<?php	echo $form->input("PointLabels.".$key.".bonus", array('label' => '%',
									'type'  => 'text',
									//'name'  => "data[$key]['bonus']",
									'width' => '50px',
									'class' => 'text_field_bg required number pointInputData',
									'value' => $data['PointLabels']['bonus'],
									)
							);?>
						</div>
						<div class="pointInfoDataDiv " style="width:120px;" >
							<?php	echo $form->input("PointLabels.".$key.".networker_title", array('label' => '',
									'type'  => 'text',
									//'name'  => "data[$key]['networker_title']",									
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



