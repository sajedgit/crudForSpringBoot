<?php

function get_route_data_multiple($arr,$table_name,$controller_name,$model_name)
{

$page_data = <<<EOF
Route::resource('$table_name','$controller_name');	
EOF;

return	$page_data;
}



function get_route_data($arr,$table_name,$controller_name,$model_name)
{
    
	 
	$page_data = <<<EOF
<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

	Route::resource('$table_name','$controller_name');

	
EOF;



	return	$page_data;

}


?>