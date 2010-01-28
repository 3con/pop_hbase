<?php

/**
 * Copyright (c) 2008, SARL Adaltas & EDF. All rights reserved.
 * Code licensed under the BSD License:
 * http://www.php-pop.org/pop_config/license.html
 */

require_once dirname(__FILE__).'/../PopHbaseTestCase.php';

/**
 * Test the add method.
 * 
 * @author		David Worms info(at)adaltas.com
 *
 */
class TablesCreateTest extends PopHbaseTestCase{
	public function testCount(){
		$hbase = $this->hbase;
		// Test with no database
		$tables = $hbase->tables();
		$this->assertSame(0,count($tables));
		// Test with one database
		$hbase->tables->create('pop_hbase','my_column');
		//$hbase->connection->disconnect();
		$this->assertSame(1,count($tables));
		$this->assertTrue($tables->current() instanceof PopHbaseTable);
		$hbase->tables->delete('pop_hbase');
	}
}
