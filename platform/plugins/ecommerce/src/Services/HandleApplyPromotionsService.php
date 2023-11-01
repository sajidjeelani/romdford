<?php

namespace Botble\Ecommerce\Services;

use Botble\Ecommerce\Models\Discount;
use Botble\Ecommerce\Repositories\Interfaces\DiscountInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductInterface;
use Cart; 
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use OrderHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class HandleApplyPromotionsService
{
    /**
     * @var DiscountInterface
     */
    protected $discountRepository;

    /**
     * @var ProductInterface
     */
    protected $productRepository;

    /**
     * @var null|Collection
     */
    protected $promotions;

    /**
     * HandleApplyPromotionsService constructor.
     * @param DiscountInterface $discountRepository
     * @param ProductInterface $productRepository
     */
    public function __construct(DiscountInterface $discountRepository, ProductInterface $productRepository)
    {
        $this->discountRepository = $discountRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @param string $token
     * @return float
     */
    public function execute($token = null, array $data = [], $prefix = '')
    {
        if (is_null($this->promotions)) {
            $promotions = $this->discountRepository->getAvailablePromotions();
            $this->promotions = $promotions;
        } else {
            $promotions = $this->promotions;
        }

        $promotionDiscountAmount = 0;
        $val = false;
        $rawTotal = Arr::get($data, 'rawTotal', Cart::instance('cart')->rawTotal());
        $cartItems = Arr::get($data, 'cartItems', Cart::instance('cart')->content());
        $countCart = Arr::get($data, 'countCart', Cart::instance('cart')->count());
        $i=0;
        foreach ($promotions as $promotion) {
            /**
             * @var Discount $promotion
             */
             
            switch ($promotion->type_option) {
                case 'amount':
                    switch ($promotion->target) {
                        case 'amount-minimum-order':
                            if ($promotion->min_order_price <= $rawTotal) {
                                $promotionDiscountAmount += $promotion->value;
                            }
                            break;
                        case 'all-orders':
                            $promotionDiscountAmount += $promotion->value;
                            break;
                        case 'category':
                            $val=false;
                            $categoryID=DB::table('ec_discount_category')->where('discount_id', $promotion->id)->pluck('category_id');
                            foreach($categoryID as $categoryID){
                                if($categoryID ){
                                        foreach ($cartItems as $item){
                                            $itemCategoryID=DB::table('ec_product_category_product')->where([['product_id',$item->id],['category_id',$categoryID]])->pluck('category_id');
                                            foreach($itemCategoryID as $itemCategoryID)
                                            if($itemCategoryID){
                                                $promotionDiscountAmount += $promotion->value;
                                                $val=true;
                                                break;
                                            }
                                            if($val)
                                                break;
                                        }
                                            if($val)
                                                break;
                                }
                            }
                            break;
                        default:
                            if ($countCart >= $promotion->product_quantity) {
                                $promotionDiscountAmount += $promotion->value;
                            }
                            break;
                    }
                    break;
                case 'percentage':
                    switch ($promotion->target) {
                        case 'amount-minimum-order':
                            if ($promotion->min_order_price <= $rawTotal) {
                                $promotionDiscountAmount += $rawTotal * $promotion->value / 100;
                            }
                            break;
                        case 'all-orders':
                            $promotionDiscountAmount += $rawTotal * $promotion->value / 100;
                            break;
                        case 'category':
                            $val=false;
                            $categoryID=DB::table('ec_discount_category')->where('discount_id', $promotion->id)->pluck('category_id');
                            foreach($categoryID as $categoryID){
                                if($categoryID){
                                    foreach ($cartItems as $item){
                                       
                                            
                                        $itemCategoryID=DB::table('ec_product_category_product')->where([['product_id',$item->id],['category_id',$categoryID]])->pluck('category_id');
                                        foreach($itemCategoryID as $itemCategoryID)
                                            if($itemCategoryID){
                                                $promotionDiscountAmount += $item->price * $promotion->value / 100;
                                                $val=true;
                                                break;
                                            }
                                            if($val){
                                                
                                                break;
                                            }
                                        }
                                            if($val)
                                            {
                                                break;
                                            }
                                        }
                                if($val)
                                            {
                                                break;
                                            }
                            }
                                
                            break;
                        default:
                            if ($countCart >= $promotion->product_quantity) {
                                $promotionDiscountAmount += $rawTotal * $promotion->value / 100;
                            }
                            break;
                    }
                    break;
                case 'same-price':
                    if ($promotion->product_quantity > 1 && $countCart >= $promotion->product_quantity) {
                        foreach ($cartItems as $item) {
                            if ($item->qty >= $promotion->product_quantity) {
                                if (in_array($promotion->target, ['specific-product', 'product-variant']) &&
                                    in_array($item->id, $promotion->products()->pluck('product_id')->all())
                                ) {
                                    $promotionDiscountAmount += ($item->price - $promotion->value) * $item->qty;
                                } elseif ($product = $this->productRepository->findById($item->id)) {
                                    $productCollections = $product
                                        ->productCollections()
                                        ->pluck('ec_product_collections.id')->all();

                                    $discountProductCollections = $promotion
                                        ->productCollections()
                                        ->pluck('ec_product_collections.id')
                                        ->all();

                                    if (!empty(array_intersect($productCollections,
                                        $discountProductCollections))) {
                                        $promotionDiscountAmount += ($item->price - $promotion->value) * $item->qty;
                                    }
                                }
                            }
                        }
                    }
                    break;
            }
        }
        
        if (!$token) {
            $token = OrderHelper::getOrderSessionToken();
        }

        $sessionData = OrderHelper::getOrderSessionData($token);
        Arr::set($sessionData, $prefix . 'promotion_discount_amount', $promotionDiscountAmount);
        OrderHelper::setOrderSessionData($token, $sessionData);

        return $promotionDiscountAmount;
    }
}