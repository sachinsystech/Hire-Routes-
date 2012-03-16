<?php

class Job extends AppModel {
    var $name = 'Job';
    var $useTable = 'jobs';
     var $order = "Job.created DESC";
}

?>
