<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.js"></script>

<script type="text/javascript">
    var windowSizeArray = [ "width=400,height=400,scrollbars=yes" ];

    $(document).ready(function(){
        $('.newWindow').click(function (event){
            var url = "/home/hrInvitationsDetail";
            var windowName = "popUp";
            var windowSize = windowSizeArray[0];
            window.open(url, windowName, windowSize);
            event.preventDefault();

        });
    });
</script>
        <!----------Netwroker points information------------->		
<h1 class="title-emp">How the Networker Points System works</h1>
<div class="content1">
	<div class="box1 box-cursor">
		<div class="box-content-text"><h2>WHAT ARE POINTS?</h2>
        	<div class="box-text">The more points you score the higher your experience level, title and thus most important your bonus %. Your bonus % is what Hire Routes pays you on top of what your Networkers make. Example: Your Networkers make $100,000 in rewards in January. Your Experience Level is 5. We will pay you $5,000. <br /> <br />All Your Point information can be found under the "Points" tab in "My Network" when logged into your <a href="#">Networker settings</a>
    		</div>
        </div>
	</div>
	<div class="box1 box-cursor">
		<div class="box-content-text">
			<h2>HOW DO YOU GET POINTS?</h2> 
			<div class="box-text"><p> <div class="space">You get Hire Routes points for <a href="#">building your network</a> of:</div></p>
        		<ul>
					<li>Networkers who sign up through your <a href="#" rel="1" class="newWindow" ">HR invitations</a> HR invitations</a> or <a href="#">Job Sharing</a> </li>
					<li>Job Seekers who sign up through your <a href="#"> HR invitations</a> or <a href="#">Job Sharing</a> </li>
					<li>Companies and/or Recruiters who sign up from your <a href="#"> HR invitations</a>  (companies and recruiters need to send in a request first).</li>
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
					<li>Job Seekers <p>= +15 points</p></li>
					<li>Companies and/or Recruiters <p>= +30 points</p></li>
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
		<li class="margin-last-child">
			<?php echo $data['PointLabels']['networker_title']; ?>
		</li>
	</div>
	<?
		$i++;
	}
	?>
</div>   
<div class="clr"></div>        

        
        
        <!----------End netwroker points information------------->
        <!------
<div class="networkerPointContent">
	<div style="float:left;width:380px;margin:auto;height:200px;">
		<div class="contentDivHeading">
			How do you score points?
		</div>
		<div style="margin:10px;">
			<div>You get points for <a href="#">building your network</a> of:</div>
			<div>
				1. Networkers who sign up through your <a href="#" rel="1" class="newWindow" ">HR invitations</a> or <a href="#">Job
				Sharing</a>
			</div>
			<div>
				2. Job Seekers who sign up through your <a href="#">HR invitations</a> or <a href="#">Job
				Sharing</a>
			</div>
			<div>
				3. Companies and/or Recruiters who sign up from your <a href="#">HR
				invitations</a> (companies and recruiters need to send in a request
				first).
			</div>
		</div>
	</div>
	<div style="float:right;width:350px;margin:auto;height:200px;">
		<div class="contentDivHeading">
			What do you get for scoring points?
		</div>
		<div style="margin:10px;">
			The more points you score the higher your experience level,
			title and thus most important your bonus %. Your bonus % is
			what Hire Routes pays you on top of what your Networkers
			make. Example: Your Networkers make $100,000 in rewards in
			January. Your Experience Level is 5. We will pay you $5,000.

		</div>
	
	</div>

	<div class="poinScoringDiv">
		<div class="contentDivHeading">
			Point Scoring
		</div>
		<div style="margin:10px;font-weight:bold;">
			<div>
				<div>
					1. Networkers (depending on their
				school ranking, undergraduate and
				graduate)*
				</div>
				<div>= +10 points (ranking 1 - 10)</div>
				<div>= +7 points (ranking 11 - 15)</div>
				<div>= +5 points (ranking 16 - 20)</div>
				<div>= +3 points (ranking 21 - 25)</div>
				<div>= +1 point (ranking 25+)</div>
			</div>
			<div>
				2. Job Seekers = +15 points
			</div>
			<div>
				3. Companies and/or Recruiters = +30
			points
			</div>
		</div>
	</div>

	<div style="float:right;width:375px;margin:auto;height:200px;">
		<div class="contentDivHeading">
			Point Levels
		</div>
		<div style="font-weight:bold;">
			Your Total Experience
		</div>
		<div class="pointsData">
			<div class ="pointsLevelHeading">
				<div  class = "networkerPoints" >
					<a href="#">Points</a>
				</div>
				<div class = "networkerLevel">
					<a href="#">Level</a>
				</div>
				<div class="networkerBonus" >
					<a href="#">Bonus %</a>
				</div>
				<div class="networkerTitle" >
					<a href="#">Networker Title</a>
				</div>			
			</div>
		
			<?php
				foreach($pointLables as $key=>$data){
			?>
				<div class ="pointsLevelHeading">
					<div class = "networkerPoints">
						<?php echo $data['PointLabels']['point_from']; ?>-
						<?php echo $data['PointLabels']['point_to']; ?>						
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
			<?
			}
			?>
		</div>
	</div>
</div>
->

