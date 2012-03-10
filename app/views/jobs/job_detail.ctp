<script type="text/javascript"> 
	
    function showDescription(){
	    $('#full_description').show();
            $('#short_description').hide();
            $('#more_info').hide();
	}
</script>
		
<!-- ------------------------ PARTICULAR JOB DETAIL ---------------------->	

	
<?php if(isset($job)): ?>	
<div class="page">
	<!-- middle section start -->
	<div class="rightBox" >
		<!-- middle conyent list -->
		<?php $job_array = array('1'=>'Full Time',
                                 '2'=>'Part Time',
								 '3'=>'Contract',
								 '4'=>'Internship',
								 '5'=>'Temporary'); ?>
			<div class="joblist_middleBox">
				<table style="width:100%">
					<tr>
						<td>
							<div>
								<div style="float:left;width:150px;height:90px;">
									<img src="" alt="Company Logo" title="company logo" />
								</div>
								<div>
									<div style="font-size:20px;"><strong><?php echo ucfirst($job['title']); ?></strong>
                                    </div>
									<div style="font-size:13px;line-height:22px;">
										<strong>By Company :</strong> <?php echo $job['company_name']."<br>"; ?>
                                        <strong>Website : </strong><?php	echo $this->Html->link($urls[$job['company_id']], 'http://'.$urls[$job['company_id']]); ?><br>
                                        <strong>Published in :</strong> 
											<?php echo $industries[$job['industry']]." - ".$specifications[$job['specification']].", "; ?>
											<?php  echo $time->timeAgoInWords($job['created'])."<br><br>";?>
									</div>
								</div>
								<div>
									<div style="font-size:15px;padding-left:15px;"><strong>About the Job</strong></div>
                                    <div style="font-size:13px;padding-left:15px;line-height:22px;">
                                    	<strong>Location :</strong> 
											<?php echo $job['city'].", ".$states[$job['id']]."<br>"; ?>
										<strong>Annual Salary Range :</strong> 
											<?php echo $job['salary_from']." - ".$job['salary_to']."<br>"; ?>
										<strong>Type :</strong> 
											<?php echo $job_array[$job['job_type']]."<br>"; ?>
									</div>
									<div style="font-size:13px;padding:10px 15px 25px 15px;">
										<?php echo $job['short_description']."<br>";?>
									</div>
								</div>
								<div style="padding-left:15px;">
									<span style="font-size:15px;">
										<strong><?php echo $job['company_name']; ?></strong></span> - 
												<?php echo $job['city'].", ".$states[$job['id']]."<br>"; ?>
                                                <?php echo $this->Html->link($urls[$job['company_id']], 'http://'.$urls[$job['company_id']]); ?><br><br>
											<div id="short_description" style="font-size:13px;">
											<?php $desc = $job['description'];
													if($desc!=''){
                                                    	$explode = explode(' ',$desc);
														$string  = '';
														$dots = '...';
														if(count($explode) <= 20){
															$dots = '';
														}
														$count  = count($explode)>= 20 ? 20 :count($explode) ;
														for($i=0;$i<$count;$i++){
															$string .= $explode[$i]." ";
														}
														if($dots){
															$string = substr($string, 0, strlen($string));
														}
														echo $string.$dots;
													}?>
											</div>
											<div id="full_description" style="display:none;font-size:13px;">
												<?php echo $job['description'];?>
											</div>
										</div>
										<?php if(str_word_count($desc)>20){?>
											<div id="more_info" align="center" style="font-size:13px;font-weight:normal;">
												<a onclick="showDescription();" style="cursor:pointer">More Info</a>
											</div>
										<?php }?>
									</div>
								<div>
							</div>
							<?php if(isset($userrole) && $userrole['role_id']==2 && !isset($jobapply)){?>
                            <div style="padding:20px;">
                            	<div style="font-size:15px;padding-bottom:20px">
									<a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobs/applyJob/<?php echo $job['id'];?>">
										<strong>Apply for this job</strong>
									</a>
								</div>
							</div>
							<?php }?>
						</td>
					</tr>
				</table>
			</div>	
		<!-- middle conyent list -->
	</div>
	<!-- middle section end -->
</div>
<?php  endif; ?>	

	
