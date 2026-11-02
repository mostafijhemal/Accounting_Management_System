<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method Dashboard
*/
//$route['default_controller'] 	= 'home';
$route['default_controller'] 	= 'app_login';
$route['user/login'] 			= 'app_login';
$route['dashboard/summary'] 	= 'app';

$route['setup/findYourCompany'] = 'home/findCompany';
$route['setup/newUser/(:num)'] 	= 'home/createNewUser/$1';
$route['setup/newUserSave'] 	= 'home/saveFirstUserData';
$route['company/information'] 	= 'instituteInfo';

// User Create & Access Related
$route['user/newUserAdd'] 				= 'app_user_manage/systemUserCreate';
$route['user/adduser'] 					= 'app_user_manage';
$route['user/save'] 					= 'app_user_manage/userDataStore';
$route['user/saveBySystem'] 			= 'app_user_manage/userDataStoreBySystem';
$route['user/accessRule'] 				= 'app_user_manage/accessRulePageLoad';
$route['user/accessSave'] 				= 'app_user_manage/accessRuleDataSave';
$route['user/accessList'] 				= 'app_user_manage/allUserAccessList';
$route['user/aUserAccessList/(:num)'] 	= 'app_user_manage/accessListVuew/$1';

// Chart Of Account Related
$route['acc/chartCreate'] 				= 'chartOfAccounts';
$route['acc/chartAccDataGetForUpdate']	= 'chartOfAccounts/chartOfAccountDataForUpdate';
$route['acc/chartAccSave']				= 'chartOfAccounts/saveChartOfAccount';

// Voucher Related
$route['acc/checkAccHead']			= 'accVoucher/accountHeadIsExist';
$route['acc/voucherTypeManage']		= 'accVoucher/manageVoucherType';
$route['acc/vTypeSave']				= 'accVoucher/saveVoucherType';
$route['acc/vTypeDataforUpdate']	= 'accVoucher/voucherTypeDataLoadForUpdate';
$route['acc/voucherCreate']			= 'accVoucher/journalVoucher';
$route['acc/getVDataFUpdate']		= 'accVoucher/voucherDataLoadForUpdate';
$route['acc/voucherSave']			= 'accVoucher/journalVoucherSave';
$route['acc/dVoucer/(:num)']		= 'accVoucher/deleteVoucher/$1';
$route['accReport/voucher/(:num)']	= 'accVoucher/voucher/$1';

// Day Open Close Related
$route['acc/dayOpenClose/(:num)']	= 'accVoucher/dayOpenOrClosePage/$1';
$route['acc/dayOpenCloseSaveAction']= 'accVoucher/dayOpenOrCloseSaveAction';
$route['acc/dayOpenCloseEdit'] 		= 'accVoucher/getDayOpenCloseDataForEdit';

$route['acc/vCheck']						= 'accVoucher/checkVoucher';
$route['acc/voucherCheckAction/(:num)']		= 'accVoucher/checkVoucherAction/$1';
$route['acc/voucherReturnToPrepare/(:num)']	= 'accVoucher/voucherReturnToCreateAction/$1';

$route['acc/vApprove']						= 'accVoucher/approveVoucher';
$route['acc/voucherApproveAction/(:num)']	= 'accVoucher/approveVoucherAction/$1';
$route['acc/voucherReturnToCheck/(:num)']	= 'accVoucher/voucherReturnToCheckAction/$1';

// Opening 
$route['acc/opening']				= 'accVoucher/openingDataEntry';
$route['acc/saveOpening']			= 'accVoucher/openingDataSave';
$route['acc/aOpeningData']			= 'accVoucher/getOpeningDataForEdit';
$route['acc/aOpeningDataApprove']	= 'accVoucher/openingDataApprove';


$route['404_override'] 			= '';
$route['translate_uri_dashes'] 	= FALSE;
