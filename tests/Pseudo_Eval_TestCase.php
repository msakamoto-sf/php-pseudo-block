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
 * Pseudo_Eval_TestCase
 *
 * @package Pseudo_Block
 * @author msakamoto-sf <msakamoto-sf@users.sourceforge.net>
 * @version $Id: Pseudo_Eval_TestCase.php 30 2008-01-20 06:11:44Z msakamoto-sf $
 */

/**
 * requires
 */
require_once('Pseudo/Eval.php');

class Pseudo_Eval_TestCase extends UnitTestCase
{
    // {{{ testEvalWithReturnValue

    function testEvalWithReturnValue()
    {
        $e =& new Pseudo_Eval();
        $GLOBALS['Pseudo_Eval.testFlag'] = false;
        $e->start();
?>
        $GLOBALS['Pseudo_Eval.testFlag'] = true;
        return 123;
<?php
        $e->end();
        $result = $e->act();
        $this->assertTrue($GLOBALS['Pseudo_Eval.testFlag']);
        $this->assertEqual(123, $result);
    }

    // }}}
    // {{{ testEvalWithoutReturnValue

    function testEvalWithoutReturnValue()
    {
        $e =& new Pseudo_Eval();
        $GLOBALS['Pseudo_Eval.testFlag'] = false;
        $e->start();
?>
        $GLOBALS['Pseudo_Eval.testFlag'] = true;
<?php
        $e->end();
        $result = $e->act();
        $this->assertTrue($GLOBALS['Pseudo_Eval.testFlag']);
        $this->assertNull($result);
    }

    // }}}
    // {{{ testEvalWithBindValues

    function testEvalWithBindValues()
    {
        $e =& new Pseudo_Eval();
        $var1 = 123;
        $var2 = "ABC";

        $e->bind('v1', $var1);
        $e->bind('v2', $var2);
        $e->start();
?>
        return $v1 . $v2;
<?php
        $e->end();
        $result = $e->act();
        $this->assertEqual($result, $var1 . $var2);
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
