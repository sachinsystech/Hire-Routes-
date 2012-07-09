<?php
	/**
	 * Element to share job in Network
	 */
?>
<style>
.contact{
	width:15px;
	float:left;
}
</style>
<script>
$(function() {
        $( "#shareDialog:ui-dialog" ).dialog( "destroy" );
		$( "#shareDialog" ).dialog({
			autoOpen: false,
			show: "blind",
			hide: "explode",
            width:700,
		});
		$( "#shareOpener" ).click(function() {
			$( "#shareDialog" ).css( "top" ,'20');
			$( "#shareDialog" ).dialog( "open" );			
			return false;
		});

        $( "#dialog-message" ).dialog({
			modal: true,
            autoOpen: false,
			width:500,
			buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
				}
			}
		});
	});
</script>
<?php if(isset($jobUrl)):?>
<div><input type="hidden" id="shareJobUrl" value="<?php echo  $jobUrl ?>"></div>
<div id='shareDialog' title="<?php echo ucfirst($jobTitle); ?>">
	<?php
		echo $form->create('shareNetwork', array('action'=>'job'));

		echo $form->input('jobId', array('label' => '','type'  => 'hidden','value'=>$jobId));
	?>
	<div style="padding-bottom:0px; clear:both">
		<div  style="float:left"><strong>Subjet:</strong></div>
		<div style="float:right">
		<?php echo $form->input('subject', array('label' => '',
												'type'  => 'text',
												'class'=> 'subject_txt required',
												'value'=>'Job Recommendation :: '
			));
		?>
		</div>
	</div>
	<div style="padding-bottom:0px; clear:both" class='s_j_email'>
		<div  style="float:left"><strong style="margin-top:10px">Message:</strong></div>
		<?php echo $form->input('message', array('label' => '',
												'type'  => 'textarea',
												'class'=> 'msg_txtarear required',  
												'value'=>"Learn more about this job (".$jobUrl.")"
			));
		?>
	</div>
	<div id='contact' style="padding-bottom:0px; clear:both">hh
	</div>
	<div style="padding-bottom:0px; clear:both">
		<div style='float:left;'>
			<?php echo $form->button('Clear', array('label' => '',
													'type'  => 'reset',
													'value' => 'Clear'
					));
			?>
		</div>	
	</div>
	<div style='float:right;'>
		<div style='float:left;'>
			<?php echo $form->button('Share', array('label' => '',
													'id' =>'shareJob',
													'type'  => 'submit',
													'value' => 'Share',
					));
			?>
			<div id='submitLoader' style='float:right;'></div>
		</div>
		<?php echo $form->input('code', array('label' => '',
										  'id'=>'interMediateCode',
										  'type'  => 'hidden',
										  'value'=>isset($intermediateCode)?$intermediateCode:"",
			));?>
	</div>
	<?php echo $form->end(); ?>
</div>
<div id='shareOpener'></div>
<?php endif;?>
<script>
function toggleChecked(status) {
	$(".contact").each( function() {
		$(this).attr("checked",status);
	})
}
function networkShare(){
	$("#shareJob").unbind();
	$("#shareOpener").click();
    setShareView();
    fillContacts('/networkers/getContact/alpha:A/page:1/');
    $("#shareJob").click(shareJobNetwork);
}

function setShareView()
{
	$('#contact').html("<div id='alphabet' style='height:15px;width:620px;margin:auto;overflow:auto;'></div><div id='imageDiv' style='border:1px solid #000000;width:550px;height:272px;overflow:auto;margin:auto;'></div><div id='paginator' style='text-align:center;'></div>");
	return false;
}

function fillContacts(getUrl){
	$('#imageDiv').html("<p><img src='/images/fbloader.gif' class='sharejob_ajax_loader'></p>");
	$('.sharejob_ajax_loader').delay('30000').animate({ height: 'toggle', opacity: 'toggle' }, 'slow').hide('.sharejob_ajax_loader');
    $.ajax({
        type: 'POST',
        url: getUrl,
        dataType: 'json',
        success: function(response){
			createView(response.contacts, response.alphabets, response.startWith, response.page);
        },
        error: function(message){
            alert('message');
        }
    });
}

