<?php
	if($this->Session->check('user_role'))
	{
		$user_role=$this->Session->read('user_role');	
		if(isset($user_role) && $user_role['role_id']==2)
		{
?>
			<ul>
				<li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers/newJob"><span>New Jobs</span></a></li>
                <li><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers/appliedJob"><span>Applied Jobs</span></a></li>
				<li class="active"><span><a style="color: #000000;text-decoration: none;font-weight: normal;" href="/jobseekers">My Account</a></span></li>
			</ul>
<?php 
		}
	}
	/*
	<ul>
				<li><span><a style="color: #000000;text-decoration: none;font-weight: normal;" href=""><span>My Network</span></li>

	*/
?>
