<?php $shortBy="";?>
<script>
	function goTo(){
		window.location.href="/companies/postJob";			
	}
</script>
<div class="page">
	<!-- left section start -->	
	<div class="leftPanel">
		<div class="sideMenu">
			<?php echo $this->element('side_menu');?>
		</div>
	</div>
	<!-- left section end -->
	<!-- middle section start -->
	<div class="rightBox" style=width:860px;">
		<!-- middle conent top menu start -->
		<div class="topMenu">
			<?php echo $this->element('top_menu');?>
		</div>
		<!-- middle conyent top menu end -->
		<!-- middle conyent list -->
			<div class="middleBox">
			<table style="width:100%">
				<tr >
					<td colspan="100%">
						<div style="width:350px;">
							<?php echo $form->create('Companies',array('action'=>'employees'))?>
							<?php echo $form->input('username',array("class"=>'text_field_bg'));
								  echo $form->submit('Search', array('name'=>'cancel',"style"=>'width:100px;')); 
							?>
						</div>
					
						<!--<div style="width:250px;float:right;">
							Status<select  id="short_by_status">
							<option value="active" <?php echo $shortBy=="date-added"?"selected":"" ?> >Active</option>
							<option value="deactive" <?php echo $shortBy=="industry"?"selected":"" ?> >Deactive</option>
							<option value="delete" <?php echo $shortBy=="salary"?"selected":"" ?> >Salary</option>
							</select>
						</div>
					-->
						<div style="float:right;width:50%;text-align:right;">
							<?php echo $paginator->first(' << ',null, null, array("class"=>"disableText"));?>
							<?php echo $this->Paginator->prev(' < ',null, null, array("class"=>"disableText")); ?>
							<?php echo $this->Paginator->numbers(array('modulus'=>4)); ?>
							<?php echo $this->Paginator->next(' > ',null, null, array("class"=>"disableText")); ?>
							<?php echo $paginator->last(' >> ',null, null, array("class"=>"disableText"));?>
						</div>
					</td>
				</tr>
				<tr>
					<th style="width:5%">#</th>
					<th style="width:15%"><?php echo $paginator->sort('Name','js.contact_name');?></th>
					<th style="width:20%">Address</th>
					<th style="width:25%">Email</th>
					<th style="width:20%">Contact no.</th>
					<th style="width:20%"><?php echo $paginator->sort('Date', 'paid_date');?></th> 
					<!--<th style="width:10%">Action</th>-->
				</tr>
				<?php if(empty($employees)){ ?>
				<tr>
					<td colspan="100%">Sorry, No Employee found.</td>
				</tr>
				<?php } ?>
				<?php $count=1; foreach($employees as $employee):?>	
				<tr><td><? echo $count++; ?></td>
					<?php if(!empty($employee['js']['contact_name']) ):?>
						<td><?php echo ucFirst($employee['js']['contact_name']);?></td>
					<?php else:?>
						<td> -- -- -- </td>
					<?php endif;?>
					<td><?php echo $employee['js']['state'].' , '.$employee['js']['city'];?></td>
					<td><?php echo $employee['users']['account_email'];?></td>
					<td><?php echo $employee['js']['contact_phone'];?></td>
					<td><?php echo $this->Time->format('m/d/Y', $employee['PaymentHistory']['paid_date']);?></td>
					<!--<td><?php /*echo $this->Html->image("/img/icon/delete.png",
														array(
															"alt" => "image",
															"width"=>"24","height"=>"24",
															'url'=>'javascript:void(0);',
														    'title'=>'Delete',
															)
													);
 						*/?>
					</td>-->
				</tr>
			
				<?php endforeach; ?>	
				<?php echo $form->end();?>		
			</table>
		</div>
		<div class="postNewJob" onclick="goTo();">POST NEW JOB</div>
		<!-- middle conyent list -->
		</div>
	<!-- middle section end -->
</div>
