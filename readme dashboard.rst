##########################################################################################
Ace Admin 
Dashboard Customize in CodeIgniter
CodeIgniter Version 3.1.5
Customize Version 1.0.1
Author : Md. Robiul Awal
##########################################################################################

************************
How to Use The Dashboard 
************************

# Database
	1. Import Database
	2. Empty Table (ci_sessions, menu_list, temp_verify_code, user_access_menu)
	3. Delete Table (test_table, all_acc_ledger_tablr)
	4. Update instiute info


# Class
	1. For Create or Add Access use 'accessCreate' Class 
	2. For Update Access use 'accessEdit' Class
	3. For Delete Access use 'accessDelete' Class


# Include Css
	$data['include_css'][]	= 'css2/style.css';
	$data['include_css'][]	= 'style.css';

	Note :: base_url().data/css/ already used appCssLinkPage, Your css path add with this base url path

	example :: base_url().data/css/css2/style.css
	example :: base_url().data/css/style.css




# Include Js
	$data['include_js'][]		= 'js2/custom.js';
	$data['include_js'][]		= 'custom.js';

	Note :: base_url().data/js/ already used appJsLinkPage, Your js path add with this base url path

	example :: base_url().data/js/js2/custom.js
	example :: base_url().data/js/custom.js