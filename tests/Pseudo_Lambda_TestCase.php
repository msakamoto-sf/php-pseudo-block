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
 * Pseudo_Lambda_TestCase
 *
 * @package Pseudo_Block
 * @author msakamoto-sf <msakamoto-sf@users.sourceforge.net>
 * @version $Id: Pseudo_Lambda_TestCase.php 30 2008-01-20 06:11:44Z msakamoto-sf $
 */

/**
 * requires
 */
require_once('Pseudo/Lambda.php');

class Pseudo_Lambda_TestCase extends UnitTestCase
{
    // {{{ testLambdaWithoutArgsAndWithoutRetval

    function testLambdaWithoutArgsAndWithoutRetval()
    {
        $l =& new Pseudo_Lambda();
        $l->start();
?>
        static $c = 0;
        $c++;
        $GLOBALS['testLambdaWithoutArgsAndWithoutRetval'] = $c;
<?php
        $l->end();
        $f = $l->create();

        // 1st call : -> 1
        $f();
        $this->assertEqual(1, 
            $GLOBALS['testLambdaWithoutArgsAndWithoutRetval']);

        // 2nd call : -> 2
        $f();
        $this->assertEqual(2, 
            $GLOBALS['testLambdaWithoutArgsAndWithoutRetval']);
    }

    // }}}
    // {{{ testLambdaWithoutArgsAndWithRetval

    function testLambdaWithoutArgsAndWithRetval()
    {
        $l =& new Pseudo_Lambda();
        $l->start();
?>
        static $c = 0;
        $c++;
        return $c;
<?php
        $l->end();
        $f = $l->create();

        // 1st call : -> 1
        $r = $f();
        $this->assertEqual(1, $r);

        // 2nd call : -> 2
        $r = $f();
        $this->assertEqual(2, $r);
    }

    // }}}
    // {{{ testLambdaWithArgsAndWithoutRetval

    function testLambdaWithArgsAndWithoutRetval()
    {
        $l =& new Pseudo_Lambda('$a, $b');
        $l->start();
?>
        static $c = 0;
        $c++;
        $GLOBALS['testLambdaWithArgsAndWithoutRetval'] = $a + $b + $c;
<?php
        $l->end();
        $f = $l->create();

        // 1st call : -> 1 + 2 + 1($c) = 4
        $f(1, 2);
        $this->assertEqual(4, 
            $GLOBALS['testLambdaWithArgsAndWithoutRetval']);

        // 2nd call : -> 3 + 4 + 2($c) = 9
        $f(3, 4);
        $this->assertEqual(9, 
            $GLOBALS['testLambdaWithArgsAndWithoutRetval']);
    }

    // }}}
    // {{{ testLambdaWithArgsAndWithRetval

    function testLambdaWithArgsAndWithRetval()
    {
        $l =& new Pseudo_Lambda('$a, $b');
        $l->start();
?>
        static $c = 0;
        $c++;
        return $a + $b + $c;
<?php
        $l->end();
        $f = $l->create();

        // 1st call : -> 1 + 2 + 1($c) = 4
        $r = $f(1, 2);
        $this->assertEqual(4, $r);

        // 2nd call : -> 3 + 4 + 2($c) = 9
        $r = $f(3, 4);
        $this->assertEqual(9, $r);
    }

    // }}}
    // {{{ testLambdaWithBindValues

    function testLambdaWithBindValues()
    {
        // test multiple lambda with binded values.
        $l1 =& new Pseudo_Lambda('$a, $b');
        $var1 = 5;
        $l1->bind('v1', $var1);
        $l1->start();
?>
        return $a + $b + $v1;
<?php
        $l1->end();
        $f1 = $l1->create();

        $l2 =& new Pseudo_Lambda('$d, $e');
        $var2 = 10;
        $l2->bind('v2', $var2);
        $l2->start();
?>
        return $d + $e + $v2;
<?php
        $l2->end();
        $f2 = $l2->create();

        $r1 = $f1(1, 2);
        $r2 = $f2(3, 4);
        $this->assertEqual($r1, 1 + 2 + 5);
        $this->assertEqual($r2, 3 + 4 + 10);
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
