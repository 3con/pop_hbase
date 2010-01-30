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
class PopHbaseRow{
	
	public $hbase;
	public $key;
	
	public function __construct(PopHbase $hbase,$table,$key){
		$this->hbase = $hbase;
		$this->table = $table;
		$this->key = $key;
	}
	
	public function get($column){
		$body = $this->hbase->request->get($this->table .'/'.$this->key.'/'.$column)->body;
		if(is_null($body)){
			return null;
		}
		return base64_decode($body['Row'][0]['Cell'][0]['$']);
	}
	
	/**
	 * Create or update a column row.
	 * 
	 * Usage:
	 * 
	 *    $hbase
	 *        ->table('my_table')
	 *            ->row('my_row')
	 *                ->put('my_column_family:my_column','my_value');
	 * 
	 * Note, in HBase, creation and modification of a column value is the same concept.
	 */
	public function put($column,$value){
		$value = array(
			'Row' => array(array(
				'key' => base64_encode($this->key),
				'Cell' => array(array(
					'column' => base64_encode($column),
					'$' => base64_encode($value)
				))
			))
		);
		return $this->hbase->request->put($this->table .'/'.$this->key.'/'.$column,$value);
	}

}
