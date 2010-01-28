<?php

/**
 * Copyright (c) 2008, SARL Adaltas. All rights reserved.
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
class HbaseGetVersionTest extends PopHbaseTestCase{
	public function testReturn(){
		$hbase = new PopHbase($this->config);
		$version = $hbase->getVersion();
		$this->assertSame(array('Stargate','Server','OS','JVM','Jersey'),array_keys($version));
	}
}
