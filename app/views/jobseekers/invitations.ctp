<?php $shortBy="";?>
<?php echo $html->css('datepicker');?>
<script>
	$(document).ready(function(){
		$("#CompaniesEmployeesForm").validate();
	});     

	$('document').ready(function(){
	  
		$("#CompaniesFromDate").datepicker({ minDate: new Date(2012,0,1), maxDate:'+0'});
		$("#CompaniesToDate").datepicker({ minDate: new Date(2012,0,1), maxDate:'+0'});
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
		var from_date=document.getElementById('CompaniesFromDate');
		var to_date=document.getElementById('CompaniesToDate');
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
	function clear_fields(){
		$('select, :text').val("");
		return false;
	}

	function goTo(){
		window.location.href="/companies/postJob";			
	}
</script>


<div class="job_top-heading">
	<?php echo $this->element("welcome_name"); ?>
</div>

<div class="job_container">
    	<div class="job_container_top_row">
    		<?php echo $this->element('side_menu');?>
    		<div class="job_right_bar">
            	<div class="job-right-top-content1">
                	<div class="job-right-top-left" >
   						<h2>Invitations</h2>
   						<?php if(isset($invitations)&&!empty($invitations)):?>
   						<?php if($this->Paginator->numbers()){?>
			            <div class="job_right_pagination invitaion_pagination ">
			                <div>
									<?php echo $paginator->first("<<",array("class"=>"arrow_margin" )); ?>	
							  
							    <ul>
									<?php echo $this->Paginator->numbers(array('modulus'=>8,
																				'tag'=>'li',
																				'separator'=>false,)); ?>
								</ul>
							    <?php echo $paginator->last(">>", array("class"=>"arrow_margin",
							    											));?>
			                </div>
			            </div>
			            <div class="job_preview_bttn"><?php echo $paginator->prev('  '.__('', true), array(), null, array('class'=>'disabled'));?></div>
			            <div class="job_next_bttn"><?php echo $paginator->next(__('', true).' ', array(), null, array('class'=>'disabled'));?></div>
						<?php } ?> 
						<div class="clr"></div>
						<div class="job_right_pagination job-sort-by contacts-sort-by invitaion_right_pagination" style="width:682px !important;">
			               	<div class="job_sort">Sort By:</div>
							<ul>
								<li style="width:16px;"><a class="link-button" href="/jobseekers/invitations">All</a></li>
								<?php
									foreach($alphabets AS $alphabet=>$count){
										$class = 'link-button';
										$url = "/jobseekers/invitations/alpha:$alphabet";
										$urlLink = "<a href=".$url.">". $alphabet ."</a>";
										if($startWith ==$alphabet || $count<1){
											$class = 'current';
											$urlLink = $alphabet;
										}
								?>
								<li class="<?php echo $class; ?>" style="font:15px Arial,Helvetica,sans-serif;"><?php echo $urlLink; ?></a></li>
								<?php
								}
								?>
							</ul>
						</div>
						<div class="job-table-heading job-table-heading-border">
							<ul>
								<li class="invitation-table-name job-table-align2">Email</li>
								<li class="job-table-source job-table-align2">Source</li>
								<li class="job-table-status job-table-align2">Status</li>
							</ul>
						</div>
						<?php
							$status = array("Pending","Accepted");
							$i=0;
						?>
						<?php foreach($invitations AS $contact):?>
						<?php $i++;?>
						<div class="job-table-subheading job-table-heading-border invitation-table-subheading <?php if($i%2==0) echo 'light';else echo 'dark'; ?>">
							<ul >
								<li class="invitation-table-name"><?php echo $contact['Invitation']['name_email']?></li>
				
								<li class="job-table-source">
									<?php echo $contact['Invitation']['from']?>
								</li>
								<li class="job-table-status"><?php echo $status[ $contact['Invitation']['status'] ];?></li>
							</ul>
						</div>
					   	<?php endforeach;?>
						<div class="clr"></div>
						<?php else:?>
							<div class='job-empty-message'>You have not invited any of your friends yet.</div>
						<?php endif;?>
	
                    <div class="clr"></div>
                </div>
            </div>
			</div>
        <div class="clr"></div>
    </div>
    <div class="job_pagination_bottm_bar"></div>
 	<div class="clr"></div>
</div>
</div>
