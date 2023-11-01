<?php

Route::group(['namespace' => 'Botble\Ecommerce\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'discounts', 'as' => 'discounts.'], function () {
            Route::resource('', 'DiscountController')->parameters(['' => 'discount']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'DiscountController@deletes',
                'permission' => 'discounts.destroy',
            ]);

            Route::post('generate-coupon', [
                'as'         => 'generate-coupon',
                'uses'       => 'DiscountController@postGenerateCoupon',
                'permission' => 'discounts.create',
            ]);

            Route::post('edit/{id}', [
                'as'         => 'edit',
                'uses'       => 'DiscountController@edit',
                'permission' => 'discounts.edit',
            ]);
            Route::get('getData/{id}', [
                'as'         => 'getData',
                'uses'       => 'DiscountController@getData',
                'permission' => 'discounts.edit',
            ]);
            Route::get('getCategories', [
                'as'         => 'getData',
                'uses'       => 'DiscountController@getCategories',
                'permission' => 'discounts.edit',
            ]);
        });
    });
});

Route::group(['namespace' => 'Botble\Ecommerce\Http\Controllers\Fronts', 'middleware' => ['web', 'core']], function () {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {

        Route::group(['prefix' => 'coupon', 'as' => 'public.coupon.'], function () {
            Route::post('apply', [
                'as'   => 'apply',
                'uses' => 'PublicCheckoutController@postApplyCoupon',
            ]);

            Route::post('remove', [
                'as'   => 'remove',
                'uses' => 'PublicCheckoutController@postRemoveCoupon',
            ]);
        });
    });
});