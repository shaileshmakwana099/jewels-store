<?php


use App\Http\Controllers\AccountController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ADMIN\ADMINLoginController;
use App\Http\Controllers\ADMIN\ADMINSubscriptionPlanController;
use App\Http\Controllers\ADMIN\MembershipController;
use App\Http\Controllers\ADMIN\CustomerController as ADMINCustomerController;
use App\Http\Controllers\ADMIN\DashboardController;
use App\Http\Controllers\ADMIN\OrderController;
use App\Http\Controllers\AntiqueCutDiamondController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ColorDiamondController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DiamondController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NaturalDiamondController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\WishlistController;
use App\Models\ColorDiamond;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SUBSCRIPTION\SubscriptionController;
use App\Http\Controllers\SUBSCRIPTION\StripeWebhookController;
use Illuminate\Support\Facades\Auth;


Route::post('/change-language', [LanguageController::class, 'changeLanguage'])->middleware('web')->name('change.language');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/password-reset', function () {
    return view('account.password-reset-form');
});

// -------------------------------- Start Admin Routes --------------------------------
Route::get('/admin', [ADMINLoginController::class, 'showLoginForm'])->name('login');
Route::post('/admin', [ADMINLoginController::class, 'login'])->name('admin.login');
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard')->middleware('auth:web');
Route::post('admin/profile/update', [ADMINLoginController::class, 'update'])->name('admin.profile')->middleware('auth:web');

// Logout route
Route::post('/admin/logout', function () {
    Auth::logout();
    return redirect('/admin')->with('toast', [
        'type' => 'success',
        'message' => 'Logged out successfully!',
    ]);
})->name('admin.logout');

Route::get('/admin/order', [OrderController::class, 'index'])->name('admin.order');
Route::get('/admin/order/{order}/view', [OrderController::class, 'show'])->name('admin.order.view');
Route::post('/admin/order/{order}/update-status', [OrderController::class, 'updateStatus'])->name('admin.order.update-status');

// Route::get('/admin/order/{id}/edit', [OrderController::class, 'edit'])->name('admin.order.edit');
// Route::put('/admin/order/{id}/update', [OrderController::class, 'update'])->name('admin.order.update');
// Route::delete('/admin/order/{id}/delete', [OrderController::class, 'destroy'])->name('admin.order.delete');
Route::get('/admin/order/{order}/invoice', [OrderController::class, 'printInvoice'])->name('admin.order.invoice');

// Route::get('/admin/account', [AccountController::class, 'index'])->name('admin.account');
// Route::get('/admin/account/{id}/view', [AccountController::class,'show'])->name('admin.account.view');
// Route::get('/admin/account/{id}/edit', [AccountController::class, 'edit'])->name('admin.account.edit');
// Route::put('/admin/account/{id}/update', [AccountController::class, 'update'])->name('admin.account.update');

Route::get('admin/subscription/plan', [ADMINSubscriptionPlanController::class, 'index'])->name('admin.subscription.plan');
Route::get('admin/subscription/plan/create', [ADMINSubscriptionPlanController::class, 'create'])->name('admin.subscription.plan.create');
Route::post('admin/subscription/plan/store', [ADMINSubscriptionPlanController::class, 'store'])->name('admin.subscription.plan.store');
Route::get('admin/subscription/plan/{id}/view', [ADMINSubscriptionPlanController::class, 'show'])->name('admin.subscription.plan.view');
Route::get('admin/subscription/plan/{id}/edit', [ADMINSubscriptionPlanController::class, 'edit'])->name('admin.subscription.plan.edit');
Route::put('admin/subscription/plan/{id}/update', [ADMINSubscriptionPlanController::class, 'update'])->name('admin.subscription.plan.update');
Route::delete('admin/subscription/plan/{id}/delete', [ADMINSubscriptionPlanController::class, 'destroy'])->name('admin.subscription.plan.delete');

Route::get('admin/membership', [MembershipController::class, 'index'])->name('admin.membership.index');


// Route::get('/admin/customers', [ADMINCustomerController::class , 'index']);
Route::get('/admin/customers', [ADMINCustomerController::class, 'index'])->name('admin.customers.index');
Route::post('/admin/customers', [ADMINCustomerController::class, 'store'])->name('admin.customers.store');
Route::get('/customers/{id}/edit', [ADMINCustomerController::class, 'edit'])->name('admin.customers.edit');
Route::put('/customers/{id}', [ADMINCustomerController::class, 'update'])->name('admin.customers.update');
Route::delete('/customers/{id}', [ADMINCustomerController::class, 'destroy'])->name('admin.customers.destroy');