function createView(contacts, alphabets, startWith, page){
	var alphabetText="";
	var view ="<table style='width:100%;margin: auto;' class='contacts'><tr><th style='width:8%;text-align:center'><input type='checkbox' onclick='toggleChecked(this.checked)'></th><th style='width:35%;text-align:center'> Name </th><th style='width:50%;text-align:center'> E-Mail </th></tr>";
	var pages="";
	$.each(contacts, function(index,value){
			view=view+"<tr><td><input type='checkbox' id='contacts["+index+"]' class='contact' value='"+value.email+"'></td><td>"+value.name+"</td><td>"+value.email+"</td></tr>";
		});
	view=view+"</table>";
	$.each(alphabets, function(alphabet, count){
		var cssClass = 'button';
		var url = "/networkers/getContact/alpha:"+alphabet;
		var urlLink = "<a href="+url+">"+alphabet+"</a>";
		if(startWith ==alphabet || count<1){
			cssClass = 'current';
			urlLink = alphabet;
			if(startWith ==alphabet && count>10){
				pageCount=(count%10>0)?Math.ceil(count/10):(count/10);
				if(page!=1){
					var prev=parseInt(page)-1;
					pages="<span style='cursor:pointer;' class="+css+" onClick=fillContacts('"+url+"/page:1');>First << </span>";
					pages=pages+"<span style='cursor:pointer;' class="+css+" onClick=fillContacts('"+url+"/page:"+prev+"');>prev < </span>";
				}
				for(var i=1;i<=pageCount;i++){
					css='button';
					if(i==page)
						pages = pages+"<span class='current'>"+i+"</span>";
					else
						pages = pages+"<span style='cursor:pointer;' class="+css+" onClick=fillContacts('"+url+"/page:"+i+"');>"+i+"</span>";
					if(i!=pageCount)
						pages = pages+" | ";
				}
				if(page<pageCount){
					var next=parseInt(page)+1;
					pages=pages+"<span style='cursor:pointer;' class="+css+" onClick=fillContacts('"+url+"/page:"+next+"');> > Next</span>";
					pages=pages+"<span style='cursor:pointer;' class="+css+" onClick=fillContacts('"+url+"/page:"+pageCount+"');> >> Last</span>";
				}
			}
		}
		if(cssClass=='current'){
			alphabetText = alphabetText+"<span class="+cssClass+">"+alphabet+"</span>";
			if(alphabet !="Z")
				alphabetText = alphabetText+" | ";
		}else{
			alphabetText =alphabetText +"<span style='cursor:pointer;' class="+cssClass+" onClick=fillContacts('"+url+"');>"+alphabet+"</span>";
			if(alphabet !="Z")
				alphabetText = alphabetText+" | ";
		}
	});
	$('#alphabet').html(alphabetText);
	$('#imageDiv').html(view);
	$('#paginator').html(pages);
}

function shareJobNetwork(){
	var to_email="";
	$(".contact").each( function() {
		if($(this).attr("checked"))
			to_email=to_email+$(this).val()+",";
	})
	if(to_email=="")
		alert('please select atlist one contact');
	else{
		to_email= to_email.slice(0,to_email.length-1);
		$('#submitLoader').html('<p><img src="/images/ajax-loader-tr.gif" class="submit_ajax_loader"/></p>');
				$.ajax({
				url: "/jobsharing/shareJobByEmail",
				type: "post",
				dataType: 'json',
				data: {jobId : $('#shareNetworkJobId').val(), jobUrl: $('#shareJobUrl').val(), toEmail : to_email, subject : $('#shareNetworkSubject').val(), message : $('#shareNetworkMessage').val(),code:$('#interMediateCode').val()},
				success: function(response){
					$('#submitLoader').html('');
					switch(response.error){
						case 0:
							$( "#dialog-message" ).html(" E-mail send successfully.");
							$( "#dialog-message" ).dialog("open");
							setView('Email');
							
							break;
						case 1:
							$( "#dialog-message" ).html("Something went wrong please try later or contact to site admin.");
							$( "#dialog-message" ).dialog("open");
							$( "#dialog" ).dialog( "close" );
							break;
						case 2:
							$( "#dialog-message" ).html(response.message);
							$( "#dialog-message" ).dialog("open");
							$( "#dialog" ).dialog( "close" );
							break;
						case 3:
                            alert(response.message);
							location.reload();	
							break;
					}
				},
				error:function(response){
					$('#submitLoader').html('');
					$( "#dialog-message" ).html("Something went wrong please try later or contact to site admin.");
					$( "#dialog-message" ).dialog("open");
					$( "#dialog" ).dialog( "close" );
				}
			});
	}
	return false;
}
</script>
