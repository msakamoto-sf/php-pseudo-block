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
 * Pseudo_Eval
 *
 * @package Pseudo_Block
 * @author msakamoto-sf <msakamoto-sf@users.sourceforge.net>
 * @version $Id: Eval.php 30 2008-01-20 06:11:44Z msakamoto-sf $
 */
/**
 * requires
 */
require_once('Pseudo/Block.php');

// {{{ Pseudo_Eval

/**
 * Pseduo Eval
 *
 * Simple Usage :
 * <code>
 * $e =& new Pseudo_Eval();
 * $e->bind('var1', 123);
 * $e->bind('var2', 456);
 * $e->start();
 * ?>
 * $a = $var1 + $var2;
 * $b = ... 
 * return ...;
 * <?php
 * $e->end();
 * $result = $e->act();
 * </code>
 *
 * @author msakamoto-sf <msakamoto-sf@users.sourceforge.net>
 * @package Pseudo_Eval
 * @since 0.1.0
 */
class Pseudo_Eval extends Pseudo_Block
{
    // {{{ properties
    // }}}
    // {{{ act()

    /**
     * @return mixed eval() result
     */
    function act()
    {
        $result = null;
        $GLOBALS['Pseudo_Eval.bindedValues'] = $this->_binds;

        // append code piece for importing binded values to eval block
        $c = 'extract($GLOBALS["Pseudo_Eval.bindedValues"]);'.PHP_EOL;
        $c .= $this->_text;
        $result = eval($c);

        unset($GLOBALS['Pseudo_Eval.bindedValues']);
        return $result;
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
