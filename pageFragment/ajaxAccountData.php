<?php 
include("../include/define.php"); 
$mode = base64_decode($_POST['mode']);

switch($mode)
{

	// -- Account Administrator Coding Here ---
	case 'addAdministrator':
	addAdministrator();
	break;
	
	case 'addTaxiCompany':
		addTaxiCompany();
		die();
	break;	

	case 'updateTaxiCompanyLoginDetails':
		updateTaxiCompanyLoginDetails();
	die;
	break;
	
	// -- Account Administrator Coding Here ---
}

?>