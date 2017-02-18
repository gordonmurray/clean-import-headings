<?php

require __DIR__ . '/vendor/autoload.php';

use gordonmurray\cleanImportHeadings;

$cleanImportHeadings = new cleanImportHeadings();

$originalFieldNamesArray = array('Company_ID', 'Company_Import_ID', 'Company_Title_1', 'Company_First_Name', 'Company_Middle_Name', 'Company_Surname', 'Maiden Name', 'Company_Birth_date', 'DEPTAP_Position', 'DEPTAP_OrgName', 'DEPTAP_Addrline1', 'DEPTAP_Addrline2', 'DEPTAP_Addrline3', 'DEPTAP_Addrline4', 'DEPTAP_Addrline5', 'DEPTAP_City', 'DEPTAP_Postcode', 'DEPTAP_County', 'DEPTAP_ContryLongDscription', 'email', 'email2', 'CIE_1_01_Degree', 'CIE_1_01_Class_of', 'CIE_1_02_Degree', 'CIE_1_02_Class_of', 'CIE_1_03_Degree', 'CIE_1_03_Class_of', 'CIE_1_04_Degree', 'CIE_1_04_Class_of', 'CIE_1_05_Degree', 'CIE_1_05_Class_of', 'CIE_1_06_Degree', 'CIE_1_06_Class_of', 'CnPrBs_Position', 'CnPrBs_Org_Name', 'CnPrBs_Relation_Code', 'Department_Position', 'Department_OrgName', 'Department_Addrline1', 'Department_Addrline2', 'Department_Addrline3', 'Department_Addrline4', 'Department_Addrline5', 'Department_City', 'Department_Postcode', 'Department_County', 'Department_ContryLongDscription', 'CnPrBsAdrPh_1_01_Phone_number', 'ACME Club/Society_1', 'ACME Club/Society_3');

$cleaned = $cleanImportHeadings->cleanStringsArray($originalFieldNamesArray);

print_r($cleaned);
