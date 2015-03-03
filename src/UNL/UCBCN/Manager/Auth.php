<?php

namespace UNL\UCBCN\Manager;
use SimpleCAS;
use UNL\UCBCN\User as User;

class Auth {

	protected $options = array();
    
    public static $directory_url = 'http://directory.unl.edu/';

    /**
     * Authenticate the user
     */
    public function authenticate() {
        $client = $this->getClient();
        
        $client->forceAuthentication();
        if (!$client->isAuthenticated()) {
            throw new RuntimeException('Unable to authenticate', 403);
        }
        
        $user = $this->getUser($client->getUsername());
        
        print_r($user);
    }

    /**
     * Get the current user (will create a user if none exist)
     *
     * @param $uid string the UID of the user
     * @return bool|User
     */
    protected function getUser($uid) {
        $uid = trim(strtolower($uid));
        
        if (empty($uid)) {
            return false;
        }
        if (!$user = User::getByAnyField('UNL\UCBCN\User', 'uid', $uid)) {
            $info = self::getUserInfo($uid);
            $user = new User();
            $user->uid = $uid;
            $user->insert();
        }
        
        return $user;
    }

	public function getClient() {
        $options = array(
            'hostname' => 'login.unl.edu',
            'port'     => 443,
            'uri'      => 'cas'
        );
        
        $protocol = new \SimpleCAS_Protocol_Version2($options);
        /**
         * We need to customize the request to use CURL because 
         * php5.4 and ubuntu systems can't verify ssl connections 
         * without specifying a CApath.  CURL does this automatically
         * based on the system, but openssl does not.
         * 
         * It looks like this will be fixed in php 5.6
         * https://wiki.php.net/rfc/tls-peer-verification
         */
        $request = new \HTTP_Request2();
        $request->setConfig('adapter', 'HTTP_Request2_Adapter_Curl');
        $protocol->setRequest($request);
        /**
         * Set up the session cache mapping
         */
        $cache_driver = new \Stash\Driver\FileSystem();
        //$cache_driver->setOptions(array(
                //Scope the cache to the current application only.
        //        'path' => Config::get('CACHE_DIR') . '/simpleCAS_map',
        //));
        
        $session_map = new \SimpleCAS_SLOMap($cache_driver);
        
        $protocol->setSessionMap($session_map);
        return \SimpleCAS::client($protocol);
    }

    /**
     * Get a user's information from directory.unl.edu
     * 
     * @param string $uid
     * @return array
     */
    public static function getUserInfo($uid) {
        $info = array();
        
        if (!$json = @file_get_contents(self::$directory_url . '?uid=' . $uid . '&format=json')) {
            return $info;
        }
        
        if (!$json = json_decode($json, true)) {
            return $info;
        }
        
        $map = array(
            'givenName' => 'first_name',
            'sn' => 'last_name',
            'mail' => 'email'
        );
        
        foreach ($map as $from => $to) {
            if (isset($json[$from][0])) {
                $info[$to] = $json[$from][0];
            }
        }
        
        return $info;
    }
}