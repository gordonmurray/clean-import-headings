<?php

require __DIR__ . '/../vendor/autoload.php';

use gordonmurray\cleanImportHeadings;

class cleanImportHeadingsTest extends PHPUnit_Framework_TestCase
{

    function testBasicClean()
    {
        $cleanImportHeadings = new cleanImportHeadings();

        $response = $cleanImportHeadings->basicClean('My_String');

        $this->assertEquals('my string', $response);

        $response = $cleanImportHeadings->basicClean('My/String');

        $this->assertEquals('my string', $response);
    }

    function testSquareMinusMean()
    {
        $cleanImportHeadings = new cleanImportHeadings();

        $response = $cleanImportHeadings->squareMinusMean(5, 1);

        $this->assertEquals(16, $response);

    }

    function testIdentifyOutliers()
    {
        $cleanImportHeadings = new cleanImportHeadings();

        $response = $cleanImportHeadings->identifyOutliers(array(1, 1, 2, 3, 4, 5, 78, 78, 79));

        $this->assertEquals(array(6 => 78, 7 => 78, 8 => 79), $response);
    }

    function testRemoveProvidedWords()
    {
        $cleanImportHeadings = new cleanImportHeadings();

        $stringsArray = array('company name', 'company address 1', 'company telephone');

        $wordsToRemove = array('company', '1');

        $expectedResponse = array('name', 'address', 'telephone');

        $response = $cleanImportHeadings->removeProvidedWords($stringsArray, $wordsToRemove);

        $this->assertEquals($expectedResponse, $response);
    }

    function testCleanStringsArray()
    {
        $cleanImportHeadings = new cleanImportHeadings();

        $stringsArray = array('Company Name', 'Company Address_1', 'Company_Telephone', 'FirstName');

        $expectedResponse = array('name', 'address 1', 'telephone','first name');

        $response = $cleanImportHeadings->cleanStringsArray($stringsArray);

        $this->assertEquals($expectedResponse, $response);
    }

    function testDetermineWordsToDrop()
    {
        $cleanImportHeadings = new cleanImportHeadings();

        $stringsArray = array('Company Name', 'Company Address_1', 'Company_Telephone');

        $expectedResponse = array('Company');

        $response = $cleanImportHeadings->determineWordsToDrop($stringsArray);

        $this->assertEquals($expectedResponse, $response);
    }

    function testCamelCaseWorks()
    {
        $cleanImportHeadings = new cleanImportHeadings();

        $response = $cleanImportHeadings->splitAtUpperCase('firstName');

        $this->assertEquals('first Name', $response);

        $response = $cleanImportHeadings->splitAtUpperCase('FirstName');

        $this->assertEquals('First Name', $response);

        $response = $cleanImportHeadings->splitAtUpperCase('Firstname');

        $this->assertEquals('Firstname', $response);

        $response = $cleanImportHeadings->splitAtUpperCase('MyFirstName');

        $this->assertEquals('My First Name', $response);
    }

}
