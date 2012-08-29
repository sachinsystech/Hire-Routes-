<div class="middle">
	<div class="job_top-heading">
	<?php if($this->Session->read('Auth.User.id')):
		if($this->Session->read('welcomeName') && ($this->Session->read('UserRole'))):?>
			<h2>WELCOME <?php echo strtoupper($this->Session->read('welcomeName'));?>!</h2>
		<?php endif;
		endif;
	?>
	</div>
    <div class="job_container">
    	<div class="job_container_top_row">
    		<?php echo $this->element('side_menu');?>
    		<div class="job_right_bar">
            	<div class="job-right-top-content1">
                	<div class="job-right-top-left"> 
                    	<h2>NETWORKER STATS</h2>
                    	<p>Total: <span>678</span></p>
                    	<p>1st°: <span>20</span></p>
                    	<p>2nd°: <span>105</span></p>
                    	<p>3rd°: <span>367</span></p>
                    	<p>4th°: <span>400</span></p>
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
						
                	
                    <div class="job-table-heading">
                    		<ul>
                            	<li class="job-table-name job-table-align">Name/Email</li>
                                <li class="job-table-netw job-table-align">Networkers</li>
                                <li class="job-table-degree job-table-align">Degree</li>
                                <li class="job-table-points job-table-align">Points</li>
                                <li class="job-table-reward job-table-align">Reward</li>
                                <li class="job-table-level job-table-level-align job-table-align">Level</li>
                            </ul>
                    </div>
                    <div class="networkers-message job-empty-message">
                    	No Networkers Found.
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
        $(".invitaionHeading div a").click(function(){
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
