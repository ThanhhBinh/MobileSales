<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\RelatedProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ShippingMethodController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;

Route::prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');

    //Category
    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('admin.category.index');
        Route::get('trash', [CategoryController::class, 'trash'])->name('admin.category.trash');
        Route::get('show/{id}', [CategoryController::class, 'show'])->name('admin.category.show');
        Route::get('create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('store', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::put('update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('admin.category.delete');
        Route::get('restore/{id}', [CategoryController::class, 'restore'])->name('admin.category.restore');
        Route::get('status/{id}', [CategoryController::class, 'status'])->name('admin.category.status');
        Route::delete('destroy/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
        Route::post('delete_multiple', [CategoryController::class, 'delete_multiple'])->name('admin.category.delete_multiple');
        Route::post('destroy_multiple', [CategoryController::class, 'destroy_multiple'])->name('admin.category.destroy_multiple');
        Route::post('restore_multiple', [CategoryController::class, 'restore_multiple'])->name('admin.category.restore_multiple');
    });

    //Product
    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('admin.product.index');
        Route::get('trash', [ProductController::class, 'trash'])->name('admin.product.trash');
        Route::get('create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('store', [ProductController::class, 'store'])->name('admin.product.store');

        //relate Product
        Route::get('create_related_product/{id}', [RelatedProductController::class, 'create_related_product'])->name('admin.product.create_related_product');
        Route::post('store_related_product', [RelatedProductController::class, 'store_related_product'])->name('admin.product.store_related_product');
        Route::get('delete_related_product/{id}', [RelatedProductController::class, 'delete_related_product'])->name('admin.product.delete_related_product');

        Route::get('edit/{id}', [ProductController::class, 'edit'])->name('admin.product.edit');
        Route::put('update/{id}', [ProductController::class, 'update'])->name('admin.product.update');
        Route::get('delete/{id}', [ProductController::class, 'delete'])->name('admin.product.delete');
        Route::post('delete_multiple', [ProductController::class, 'delete_multiple'])->name('admin.product.delete_multiple');
        Route::get('restore/{id}', [ProductController::class, 'restore'])->name('admin.product.restore');
        Route::get('status/{id}', [ProductController::class, 'status'])->name('admin.product.status');
        Route::delete('destroy/{id}', [ProductController::class, 'destroy'])->name('admin.product.destroy');
        Route::post('destroy_multiple', [ProductController::class, 'destroy_multiple'])->name('admin.product.destroy_multiple');
        Route::post('restore_multiple', [ProductController::class, 'restore_multiple'])->name('admin.product.restore_multiple');
    });

    //media
    Route::prefix('media')->group(function () {
        Route::post('store', [MediaController::class, 'store'])->name('admin.media.store');
        Route::post('update/{id}', [MediaController::class, 'update'])->name('admin.media.update');
        Route::post('updatevideo/{id}', [MediaController::class, 'updatevide'])->name('admin.media.updatevideo');
        Route::delete('destroy/{id}', [MediaController::class, 'destroy'])->name('admin.media.destroy');
        Route::post('addVideo', [MediaController::class, 'addVideo'])->name('admin.media.addVideo');
    });

    //ProductReview
    Route::prefix('productreview')->group(function () {
        Route::get('/', [ProductReviewController::class, 'index'])->name('admin.productreview.index');
        Route::get('trash', [ProductReviewController::class, 'trash'])->name('admin.productreview.trash');
        Route::get('replay/{review_id}', [ProductReviewController::class, 'replay'])->name('admin.productreview.replay');
        Route::put('replayid/{review_id}', [ProductReviewController::class, 'replayid'])->name('admin.productreview.replayid');
        Route::get('delete/{review_id}', [ProductReviewController::class, 'delete'])->name('admin.productreview.delete');
        Route::get('restore/{review_id}', [ProductReviewController::class, 'restore'])->name('admin.productreview.restore');
        Route::delete('destroy/{review_id}', [ProductReviewController::class, 'destroy'])->name('admin.productreview.destroy');
        Route::post('delete_multiple', [ProductReviewController::class, 'delete_multiple'])->name('admin.productreview.delete_multiple');
        Route::post('publish_multiple', [ProductReviewController::class, 'publish_multiple'])->name('admin.productreview.publish_multiple');
        Route::post('unpublish_multiple', [ProductReviewController::class, 'unpublish_multiple'])->name('admin.productreview.unpublish_multiple');
        Route::post('destroy_multiple', [ProductReviewController::class, 'destroy_multiple'])->name('admin.productreview.destroy_multiple');
        Route::post('restore_multiple', [ProductReviewController::class, 'restore_multiple'])->name('admin.productreview.restore_multiple');
    });

    //Banner
    Route::prefix('banner')->group(function () {
        Route::get('/', [BannerController::class, 'index'])->name('admin.banner.index');
        Route::get('trash', [BannerController::class, 'trash'])->name('admin.banner.trash');
        Route::get('show/{id}', [BannerController::class, 'show'])->name('admin.banner.show');
        Route::get('create', [BannerController::class, 'create'])->name('admin.banner.create');
        Route::post('store', [BannerController::class, 'store'])->name('admin.banner.store');
        Route::get('edit/{id}', [BannerController::class, 'edit'])->name('admin.banner.edit');
        Route::put('update/{id}', [BannerController::class, 'update'])->name('admin.banner.update');
        Route::get('delete/{id}', [BannerController::class, 'delete'])->name('admin.banner.delete');
        Route::get('restore/{id}', [BannerController::class, 'restore'])->name('admin.banner.restore');
        Route::get('status/{id}', [BannerController::class, 'status'])->name('admin.banner.status');
        Route::post('destroy_multiple', [BannerController::class, 'destroy_multiple'])->name('admin.banner.destroy_multiple');
        Route::post('restore_multiple', [BannerController::class, 'restore_multiple'])->name('admin.banner.restore_multiple');
        Route::post('delete_multiple', [BannerController::class, 'delete_multiple'])->name('admin.banner.delete_multiple');
        Route::delete('destroy/{id}', [BannerController::class, 'destroy'])->name('admin.banner.destroy');
    });

    //Payment
    Route::prefix('payment')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('admin.payment.index');
        Route::get('trash', [PaymentController::class, 'trash'])->name('admin.payment.trash');
        Route::get('show/{id}', [PaymentController::class, 'show'])->name('admin.payment.show');
        Route::get('create', [PaymentController::class, 'create'])->name('admin.payment.create');
        Route::post('store', [PaymentController::class, 'store'])->name('admin.payment.store');
        Route::get('edit/{id}', [PaymentController::class, 'edit'])->name('admin.payment.edit');
        Route::put('update/{id}', [PaymentController::class, 'update'])->name('admin.payment.update');
        Route::get('delete/{id}', [PaymentController::class, 'delete'])->name('admin.payment.delete');
        Route::get('restore/{id}', [PaymentController::class, 'restore'])->name('admin.payment.restore');
        Route::get('status/{id}', [PaymentController::class, 'status'])->name('admin.payment.status');
        Route::delete('destroy/{id}', [PaymentController::class, 'destroy'])->name('admin.payment.destroy');
    });
    //Post
    Route::prefix('post')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('admin.post.index');
        Route::get('trash', [PostController::class, 'trash'])->name('admin.post.trash');
        Route::get('show/{id}', [PostController::class, 'show'])->name('admin.post.show');
        Route::get('create', [PostController::class, 'create'])->name('admin.post.create');
        Route::post('store', [PostController::class, 'store'])->name('admin.post.store');
        Route::get('edit/{id}', [PostController::class, 'edit'])->name('admin.post.edit');
        Route::put('update/{id}', [PostController::class, 'update'])->name('admin.post.update');
        Route::get('delete/{id}', [PostController::class, 'delete'])->name('admin.post.delete');
        Route::get('restore/{id}', [PostController::class, 'restore'])->name('admin.post.restore');
        Route::get('status/{id}', [PostController::class, 'status'])->name('admin.post.status');
        Route::delete('destroy/{id}', [PostController::class, 'destroy'])->name('admin.post.destroy');
        Route::post('destroy_multiple', [PostController::class, 'destroy_multiple'])->name('admin.post.destroy_multiple');
        Route::post('restore_multiple', [PostController::class, 'restore_multiple'])->name('admin.post.restore_multiple');
        Route::post('delete_multiple', [PostController::class, 'delete_multiple'])->name('admin.post.delete_multiple');
    });
    //Brand
    Route::prefix('brand')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('admin.brand.index');
        Route::get('trash', [BrandController::class, 'trash'])->name('admin.brand.trash');
        Route::get('show/{id}', [BrandController::class, 'show'])->name('admin.brand.show');
        Route::get('create', [BrandController::class, 'create'])->name('admin.brand.create');
        Route::post('store', [BrandController::class, 'store'])->name('admin.brand.store');
        Route::get('edit/{id}', [BrandController::class, 'edit'])->name('admin.brand.edit');
        Route::put('update/{id}', [BrandController::class, 'update'])->name('admin.brand.update');
        Route::get('delete/{id}', [BrandController::class, 'delete'])->name('admin.brand.delete');
        Route::post('delete_multiple', [BrandController::class, 'delete_multiple'])->name('admin.brand.delete_multiple');
        Route::post('destroy_multiple', [BrandController::class, 'destroy_multiple'])->name('admin.brand.destroy_multiple');
        Route::post('restore_multiple', [BrandController::class, 'restore_multiple'])->name('admin.brand.restore_multiple');
        Route::get('restore/{id}', [BrandController::class, 'restore'])->name('admin.brand.restore');
        Route::get('status/{id}', [BrandController::class, 'status'])->name('admin.brand.status');
        Route::delete('destroy/{id}', [BrandController::class, 'destroy'])->name('admin.brand.destroy');
    });

    //Order
    Route::prefix('order')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('admin.order.index');
        Route::get('edit/{order_id}', [OrderController::class, 'edit'])->name('admin.order.edit');
        Route::put('update/{order_id}', [OrderController::class, 'update'])->name('admin.order.update');
        Route::get('delete/{order_id}', [OrderController::class, 'delete'])->name('admin.order.delete');
        Route::get('status/{order_id}', [OrderController::class, 'status'])->name('admin.order.status');
        Route::delete('destroy/{order_id}', [OrderController::class, 'destroy'])->name('admin.order.destroy');
    });
    //Orderdetail
    Route::prefix('orderdetail')->group(function () {
        Route::get('/', [OrderDetailController::class, 'index'])->name('admin.orderdetail.index');
        Route::get('trash', [OrderDetailController::class, 'trash'])->name('admin.orderdetail.trash');
        Route::get('show/{id}', [OrderDetailController::class, 'show'])->name('admin.orderdetail.show');
        Route::get('create', [OrderDetailController::class, 'create'])->name('admin.orderdetail.create');
        Route::post('store', [OrderDetailController::class, 'store'])->name('admin.orderdetail.store');
        Route::get('edit/{id}', [OrderDetailController::class, 'edit'])->name('admin.orderdetail.edit');
        Route::put('update/{id}', [OrderDetailController::class, 'update'])->name('admin.orderdetail.update');
        Route::get('delete/{id}', [OrderDetailController::class, 'delete'])->name('admin.orderdetail.delete');
        Route::get('restore/{id}', [OrderDetailController::class, 'restore'])->name('admin.orderdetail.restore');
        Route::get('status/{id}', [OrderDetailController::class, 'status'])->name('admin.orderdetail.status');
        Route::delete('destroy/{id}', [OrderDetailController::class, 'destroy'])->name('admin.orderdetail.destroy');
    });
    //Shipping
    Route::prefix('shipping')->group(function () {
        Route::get('/', [ShippingMethodController::class, 'index'])->name('admin.shipping.index');
        Route::get('edit/{shipping_id}', [ShippingMethodController::class, 'edit'])->name('admin.shipping.edit');
        Route::delete('destroy/{shipping_id}', [ShippingMethodController::class, 'destroy'])->name('admin.shipping.destroy');
    });

    //Topic
    Route::prefix('topic')->group(function () {
        Route::get('/', [TopicController::class, 'index'])->name('admin.topic.index');
        Route::get('trash', [TopicController::class, 'trash'])->name('admin.topic.trash');
        Route::get('show/{id}', [TopicController::class, 'show'])->name('admin.topic.show');
        Route::get('create', [TopicController::class, 'create'])->name('admin.topic.create');
        Route::post('store', [TopicController::class, 'store'])->name('admin.topic.store');
        Route::get('edit/{id}', [TopicController::class, 'edit'])->name('admin.topic.edit');
        Route::put('update/{id}', [TopicController::class, 'update'])->name('admin.topic.update');
        Route::get('delete/{id}', [TopicController::class, 'delete'])->name('admin.topic.delete');
        Route::get('restore/{id}', [TopicController::class, 'restore'])->name('admin.topic.restore');
        Route::get('status/{id}', [TopicController::class, 'status'])->name('admin.topic.status');
        Route::delete('destroy/{id}', [TopicController::class, 'destroy'])->name('admin.topic.destroy');
        Route::post('destroy_multiple', [TopicController::class, 'destroy_multiple'])->name('admin.topic.destroy_multiple');
        Route::post('restore_multiple', [TopicController::class, 'restore_multiple'])->name('admin.topic.restore_multiple');
        Route::post('delete_multiple', [TopicController::class, 'delete_multiple'])->name('admin.topic.delete_multiple');
    });

    //PromotionController
    Route::prefix('promotion')->group(function () {
        Route::get('/', [PromotionController::class, 'index'])->name('admin.promotion.index');
        Route::get('create', [PromotionController::class, 'create'])->name('admin.promotion.create');
        Route::post('store', [PromotionController::class, 'store'])->name('admin.promotion.store');
        Route::get('edit/{id}', [PromotionController::class, 'edit'])->name('admin.promotion.edit');
        Route::put('update/{id}', [PromotionController::class, 'update'])->name('admin.promotion.update');
        Route::get('status/{id}', [PromotionController::class, 'status'])->name('admin.promotion.status');
        Route::delete('destroy/{id}', [PromotionController::class, 'destroy'])->name('admin.promotion.destroy');
    });

    //User
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.user.index');
        Route::get('create', [UserController::class, 'create'])->name('admin.user.create');
        Route::post('store', [UserController::class, 'store'])->name('admin.user.store');
        Route::get('create_address/{user_id}', [AddressController::class, 'create_address'])->name('admin.user.create_address');
        Route::post('store_address', [AddressController::class, 'store_address'])->name('admin.user.store_address');
        Route::get('edit/{user_id}', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::put('update/{user_id}', [UserController::class, 'update'])->name('admin.user.update');
        Route::get('edit_address/{id}', [AddressController::class, 'edit_address'])->name('admin.user.edit_address');
        Route::put('update_address/{id}', [AddressController::class, 'update_address'])->name('admin.user.update_address');
        Route::delete('destroy_address/{id}', [AddressController::class, 'destroy_address'])->name('admin.user.destroy_address');
        Route::delete('destroy/{user_id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
    });

    //roles
    Route::prefix('roles')->group(function () {
        Route::get('/', [RolesController::class, 'index'])->name('admin.roles.index');
        Route::get('create', [RolesController::class, 'create'])->name('admin.roles.create');
        Route::post('store', [RolesController::class, 'store'])->name('admin.roles.store');
        Route::get('edit/{id}', [RolesController::class, 'edit'])->name('admin.roles.edit');
        Route::put('update/{id}', [RolesController::class, 'update'])->name('admin.roles.update');
        Route::delete('destroy/{id}', [RolesController::class, 'destroy'])->name('admin.roles.destroy');
    });

    //report
    Route::prefix('report')->group(function () {
        Route::get('SalesSummary', [ReportController::class, 'SalesSummary'])->name('admin.report.SalesSummary');
        Route::get('LowStock', [ReportController::class, 'LowStock'])->name('admin.report.LowStock');
    });

    Route::get('/export-pdf/{id}', [InvoiceController::class, 'exportPdf'])->name('admin.export.pdf');
});
