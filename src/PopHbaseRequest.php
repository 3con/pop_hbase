<?php

/**
 * Copyright (c) 2008, SARL Adaltas. All rights reserved.
 * Code licensed under the BSD License:
 * http://www.php-pop.org/pop_hbase/license.html
 */

/**
 * Wrap an Hbase request
 *
 * @author		David Worms info(at)adaltas.com
 */
class PopHbaseRequest{

	public $hbase;
	
	/**
	 * Request constructor.
	 * 
	 * @param PopHbaseConnection required $connection
	 */
	function __construct(PopHbase $hbase){
		$this->hbase = $hbase;
	}
	
	public function delete($url){
		return $this->hbase->connection->execute('DELETE',$url);
	}
	
	public function get($url){
		return $this->hbase->connection->execute('GET',$url);
	}
	
	public function post($url,$data){
		return $this->hbase->connection->execute('POST',$url,$data);
	}
	
	public function put($url,$data=null){
		return $this->hbase->connection->execute('PUT',$url,$data);
	}

}
