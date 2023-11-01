<?php

namespace Botble\Newsletter\Listeners;

use Botble\Newsletter\Events\SubscribeNewsletterEvent;
use EmailHandler;
use Html;
use Illuminate\Contracts\Queue\ShouldQueue;
use URL;

use Illuminate\Support\Facades\DB;

class SubscribeNewsletterListener implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param SubscribeNewsletterEvent $event
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException 
     * @throws \Throwable
     */
    public function handle(SubscribeNewsletterEvent $event)
    {
        $coupon=$this->newsletterCoupon();
        $mailer = EmailHandler::setModule(NEWSLETTER_MODULE_SCREEN_NAME)
            ->setVariableValues([
                'newsletter_name'             => $coupon ?? 'N/A',
                'newsletter_email'            => $event->newsLetter->email,
                'newsletter_unsubscribe_link' => Html::link(
                    URL::signedRoute('public.newsletter.unsubscribe',
                        ['user' => $event->newsLetter->id]),
                    __('here')
                )->toHtml(),
            ]);

        $mailchimpApiKey = setting('newsletter_mailchimp_api_key', config('plugins.newsletter.general.mailchimp.api_key'));
        $mailchimpListId = setting('newsletter_mailchimp_list_id', config('plugins.newsletter.general.mailchimp.list_id'));

        if (!$mailchimpApiKey || !$mailchimpListId) {
            $mailer->sendUsingTemplate('subscriber_email', $event->newsLetter->email);
        }

        $mailer->sendUsingTemplate('admin_email');
    }
    
    /**
     * @return string
     */
    public function newsletterCoupon(){
        
        $coupon = $this->randomString(4);
        $value=DB::table('settings')->where('key', 'theme-shopwise-newCustomercoupon')->pluck('value');
        $CopuPonid = DB::table('ec_discounts')->insertGetId([
            'title'=>"NewsLetter Registration",
            'code'=>$coupon,
            'type'=>'coupon',
            'total_used' => 0,
            'quantity'=>1,
            'type_option'=>'percentage',
            'value'=>$value[0],
            'target'=>'all-order',
            'product_quantity'=>1,
            'start_date'=>date('Y-m-d h:i:s'),
            'can_use_with_promotion'=> 1,
            'end_date'=>null
        ]);  
        
        
        return $coupon;
    }
    
     public function randomString() {
        
        $length = 8;
        $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $str = "";    
    
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[mt_rand(0, strlen($chars) - 1)];
        }

            return $str;
        }

}