Route::get('/admin/fancy-color-diamonds', function () {
    return view('admin.fancy-color-diamonds');
});
Route::get('/admin/natural-diamonds', function () {
    return view('admin.natural-diamonds');
});
Route::get('/admin/lab-grown-diamonds', function () {
    return view('admin.lab-grown-diamonds');
});
Route::get('/admin/antique-cut-diamonds', function () {
    return view('admin.antique-cut-diamonds');
});
Route::get('/admin/precious-stone-diamonds', function () {
    return view('admin.precious-stone-diamonds');
});
// -------------------------------- End Admin Routes ----------------------------------


// -------------------------------- Diamond Lab Routes --------------------------------------------------
Route::get('/fancy-shapes-diamonds', function () {
    return view('lab-diamonds.fancy-shapes-diamonds');
})->name('fancy-shapes-diamonds');





Route::get('/color-melee-diamonds', function () {
    return view('lab-diamonds.color-melee-diamonds');
})->name('color-melee-diamonds');
// -------------------------------- End Diamond Lab Routes ----------------------------------------------

// -------------------------------- Engagement Rings Routes --------------------------------------------
// Create Your Diamond Ring
Route::get('/build-a-ring', function () {
    return view('engagement-rings.build-a-ring');
})->name('build-a-ring');
// Shop By Style
Route::get('/solitaire', function () {
    return view('engagement-rings.solitaire');
})->name('solitaire');
Route::get('/halo', function () {
    return view('engagement-rings.halo');
})->name('halo');
Route::get('/diamond-band', function () {
    return view('engagement-rings.diamond-band');
})->name('diamond-band');
Route::get('/hidden-halo', function () {
    return view('engagement-rings.hidden-halo');
})->name('hidden-halo');
Route::get('/three-stone', function () {
    return view('engagement-rings.three-stone');
})->name('three-stone');
Route::get('/bezel', function () {
    return view('engagement-rings.bezel');
})->name('bezel');
Route::get('/cluster', function () {
    return view('engagement-rings.cluster');
})->name('cluster');
Route::get('/dainty', function () {
    return view('engagement-rings.dainty');
})->name('dainty');
Route::get('/unique', function () {
    return view('engagement-rings.unique');
})->name('unique');
Route::get('/vintage-inspired', function () {
    return view('engagement-rings.vintage-inspired');
})->name('vintage-inspired');

// -------------------------------- End Engagement Rings Routes ------------------------------------------

// -------------------------------- Fine Jewellery Routes ------------------------------------------------

// Earrings
Route::get('/earrings', function () {
    return view('components.fine-jewellery.earrings.earrings');
})->name('earrings');

Route::get('/stud-earrings', function () {
    return view('components.fine-jewellery.earrings.stud');
})->name('stud-earrings');

Route::get('/hoops-and-drops', function () {
    return view('components.fine-jewellery.earrings.hoops-and-drops');
})->name('hoops-and-drops');

Route::get('/halo-earrings', function () {
    return view('components.fine-jewellery.earrings.halo');
})->name('halo-earrings');

Route::get('/cluster', function () {
    return view('components.fine-jewellery.earrings.cluster');
})->name('cluster');

Route::get('/wedding-rings', function () {
    return view('components.fine-jewellery.wedding-rings.wedding-rings');
})->name('wedding-rings');
// Wedding Rings
Route::get('/diamond', function () {
    return view('components.fine-jewellery.wedding-rings.diamond');
})->name('diamond');

Route::get('/anniversary', function () {
    return view('components.fine-jewellery.wedding-rings.anniversary');
})->name('anniversary');

Route::get('/eternity', function () {
    return view('components.fine-jewellery.wedding-rings.eternity');
})->name('eternity');


Route::get('/stackable', function () {
    return view('components.fine-jewellery.wedding-rings.stackable');
})->name('stackable');

Route::get('/pendants', function () {
    return view('components.fine-jewellery.pendants.pendants');
})->name('pendants');

Route::get('/solitaire-pendants', function () {
    return view('components.fine-jewellery.pendants.solitaire');
})->name('solitaire-pendants');

Route::get('/halo-pendants', function () {
    return view('components.fine-jewellery.pendants.halo');
})->name('halo-pendants');

Route::get('/diamond-pendants', function () {
    return view('components.fine-jewellery.pendants.diamond-pendants');
})->name('diamond-pendants');

Route::get('/chains', function () {
    return view('components.fine-jewellery.pendants.chains');
})->name('chains');

Route::get('/bracelets', function () {
    return view('components.fine-jewellery.bracelets.bracelets');
})->name('bracelets');

// Tennis Bracelets
Route::get('/tennis-bracelets', function () {
    return view('components.fine-jewellery.bracelets.tennis-bracelets');
})->name('tennis-bracelets');

