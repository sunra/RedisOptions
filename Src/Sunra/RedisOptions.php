<?php

namespace Sunra;

class RedisOptions {
	private $redis;
	
	
	public function set_list($list_name, $elem, $TTL=0){
		
		$list = $this->get_list($list_name);
		
		if (!in_array($elem,$list)){
			   $list[] = $elem;
		}
		
		
		
		return $this->set($list_name,$list, $TTL);
		
	}
	
	
	public function get_list($list_name, $default=array()){
		
		return $this->get($list_name, $default);
		
	}
	
	
	public function inc($key_name, $by_val=1, $TTL=0){		
		
		$result = $this->redis->incrby($key_name, $by_val);
		if($TTL) {
			$this->redis->expire( $key_name, $TTL );
		}
		
		return $result;
		
	}
	
	
    public function set( $name, $value='', $TTL=0, $TTL_milliseconds = false ) {
		
        if ($this->redis->ping() <> 'PONG') {
            
			throw new Exception('Redis no PING');
			
			return false;
        }
		
		if (!$value) { 
			
			return $this->redis->del( $name );
			
		} else {
			
			if ($TTL) { 
				
				if($TTL_milliseconds) {
					//$res = $this->redis->psetex( $name, $TTL, serialize($value) );  // not work in redis 2.4
					$res = $this->redis->setex( $name, $TTL=1, serialize($value) ); 
				} else {
				    $res = $this->redis->setex( $name, $TTL, serialize($value) ); 
				}
				
				//$this->redis->expire( $name, $TTL );
				 
				return $res;
				
			} else {
				//echo 'tut';
				//var_dump(
				//    $this->redis->set( $name, serialize($value) )
				//);
				//die();
				
				return $this->redis->set( $name, serialize($value) );
			
			}
		}
    }	

    
	public function rm( $name ) {
			return $this->redis->del( $name );
    }	
	
	
	public function del( $name ) { // synonym for rm
			return $this->redis->del( $name );
    }
	
	
	public function get( $name, $default='' ) {
		
		if ( $val = $this->redis->get( $name ) ) {
			
			$value = unserialize($val);
			
			return $value;
			
		} else {
			
			return $default;
			
		}
	}

	
	public function cut($name, $default='') { // get and rm
	    $data = $this->get($name, $default);
		$this->rm($name);
		
		return $data;		
	}

    
	public function get_redis() {
		
		return $this->redis;
	}
	
    
	function __construct( $redis ) {
		
        $this->redis = $redis;
		
    }
	
} // Options