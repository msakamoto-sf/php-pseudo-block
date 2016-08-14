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
 * Pseudo_Block
 *
 * @package Pseudo_Block
 * @author msakamoto-sf <msakamoto-sf@users.sourceforge.net>
 * @version $Id: Block.php 15 2007-09-22 14:28:02Z msakamoto-sf $
 */

// {{{ Pseudo_Block

/**
 * Pseduo Block Basic Handle Class
 *
 * Simple Usage :
 * <code>
 * $block =& new Pseudo_Block();
 * $block->start();
 * ?>
 * $a = ... 
 * <?php
 * $block->end();
 * $code = $block->getText();
 * </code>
 *
 * @author msakamoto-sf <msakamoto-sf@users.sourceforge.net>
 * @package Pseudo_Block
 * @since 0.1.0
 */
class Pseudo_Block
{
    // {{{ properties

    /**
     * Pseudo block string buffer.
     *
     * @var string
     * @access protected
     * @since 0.1.0
     */
    var $_text = "";

    /**
     * Binded values to code block scope.
     *
     * @var array
     * @access protected
     * @since 0.1.0
     */
    var $_binds = array();

    // }}}
    // {{{ start()

    /**
     * Start pseudo block.
     */
    function start()
    {
        ob_start();
    }

    // }}}
    // {{{ end()

    /**
     * End pseudo block.
     */
    function end()
    {
        $this->_text = ob_get_contents();
        ob_end_clean();
    }

    // }}}
    // {{{ getText()

    /**
     *
     * @return string pseudo block code
     */
    function getText()
    {
        return $this->_text;
    }

    // }}}
    // {{{ bind()

    /**
     * Binds variables to code block scope.
     *
     * @param string variable name in code block
     * @param mixed variable value
     */
    function bind($n, $v)
    {
        $this->_binds[$n] = $v;
    }

    // }}}
    // {{{ unbind()

    /**
     * Unbinds variables from code block scope.
     *
     * @param string variable name in code block
     */
    function unbind($n)
    {
        unset($this->_binds[$n]);
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
