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

use App\Countries;
use App\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

if ( ! app()->environment('production')) {
    Route::get('/db/seed', function () {
        return Artisan::call('db:seed');
    });
    Route::get('/db/import', function () {
        return Artisan::call('import:sql');
    });
    Route::get('/generate/countries', function () {
        return Countries::generate();
    });
    Route::get('/generate/user/affiliate', function () {
        return User::generateAffiliate();
    });
    Route::get('/test', 'TestController@index')->name("test");
}

Auth::routes(['verify' => true]);

Route::get('/lang/{locale}', function ($locale) {
    if(in_array($locale, ['en','pl','se','de','dk','cz','es'])) auth()->user()->setLocale($locale);
    App::setLocale($locale);
    return redirect()->back();
})->name('lang.change');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@index')->name('dashboard');

// Marketplace routes
Route::get('/marketplace', 'MarketController@index')->name('marketplace');
Route::get('/marketplace/bought-text', 'MarketController@boughtText')->name('marketplace.bought_text');
Route::post('/sells/create', 'MarketController@create_sell')->name('sells.post');
Route::get('/sells/buy/{sell}', 'MarketController@buySell')->name('sell.buy');
Route::get('/sells/view/{id}', 'MarketController@view_sell')->name('sell.view');
Route::post('/sells/search', 'MarketController@search_sell')->name('sell.search');
Route::get('/sells/approve/{id}', 'AdminController@approve_sell')->name('sell.approve');

// Projects routes
// ============== For Clients =================== //
Route::get('/projects/new', 'ProjectController@create')->name('projects.new');
Route::post('/projects/save', 'ProjectController@save')->name('projects.save');
Route::get('/project/payment/success/{orderId}/{projectId}', 'ProjectController@project_pay_success')
    ->name('projects.pay_success');
Route::get('/project/payment/notify/{orderId}/{projectId}', 'ProjectController@project_pay_notify')
    ->name('projects.pay_notify');
Route::get('notify/test/{number}', 'PaymentController@testNotification')->name('notify.test');


Route::get('/projects/all', 'AdminController@projects_all')->name('projects.list');
Route::get('/projects/view/{project}', 'ProjectController@view')->name('projects.view')->middleware('can:view,project');
Route::get('/projects/view/all', 'ProjectController@view_all')->name('projects.view.all');
Route::get('/projects/open', 'ProjectController@open')->name('projects.open');
Route::get('/projects/sketch', 'ProjectController@sketch')->name('projects.sketch');
Route::get('/projects/cancel', 'ProjectController@cancel')->name('project.cancel');
Route::get('/projects/accept/{project}', 'ProjectController@acceptText')->name('project.accept');
Route::get('/projects/reject/{project}', 'ProjectController@rejectText')->name('project.reject')->middleware('can:reject,project');
Route::get('/projects/jumpout/{project}', 'ProjectController@jumpOut')->name('project.jump_out')->middleware('can:jumpOut,project');
Route::post('/projects/pay', 'ProjectController@pay')->name('project.pay');
Route::post('/project/{project}/price/update', 'ProjectController@priceUpdate')->name('project.price.update');


Route::get('/projects/preview', 'ProjectController@preview')->name('projects.preview'); // display other's order as well
Route::get('/projects/previewall', 'ProjectController@preview_all')
    ->name('projects.previewall'); // display other's order as well

Route::post('/projects/review/{project}/add', 'ProjectController@reviewAdd')->name('projects.review.add');


Route::get('/projects/history', 'ProjectController@history')->name('projects.history');
Route::post('/financial/bonus/receive', 'FinancialController@bonus_receive')->name('bonus_receive');

// ============== For Freelancers =============== //
Route::get('/projects/browse', 'ProjectController@browse')->name('projects.browse');
Route::get('/projects/actual', 'ProjectController@actual')->name('projects.actual');
Route::post('/projects/browse/ajax', 'ProjectController@browse_ajax')->name('projects.ajax.browse');
Route::get('/projects/reserve', 'ProjectController@reserve')->name('projects.reserve');
Route::post('/projects/save_text', 'ProjectController@save_text')->name('project.save_text');
Route::get('/projects/get_text', 'ProjectController@get_text')->name('project.get_text');
Route::post('/projects/send-amendments/{project}', 'ProjectController@sendAmendments')->name('project.send_amendments')->middleware('can:sendAmendments,project');
Route::get('/category/user/get', 'ProjectController@getCategory')->name('category.user.get');
Route::post('/password/save', 'HomeController@password_save')->name('user.update.password');
Route::get('/projects/review/accept/{project}', 'ProjectController@reviewAccept')->name('project.review.accept');

