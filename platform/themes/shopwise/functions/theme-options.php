<?php

app()->booted(function () {
    theme_option()
        ->setField([
            'id'         => 'copyright',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Copyright'),
            'attributes' => [
                'name'    => 'copyright',
                'value'   => '© 2021 Romford Gifts.',
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => __('Change copyright'),
                    'data-counter' => 250,
                ],
            ],
            'helper'     => __('Copyright on footer of site'),
        ])
        ->setField([
            'id'         => 'Under_Maintenance_Message',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Under Maintenance Message'),
            'attributes' => [
                'name'    => 'Under_Maintenance_Message',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => 'Under_Maintenance_Message',
                    'data-counter' => 500,
                ],
            ],
        ])
        ->setField([
            'id'         => 'Under_Maintenance',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'select',
            'label'      => __('Under Maintenance?'),
            'attributes' => [
                'name'    => 'Under_Maintenance',
                'list'    => [
                    'no'  => trans('core/base::base.no'),
                    'yes' => trans('core/base::base.yes'),
                ],
                'value'   => 'no',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'preloader_enabled',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'select',
            'label'      => __('Enable Preloader?'),
            'attributes' => [
                'name'    => 'preloader_enabled',
                'list'    => [
                    'no'  => trans('core/base::base.no'),
                    'yes' => trans('core/base::base.yes'),
                ],
                'value'   => 'no',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'hotline',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Hotline'),
            'attributes' => [
                'name'    => 'hotline',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => 'Hotline',
                    'data-counter' => 30,
                ],
            ],
        ])
        ->setField([
            'id'         => 'company_info',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Company Information'),
            'attributes' => [
                'name'    => 'company_info',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => 'Company Information',
                    'data-counter' => 300,
                ],
            ],
        ])
        ->setField([
            'id'         => 'newCustomercoupon',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'number',
            'label'      => __('Newsletter Subscription Coupon %'),
            'attributes' => [
                'name'    => 'newCustomercoupon',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => 'Newsletter Subscription Coupon %',

                ],
            ],
        ])
        
        ->setField([
            'id'         => 'giftprice',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'number',
            'label'      => __('Gift Wrap Price'),
            'attributes' => [
                'name'    => 'giftprice',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => 'Gift Wrape Price',

                ],
            ],
        ])
        ->setField([
            'id'         => 'headerdata',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Header Data Slide 1'),
            'attributes' => [
                'name'    => 'headerdata',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => 'Header Data Slider 1',
                    'data-counter' => 500,
                ],
            ],
        ])
        ->setField([
            'id'         => 'headerdata1',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Header Data Slide 2'),
            'attributes' => [
                'name'    => 'headerdata1',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => 'Header Data  Slider 2',
                    'data-counter' => 500,
                ],
            ],
        ])
        ->setField([
            'id'         => 'headerdata2',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Header Data Slider 3'),
            'attributes' => [
                'name'    => 'headerdata2',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => 'Header Data Slider 3',
                    'data-counter' => 500,
                ],
            ],
        ])
        ->setField([
            'id'         => 'newsletter_message',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Newsletter Message'),
            'attributes' => [
                'name'    => 'newsletter_message',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => 'Newsletter Message',
                    'data-counter' => 500,
                ],
            ],
        ])
        ->setField([
            'id'         => 'address',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Address'),
            'attributes' => [
                'name'    => 'address',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => 'Address',
                    'data-counter' => 120,
                ],
            ],
        ])
        ->setField([
            'id'         => 'email',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'email',
            'label'      => __('Email'),
            'attributes' => [
                'name'    => 'email',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => 'Email',
                    'data-counter' => 120,
                ],
            ],
        ])
        ->setField([
            'id'         => 'about-us',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'textarea',
            'label'      => __('About us'),
            'attributes' => [
                'name'    => 'about-us',
                'value'   => null,
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'primary_font',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'googleFonts',
            'label'      => __('Primary font'),
            'attributes' => [
                'name'  => 'primary_font',
                'value' => 'Poppins',
            ],
        ])
        ->setField([
            'id'         => 'slidersidetop',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'mediaImage',
            'label'      => __('Slider-Side Top Image'),
            'attributes' => [
                'name'  => 'slidersidetop',
                'value' => null,
            ],
        ])
        ->setField([
            'id'         => 'slidersidetoplink',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Slider-Side Bottom Right Content Link'),
            'attributes' => [
                'name'    => 'slidersidetoplink',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => 'Slider-Side Bottom Right Content Link',
                    'data-counter' => 200,
                ],
            ],
        ])
        ->setField([
            'id'         => 'slidersidetopcontent',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'mediaImage',
            'label'      => __('Slider-Side Top Right Image'),
            'attributes' => [
                'name'  => 'slidersidetopcontent',
                'value' => null,
            ],
        ])

        ->setField([
            'id'         => 'slidersidetopcontentlink',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Slider-Side Top Content Link'),
            'attributes' => [
                'name'    => 'slidersidetopcontentlink',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => 'Slider-Side Top Content Link',
                    'data-counter' => 200,
                ],
            ],
        ])
        ->setField([
            'id'         => 'mostfavouritelink',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Most Favourite Redirect Link'),
            'attributes' => [
                'name'    => 'mostfavouritelink',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => 'Most Favourite Redirect Link',
                    'data-counter' => 200,
                ],
            ],
        ])
        ->setField([
            'id'         => 'mostfavourite',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'mediaImage',
            'label'      => __('Most Favourite'),
            'attributes' => [
                'name'    => 'mostfavourite',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => 'Most Favourite',
                    'data-counter' => 200,
                ],
            ],
        ])
        ->setField([
            'id'         => 'disneyimage',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'mediaImage',
            'label'      => __('Disney Image'),
            'attributes' => [
                'name'    => 'disneyimage',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => 'Disney Image',
                    'data-counter' => 200,
                ],
            ],
        ])
        ->setField([
            'id'         => 'disnyredirectlink',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Disney Redirect Link'),
            'attributes' => [
                'name'    => 'disnyredirectlink',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => 'Disney Redirect Link',
                    'data-counter' => 200,
                ],
            ],
        ])
        
        ->setField([
            'id'         => 'giftitemquantity',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Gift Item Quantity'),
            'attributes' => [
                'name'    => 'giftitemquantity',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => 'Gift Item Quantity',
                    'data-counter' => 200,
                ],
            ],
        ])
        ->setField([
            'id'         => 'bestgiftredirectlink',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Best Gift Redirect Link'),
            'attributes' => [
                'name'    => 'bestgiftredirectlink',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => 'Best Gift Redirect Link',
                    'data-counter' => 200,
                ],
            ],
        ])
        ->setField([
            'id'         => 'bestgiftimage',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'mediaImage',
            'label'      => __('Best Gift'),
            'attributes' => [
                'name'  => 'bestgiftimage',
                'value' => null,
            ],
        ])
        ->setField([
            'id'         => 'jokerimg',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'mediaImage',
            'label'      => __('Disney Showcase'),
            'attributes' => [
                'name'  => 'jokerimg',
                'value' => null,
            ],
        ])
        
        ->setField([
            'id'         => 'jokerlink',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Disney Showcase Link'),
            'attributes' => [
                'name'    => 'jokerlink',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'placeholder'  => 'Disney Showcase Link',
                    'data-counter' => 200,
                ],
            ],
        ])
        ->setField([
            'id'         => 'primary_color',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'customColor',
            'label'      => __('Primary color'),
            'attributes' => [
                'name'  => 'primary_color',
                'value' => '#FF324D',
            ],
        ])
        ->setField([
            'id'         => 'secondary_color',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'customColor',
            'label'      => __('Secondary color'),
            'attributes' => [
                'name'  => 'secondary_color',
                'value' => '#1D2224',
            ],
        ])
        ->setField([
            'id'         => 'enable_newsletter_popup',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'select',
            'label'      => __('Enable Newsletter popup?'),
            'attributes' => [
                'name'    => 'enable_newsletter_popup',
                'list'    => [
                    'no'  => trans('core/base::base.no'),
                    'yes' => trans('core/base::base.yes'),
                ],
                'value'   => 'yes',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'newsletter_image',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'mediaImage',
            'label'      => __('Image for newsletter popup'),
            'attributes' => [
                'name'  => 'newsletter_image',
                'value' => null,
            ],
        ])
        
        ->setField([
            'id'         => 'newsletter_show_after_seconds',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'number',
            'label'      => __('Newsletter popup delay time (seconds)'),
            'attributes' => [
                'name'    => 'newsletter_show_after_seconds',
                'value'   => 10,
                'options' => [
                    'class'       => 'form-control',
                    'placeholder' => __('Default: 10 (seconds)'),
                ],
            ],
        ])
        ->setField([
            'id'         => 'logo_footer',
            'section_id' => 'opt-text-subsection-logo',
            'type'       => 'mediaImage',
            'label'      => __('Dark Logo'),
            'attributes' => [
                'name'  => 'logo_footer',
                'value' => null,
            ],
        ])
        ->setSection([
            'title'      => __('Social'),
            'desc'       => __('Social links'),
            'id'         => 'opt-text-subsection-social',
            'subsection' => true,
            'icon'       => 'fa fa-share-alt',
        ])
        ->setField([
            'id'         => 'facebook',
            'section_id' => 'opt-text-subsection-social',
            'type'       => 'text',
            'label'      => 'Facebook',
            'attributes' => [
                'name'    => 'facebook',
                'value'   => null,
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'twitter',
            'section_id' => 'opt-text-subsection-social',
            'type'       => 'text',
            'label'      => 'Twitter',
            'attributes' => [
                'name'    => 'twitter',
                'value'   => null,
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'youtube',
            'section_id' => 'opt-text-subsection-social',
            'type'       => 'text',
            'label'      => 'Youtube',
            'attributes' => [
                'name'    => 'youtube',
                'value'   => null,
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'instagram',
            'section_id' => 'opt-text-subsection-social',
            'type'       => 'text',
            'label'      => 'Instagram',
            'attributes' => [
                'name'    => 'instagram',
                'value'   => null,
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'payment_methods',
            'section_id' => 'opt-text-subsection-ecommerce',
            'type'       => 'mediaImages',
            'label'      => 'Accepted Payment methods',
            'attributes' => [
                'name'   => 'payment_methods[]',
                'values' => theme_option('payment_methods', []),
            ],
        ])
        ->setSection([
            'title'      => __('Header'),
            'desc'       => __('Options for header'),
            'id'         => 'opt-text-subsection-header',
            'subsection' => true,
            'icon'       => 'fas fa-magic',
        ])
        ->setField([
            'id'         => 'enable_sticky_header',
            'section_id' => 'opt-text-subsection-header',
            'type'       => 'select',
            'label'      => 'Enable sticky header?',
            'attributes' => [
                'name'    => 'enable_sticky_header',
                'list'    => [
                    'yes' => trans('core/base::base.yes'),
                    'no'  => trans('core/base::base.no'),
                ],
                'value'   => 'yes',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'collapsing_product_categories_on_homepage',
            'section_id' => 'opt-text-subsection-header',
            'type'       => 'select',
            'label'      => 'Collapsing product categories on homepage?',
            'attributes' => [
                'name'    => 'collapsing_product_categories_on_homepage',
                'list'    => [
                    'yes' => trans('core/base::base.yes'),
                    'no'  => trans('core/base::base.no'),
                ],
                'value'   => 'no',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ]);
// Facebook integration
    theme_option()
        ->setSection([
            'title'      => __('Facebook Integration'),
            'desc'       => __('Facebook Integration'),
            'id'         => 'opt-text-subsection-facebook-integration',
            'subsection' => true,
            'icon'       => 'fab fa-facebook',
        ])
        ->setField([
            'id'         => 'facebook_chat_enabled',
            'section_id' => 'opt-text-subsection-facebook-integration',
            'type'       => 'select',
            'label'      => __('Enable Facebook chat?'),
            'attributes' => [
                'name'    => 'facebook_chat_enabled',
                'list'    => [
                    'no'  => trans('core/base::base.no'),
                    'yes' => trans('core/base::base.yes'),
                ],
                'value'   => 'no',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
            'helper'     => __('To show chat box on that website, please go to :link and add :domain to whitelist domains!',
                [
                    'domain' => Html::link(url('')),
                    'link'   => Html::link('https://www.facebook.com/' . theme_option('facebook_page_id') . '/settings/?tab=messenger_platform'),
                ]),
        ])
        ->setField([
            'id'         => 'facebook_page_id',
            'section_id' => 'opt-text-subsection-facebook-integration',
            'type'       => 'text',
            'label'      => __('Facebook page ID'),
            'attributes' => [
                'name'    => 'facebook_page_id',
                'value'   => null,
                'options' => [
                    'class' => 'form-control',
                ],
            ],
            'helper'     => __('You can get fan page ID using this site :link',
                ['link' => Html::link('https://findmyfbid.com')]),
        ])
        ->setField([
            'id'         => 'facebook_comment_enabled_in_post',
            'section_id' => 'opt-text-subsection-facebook-integration',
            'type'       => 'select',
            'label'      => __('Enable Facebook comment in post detail page?'),
            'attributes' => [
                'name'    => 'facebook_comment_enabled_in_post',
                'list'    => [
                    'yes' => trans('core/base::base.yes'),
                    'no'  => trans('core/base::base.no'),
                ],
                'value'   => 'no',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'facebook_comment_enabled_in_product',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'select',
            'label'      => __('Enable Facebook comment in product detail page?'),
            'attributes' => [
                'name'    => 'facebook_comment_enabled_in_product',
                'list'    => [
                    'no'  => trans('core/base::base.no'),
                    'yes' => trans('core/base::base.yes'),
                ],
                'value'   => 'no',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id'         => 'facebook_app_id',
            'section_id' => 'opt-text-subsection-facebook-integration',
            'type'       => 'text',
            'label'      => __('Facebook App ID'),
            'attributes' => [
                'name'        => 'facebook_app_id',
                'value'       => null,
                'options'     => [
                    'class' => 'form-control',
                ],
                'placeholder' => 'Ex: 2061237023872679',
            ],
            'helper'     => __('You can create your app in :link',
                ['link' => Html::link('https://developers.facebook.com/apps')]),
        ])
        ->setField([
            'id'         => 'facebook_admins',
            'section_id' => 'opt-text-subsection-facebook-integration',
            'type'       => 'repeater',
            'label'      => __('Facebook Admins'),
            'attributes' => [
                'name'   => 'facebook_admins',
                'value'  => null,
                'fields' => [
                    [
                        'type'       => 'text',
                        'label'      => __('Facebook Admin ID'),
                        'attributes' => [
                            'name'    => 'text',
                            'value'   => null,
                            'options' => [
                                'class'        => 'form-control',
                                'data-counter' => 40,
                            ],
                        ],
                    ],
                ],
            ],
            'helper'     => __('Facebook admins to manage comments :link',
                ['link' => Html::link('https://developers.facebook.com/docs/plugins/comments')]),
        ]);

    add_filter(THEME_FRONT_HEADER, function ($html) {
        if (theme_option('facebook_app_id')) {
            $html .= Html::meta(null, theme_option('facebook_app_id'), ['property' => 'fb:app_id'])->toHtml();
        }

        if (theme_option('facebook_admins')) {
            foreach (json_decode(theme_option('facebook_admins'), true) as $facebookAdminId) {
                if (Arr::get($facebookAdminId, '0.value')) {
                    $html .= Html::meta(null, Arr::get($facebookAdminId, '0.value'), ['property' => 'fb:admins'])
                        ->toHtml();
                }
            }
        }

        return $html;
    }, 1180);

    add_filter(THEME_FRONT_FOOTER, function ($html) {
        return $html . Theme::partial('facebook-integration');
    }, 1180);
});