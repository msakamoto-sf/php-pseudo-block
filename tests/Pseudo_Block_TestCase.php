<?php
/*
 *   Copyright (c) 2007 msakamoto-sf <msakamoto-sf@users.sourceforge.net>
 *
 *   Licensed under the Apache License, Version 2.0 (the "License");
 *   you may not use this file except in compliance with the License.
 *   You may obtain a copy of the License at
 *
 *       http://www.apache.org/licenses/LICENSE-2.0
 *
 *   Unless required by applicable law or agreed to in writing, software
 *   distributed under the License is distributed on an "AS IS" BASIS,
 *   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *   See the License for the specific language governing permissions and
 *   limitations under the License.*
 */

/**
 * Pseudo_Block_TestCase
 *
 * @package Pseudo_Block
 * @author msakamoto-sf <msakamoto-sf@users.sourceforge.net>
 * @version $Id: Pseudo_Block_TestCase.php 30 2008-01-20 06:11:44Z msakamoto-sf $
 */

/**
 * requires
 */
require_once('Pseudo/Block.php');

class Pseudo_Block_Mock extends Pseudo_Block
{
    function getBinds() { return $this->_binds; }
}

class Pseudo_Block_TestCase extends UnitTestCase
{
    // {{{ testCodeBlockShouldBeRetrievedCorrectly

    function testCodeBlockShouldBeRetrievedCorrectly()
    {
        $block =& new Pseudo_Block();
        $block->start();
?>
$a = 123;
<?php
        $block->end();
        $text = $block->getText();
        $this->assertEqual(trim($text), '$a = 123;');
    }

    // }}}
    // {{{ testBindAndUnbind()

    function testBindAndUnbind()
    {
        $var1 = 123;
        $var2 = "abc";
        $mock =& new Pseudo_Block_Mock();
        $mock->bind('var1', $var1);
        $mock->bind('var2', $var2);

        $binds = $mock->getBinds();

        $this->assertEqual($binds['var1'], $var1);
        $this->assertEqual($binds['var2'], $var2);
        $this->assertEqual(2, count($binds));

        $mock->unbind('var1');
        $binds = $mock->getBinds();
        $this->assertFalse(isset($binds['var1']));
        $this->assertEqual($binds['var2'], $var2);
        $this->assertEqual(1, count($binds));

        // update binded value
        $mock->bind('var2', "xyz");
        $binds = $mock->getBinds();
        $this->assertEqual($binds['var2'], "xyz");
        $this->assertEqual(1, count($binds));

        $mock->unbind('var2');
        $binds = $mock->getBinds();
        $this->assertFalse(isset($binds['var2']));
        $this->assertEqual(0, count($binds));

        $var3 = 123.456;
        $mock->bind('xyz', $var3);
        $binds = $mock->getBinds();
        $this->assertEqual($binds['xyz'], $var3);
        $this->assertEqual(1, count($binds));
    }

    // }}}
}


/**
 * Local Variables:
 * mode: php
 * coding: iso-8859-1
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * indent-tabs-mode: nil
 * End:
 * vim: set expandtab tabstop=4 shiftwidth=4:
 */
?>