// Solitaire Bracelets
Route::get('/solitaire-bracelets', function () {
    return view('components.fine-jewellery.bracelets.solitaire-bracelets');
})->name('solitaire-bracelets');

Route::get('/all-diamond-necklaces', function () {
    return view('components.fine-jewellery.necklaces.all-diamond-necklaces');
});

// Diamond Necklaces
Route::get('/diamond-necklaces', function () {
    return view('components.fine-jewellery.necklaces.diamond-necklaces');
})->name('diamond-necklaces');

// Tennis Necklaces
Route::get('/tennis-necklaces', function () {
    return view('components.fine-jewellery.necklaces.tennis-necklaces');
})->name('tennis-necklaces');

// Ready To Ship
Route::get('/ready-to-ship', function () {
    return view('components.ready-to-ship');
})->name('ready-to-ship');

// Membership
Route::get('/membership', [\App\Http\Controllers\MembershipController::class, 'index'])->name('membership');

// // Subscription Plan
// Route::get('/subscription-plan', function () {
//     return view('components.subscription-plan');
// })->name('subscription.plans');







// Product Display Pages
Route::get('/product', function () {
    return view('product.product');
});
Route::get('/product2', function () {
    return view('product.product2');
});

// My Account
Route::get('/my-account', function () {
    return view('account.my-account');
})->name('account.my-account');

// Login-Register
Route::get('/account', function () {
    return view('account.account');
})->name('account');

// Cart
// Route::get('/cart', function () {
//     return view('cart.cart');
// });





// Footer Categories
Route::get('/categories/custom-shape-diamonds', function () {
    return view('categories.custom-shape-diamonds');
})->name('custom-shape-diamonds');




// Footer Help
Route::get('/about-us', function () {
    return view('components.help.about');
})->name('about-us');

Route::get('/compare-us', function () {
    return view('components.help.compare-us');
})->name('compare-us');

Route::get('/why-choose-us', function () {
    return view('components.help.why-choose-us');
})->name('why-choose-us');

// Route::get('/diamond-size-chart', function () {
//     return view('components.help.diamond-size-chart');
// })->name('diamond-size-chart');

Route::get('/faq', function () {
    return view('components.help.faq');
})->name('faq');

Route::get('/contact-us', function () {
    return view('components.help.contact-us');
})->name('contact-us');

Route::get('/education', function () {
    return view('components.help.education');
})->name('help.education');

// Footer Privacy
Route::get('/shipping-policy', function () {
    return view('privacy.shipping-policy');
})->name('shipping-policy');

Route::get('/return-refund-policy', function () {
    return view('privacy.return-refund-policy');
})->name('return-refund-policy');

Route::get('/price-match-policy', function () {
    return view('privacy.price-match-policy');
})->name('price-match-policy');

Route::get('/feedback', function () {
    return view('privacy.feedback');
})->name('feedback');

Route::get('/privacy-policy', function () {
    return view('privacy.privacy-policy');
})->name('privacy-policy');

Route::get('/terms-of-use', function () {
    return view('privacy.terms-of-use');
})->name('terms-of-use');

// Contact Us
Route::get('/stores', function () {
    return view('components.stores');
})->name('stores');

Route::get('/ourstory', function () {
    return view('components.our_story');
})->name('ourstory');

Route::get('/mission', function () {
    return view('components.our_mission');
})->name('mission');


// ---------------------------------- Cart Routes -----------------------------------------------------
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
// ---------------------------------- End Cart Routes -------------------------------------------------

