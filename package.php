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

/*
 * package.xml/package2.xml generator
 *
 * @author msakamoto-sf <msakamoto-sf@users.sourceforge.net>
 * @version $Id: package.php 31 2008-01-20 06:30:40Z msakamoto-sf $
 */

require_once 'PEAR/PackageFileManager2.php';
PEAR::setErrorHandling(PEAR_ERROR_DIE);

// {{{ Package Information Items

$releaseVersion = '0.1.1';
$releaseStability = 'beta';
$apiVersion = '0.1.1';
$apiStability = 'beta';
$summary = 'Pseudo block coding support package';
$description = 'Pseudo_Block improves usability of eval(), create_function().
You do not have to escape double/single quotations, back slashes in your 
eval(), create_function().
Pseudo_Block provides \'pseudo code block\' way which not supported in PHP 
syntax natularry.';
$notes = '
Add Pseudo_Perl, change package.php, changelogs.
';
$changelog = '
Add Pseudo_Perl class and its test cases.
Change some test codes for Stagehand_TestRunner version 1.2.0.
Thank you.';

// }}}

$pkg2xml = new PEAR_PackageFileManager2();
$pkg2xml->setOptions(array(
    'packagefile' => 'package2.xml',
    'filelistgenerator' => 'file',
    'packagedirectory' => dirname(__FILE__),
    'baseinstalldir' => '/',
    'ignore' => array(
        basename(__FILE__), //'package.xml', 'package2.xml',
        ),
    'dir_roles' => array(
        'tests' => 'test',
        ),
    'exceptions' => array(
        'LICENSE' => 'doc',
        ),
    'changelogoldtonew' => true,
    'changelognotes' => $changelog,
//    'simpleoutput' => true,
    ));
$pkg2xml->setPackageType('php'); // this is a PEAR-style php script package
$pkg2xml->addRelease();
$pkg2xml->setPackage('Pseudo_Block');
$pkg2xml->setUri('http://xhwlay.sourceforge.net/');
$pkg2xml->setReleaseVersion($releaseVersion);
$pkg2xml->setAPIVersion($apiVersion);
$pkg2xml->setReleaseStability($releaseStability);
$pkg2xml->setAPIStability($apiStability);
$pkg2xml->setSummary($summary);
$pkg2xml->setDescription($description);
$pkg2xml->setNotes($notes);
$pkg2xml->setPhpDep('4.3.0'); // PHP 4.3.0 - 
$pkg2xml->setPearinstallerDep('1.4.0'); // PEAR 1.4.0 - 
$pkg2xml->addMaintainer(
    'lead', 
    'msakamoto-sf', 
    'Masahiko Sakamoto', 
    'msakamoto-sf@users.sourceforge.net'
    );
$pkg2xml->setLicense(
    'Apache License, Version 2.0', 
    'http://www.apache.org/licenses/LICENSE-2.0'
    );
$pkg2xml->generateContents();

// get a PEAR_PackageFile object
$pkg1xml =& $pkg2xml->exportCompatiblePackageFile1();

if (isset($_GET['make']) || 
    (isset($_SERVER['argv']) && @$_SERVER['argv'][1] == 'make')) {
    $pkg1xml->writePackageFile();
    $pkg2xml->writePackageFile();
} else {
    $pkg1xml->debugPackageFile();
    $pkg2xml->debugPackageFile();
}

?>