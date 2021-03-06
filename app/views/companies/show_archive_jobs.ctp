<?php ?>
<script>
	$(document).ready(function(){
		$("#short_by1").change(function(){
			onSelectChange($("#short_by1").val());
		});
		$("#short_by2").change(function(){
			onSelectChange($("#short_by2").val());
		});
	});

	function onSelectChange(sortby){
		var shortSelected = $("#short_by option:selected"); 
		window.location.href="/companies/showArchiveJobs/shortby:"+sortby;
	}

	function onDelete(id)
	{	if(confirm("Do you want to delete?")){
			$.ajax({
				url: "/companies/deleteJob",
				type: "post",
				dataType:"json",
				data: {jobId : id,action:'archiveJobs'},
				success: function(response){
					if(response.error==1){
						alert(response['message']);
						return;
					}
					window.location.reload();	      
				},
				error:function(response)
				{
					alert("You may be clicked on old link or entered manually");
				}
			});
		}
		return false;
	}

	function goTo(){
		window.location.href="/companies/postJob";			
	}
</script>

<div class="job_top-heading">
<?php if($this->Session->read('Auth.User.id')):?>
	<?php if($this->Session->read('welcomeName') && ($this->Session->read('UserRole'))):?>
			<h2>WELCOME <?php echo strtoupper($this->Session->read('welcomeName'));?>!</h2>
	<?php endif; ?>
<?php endif; ?>
</div>

<div class="job_container">
	<div class="job_container_top_row">
		<?php echo $this->element('side_menu'); ?>
		<div class="job_right_bar">
			<div class="job_right_top_bar">
				<div class="job_right_sortby">
					<div class="job_right_shortby_txt">Sort By:</div>
					<div class="job_right_shortby_field">
						<select id="short_by1">
							<option value="date-added" <?php echo $shortBy=="date-added"?"selected":"" ?> >Date Added</option>
							<option value="industry" <?php echo $shortBy=="industry"?"selected":"" ?> >Industry</option>
							<option value="salary" <?php echo $shortBy=="salary"?"selected":"" ?> >Salary</option>
						</select>
						
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
																	)); }?>
					 <!---<a class="arrow_margin" href="#">&gt;&gt;</a>-->
				 </div>
				
				</div>
					<?php if($this->Paginator->numbers()){?>
					<div class="job_preview_bttn"><?php echo $paginator->prev('  '.__('', true), array(), null, array('class'=>'disabled'));?></div>
					<div class="job_next_bttn"><?php echo $paginator->next(__('', true).' ', array(), null, array('class'=>'disabled'));?>
					</div>
					<?php } ?>
				</div>
			
			<?php if(empty($jobs)){ ?>
				<div class="job-empty-message">There is no archived by you.</div>
			<?php } ?>
			
			 <?php foreach($jobs as $job):?>
			<div class="job_right_section job_right_hover">
				<div class="job_right_section_left">
					<h2><a href="#" ><?php echo ucfirst($job['Job']['title']) ?></a></h2>
					<p class="job-right-section-p">Posted: <?php echo $time->timeAgoInWords($job['Job']['created'],'m/d/Y');?></p>
					<p class="job-submission-margin">Submissions: <span><?php echo $job[0]['submissions']; ?></span></p>
				</div>
				<div class="job-right-rightmost">
					
					<!-- a class="job-details" href="#" ></a>
					<a class="job-archive" href="#" ></a>
					<a class="job-person" href="#" ></a>
					<a class="job-stats" href="#" ></a>
					<a class="job-edit" href="#" ></a -->
					<a class="job-cancel" href="javascript:void(0);"  style="float:right" onclick="return onDelete(<?php echo $job['Job']['id']; ?>)" title='Delete'></a>
				</div>                   
			</div>
			<?php endforeach; ?>
			
		</div>
	</div>
	<div class="job_pagination_bottm_bar">
		<div class="job_right_sortby">
				<div class="job_right_shortby_txt">Sort By:</div>
				<div class="job_right_shortby_field">
					<select id="short_by2">
						<option value="date-added" <?php echo $shortBy=="date-added"?"selected":"" ?> >Date Added</option>
						<option value="industry" <?php echo $shortBy=="industry"?"selected":"" ?> >Industry</option>
						<option value="salary" <?php echo $shortBy=="salary"?"selected":"" ?> >Salary</option>
					</select>
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
	<div class="clr"></div>
</div>
<div class="clr"></div>

