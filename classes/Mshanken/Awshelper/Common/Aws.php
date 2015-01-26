<?php
namespace Mshanken\Awshelper\Common;


class Aws extends \Aws\Common\Aws
{
    
    /*
     * Wraps the AWS factory and automatically loads/adds IAM instance keys if needed
     */
    public static function factory($config = array(), array $globalParameters = array())
    {
        // If a config array was passed and it does not include a key/secret
        if(is_array($config) && empty($config['key']) && empty($config['secret']))
        {
            $config = \Kohana::$config->load('aws.config');
            $config['region'] = \Kohana::$config->load('aws.region');
        }
        
        return parent::factory($config, $globalParameters);
    }

}