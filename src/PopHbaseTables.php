<?php

/**
 * Copyright (c) 2008, SARL Adaltas. All rights reserved.
 * Code licensed under the BSD License:
 * http://www.php-pop.org/pop_hbase/license.html
 */

/**
 * Hold a list of tables.
 *
 * @author		David Worms info(at)adaltas.com
 */
class PopHbaseTables extends PopHbaseIterator{
	
	public $hbase;
	
	public function __construct(PopHbase $hbase){
		$this->hbase = $hbase;
		$this->__data = array();
	}
	
//	public function __unset($property){
//		unset($this->__data['data'][$property]);
//		echo '__unset__ '.count($this->__data['data']).' '.$this->key()."\n";
//	}
	
	public function add($table){
		$body = $this->hbase->request->put('/'.$table)->body;
		$this->reload();
		return $this;
	}
	
	public function delete($table){
		$body = $this->hbase->request->delete($table.'/schema');
		$this->reload();
		return $this;
	}
	
	public function reload(){
		echo 'reload'."\n";
		unset($this->__data['data']);
	}
	
	public function load(){
		if(isset($this->__data['data'])){
			return $this;
		}
		$tables = $this->hbase->request->get('/')->body;
		$this->__data['data'] = array();
		if(is_null($tables)){ // No table
			return $this;
		}
		foreach($tables['table'] as $table){
			$this->__data['data'][$table['name']] = new PopHbaseTable($this->hbase,$table['name']);
		}
		return $this;
	}
	
	/**
	 * Create a new table and associated column families schema.
	 * 
	 * The first argument is expected to be the column name while the following
	 * arguments describle column families.
	 * 
	 * Usage
	 *     $hbase->tables->add(
	 *         'table_name',
	 *         'column_1',
	 *         array('name'=>'column_2'),
	 *         array('NAME'=>'column_3'),
	 *         array('@NAME'=>'column_4',...);
	 */
	public function create($table){
		$args = func_get_args();
		if(count($args)===0){
			throw new InvalidArgumentException('Missing table schema definition');
		}
		$table = array_shift($args);
		switch(gettype($table)){
			case 'string':
				$schema = array('name' => $table);
				break;
			case 'array':
				// name is required
				// other keys include IS_META and IS_ROOT
				$schema = array();
				foreach($table as $k=>$v){
					if(substr($k,0,1)!='@'){
						$k = substr($k,1);
					}
					if($k=='NAME'){
						$k = 'name';
					}else{
						$k = strtoupper($k);
					}
					$schema[$k] = $v;
				}
				if(!isset($schema['name'])){
					throw new InvalidArgumentException('Table schema definition not correctly defined "'.PurLang::toString($table).'"');
				}
				break;
			default:
				throw new InvalidArgumentException('Table schema definition not correctly defined: "'.PurLang::toString($table).'"');
		}
		$schema['ColumnSchema'] = array();
		foreach($args as $arg){
			switch(gettype($arg)){
				case 'string':
					$schema['ColumnSchema'][] = array('name' => $arg);
					break;
				case 'array':
					// name is required
					// other keys include BLOCKSIZE, BLOOMFILTER,
					// BLOCKCACHE, COMPRESSION, LENGTH, VERSIONS, 
					// TTL, and IN_MEMORY
					$columnSchema = array();
					foreach($arg as $k=>$v){
						if(substr($k,0,1)=='@'){
							$k = substr($k,1);
						}
						if($k=='NAME'){
							$k = 'name';
						}else{
							$k = strtoupper($k);
						}
						$columnSchema[$k] = $v;
					}
					if(!isset($columnSchema['name'])){
						throw new InvalidArgumentException('Column schema definition not correctly defined "'.PurLang::toString($table).'"');
					}
					$schema['ColumnSchema'][] = $columnSchema;
					break;
				default:
				throw new InvalidArgumentException('Column schema definition not correctly defined: "'.PurLang::toString($table).'"');
			}
		}
		//echo json_encode($schema)."\n";
		echo '----------------------------- start'."\n";
		$this->hbase->request->put($schema['name'].'/schema',$schema);
		if($this->hbase->options['alive']){
		echo '-- 1 '."\n";
			// For some reason, connection need to be reset 
			// for count to return correct number of tables
//			sleep(2);
			//$this->hbase->connection->disconnect();
//			$this->hbase->connection->disconnect();
//			$this->hbase->connection->disconnect();
		echo '-- 2 '."\n";
		}
//		$this->hbase->connection->disconnect();
		echo '----------------------------- stop'."\n";
		$this->reload();
	}

}
