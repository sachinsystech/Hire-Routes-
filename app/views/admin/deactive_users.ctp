<?php echo $this->Session->flash();?>
<div id="page-heading"><h1><?php //echo $jobseekerCount;?> Pending User's</h1></div>
<?php 
     $sno = 1;
?>
<table id="content-table" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody><tr>
		<th rowspan="3" class="sized"></th>
		<th class="topleft"></th>
		<th id="tbl-border-top">&nbsp;</th>
		<th class="topright"></th>
		<th rowspan="3" class="sized"></th>
	</tr>
	<tr>
	 	<td id="tbl-border-left"></td>
    	<td>
			<div class="content-table-inner">
				<div style="float:right;margin:10px;">
					<?php
						if($this->Paginator->numbers()){ 
							echo $paginator->first('First  |'); 
							echo $paginator->prev('  '.__('Previous', true), array(), null, array('class'=>'disabled'));
							echo " < ".$this->Paginator->numbers(array('modulus'=>4))."  > ";
							echo $paginator->next(__('Next', true).' ', array(), null, array('class'=>'disabled'));
							echo $paginator->last(' |  Last'); 
						}
						$userType =array("1"=>"Company","2"=>"Jobseeker","3"=>"Networker")
					?>
				</div>
				    <table width ="100%" cellspacing='0' class='userTable'>
					    <tr class="usertableHeading userTableLeftRadius" style="border:1px solid;padding:5px;"> 
						    <th width="5%" style="line-height:25px;">#</th> 
						    <th width="24%">
						    	<div><?php echo $this->Paginator->sort('E-Mail','UserList.account_email')?></div>
						    </th>
							<th width="24%">
						    	<div>
						    		<?php echo $this->Paginator->sort('Ancestor','Parent_User.account_email')?>
						    	</div>
						    </th>
						    <th width="10%">
							    <div>
						    		Group
						    	</div>
						    </th>
						    <th width="10%">
							    <div>
						    		Sign up
						    	</div>
						    </th>
						    <th width="18%">
						    	<div><?php echo $this->Paginator->sort('Created','UserList.created')?></div>
						    </th>
   						</tr>
	    		            <?php $page=0;
	    		            	if(isset($this->params['named']['page'])){
	    		            		$page = $this->params['named']['page']-1;
	    		            	}
								if(count($deactiveUsers)>0){
	    		            		foreach($deactiveUsers as $deactiveUser):
	    		                	$class = $sno%2?"odd":"even";
	    			        ?>
						<tr class="<?php echo $class; ?>" > 
							<td style="padding:7px;text-align:center;" ><?php echo $page*10+$sno++; ?></td> 
							<td>
								<?php echo $deactiveUser['UserList']['account_email']?>
							</td>
							<td>
								 <?php
								 	$url ="" ;
								 	if (isset($deactiveUser['ParentUser']['account_email'])){
									 if( $userType[$deactiveUser['ParentUserRules']['role_id']] == "Company" ){
										$url =	"/admin/employerSpecificData/".$deactiveUser['ParentUser']['id'];
									}else if( $userType[$deactiveUser['ParentUserRules']['role_id']] == "Networker" ){
										$url =	"/admin/networkerSpecificData/".$deactiveUser['ParentUser']['id'];
									 }
								 ?>
								 	<a href =<?php echo $url; ?> >
								 <?php
								 		echo $deactiveUser['ParentUser']['account_email'];
								 		echo "</a>";
								 	}
								 ?>
								<?php ?>
							</td>
							<td>
								<?php echo $userType[$deactiveUser['UserRoles']['role_id']];?>
							</td>
							<td>
								<?php 
									switch($deactiveUser['UserList']['sinup_source']){
										case EMAIL:
												echo "E-Mail";
												break;
										case FACEBOOK:
												echo "Facebook";
												break;
										case LINKEDIN:
												echo "Linked In";
												break;
										default :
												echo "";
									}
								?>
							</td>
							<td style="text-align:center;"> <?php echo 
							date("m/d/Y h:m:s", strtotime($deactiveUser['UserList']['created']));?> </td>
			    		</tr> 
      					<?php
	    				endforeach; 
	    			}else{
					?>	
					<tr class="odd">			
					    <td colspan="8" align="center" style="line-height: 40px;">Sorry , No result found.</td>
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
<?php echo $form->end();?>	


