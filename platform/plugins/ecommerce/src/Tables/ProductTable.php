<?php

namespace Botble\Ecommerce\Tables;

use BaseHelper;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Ecommerce\Exports\ProductExport;
use Botble\Ecommerce\Repositories\Interfaces\ProductInterface;
use Botble\Table\Abstracts\TableAbstract;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use RvMedia;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProductTable extends TableAbstract
{
    /**
     * @var bool
     */
    protected $hasActions = true;

    /**
     * @var bool
     */
    protected $hasFilter = true;

    /**
     * @var string
     */
    protected $exportClass = ProductExport::class;

    /**
     * ProductTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param ProductInterface $productRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, ProductInterface $productRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $productRepository;

        if (!Auth::user()->hasAnyPermission(['products.edit', 'products.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function ajax()
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                if (!Auth::user()->hasPermission('products.edit')) {
                    return $item->name;
                }

                return Html::link(route('products.edit', $item->id), $item->name);
            })
            ->editColumn('image', function ($item) {
                if ($this->request()->input('action') == 'csv') {
                    return RvMedia::getImageUrl($item->image, null, false, RvMedia::getDefaultImage());
                }

                if ($this->request()->input('action') == 'excel') {
                    return RvMedia::getImageUrl($item->image, 'thumb', false, RvMedia::getDefaultImage());
                }

                return $this->displayThumbnail($item->image);
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('price', function ($item) {
                $price = format_price($item->front_sale_price);

                if ($item->front_sale_price != $item->price) {
                    $price .= ' <del class="text-danger">' . format_price($item->price) . '</del>';
                }

                return $price;
            })
            ->editColumn('quantity', function ($item) {
                return view('plugins/ecommerce::products.partials.quantity', compact('item'))->render();
                // return $item->with_storehouse_management ? $item->quantity : '&#8734;';
            })
            ->editColumn('category', function ($item) {
                $data = json_decode(DB::table('ec_product_category_product')->select('category_id')->where('product_id', $item->id)->get());
                // $id = $data[0]->category_id;
                // $data=json_decode(DB::table('ec_product_categories')->select('name')->where('id', $id)->get());
                // return $data[0]->name;
                $id = $data[0]->category_id;

                $data = json_decode(DB::table('ec_product_categories')->select('name')->where('id', $id)->get());
            
                // Check if data is present in the second query
                if (!empty($data) && isset($data[0]->name)) {
                    return $data[0]->name;
                } else {
                    return 0; // Data not present in the second query
            }
            })
            ->editColumn('sku', function ($item) {
                return $item->sku ?: '&mdash;';
            })
            ->editColumn('Height', function ($item) {
                return $item->height ?: '&mdash;';
            })
            ->editColumn('Width', function ($item) {
                return $item->wide ?: '&mdash;';
            })
            ->editColumn('Depth', function ($item) {
                return $item->length ?: '&mdash;';
            })
            ->editColumn('Weight', function ($item) {
                return $item->weight ?: '&mdash;';
            })
            ->editColumn('order', function ($item) {
                return view('plugins/ecommerce::products.partials.sort-order', compact('item'))->render();
            })
            ->editColumn('status', function ($item) {
                return $item->status->toHtml();
            })
            ->editColumn('stock_status', function ($item) {
                return $item->stock_status_html;
            })
            ->addColumn('operations', function ($item) {
                return $this->getOperations('products.edit', 'products.destroy', $item);
            });
            

        return $this->toJson($data);
    }

    /**
     * {@inheritDoc}
     */
    public function query()
    {
        $query = $this->repository->getModel()
            ->select([
                'id',
                'name',
                'order',
                'created_at',
                'status',
                'sku',
                'height',
                'wide',
                'length',
                'weight',
                'images',
                'price',
                'sale_price',
                'sale_type',
                'start_date',
                'end_date',
                'quantity',
                'with_storehouse_management',
                'stock_status',
            ])
            ->where('is_variation', 0);

        return $this->applyScopes($query);
    }

    /**
     * {@inheritDoc}
     */
    public function htmlDrawCallbackFunction(): ?string
    {
        return parent::htmlDrawCallbackFunction() . '$(".editable").editable();';
    }

    /**
     * {@inheritDoc}
     */
    public function columns()
    {
        return [
            'id'           => [
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'image'        => [
                'name'  => 'images',
                'title' => trans('plugins/ecommerce::products.image'),
                'width' => '70px',
                'class' => 'text-center',
            ],
            'name'         => [
                'title' => trans('core/base::tables.name'),
                'class' => 'text-left',
            ],
            'price'        => [
                'title' => trans('plugins/ecommerce::products.price'),
                'class' => 'text-left',
            ],
            'category'        => [
                'title' => trans('Category'),
                'class' => 'text-left',
            ],
            'stock_status' => [
                'title' => trans('plugins/ecommerce::products.stock_status'),
                'class' => 'text-left',
            ],
            'quantity'     => [
                'title' => trans('plugins/ecommerce::products.quantity'),
                'class' => 'text-left',

            ],
            'height'          => [
                'title' => trans('Height'),
                'class' => 'text-left',
            ],
            'wide'          => [
                'title' => trans('Width'),
                'class' => 'text-left',
            ],
            'length'          => [
                'title' => trans('Depth'),
                'class' => 'text-left',
            ],
            'weight'          => [
                'title' => trans('Weight'),
                'class' => 'text-left',
            ],
            'sku'          => [
                'title' => trans('plugins/ecommerce::products.sku'),
                'class' => 'text-left',
            ],
            'order'        => [
                'title' => trans('core/base::tables.order'),
                'width' => '20px',
                'class' => 'text-center',
            ],
            'status'       => [
                'title' => trans('core/base::tables.status'),
                'width' => '20px',
                'class' => 'text-center',
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function buttons()
    {
        $this->addImportButton(route('products.create','products.create'));
        return $this->addCreateButton(route('products.create'), 'products.create');
    }


    /**
     * {@inheritDoc}
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('products.deletes'), 'products.destroy', parent::bulkActions());
    }

    /**
     * {@inheritDoc}
     */
    public function getBulkChanges(): array
    {
        return [
            'name'       => [
                'title'    => trans('core/base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'order'      => [
                'title'    => trans('core/base::tables.order'),
                'type'     => 'number',
                'validate' => 'required|min:0',
            ],
            'status'     => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function renderTable($data = [], $mergeData = [])
    {
        if ($this->query()->count() === 0 &&
            !$this->request()->wantsJson() &&
            $this->request()->input('filter_table_id') !== $this->getOption('id')
        ) {
            return view('plugins/ecommerce::products.intro');
        }
        return parent::renderTable($data, $mergeData);
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultButtons(): array
    {
        return [
            'export',
            'reload',
        ];
    }
}