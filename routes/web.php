<?php

use Illuminate\Support\Facades\File;
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
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\CategoryController;

Route::get('/language/{locale}', [App\Http\Controllers\Admin\LanguageController::class,'setLanguage'])->name('language.set');

// Admin Blog Posts Routes
Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cleared!";

});

Route::get('/foo', function () {
    Artisan::call('storage:link');
});

// Route::get('/translator', [App\Http\Controllers\WebsiteTranslationController::class,'crawlAndTranslate']);
// Route::get('/create_json_file', [App\Http\Controllers\WebsiteTranslationController::class,'create_json_file']);


// categories routes
Route::get('/admin/categories', [App\Http\Controllers\Admin\CategoryController::class,'index'])->name('admin.categories.index');
Route::get('/admin/categories/create', [App\Http\Controllers\Admin\CategoryController::class,'create'])->name('admin.categories.create');
Route::post('/admin/categories', [App\Http\Controllers\Admin\CategoryController::class,'store'])->name('admin.categories.store');
// // Show the form to edit an existing blog post
Route::get('/admin/categories/{id}/edit', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('admin.categories.edit');

// // Update an existing blog post in the database
Route::put('/admin/categories/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('admin.categories.update');

// // Delete a blog post from the database
Route::delete('/admin/categories/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('admin.categories.destroy');

// blog routes
Route::get('/admin/blogs', [BlogPostController::class, 'index'])->name('admin.blogs.index');

// Show the form to create a new blog post
Route::get('/admin/blogs/create', [App\Http\Controllers\Admin\BlogPostController::class, 'create'])->name('admin.blogs.create');

// // Store a new blog post in the database
Route::post('/admin/blogs', [App\Http\Controllers\Admin\BlogPostController::class, 'store'])->name('admin.blogs.store');

// // Show the form to edit an existing blog post
Route::get('/admin/blogs/{slug}/edit', [App\Http\Controllers\Admin\BlogPostController::class, 'edit'])->name('admin.blogs.edit');

// // Update an existing blog post in the database
Route::put('/admin/blogs/{slug}', [App\Http\Controllers\Admin\BlogPostController::class, 'update'])->name('admin.blogs.update');

// // Delete a blog post from the database
Route::delete('/admin/blogs/{id}', [App\Http\Controllers\Admin\BlogPostController::class, 'destroy'])->name('admin.blogs.destroy');


Route::get('testlang', function(){
    return \Illuminate\Support\Facades\Artisan::call('config:cache');
});

Route::get('lang/{lang}', [\App\Http\Controllers\HomeController::class, 'languageChange'])->name('change-language');
 
Route::get('/', function () { return view('index');});


Auth::routes();
// Route::get('/comsignup', function () {
//         return view('comsignup');
//     });
Route::get('comsignup',[App\Http\Controllers\Auth\ComRegisterController::class, 'index']);
Route::get('checkValidVat/{vat}',[App\Http\Controllers\Auth\ComRegisterController::class, 'checkValidVat'])->name('checkValidVat');

Route::post('comsignup',[App\Http\Controllers\Auth\ComRegisterController::class, 'create'])->name('comsignup.create');

/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/

Route::any('/user-proxy/enter/{id}', function ($id) {
    request()->session()->put('user-proxy-id', $id);
    return redirect('/company/companyDashboard');
});

// Exit Impersonation Mode
Route::any('/user-proxy/exit', function () {
    request()->session()->remove('user-proxy-id');
    return redirect('/admin/adminDashboard');
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
    $request->fulfill();

    if(auth()->user()->type == 'user'){
    return redirect(route('dashboard'));
    }
    else{
        return redirect(route('company.companyDashboard'));

    }
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (\Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::post('contact_us', [App\Http\Controllers\MailController::class, 'contact']);
Route::get('contact', [App\Http\Controllers\MailController::class, 'index']);
Route::get('/contact', [App\Http\Controllers\MailController::class, 'index'])->name('contact');

    Route::get('/about', function () {
        return view('about');
    });
    Route::get('/blogs', function () {
        // $blogs = DB::table('blogs')->where(['status'=>1])->latest()->paginate(10);
        $categories = DB::table('categories')->where(['status'=>1])->get();
        $blogs = DB::table('blogs')
        ->join('categories', 'blogs.cat_id', '=', 'categories.id')
        ->select('blogs.*', 'categories.name as category_name')
        ->where('blogs.status', '=',1)
        ->paginate(10);
        if ($blogs->isEmpty()) {
            return view('no_blogs_found', ['message' => 'No blogs found.','categories' => $categories]);
        }
        return view('blogs', ['blogs' => $blogs,'categories' => $categories]);
    });

    Route::get('/cat-blogs/{id}', function ($id) {
        $categories = DB::table('categories')->where(['status'=>1])->get();
        $blogs = DB::table('blogs')
        ->join('categories', 'blogs.cat_id', '=', 'categories.id')
        ->select('blogs.*', 'categories.name as category_name')
        ->where('categories.id', '=', $id)
        ->paginate(10);
        if ($blogs->isEmpty()) {
            return view('no_blogs_found', ['message' => 'No blogs found .','categories' => $categories]);
        }

        if ($categories->isEmpty()) {
            return view('no_blogs_found', ['message' => 'No categories found.','categories' => $categories]);
        }
        return view('blogs', ['blogs' => $blogs,'categories' => $categories]);
    });

    Route::get('/blog/{slug}', [App\Http\Controllers\HomeController::class, 'single_blog'])->name('single_blog');
    // Route::get('/contact', function () {
    //     return view('contact');
    // });
    Route::get('/service', function () {
        return view('service');
    });

    Route::get('/privacy', function () {
        return view('privacy');
    });
    Route::get('/whosignup', function () {
        return view('whosignup');
    });

    Route::get('price', function() { return redirect('/'); });
    Route::post('distance_calculate',[App\Http\Controllers\PriceController::class, 'calculate_price'])->name('price.calculate_price');
    Route::get( 'priceIndex',[App\Http\Controllers\PriceController::class, 'index'])->name('price.index');
    Route::post('priceCreate',[App\Http\Controllers\PriceController::class, 'create'])->name('price.create');
    Route::post('priceUpdate/{id}',[App\Http\Controllers\PriceController::class, 'update'])->name('price.update');
    Route::post('calculate_average_price',[App\Http\Controllers\PriceController::class, 'calculate_average_price'])->name('price.calculate_average_price');
    Route::get('change_pw/{id}',[App\Http\Controllers\PriceController::class, 'change_pw']);
    Route::get('/invoice/{id}', [App\Http\Controllers\InvoiceController::class, 'index']);
    Route::post('invoiceCreate',[App\Http\Controllers\InvoiceController::class, 'create'])->name('invoice.create');
    Route::get('/customer_invoice/{id}', [App\Http\Controllers\InvoiceController::class, 'customer_invoice']);
    Route::get('/payment', [App\Http\Controllers\StripeController::class, 'index']);
    Route::get('bank_payment/{id}',[App\Http\Controllers\StripeController::class, 'bankDetail']);
    Route::get('defferd_payment/{id}',[App\Http\Controllers\StripeController::class, 'defferd_payment']);
    Route::get('invoice_bank_payment/{id}',[App\Http\Controllers\StripeController::class, 'invoice_bank_payment']);
    Route::get('/stripe-payment', [App\Http\Controllers\StripeController::class, 'handleGet']);
    Route::post('/stripe-payment', [App\Http\Controllers\StripeController::class, 'handlePost'])->name('stripe.payment');
    Route::post('/stripe-invoice_payment', [App\Http\Controllers\StripeController::class, 'handleInvoicePost'])->name('stripe.invoice_payment');
    Route::get('/invoice_payment_done', [App\Http\Controllers\StripeController::class, 'handleInvoiceGet'])->name('stripe.invoice_payment_done');

    Route::get('repair', function () {
        $locations = DB::table('users')->where(['type'=>'2'])->groupBy('location')->get();
        $services = DB::table('services')->get();
        return view('repair', ['locations' => $locations, 'services' => $services]);
    });

    Route::get('purchase', function () {
        $locations = DB::table('users')->where(['type'=>'2'])->groupBy('location')->get();
        return view('purchase', ['locations' => $locations]);
    });

    Route::get('transport', [App\Http\Controllers\TransportController::class, 'index']);

    Route::get('sendMail', [App\Http\Controllers\MailController::class, 'index']);

    Route::middleware(['auth', 'verified', 'user-access:user'])->group(function () {
    Route::post('repair',[App\Http\Controllers\RepairController::class, 'store'])->name('repair.store');
    Route::get('repairConfirm', function () { return view('repairConfirm');})->name('repairConfirm');
    Route::post('purchase',[App\Http\Controllers\PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('purchaseConfirm', function () { return view('purchaseConfirm');})->name('purchaseConfirm');
    Route::post('transport',[App\Http\Controllers\TransportController::class, 'store'])->name('transport.store');
    Route::get('transportConfirm', function () { return view('transportConfirm');})->name('transportConfirm');
    Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('booking', [App\Http\Controllers\BookingController::class, 'index'])->name('booking');
    Route::get('quote', [App\Http\Controllers\QuoteController::class, 'index'])->name('quote');
    Route::get('pastQuote', [App\Http\Controllers\QuoteController::class, 'past'])->name('pastQuote');
    Route::get('profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::post('edit-profile/name',[App\Http\Controllers\ProfileController::class, 'store'])->name('profile.store');
    Route::post('edit-profile/password',[App\Http\Controllers\ProfileController::class, 'password'])->name('profile.password');
    Route::get('/create_order', [App\Http\Controllers\ProfileController::class, 'create_order'])->name('user.create_order');
    Route::get('/quote/get/{sender}/{receiver}', [App\Http\Controllers\ProfileController::class, 'getReceiverDetails'])->name('details-receiver-get');
    Route::get('/invoice_company',[App\Http\Controllers\ProfileController::class, 'invoice'])->name('invoice-user');
    Route::get('view_order_company/{id}',[App\Http\Controllers\ProfileController::class, 'viewOrder'])->name('invoice-user');
});



/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::resource('admin/adminDashboard', App\Http\Controllers\Admin\AdminDashboardController::class);
    Route::resource('admin/adminRequest', App\Http\Controllers\Admin\AdminRequestController::class);
    
    // Shahzad New Blog routes 
    
    Route::post('/admin/add_order_address', [App\Http\Controllers\Admin\AdminRequestController::class,'add_order_address'])->name('admin.add_order_address');
    Route::post('/admin/edit_order_info', [App\Http\Controllers\Admin\AdminRequestController::class,'edit_order_info'])->name('admin.edit_order_info');
    Route::post('/admin/manage_additional_charges', [App\Http\Controllers\Admin\AdminRequestController::class,'manage_additional_charges'])->name('admin.manage_additional_charges');
    Route::post('/admin/request_additional_charges', [App\Http\Controllers\Admin\AdminRequestController::class,'request_additional_charges'])->name('admin.request_additional_charges');
    Route::post('/admin/new_invoice_gen', [App\Http\Controllers\Admin\AdminRequestController::class,'new_invoice_gen'])->name('admin.new_invoice_gen');
    Route::post('/admin/manage_refund', [App\Http\Controllers\Admin\AdminRequestController::class,'manage_refund'])->name('admin.manage_refund');
    Route::post('/admin/create_credit_note', [App\Http\Controllers\Admin\AdminRequestController::class,'create_credit_note'])->name('admin.create_credit_note');
    Route::post('/admin/send_carrier_email', [App\Http\Controllers\Admin\AdminRequestController::class,'send_carrier_email'])->name('admin.send_carrier_email');
    Route::post('/admin/payment_link_email', [App\Http\Controllers\Admin\AdminRequestController::class,'payment_link_email'])->name('admin.payment_link_email');
    Route::resource('admin/adminComRequest', App\Http\Controllers\Admin\AdminComRequestController::class);
    Route::resource('admin/adminGuestRequest', App\Http\Controllers\Admin\AdminGuestRequestController::class);
    Route::resource('admin/adminUser', App\Http\Controllers\Admin\AdminUserController::class);
    Route::resource('admin/adminCarrier', App\Http\Controllers\Admin\AdminCarrierController::class);
    Route::resource('admin/adminCompany', App\Http\Controllers\Admin\AdminCompanyController::class);
    Route::get('admin/company_profile/{id}',[App\Http\Controllers\Admin\AdminCompanyController::class, 'company_profile']);
    Route::post('admin/company_profile_update',[App\Http\Controllers\Admin\AdminCompanyController::class, 'company_profile_update'])->name('admin.company_profile_update');
    Route::delete('admin/delete_order/{id}',[App\Http\Controllers\Admin\AdminCompanyController::class, 'delete_order']);
    Route::resource('admin/adminNewUser', App\Http\Controllers\Admin\AdminNewUserController::class);
    Route::resource('admin/adminLocation', App\Http\Controllers\Admin\AdminLocationController::class);
    Route::resource('admin/adminService', App\Http\Controllers\Admin\AdminServiceController::class);
    Route::resource('admin/adminCost', App\Http\Controllers\Admin\AdminCostController::class);
    Route::resource('admin/orders', \App\Http\Controllers\OrderController::class);
    Route::get('admin/invoice/{id}',[App\Http\Controllers\OrderController::class, 'invoice'])->name('invoice-admin');
    Route::post("/admin/verify_vat",[App\Http\Controllers\Admin\AdminCompanyController::class, 'verifyVat'])->name('admin.verify-vat');
    Route::post('/admin/invoice_view',[App\Http\Controllers\Admin\AdminRequestController::class, 'invoice_view'])->name('admin.invoice_view');
    Route::get('/admin/invoice_pdf_view/{id}',[App\Http\Controllers\Admin\AdminRequestController::class, 'invoice_pdf_view']);
    Route::get('/admin/credit_note_pdf/{id}',[App\Http\Controllers\Admin\AdminRequestController::class, 'credit_note_pdf']);
    Route::get('/admin/display_pdf/{file_name}',[App\Http\Controllers\Admin\AdminRequestController::class, 'display_pdf']);
   // Route::get('admin/weekly_invoice',[App\Http\Controllers\InvoiceController::class, 'weekly_invoice'])->name('admin.weekly_invoice');
   // Route::get('admin/monthly_invoice',[App\Http\Controllers\InvoiceController::class, 'monthly_invoice'])->name('admin.monthly_invoice');


});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'verified', 'user-access:company'])->group(function () {
    Route::get('/company/companyDashboard', [App\Http\Controllers\Company\CompanyDashboardController::class, 'index'])->name('company.companyDashboard');
    Route::get('/company/companyQuote', [App\Http\Controllers\Company\CompanyQuoteController::class, 'index'])->name('company.companyQuote');
    Route::get('/company/companyQuote/create', [App\Http\Controllers\Company\CompanyQuoteController::class, 'create'])->name('companyQuote.create');
    Route::get('/company/companyQuote/get/{sender}/{receiver}', [App\Http\Controllers\Company\CompanyQuoteController::class, 'getReceiverDetails'])->name('get-receiver-details');
    Route::get('/company/companyPastQuote', [App\Http\Controllers\Company\CompanyQuoteController::class, 'past'])->name('company.companyPastQuote');
    Route::get('/company/companyBooking', [App\Http\Controllers\Company\CompanyBookingController::class, 'index'])->name('company.companyBooking');
    Route::get('/company/companyProfile', [App\Http\Controllers\Company\CompanyProfileController::class, 'index'])->name('company.companyProfile');
    Route::post('/company/edit-profile/name',[App\Http\Controllers\Company\CompanyProfileController::class, 'store'])->name('companyProfile.store');
    Route::post('/company/edit-profile/password',[App\Http\Controllers\Company\CompanyProfileController::class, 'password'])->name('companyProfile.password');
    Route::get('company/view_order_company/{id}',[App\Http\Controllers\Company\CompanyProfileController::class, 'viewOrder']);
    Route::post('/company/invoice_company',[App\Http\Controllers\Company\CompanyQuoteController::class, 'invoice'])->name('company.invoice-company');
    Route::post("/company/verify_vat",[App\Http\Controllers\Company\CompanyQuoteController::class, 'verifyVat'])->name('company.verify-vat');

});




