<?php

/**
 * Copyright (c) 2008, SARL Adaltas & EDF. All rights reserved.
 * Code licensed under the BSD License:
 * http://www.php-pop.org/pop_config/license.html
 */

require_once dirname(__FILE__).'/../PopHbaseTestCase.php';

/**
 * Test the PopHbaseRow->get method.
 * 
 * @author		David Worms info(at)adaltas.com
 *
 */
class HbaseRowGetTest extends PopHbaseTestCase{
	public function testUndefinedColumn(){
		$hbase = $this->hbase;
		$value = $hbase->tables->pop_hbase
			->row('row_test_count_1')->get('column_test:get_undefined_my_column');
		echo $value;
		$this->assertNull($value);
	}
}
