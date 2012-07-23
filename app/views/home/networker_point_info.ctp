<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.js"></script>

<script type="text/javascript">
    var windowSizeArray = [ "width=400,height=400,scrollbars=yes" ];

    $(document).ready(function(){
        $('.newWindow').click(function (event){

            var url = "/users/hrInvitationsDetail";
            var windowName = "popUp";
            var windowSize = windowSizeArray[0];
            window.open(url, windowName, windowSize);
            event.preventDefault();

        });
    });
</script>
        
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
				foreach($networkersTitles as $key=>$data){
			?>
				<div class ="pointsLevelHeading">
					<div class = "networkerPoints">
						<?php echo $points[$key-1]; ?>
					</div>
					<div class = "networkerLevel">
						<?php echo $key; ?>
					</div >
					<div class="networkerBonus">
						<span>+ <?php echo $key; ?> %</span>
					</div>
					<div class="networkerTitle" >
						<?php echo $data; ?>
					</div>			
				</div>
			<?
			}
			?>
		</div>
	</div>
</div>


