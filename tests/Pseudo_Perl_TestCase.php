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
 * Pseudo_Perl_TestCase
 *
 * @package Pseudo_Block
 * @author msakamoto-sf <msakamoto-sf@users.sourceforge.net>
 * @version $Id: Pseudo_Perl_TestCase.php 30 2008-01-20 06:11:44Z msakamoto-sf $
 */

/**
 * requires
 */
require_once('Pseudo/Perl.php');

class Pseudo_Perl_TestCase extends UnitTestCase
{
    // TODO change this value for your environment. (ex: '/usr/bin/perl')
    var $_perl_bin = 'C:/Perl/bin/perl.exe -w';

    // {{{ testPerlRetVal

    function testPerlRetVal()
    {
        $pp =& new Pseudo_Perl();
        $pp->setPerlBin($this->_perl_bin);
        $pp->start();
?>
exit 25;
<?php
        $pp->end();
        $pp->popen();
        $retval = $pp->pclose();
        $this->assertEqual($retval, 25);
    }

    // }}}
    // {{{ testPerlWithPipes

    function testPerlWithPipes()
    {
        $pp =& new Pseudo_Perl();
        $pp->setPerlBin($this->_perl_bin);
        $pp->start();
?>
while(<STDIN>) {
    print STDOUT $_;
    print STDERR "--", $_;
}
<?php
        $pp->end();
        $pp->descriptors = array(
            0 => array('pipe', 'r'),
            1 => array('pipe', 'w'),
            2 => array('pipe', 'w'),
        );
        $pp->popen();
        fwrite($pp->pipes[0], "ABC");
        fwrite($pp->pipes[0], "DEF");
        fclose($pp->pipes[0]);

        $output = fread($pp->pipes[1], 8192);
        $this->assertEqual($output, "ABCDEF");
        fclose($pp->pipes[1]);

        $output = fread($pp->pipes[2], 8192);
        $this->assertEqual($output, "--ABCDEF");
        fclose($pp->pipes[2]);

        $pp->pclose();
    }

    // }}}
    // {{{ testPerlBindValues

    function testPerlBindValues()
    {
        $pp =& new Pseudo_Perl();
        $pp->setPerlBin($this->_perl_bin);
        $pp->bind('foo', 123);
        $pp->start();
?>
use strict;
use warnings;
use CGI;
our $q = new CGI();
print $q->param('foo'), "\n";
print $q->param('bar'), "\n";
<?php
        $pp->end();
        $pp->bind('bar', 'ABC DEF GHI');
        $pp->descriptors = array(
            1 => array('pipe', 'w'),
        );
        $pp->popen();

        $output = fread($pp->pipes[1], 8192);
        $this->assertEqual($output, "123\nABC DEF GHI\n");
        fclose($pp->pipes[1]);

        $pp->pclose();
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