// CopyWriter routes
Route::get('/copylist', 'HomeController@copylist')->name('copylist');

// ======================= Financial routes (users) =============
Route::get('/payments', 'FinancialController@payments_page')->name('payments');
Route::get('/invoice/all', 'FinancialController@invoice_page')->name('invoice');
Route::get('/invoice/{invoice}/download', 'FinancialController@invoiceDownload')->name('invoice.download');
if ( ! app()->environment('production')) {
    Route::get('/invoice/test', function () {
        return view('pdf.invoice_test');
    })->name('invoice.test');
}

Route::post('/deposit', 'FinancialController@deposit')->name('deposit');
Route::post('/stripe/deposit', 'StripeController@deposit')->name('stripe.deposit');
Route::get('/stripe/checkout', 'StripeController@checkout')->name('stripe.checkout');

Route::any('/payments/success/{orderId}', 'PaymentController@deposit_success')->name('deposit.success');
Route::any('/payments/notify/{orderId}', 'PaymentController@deposit_notify')->name('deposit.notify');

// ======================= Financial routes (copywriter) =============
Route::get('/document', 'FinancialController@document_page')->name('document');
Route::get('/document/download/{document}', 'FinancialController@documentDownload')->name('document.download');
Route::post('/withdrawal', 'FinancialController@withdrawal')->name('withdrawal');
Route::get('/withdrawal/continue', 'FinancialController@withdrawal_continue')->name('withdrawal_continue');

// Chat routes
Route::get('/chat', 'ChatController@index')->name('chat');
Route::post('/chat/send', 'ChatController@chat_send')->name('chat.send');
Route::post('/chat/latest', 'ChatController@chat_get_latest')->name('chat.get_latest');

// Affilate routes
Route::get('/affilate', 'HomeController@affilate')->name('affilate');
Route::get('/affilate/all', 'HomeController@affilate_all')->name('affilate_all');
Route::get('/invite/{code}', 'Auth\RegisterController@showRegistrationForm')->name('invite');

// Setting routes
Route::get('/settings', 'HomeController@settings')->name('settings');
Route::get('/profile/{user?}', 'HomeController@profile')->name('profile');
Route::post('/settings/copywriter/save', 'HomeController@settings_copywriter_save')->name('settings.copywriter.save');
Route::post('/settings/client/save', 'HomeController@settings_client_save')->name('settings.client.save');
Route::post('/settings/about/save', 'HomeController@saveAbout')->name('settings.about.save');
Route::post('/settings/categories/save', 'HomeController@saveCategories')->name('settings.categories.save');
Route::post('/settings/languages/save', 'HomeController@saveLanguages')->name('settings.languages.save');


// support routes
Route::get('/support', 'HomeController@support')->name('support');
Route::get('/about_us', function () {
    return view('homepage.about_us');
})->name('about_us');
Route::get('/question', function () {
    return view('homepage.questions');
})->name('question');
Route::get('/for_agency', function () {
    return view('homepage.for-agency');
})->name('for_agency');
Route::get('/for-copywriter', function () {
    return view('homepage.for-copywriters');
})->name('for_copywriter');
Route::get('/help_center', function () {
    return view('homepage.help_center');
})->name('help_center');
Route::get('/knowledgebase', function () {
    return view('homepage.knowledgebase');
})->name('knowledgebase');
Route::get('/agreement', function () {
    return view('homepage.agreement');
})->name('agreement');
Route::get('/contact', function () {
    return view('homepage.contact');
})->name('contact');

// Admin routes
Route::get('/members/users', 'AdminController@users_all')->name('users.list');
Route::get('/members/copywriters', 'AdminController@copywriters_all')->name('copywriters.list');
Route::get('/members/waiting_copywriters', 'AdminController@copywriters_waiter')->name('copywriters.waiter_list');
Route::get('/members/waiter', 'AdminController@member_waiter')->name('member.waiter_list');
Route::get('/members/approve/{id}', 'AdminController@member_approve')->name('member.approve');
Route::get('/members/view/{id}', 'AdminController@member_view')->name('member.view');
Route::get('/members/block/{id}', 'AdminController@member_block')->name('member.block');

