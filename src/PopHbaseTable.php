<?php

/**
 * Copyright (c) 2008, SARL Adaltas. All rights reserved.
 * Code licensed under the BSD License:
 * http://www.php-pop.org/pop_hbase/license.html
 */

/**
 * Wrap an Hbase table
 *
 * @author		David Worms info(at)adaltas.com
 */
class PopHbaseTable{
	
	public $hbase;
	public $name;
	
	public function __construct(PopHbase $hbase,$name){
		$this->hbase = $hbase;
		$this->name = $name;
	}
	
	public function delete(){
		$body = $this->hbase->request->delete('/'.$this->name)->body;
//		$this->hbase->tables->reload();
//		unset($this->hbase->tables->{$this->name});
		return $this;
	}

}
