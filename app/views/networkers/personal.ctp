<div class="middle">
	<div class="job_top-heading">
		<?php echo $this->element("welcome_name"); ?>
	</div>
    <div class="job_container">
    	<div class="job_container_top_row">
    		<?php echo $this->element('side_menu');?>
    		<div class="job_right_bar">
            	<div class="job-right-top-content1">
                	<div class="job-right-top-left"> 
                    	<h2>NETWORKER STATS</h2>
                    	<p>Total: <span><?php echo isset($networkerDataCount)?array_sum($networkerDataCount):"0";?></span></p>
                    	<?php if(isset($networkerDataCount)){ ?>
	                    	<?php foreach($networkerDataCount as $key => $value){ ?>
    	                	<p><?php
    	                		$num =$key+1; 
   	                			    if (!in_array(($num % 100),array(11,12,13))){
   	                			    
									  switch ($num % 10) {
										case 1:
										  $i = $num.'st°:';break;
										case 2:
										  $i = $num.'nd°:';break;
										case 3:
										  $i = $num.'rd°:';break;
										default:
										 $i = $num.'th°:';
									  }
									}
									echo $i;
    	                		?>&nbsp;<span><?php echo $value;?></span></p>
    	                	<?php }?>
    	                <?php } ?>
                    </div>
                    <div class="job-right-top-right" >
                    	<div id="invitationList">
							<?php //echo $this->element("networker_invitations");?>
						</div> 
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="job-right-bottom-right" >
                	<h2>MY NETWORKERS</h2>
                	<div class="sub_netwokres_data">
	                	<?php if(isset($this->Paginator) && $this->Paginator->numbers()){?>
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
                    <div class="job-table-heading">
		        		<ul>
		                	<li class="job-table-email job-table-align">Name/Email</li>
		                    <li class="job-table-netw job-table-align">Networkers</li>
		                    <!--<li class="job-table-degree job-table-align">Degree</li>-->
		                    <li class="job-table-points job-table-align">Points</li>
		                    <li class="job-table-reward job-table-align">Reward</li>
		                    <li class="job-table-level job-table-level-align job-table-align">Level</li>
		                </ul>
                    </div>
                     <div class="clr"></div>
                    <?php if(isset($networkerData) && $networkerData != null){ 
                    	$i=0;?>
                    	<?php foreach($networkerData as $key => $value){
                    			foreach($value as $key1=> $data){
                    	  ?>
                   	  <div class="job-table-data">
						<ul >
                            <li class="job-data-name job-table-align <?php if($i%2==0) echo'dark';?>"><?php echo $data['User']['account_email'] ;?></li>
                            <li class="job-data-netw job-table-align <?php if($i%2==0) echo'dark';?>"><?php echo $data['networkers']; ?></li>
                            <!--<li class="job-data-degree job-table-align <?php if($i%2==0) echo'dark';?>"><?php echo $networkerDegree +$key+1 ?></li>-->
                            <li class="job-data-points job-table-align <?php if($i%2==0) echo'dark';?>"><?php echo $data['Networker']['points'] ;?></li>
                            <li class="job-data-reward job-table-align <?php if($i%2==0) echo'dark';?> "><?php echo 
                            	$this->Number->format($data['reward'],
													array(
														'places' => 2,
														'before' => '$',
														'decimals' => '.',
														'thousands' => ',')
													);?></li>
                                <li class="job-data-level job-table-align <?php if($i%2==0) echo'dark';?>"><?php echo $key+1?></li>
                            </ul>
						</div>
							<?php $i++;?>
                           <?php }} ?>
                    <?php }else{ ?>
                    <div class="networkers-message">
                    	No Networker Found.
                    </div>
                    <?php } ?>
                    </div>
                </div>
            </div>
        <div class="clr"></div>
    </div>
    <div class="job_pagination_bottm_bar"></div>
 	<div class="clr"></div>
</div>
</div>
</div>
<!======================================================>
<script type="text/javascript">
	$(document).ready(function() {
		loadPiece("<?php echo $html->url(array('controller'=>'Networkers','action'=>'invitations'));?>","#invitationList");
	});
</script>
<script type="text/javascript">
function loadPiece(href,divName) {    
    $(divName).load(href, {}, function(){
        var divPaginationLinks = divName+" #pagination a";
        $(".invitaionHeading ul li a").click(function(){
           var thisHref = $(this).attr("href");
            loadPiece(thisHref,divName);
            return false;
        });
        
        
        $(divPaginationLinks).click(function() {     
            var thisHref = $(this).attr("href");
            loadPiece(thisHref,divName);
            return false;
        });
    });
} 
</script>
