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
 * Pseudo_Perl
 *
 * @package Pseudo_Block
 * @author msakamoto-sf <msakamoto-sf@users.sourceforge.net>
 * @version $Id: Perl.php 30 2008-01-20 06:11:44Z msakamoto-sf $
 */
/**
 * require
 */
require_once('Pseudo/Block.php');

// {{{ Pseudo_Perl

/**
 * Pseduo Perl
 *
 * Simple Usage :
 * <code>
 * $pp =& new Pseudo_Perl();
 * $pp->bind('foo', 123);
 * $pp->start();
 * ?>
 * use strict;
 * use CGI;
 * my $q = new CGI();
 * print $q->param('foo') . "\n";
 * print $q->param('bar') . "\n";
 * ...
 * <?php
 * $pp->end();
 * $pp->bind('bar', 456);
 * $pp->setPerlBin('C:/Perl/bin/perl.exe -w');
 * $pp->act();
 * </code>
 *
 * NOTE: bound arguments are passed by following format:
 * <code>
 * (perl-bin) (temporary-script-name) key1="val1" key2="val2"
 * </code>
 * So, using CGI module will help you to get arguments.
 *
 * @author msakamoto-sf <msakamoto-sf@users.sourceforge.net>
 * @package Pseudo_Block
 * @since 0.1.1
 */
class Pseudo_Perl extends Pseudo_Block
{
    // {{{ properties

    /**
     * Perl Binary Location
     *
     * @var string
     * @access protected
     */
    var $_bin = "";

    /**
     * Perl temporary script file name
     *
     * @var string
     * @access protected
     */
    var $_tmpscript = "";

    /**
     * command line
     *
     * @var string
     * @access protected
     */
    var $_cmdline = "";

    /**
     * proc_open()'s return value
     *
     * @var resource
     * @access protected
     */
    var $_pp = array();

    /**
     * proc_open()'s "descriptorspec" argument
     *
     * @var array
     * @access public
     */
    var $descriptors = array();

    /**
     * proc_open()'s "pipes" argument
     *
     * @var array
     * @access public
     */
    var $pipes = array();

    // }}}
    // {{{ setPerlBin()

    /**
     * Set perl binary location and commandline options.
     *
     * @access public
     * @param string
     */
    function setPerlBin($bin)
    {
        $this->_bin = $bin;
    }

    // }}}
    // {{{ poepn()

    /**
     * Open process, Invoke perl interpreter.
     *
     */
    function popen()
    {
        $this->_tmpscript = tempnam(getenv('TMP'), 'Pseudo_Perl_');
        if (!$this->_tmpscript) {
            trigger_error(
                "Failure for creating temorary file", E_USER_WARNING);
            exit;
        }

        $fp = fopen($this->_tmpscript, "w");
        if (!$fp) {
            trigger_error(
                "Failure for opening temorary file(" . $this->_tmpscript . ")", E_USER_WARNING);
            exit;
        }
        fwrite($fp, $this->_text);
        fclose($fp);

        $_q = array();
        foreach ($this->_binds as $k => $v) {
            $_q[] = $k . '="' . (string)$v . '"';
        }
        $this->_cmdline = $this->_bin . ' "'. $this->_tmpscript . '" ' 
            . implode(' ', $_q);

        $this->_pp = proc_open(
            $this->_cmdline, 
            $this->descriptors, 
            $this->pipes);

        if (!$this->_pp) {
            trigger_error(
                "Failure for opening process(" . $this->_cmdline . ")", E_USER_WARNING);
            exit;
        }
    }

    // }}}
    // {{{ pclose()

    /**
     * Close process.
     *
     * @return integer proc_close()'s return value.
     */
    function pclose()
    {
        $retval = proc_close($this->_pp);
        @unlink($this->_tmpscript);
        return $retval;
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
