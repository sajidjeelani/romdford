<?php

namespace Botble\Ecommerce\Http\Controllers;

use Assets;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Http\Requests\DiscountRequest;
use Botble\Ecommerce\Models\Discount;
use Botble\Ecommerce\Repositories\Interfaces\DiscountInterface;
use Botble\Ecommerce\Tables\DiscountTable;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class DiscountController extends BaseController
{

    /**
     * @var DiscountInterface
     */
    protected $discountRepository;

    /**
     * @param DiscountInterface $discountRepository
     */
    public function __construct(DiscountInterface $discountRepository)
    {
        $this->discountRepository = $discountRepository;
    }

    /**
     * @param DiscountTable $dataTable
     * @return Factory|View
     * @throws Throwable
     */
    public function index(DiscountTable $dataTable)
    {
        page_title()->setTitle(trans('plugins/ecommerce::discount.name'));

        Assets::addStylesDirectly(['vendor/core/plugins/ecommerce/css/ecommerce.css']);

        return $dataTable->renderTable();
    }

    /**
     * @return string
     */
    public function create()
    {
        page_title()->setTitle(trans('plugins/ecommerce::discount.create'));

        Assets::addStylesDirectly(['vendor/core/plugins/ecommerce/css/ecommerce.css'])
            ->addScriptsDirectly([
                'vendor/core/plugins/ecommerce/js/discount.js',
            ])
            ->addScripts(['timepicker', 'input-mask', 'blockui'])
            ->addStyles(['timepicker']);

        return view('plugins/ecommerce::discounts.create');
    }
    /**
     * @param int $id
     * @return string
     */
    public function edit(int $id)
    {
        page_title()->setTitle(trans('Edit Discount'));

        Assets::addStylesDirectly(['vendor/core/plugins/ecommerce/css/ecommerce.css'])
            ->addScriptsDirectly([
                'vendor/core/plugins/ecommerce/js/discount.js',
            ])
            ->addScripts(['timepicker', 'input-mask', 'blockui'])
            ->addStyles(['timepicker']);

        return view('plugins/ecommerce::discounts.edit',compact('id'));
    }
    /**
     * @param int $id
     * @return BaseHttpResponse
     */
    
    public function getData(int $id)
    {
        $user = DB::select('select * from ec_discounts where id=?',[$id]);
        return ($user);
    }
    /**
     * @param int $id
     * @return BaseHttpResponse
     */
    
    public function getCategories()
    {
        $categories = DB::select('select * from ec_product_categories');
        return ($categories);
    }

    /**
     * @param Request $req
     * @param string $id
     */
    public function update(Request $request,string $id){
        if (!$request->has('can_use_with_promotion')) {
            $request->merge(['can_use_with_promotion' => 0]);
        }

        if ($request->input('is_unlimited')) {
            $request->merge(['quantity' => null]);
        }

        $request->merge([
            'start_date' => Carbon::parse($request->input('start_date') . ' ' . $request->input('start_time'))
                ->toDateTimeString(),
        ]);

        if ($request->has('end_date') && !$request->has('unlimited_time')) {
            $request->merge([
                'end_date' => Carbon::parse($request->input('end_date') . ' ' . $request->input('end_time'))
                    ->toDateTimeString(),
            ]);
        } else {
            $request->merge([
                'end_date' => null,
            ]);
        }
        DB::table('ec_discounts')
            ->where('id', $id)
            ->update(['title'=>$request->title,'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,'quantity'=>$request->quantity,'value'=>$request->value,
            'product_quantity'=>$request->product_quantity,'min_order_price'=>$request->min_order_price,'type_option'=>$request->type_option,
            'target'=>$request->target,'customer_id'=>$request->customers]);
        if($request->customers!=null)
            DB::table('ec_discount_customers')
            ->updateOrInsert(['discount_id'=>$id],['customer_id'=>$request->customers]) ;
        if($request->products!=null)
            DB::table('ec_discount_products')
            ->updateOrInsert(['discount_id'=>$id],['product_id'=>$request->products]) ;
        if($request->product_collections!=null)
            DB::table('ec_discount_product_collections')
            ->updateOrInsert(['discount_id'=>$id],['product_collection_id'=>$request->product_collections]) ;
        if($request->categories!=null){
            DB::table('ec_discount_category')
            ->updateOrInsert(['discount_id'=>$id],['category_id'=>$request->categories]) ;
            
        }
        return redirect('/admin/discounts');
    }
    
    /**
     * @param DiscountRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function store(DiscountRequest $request, BaseHttpResponse $response)
    {
        if (!$request->has('can_use_with_promotion')) {
            $request->merge(['can_use_with_promotion' => 0]);
        }

        if ($request->input('is_unlimited')) {
            $request->merge(['quantity' => null]);
        }

        $request->merge([
            'start_date' => Carbon::parse($request->input('start_date') . ' ' . $request->input('start_time'))
                ->toDateTimeString(),
        ]);

        if ($request->has('end_date') && !$request->has('unlimited_time')) {
            $request->merge([
                'end_date' => Carbon::parse($request->input('end_date') . ' ' . $request->input('end_time'))
                    ->toDateTimeString(),
            ]);
        } else {
            $request->merge([
                'end_date' => null,
            ]);
        }

        /**
         * @var Discount $discount
         */
        $discount = $this->discountRepository->createOrUpdate($request->input());

        if ($discount) {
            $productCollections = $request->input('product_collections');
            if ($productCollections) {
                if (!is_array($productCollections)) {
                    $productCollections = [$productCollections];
                    $discount->productCollections()->attach($productCollections);
                }
            }

            $products = $request->input('products');

            if ($products) {
                if (!is_array($products)) {
                    $products = [$products];
                }
                $discount->products()->attach($products);
            }

            $variants = $request->input('variants');
            if ($variants) {
                if (is_string($variants) && Str::contains($variants, ',')) {
                    $variants = explode(',', $variants);
                }

                if (!is_array($variants)) {
                    $variants = [$variants];
                }

                $discount->products()->attach($variants);
            }

            $customers = $request->input('customers');
            if ($customers) {
                if (!is_array($customers)) {
                    $customers = [$customers];
                }
                $discount->customers()->attach($customers);
            }
        }

        event(new CreatedContentEvent(DISCOUNT_MODULE_SCREEN_NAME, $request, $discount));
        if($request->input('categories')!=null){
            $id = DB::table('ec_discounts')->orderBy('id', 'DESC')->first()->id;
            DB::table('ec_discount_category')
            ->updateOrInsert(['discount_id'=>$id],['category_id'=>$request->categories]) ;
        }
        return $response
            ->setNextUrl(route('discounts.index'))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $discount = $this->discountRepository->findOrFail($id);
            $this->discountRepository->delete($discount);
            event(new DeletedContentEvent(DISCOUNT_MODULE_SCREEN_NAME, $request, $discount));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $discount = $this->discountRepository->findOrFail($id);
            $this->discountRepository->delete($discount);
            event(new DeletedContentEvent(DISCOUNT_MODULE_SCREEN_NAME, $request, $discount));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }

    /**
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function postGenerateCoupon(BaseHttpResponse $response)
    {
        do {
            $code = strtoupper(Str::random(12));
        } while ($this->discountRepository->count(['code' => $code]) > 0);

        return $response->setData($code);
    }
}
