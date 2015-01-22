<?php
namespace Mshanken\Awshelper\Common;


class Aws extends \Aws\Common\Aws
{

    public static function get_config()
    {
        // Attempt to load credentials from cache
        $kohanaCache = \Cache::instance('kohanaCache');
        $credentials = $kohanaCache->get('aws.ami.credentials');
        
        // If failed to load OR token is expired, grab the credentials from amazon
        if(NULL == $credentials || empty($credentials->Expiration) || strtotime($credentials->Expiration) <= time())
        {
            $curl = curl_init(\Kohana::$config->load('aws.credential_url'));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($curl);
            
            $credentials = json_decode($response);
            
            $kohanaCache->set('aws.ami.credentials', $credentials, 43200);
        }
        
        $config['key'] = $credentials->AccessKeyId;
        $config['secret'] = $credentials->SecretAccessKey;
        
        return $config;
    }
    
    /*
     * Wraps the AWS factory and automatically loads/adds IAM instance keys if needed
     */
    public static function factory($config = array(), array $globalParameters = array())
    {
        // If a config array was passed and it does not include a key/secret
        if(is_array($config) && empty($config['key']) && empty($config['secret']))
        {
            $config = self::get_config()
        }
        
        return parent::factory($config, $globalParameters);
    }

}