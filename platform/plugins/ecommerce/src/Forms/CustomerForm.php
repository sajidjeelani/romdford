<?php

namespace Botble\Ecommerce\Forms;

use Botble\Base\Forms\FormAbstract;
use Botble\Ecommerce\Http\Requests\CustomerCreateRequest;
use Botble\Ecommerce\Models\Customer;
use Illuminate\Support\Facades\DB;

class CustomerForm extends FormAbstract
{

    /**
     * @var string
     */
    protected $template = 'core/base::forms.form-tabs';

    /**
     * {@inheritDoc}
     */
    public function buildForm()
    {
        $cutomerAddress = DB::table('ec_customer_addresses')->where('customer_id', basename(url()->current()))->first();
        $this
            ->setupModel(new Customer)
            ->setValidatorClass(CustomerCreateRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('email', 'text', [
                'label'      => trans('plugins/ecommerce::customer.email'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('plugins/ecommerce::customer.email_placeholder'),
                    'data-counter' => 60,
                ],
            ])
            ->add('address', 'text', [
                'label'      => trans('Address'),
                'label_attr' => ['class' => 'control-label required'],
                'value' => $cutomerAddress->address.", ".$cutomerAddress->city.", ".$cutomerAddress->state.", ".$cutomerAddress->country,

                'attr'       => [
                    'placeholder'  => trans('Address'),
                    'data-counter' => 60,
                    'readonly'=>true,
                ],
            ])
            ->add('address 1', 'text', [
                'label'      => trans('Address 1'),
                'label_attr' => ['class' => 'control-label required'],
                'value' => $cutomerAddress->address1,

                'attr'       => [
                    'placeholder'  => trans('Address'),
                    'data-counter' => 60,
                    'readonly'=>true,
                ],
            ])

            ->add('Additional address', 'text', [
                'label'      => trans('Additional address'),
                'label_attr' => ['class' => 'control-label required'],
                'value' => $cutomerAddress->aaddress,

                'attr'       => [
                    'placeholder'  => trans('Address'),
                    'data-counter' => 60,
                    'readonly'=>true,
                ],
            ])
            
            ->add('is_change_password', 'checkbox', [
                'label'      => trans('plugins/ecommerce::customer.change_password'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class' => 'hrv-checkbox',
                ],
                'value'      => 1,
            ])
            ->add('password', 'password', [
                'label'      => trans('plugins/ecommerce::customer.password'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'data-counter' => 60,
                ],
                'wrapper'    => [
                    'class' => $this->formHelper->getConfig('defaults.wrapper_class') . ($this->getModel()->id ? ' hidden' : null),
                ],
            ])
            ->add('password_confirmation', 'password', [
                'label'      => trans('plugins/ecommerce::customer.password_confirmation'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'data-counter' => 60,
                ],
                'wrapper'    => [
                    'class' => $this->formHelper->getConfig('defaults.wrapper_class') . ($this->getModel()->id ? ' hidden' : null),
                ],
            ]);
    }
}