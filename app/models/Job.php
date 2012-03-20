<?php

class Job extends AppModel {
    var $name = 'Job';
    var $useTable = 'jobs';

public function paginateCount($conditions = null, $recursive = 0, $extra = array())
{
    if ( isset($extra['group']) )
    {
        $parameters = compact('conditions', 'recursive');
        $count = $this->find('count', $parameters);
    }
    else
    {
        $parameters = compact('conditions', 'recursive');
        $count = $this->find('count', array_merge($parameters, $extra));
    }
    return $count;
}

}

?>