Route::get('/markets/active', 'AdminController@markets_active')->name('markets.active');
Route::get('/markets/pending', 'AdminController@markets_pending')->name('markets.pending');
Route::get('/markets/history', 'AdminController@markets_history')->name('markets.history');
Route::get('/market/approve/{id}', 'AdminController@market_approve')->name('market.approve');
Route::get('/market/view', 'AdminController@market_view')->name('market.view');

Route::get('/category/edit', 'AdminController@category_edit')->name('category.edit');
Route::post('/category/save', 'AdminController@category_save')->name('category.save');
Route::get('/category/get', 'AdminController@category_get')->name('category.get');
Route::get('/category/delete', 'AdminController@category_delete')->name('category.delete');

Route::get('/tax-office', 'AdminController@tax_office')->name('tax-office');
Route::post('/tax-office/save', 'AdminController@tax_office_save')->name('tax-office.save');
Route::get('/tax-office/get', 'AdminController@tax_office_get')->name('tax-office.get');
Route::get('/tax-office/delete', 'AdminController@tax_office_delete')->name('tax-office.delete');

Route::get('/countries', 'AdminController@countries')->name('countries');
Route::post('/countries/save', 'AdminController@countries_save')->name('countries.save');
Route::get('/countries/get', 'AdminController@countries_get')->name('countries.get');
Route::get('/countries/delete', 'AdminController@countries_delete')->name('countries.delete');

// Bonus code
Route::get('/bonus-code', 'AdminController@bonus_code')->name('bonus-code');
Route::post('/bonus-code/save', 'AdminController@bonus_code_save')->name('bonus-code.save');
Route::get('/bonus-code/get', 'AdminController@bonus_code_get')->name('bonus-code.get');
Route::get('/bonus-code/delete', 'AdminController@bonus_code_delete')->name('bonus-code.delete');

// Transaction
Route::post('/admin/transaction/add', 'AdminController@addTransaction')->name('bonus-code.save');

// Admin
Route::get('/admin/settings', 'AdminController@admin_settings')->name('admin.settings');
Route::post('/admin/settings/save', 'AdminController@admin_settings_save')->name('admin.settings.save');

Route::get('/admin/payu/edit', 'AdminController@admin_payu_edit')->name('admin.payu.edit');
Route::post('/admin/payu/save', 'AdminController@admin_payu_save')->name('admin.payu.save');

Route::any('/admin/withdrawal/pending', 'AdminController@admin_withdrawal_pending')->name('admin.withdrawal.pending');
Route::get('/admin/withdrawal/approve/{id}', 'AdminController@admin_withdrawal_approve')->name('admin.withdrawal.approve');
Route::get('/admin/withdrawal/history', 'AdminController@admin_withdrawal_history')->name('admin.withdrawal.history');
Route::get('/admin/transaction/history', 'AdminController@admin_transaction_history')->name('admin.transaction.history');

Route::get('/admin/projects/active', 'AdminController@admin_project_active')->name('admin.project.active');
Route::get('/admin/projects/sketch', 'AdminController@admin_project_sketch')->name('admin.project.sketch');
Route::get('/admin/projects/history', 'AdminController@admin_project_history')->name('admin.project.history');

Route::get('/admin/messages', 'AdminController@admin_messages')->name('admin.messages');
Route::get('/admin/invoices', 'AdminController@admin_invoices')->name('admin.invoices');
Route::post('/admin/invoices/download/bulk', 'AdminController@downloadBulkInvoices')->name('admin.invoices.download.bulk');
Route::get('/admin/bills', 'AdminController@admin_bills')->name('admin.bills');

Route::get('/admin/block/user', 'AdminController@block_user')->name('admin.block.user');
Route::post('/admin/balance/update', 'AdminController@update_user_balance');
Route::post('/admin/message', 'AdminController@admin_message_send');

Route::get('/admin/root', 'AdminController@root')->name('admin.root');
Route::post('/admin/root/save', 'AdminController@root_save')->name('admin.root.save');
Route::get('/admin/root/get', 'AdminController@root_get')->name('admin.root.get');
Route::get('/admin/root/delete', 'AdminController@root_delete')->name('admin.root.delete');

Route::get('/admin/level', 'AdminController@level')->name('admin.level');
Route::post('/admin/level/save', 'AdminController@level_save')->name('admin.level.save');
Route::get('/admin/level/get', 'AdminController@level_get')->name('admin.level.get');
Route::get('/admin/level/delete', 'AdminController@level_delete')->name('admin.level.delete');