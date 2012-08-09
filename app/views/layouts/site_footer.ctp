<div class="footer-content"> 
    <!-- footer-block-->
    <div class="footer-block first">
      <h3>sitemap</h3>
      <ul>
        <li><a href="/">Home</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="/jobs">Job Postings</a></li>
        <li><a href="/contactUs">Contact Us</a></li>
        <li><a href="#">Fast Facts</a></li>
        <li><a href="/howItWorks">How it Works</a></li>
        <li><a href="#">News</a></li>
        <li><a href="#">Terms &amp; Conditions</a></li>
      </ul>
    </div>
    <!-- footer-block --> 
    
    <!-- footer-block-->
    <div class="footer-block second">
      <h3>fast facts</h3>
		<?php
			include(APP_DIR.'/vendors/twitter/twitterstatus.php');
			$t = new TwitterStatus('atulasati87', 3);
			//$t->__render();
			
			echo $t->render();
		?>

		<style type="text/css">

		#jstwitter {
			width: 300px;
			font-family: Arial regular,Sans-serif;
			font-size: 15px;
			color: ##DED7C4;
		}
		
		#jstwitter .tweet {
			border-bottom: 1px dotted #ccc;
		}
		
		#jstwitter .tweet a {
			text-decoration: none;
			color: #13c9d0;
		}

		#jstwitter .tweet a:hover {
			text-decoration: underline;
		}
		
		#jstwitter .tweet .time {
			font-style: italic;
			color: #DED7C4;
		}
		</style>
    </div>
    <!-- footer-block --> 
    
    <!-- footer-block-->
	<div class="footer-block third">
	<h3>recent jobs</h3>
	<?php 
		$jobs = $this->Session->read('recentJobs');
		if($jobs!=null)
		foreach($jobs as $job){ ?>
		<p> <a href="/jobs/jobDetail/<?php echo $job['Job']['id'] ;?>"><?php echo strtoupper($job['Job']['title']) ;?></a> <br />
		    <?php echo ucfirst($job['state']['name']) ;?><br />
		    Reward: <?php echo $this->Number->format(
										$job['Job']['reward'],
										array(
											'places' => 2,
											'before' => '$',
											'decimals' => '.',
											'thousands' => ',')
										);?> 
		</p>
	<? } ?>
    </div>
    	
    <!-- footer-block -->
    <div class="clr"></div>
    <!-- copyright -->
    <div class="copyright"> &copy; Hire Routes Inc. All rights Reserved. <a href="#">info@hireroutes.com</a>
      <div class="foot-right">
        <ul>
	       	<?php  if($current_user['id']==2 || !isset($current_user)):?>
				<li><a href="/users/login">Login</a></li>
				<li><a href="/users">Sign up</a></li>
			<?php endif; ?>
        </ul>
      </div>
    </div>
    <!-- copyright -->
    
    <div class="clr"></div>
  </div>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-32401487-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
