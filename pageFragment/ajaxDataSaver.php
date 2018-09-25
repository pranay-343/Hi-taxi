<?php include("../include/define.php"); 

$mode = base64_decode($_POST['mode']);
switch($mode)
{

	case 'check_user':
		echo $result = check_user();
		die();
	break;

	case 'contact_form':
		$result = contact_form();
		die();
	break;	
    
        case 'Login':
		login('login');
		die();
	break;	

// -- Super Admin Coding Here---
	case 'updateLoginDetails':
		updateLoginDetails();
		die();
	break;	

	case 'addAdministrator':
		addAdministrator();
		die();
	break;	

	case 'addAcountAdministrator':
		addAcountAdministrator();
		die();
	break;
// -- Super Admin Coding End Here---
    
// -- Corporate Admin Coding Here---
    case 'addCorporateCompany':
		addCorporateCompany();
		die();
	break;
    case 'addCorporateUser':
		addCorporateUser();
		die();
	break;
    
    case 'updateCorporateUser':
        updateCorporateUser();
        die();
    break;

    case 'updatePasswordCorporate':
        updatePasswordCorporate();
        die();
    break;
	case 'updateCorporateCompany':
		updateCorporateCompany();
		die();
	break;
// -- Corporate Admin Coding End Here---
    
	case 'saveColoniess':
		saveColoniess();
		die();
	break;
}




?>