<?php

namespace Theme\Shopwise\Http\Controllers;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Blog\Repositories\Interfaces\PostInterface;
use Botble\Ecommerce\Repositories\Interfaces\FlashSaleInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductVariationInterface;
use Botble\Ecommerce\Repositories\Interfaces\ReviewInterface;
use Botble\Testimonial\Repositories\Interfaces\TestimonialInterface;
use Botble\Theme\Http\Controllers\PublicController;
use Cart;
use DB;
use Mail;
use EcommerceHelper;
use Illuminate\Http\Request;
use Theme;
use Theme\Shopwise\Http\Resources\BrandResource;
use Theme\Shopwise\Http\Resources\PostResource;
use Theme\Shopwise\Http\Resources\ProductCategoryResource;
use Theme\Shopwise\Http\Resources\ReviewResource;
use Theme\Shopwise\Http\Resources\TestimonialResource;

class MailController extends PublicController
{
    
    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */

    public function sendmail(Request $request){
        $name=($request->input('recipient-mail'));
        $data=['msg'=>$request->input('message-text'),'data'=>$request->input('url')];
        $user['to']= $name;
        Mail::send('mail',$data,function($messages) use ($user){ 
            $messages->to($user['to']);
            $messages->subject('Product Shared From Romford');
        });
        return redirect($request->input('url'));
        
    }
}
