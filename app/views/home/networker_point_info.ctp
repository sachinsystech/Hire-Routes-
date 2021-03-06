<!--script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.js"></script-->

<script type="text/javascript">
 	//var windowSizeArray = [ "width=400,height=400,scrollbars=yes" ];

    $(document).ready(function(){
        /*$('.newWindow').click(function (event){
            var url = "/home/hrInvitationsDetail";
            var windowName = "popUp";
            var windowSize = windowSizeArray[0];
            window.open(url, windowName, windowSize);
            event.preventDefault();

        });*/
    });
</script>
        <!----------Netwroker points information------------->		
<h1 class="title-emp">How the Networker Points System Works</h1>
<div class="content1">
	<div class="box1 box-cursor">
		<div class="box-content-text"><h2>WHAT ARE POINTS?</h2>
        	<div class="box-text">
        	<p class="space">The more points you score the higher your experience level, title and thus most important your bonus %. Your bonus % is what Hire Routes pays you on top of what your Networkers make.
        	</p>
        	<p class="space">
        	<b> Example:</b> Your Networkers make $100,000 in rewards in January. Your Experience Level is 5. We will pay you $5,000. </p>
        	<p class="space">All your point information can be found under the Points tab in My Network when logged in.</p>
    		</div>
        </div>
	</div>
	<div class="box1 box-cursor">
		<div class="box-content-text">
			<h2>HOW DO YOU GET POINTS?</h2> 
			<div class="box-text"><p> <div class="space">You get Hire Routes points for building your network of:</div></p>
        		<ul>
					<li>Networkers who sign up through your HR invitations or Job Sharing </li>
					<li>Job Seekers who sign up through your HR invitations or Job Sharing </li>
					<li>Companies and/or Recruiters who sign up from your HR invitations  (companies and recruiters need to send in a request first).</li>
				</ul>
			</div>
		</div> 
	</div>
    <div class="box1 box-cursor">
		<div class="box-content-text"><h2>POINT SCORING</h2>
			<div class="box-text">
		        <ul>
			        <li>Networkers*<p>*(depending on their school ranking, undergraduate and graduate) </p><p>= +10 points (ranking 1 - 10)</p><p>
= +7 points (ranking 11 - 15)</p><p>= +5 points (ranking 16 - 20)</p><p>= +3 points (ranking 21 - 25) </p><p>= +1 point (ranking 25+)</li>
					<li>Job Seekers <p>= +<?php echo $config[1]['Config']['value'] ;?> points</p></li>
					<li>Companies and/or Recruiters <p>= +<?php echo $config[0]['Config']['value'] ;?>  points</p></li>
				</ul>
			</div>
        </div> 
	</div>
    <div class="clr"></div>
</div>
    
    
<!-- Wrapper middle bottom : Table-Points-->
<div class="list-point-level">
	<h2>POINT LEVELS</h2>
    <div class="list-head list-margin">
    	<ul class="list-heading">
   			<li>POINTS</li>
   			<li class="center-align">LEVEL</li>
  			<li class="center-align">BONUS %</li>
   			<li class="margin-last-child">TITLE</li>
    	</ul>
	</div>
	<?php
		$i = 0;
		foreach($pointLables as $key=>$data){
			if($i % 2 == 0)	
				$class= " dark";
			else
				$class= "";
	?>
	<div class="list-head">
		<ul class="listing<?php echo $class; ?>">
			<li >
			<?php echo $data['PointLabels']['point_from']; 
			echo ($i == 9) ? "+" :  "-"; ?>
			<?php echo $data['PointLabels']['point_to']; ?>						
			</li>
		<li class="center-align">
			<?php echo $data['PointLabels']['level']; ?>
		</li>
		<li class="center-align">
			<span>+ <?php echo $data['PointLabels']['bonus']; ?> %</span>
		</li>
		<li class="margin-last-child" style="width:175px;">
			<?php echo $data['PointLabels']['networker_title']; ?>
		</li>
	</div>
	<?
		$i++;
	}
	?>
</div>   
<div class="clr"></div>        


