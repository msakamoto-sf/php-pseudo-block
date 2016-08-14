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
 * Pseudo_Lambda
 *
 * @package Pseudo_Block
 * @author msakamoto-sf <msakamoto-sf@users.sourceforge.net>
 * @version $Id: Lambda.php 30 2008-01-20 06:11:44Z msakamoto-sf $
 */
/**
 * requires
 */
require_once('Pseudo/Block.php');

// {{{ Pseudo_Lambda

/**
 * Pseduo Lambda
 *
 * Simple Usage :
 * <code>
 * $l =& new Pseudo_Lambda('$a, $b');
 * $l->bind('var1', 123);
 * $l->start();
 * ?>
 * static $c = 0;
 * $c++;
 * return $a + $b + $c + $var1;
 * <?php
 * $l->end();
 * $f = $l->create();
 * echo $f(1, 2)."\n";
 * echo $f(1, 3)."\n";
 * </code>
 *
 * @author msakamoto-sf <msakamoto-sf@users.sourceforge.net>
 * @package Pseudo_Eval
 * @since 0.1.0
 */
class Pseudo_Lambda extends Pseudo_Block
{
    // {{{ properties

    /**
     * Arguments definition
     *
     * @var string
     * @access protected
     * @since 0.1.0
     */
    var $_args = "";

    // }}}
    // {{{ Pseudo_Lambda()

    function Pseudo_Lambda($args = "")
    {
        $this->_args = $args;
    }

    // }}}
    // {{{ create()

    /**
     * @return string result of create_function()
     */
    function create()
    {
        // bind globals must be identical for each lambda blocks.
        $_k = 'Pseudo_Lambda.bindedValues ' . rand() . '.' . rand();
        $GLOBALS[$_k] = $this->_binds;

        // append code piece for importing binded values to eval block
        $c = 'extract($GLOBALS["' . $_k . '"]);'.PHP_EOL;
        $c .= $this->_text;

        // there's no need to clear bind globals because all of the binded 
        // globals is identical for each lambda blocks.
        return create_function($this->_args, $c);
    }

    // }}}
}

// }}}

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
