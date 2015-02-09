<?php defined('SYSPATH') OR die('No direct access allowed.');


return array(
    'config' => array(
        'default_cache_config' => APPPATH.'cache/aws'
    ),
    
    /* for development/use on non AWS servers, replace the config above with a key/secret like so:
    'config' => array(
        'key' => 'foo',
        'secret' => 'bar',
    ),
    */
    
    'region' => 'us-east-1',
);

?>          