// ---------------------------------- Checkout Routes -------------------------------------------------
Route::get('/checkout/shipping', [CheckoutController::class, 'shipping'])->name('checkout.shipping');
Route::post('/checkout/shipping', [CheckoutController::class, 'storeShipping'])->name('checkout.shipping.store');
Route::get('/checkout/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::post('/checkout/process', [CheckoutController::class, 'checkoutProcess'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
Route::get('/checkout/complete', [CheckoutController::class, 'complete'])->name('checkout.complete');
// ---------------------------------- End Checkout Routes -------------------------------------------------

// ------------------------------- Addresses -----------------------------------------------------------
Route::get('/shipping-address', [AddressController::class, 'shipping'])->name('account.addresses.shipping');
Route::get('/billing-address', [AddressController::class, 'billing'])->name('account.addresses.billing');
Route::get('/account/addresses', [AddressController::class, 'addresses'])->name('account.addresses');
// -------------------------------- End Addresses ------------------------------------------------------

// -------------------------------- Customer Registration -----------------------------------------------
Route::get('/register', [CustomerController::class, 'index'])->name('customer.index');
Route::post('/register', [CustomerController::class, 'register'])->name('customer.store');
// -------------------------------- End Customer Registration -------------------------------------------

// -------------------------------- Password Reset ------------------------------------------------------
Route::post('/password-reset', [CustomerController::class, 'passwordReset'])->name('customer.password-reset');
Route::get('/password-reset/{token}', [CustomerController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/password-reset/update', [CustomerController::class, 'updatePassword'])->name('password.update');
// -------------------------------- End Password Reset --------------------------------------------------

// -------------------------------- Customer Login ------------------------------------------------------
Route::get('/login', [CustomerController::class, 'loginIndex'])->name('customer.login.index');
Route::post('/login', [CustomerController::class, 'login'])->name('customer.login');
// -------------------------------- End Customer Login --------------------------------------------------

// -------------------------------- Inventory & Diamond Routes ------------------------------------------
Route::get('/inventory', [DiamondController::class, 'index'])->name('inventory');
Route::get('/inventory/diamond/{diamond}', [DiamondController::class, 'details'])->name('diamonds.details');
// -------------------------------- End Inventory & Diamond Routes --------------------------------------

// -------------------------------- Fancy Color Diamond Routes ------------------------------------------
Route::get('/fancy-color-diamonds', [ColorDiamondController::class, 'index'])->name('color.diamond');
Route::get('/color/diamond/{colorDiamond}', [ColorDiamond::class, 'details'])->name('color.diamonds.details');
// --------------------------------  End Fancy Color Diamond Routes ------------------------------------------



// -------------------------------- Natural Diamond Routes ------------------------------------------
Route::get('/natural-diamond', [NaturalDiamondController::class, 'index'])->name('natural-diamond');
Route::get('/natural/diamond/{naturalDiamond}', [NaturalDiamondController::class, 'details'])->name('natural.diamonds.details');
// -------------------------------- End Natural Diamond Routes --------------------------------------

// -------------------------------- Antique Cut Diamond Routes ------------------------------------------
Route::get('/antique-cut-diamond', [AntiqueCutDiamondController::class, 'index'])->name('antique.cut.diamond');
Route::get('/antique/cut/diamond/{naturalDiamond}', [AntiqueCutDiamondController::class, 'details'])->name('antique.cut.diamonds.details');
// -------------------------------- Antique Cut Diamond Routes ------------------------------------------




// -------------------------------- Authenticated Routes ------------------------------------------------
Route::middleware(['auth:customer'])->group(function () {
    // Customer Details
    Route::get('/account/details', [AccountController::class, 'details'])->name('account.details');
    // Update Customer Details
    Route::post('/account/details', [CustomerController::class, 'updateDetails'])->name('account.update');
    // Logout
    Route::get('/account/logout', [AccountController::class, 'logout'])->name('account.logout');
    // My subscription
    Route::get('/account/my-subscription', [AccountController::class, 'mySubscription'])->name('account.my-subscription');

    // Customer Addresses
    Route::post('/account/addresses', [AddressController::class, 'store'])->name('account.addresses.store');
    Route::put('/account/addresses/{address}', [AddressController::class, 'update'])->name('account.addresses.update');
    Route::delete('/account/addresses/{address}', [AddressController::class, 'destroy'])->name('account.addresses.destroy');
    Route::post('/account/addresses/{address}/set-default', [AddressController::class, 'setDefault'])->name('account.addresses.setDefault');


    // Wishlist routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');

    // Orders
    Route::get('/account/orders', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/account/orders/{id}', [AccountController::class, 'orderDetails'])->name('account.orders.details');

    // Subscription Routes
    Route::post('/subscription/checkout', [SubscriptionController::class, 'checkout'])->name('subscription.checkout');
    Route::get('/subscription/success', [SubscriptionController::class, 'success'])->name('subscription.success');
    Route::get('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
    Route::get('/subscription/manage', [SubscriptionController::class, 'manage'])->name('subscription.manage');
    Route::post('/subscription/cancel-subscription', [SubscriptionController::class, 'cancelSubscription'])->name('subscription.cancel-subscription');
    Route::post('/subscription/resume-subscription', [SubscriptionController::class, 'resumeSubscription'])->name('subscription.resume-subscription');
});

// -------------------------------- End Authenticated Routes ---------------------------------------------

Route::get('/subscription-plans', [SubscriptionController::class, 'index'])->name('subscription.plans');
Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications.get');
Route::post('/notifications/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');

// -------------------------------- Stripe Webhook Routes ---------------------------------------------
Route::post('/webhook/stripe', [StripeWebhookController::class, 'handleWebhook'])->name('webhook.stripe');
// -------------------------------- End Stripe Webhook Routes ---------------------------------------------
