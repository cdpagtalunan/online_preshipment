<?php

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
    return view('home');
})->name('home');


Route::get('/inspector', function () {
    return view('Inspector');
});
Route::get('/ppc', function () {
    return view('ppc');
});
Route::get('/materialhandler', function () {
    return view('materialhandler');
});
Route::get('/admin', function () {
    return view('admin');
});

Route::get('/warehouse', function () {
    return view('warehouse');
});
Route::get('/receiver-warehouse', function () {
    return view('receiver-warehouse');
});



Route::get('/get_rapidx_user', 'UserController@get_rapidx_user');
Route::get('/get_user', 'UserController@get_user');
Route::post('/add_user', 'UserController@add_user');
Route::get('/get_user_email', 'UserController@get_user_email');
Route::get('/get_user_details_for_edit', 'UserController@get_user_details_for_edit');
Route::get('/delete_user', 'UserController@delete_user');
Route::get('/enable_user', 'UserController@enable_user');
Route::get('/get_user_for_verify_login', 'UserController@get_user_for_verify_login');





// Material Handler
Route::get('/get_Preshipment', 'MHPreshipmentController@get_Preshipment');
Route::get('/getpreshipmentbyCtrlNo', 'MHPreshipmentController@getpreshipmentbyCtrlNo');
Route::get('/get_Preshipment_list', 'MHPreshipmentController@get_Preshipment_list');
Route::post('/disapprove_list', 'MHPreshipmentController@disapprove_list');
Route::post('/approve_list', 'MHPreshipmentController@approve_list');
Route::get('/get_for_whse_transaction', 'MHPreshipmentController@get_for_whse_transaction');
Route::get('/getpreshipmentbyCtrlNoWhse', 'MHPreshipmentController@getpreshipmentbyCtrlNoWhse');
Route::get('/get_for_whse_ext_transaction', 'MHPreshipmentController@get_for_whse_ext_transaction');



//INSPECTOR
Route::get('/get_Preshipment_QC', 'QCPreshipmentController@get_Preshipment_QC');
Route::get('/getpreshipmentbyCtrlNo_QC', 'QCPreshipmentController@getpreshipmentbyCtrlNo_QC');
Route::get('/get_Preshipment_list_QC', 'QCPreshipmentController@get_Preshipment_list_QC');
Route::get('/disapprove_list_QC', 'QCPreshipmentController@disapprove_list_QC');
Route::post('/approve_list_QC', 'QCPreshipmentController@approve_list_QC');


Route::get('/insert_preshimentlist_from_qc_qr_checking', 'QCPreshipmentController@insert_preshimentlist_from_qc_qr_checking');


//WAREHOUSE
Route::get('/get_preshipment_for_whse', 'WhsePreshipmentController@get_preshipment_for_whse');
Route::get('/get_preshipment_by_id_for_whse', 'WhsePreshipmentController@get_preshipment_by_id_for_whse');

Route::get('/get_preshipment_list_for_whse', 'WhsePreshipmentController@get_preshipment_list_for_whse');

Route::get('/get_preshipment_by_id_for_approval_whse', 'WhsePreshipmentController@get_preshipment_by_id_for_approval_whse');


Route::get('/send_preshipment_from_whse_to_whse', 'WhsePreshipmentController@send_preshipment_from_whse_to_whse');


Route::get('/get_preshipment_for_ts_cn_whse', 'WhsePreshipmentController@get_preshipment_for_ts_cn_whse');

Route::post('/accept_preshipment', 'WhsePreshipmentController@accept_preshipment');

Route::get('/get_preshipment_by_id_for_receiving', 'WhsePreshipmentController@get_preshipment_by_id_for_receiving');

Route::get('/get_preshipment_details_for_upload', 'WhsePreshipmentController@get_preshipment_details_for_upload');
Route::get('/get_preshipment_list_for_whse_for_upload', 'WhsePreshipmentController@get_preshipment_list_for_whse_for_upload');

Route::get('/get_invoice_ctrl_no_from_rapid', 'WhsePreshipmentController@get_invoice_ctrl_no_from_rapid');


Route::post('/done_upload_preshipment', 'WhsePreshipmentController@done_upload_preshipment');


Route::get('/get_preshipment_details_for_superior', 'WhsePreshipmentController@get_preshipment_details_for_superior');
Route::get('/get_preshipment_list_for_whse_superior', 'WhsePreshipmentController@get_preshipment_list_for_whse_superior');


Route::get('/get_wbs_receiving_number', 'WhsePreshipmentController@get_wbs_receiving_number');
Route::get('/get_wbs_local_receiving_number', 'WhsePreshipmentController@get_wbs_local_receiving_number');



Route::post('/superior_approval', 'WhsePreshipmentController@superior_approval');
Route::post('/superior_disapproval', 'WhsePreshipmentController@superior_disapproval');

Route::get('/get_preshipment_for_whse_view', 'WhsePreshipmentController@get_preshipment_for_whse_view');
Route::get('/get_preshipmentlist_for_view', 'WhsePreshipmentController@get_preshipmentlist_for_view');

Route::get('/get_preshipment_of_ts_cn_for_approval', 'WhsePreshipmentController@get_preshipment_of_ts_cn_for_approval');


Route::get('/pps_disapprove_preshipment', 'WhsePreshipmentController@pps_disapprove_preshipment');
Route::post('/whse_reject_preshipment', 'WhsePreshipmentController@whse_reject_preshipment');

Route::get('/insert_preshipmentlist_for_whse_check', 'WhsePreshipmentController@insert_preshipmentlist_for_whse_check');


//EXPORTS

Route::get('/export/{invoice_number}/{packing_list_ctrl_num}/{packingListProductLine}', 'ExportController@export');
// Route::get('/export/{invoice_number}/{packing_list_ctrl_num}/{packingListProductLine}', 'ExportController@export');


Route::get('/export_excel/{approving_id}', 'ExportController@export_excel');

Route::get('/pdf_export/{approving_id}', 'ExportController@pdf_export');

// AUTOMAILER

Route::get('/mailer', function () {
    return view('automailer');
});
Route::get('/automail_pending_preshipment', 'MailerController@automail_pending_preshipment');







