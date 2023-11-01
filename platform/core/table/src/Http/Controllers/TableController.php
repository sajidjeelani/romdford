<?php

namespace Botble\Table\Http\Controllers;

use App\Http\Controllers\Controller;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Table\Http\Requests\BulkChangeRequest;
use Botble\Table\Http\Requests\FilterRequest;
use Botble\Table\TableBuilder;
use Exception;
use Form;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use Botble\Ecommerce\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class TableController extends Controller
{

    /**
     * @var TableBuilder
     */
    protected $tableBuilder;

    /**
     * TableController constructor.
     * @param TableBuilder $tableBuilder
     */
    public function __construct(TableBuilder $tableBuilder)
    {
        $this->tableBuilder = $tableBuilder;
    }

    /**
     * @param BulkChangeRequest $request
     * @return array|mixed
     * @throws Throwable
     */
    public function getDataForBulkChanges(BulkChangeRequest $request)
    {
        $object = $this->tableBuilder->create($request->input('class'));

        $data = $object->getValueInput(null, null, 'text');
        if (!$request->input('key')) {
            return $data;
        }

        $column = Arr::get($object->getBulkChanges(), $request->input('key'));
        if (empty($column)) {
            return $data;
        }

        $labelClass = 'control-label';
        if (!empty($column) && Str::contains(Arr::get($column, 'validate'), 'required')) {
            $labelClass .= ' required';
        }

        $label = '';
        if (!empty($column['title'])) {
            $label = Form::label($column['title'], null, ['class' => $labelClass])->toHtml();
        }

        if (isset($column['callback']) && method_exists($object, $column['callback'])) {
            $data = $object->getValueInput(
                $column['title'],
                null,
                $column['type'],
                call_user_func([$object, $column['callback']])
            );
        } else {
            $data = $object->getValueInput($column['title'], null, $column['type'], Arr::get($column, 'choices', []));
        }

        $data['html'] = $label . $data['html'];

        return $data;
    }
    
    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws BindingResolutionException
     */
    public function postSaveBulkChange(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/table::table.please_select_record'));
        }

        $inputKey = $request->input('key');
        $inputValue = $request->input('value');

        $object = $this->tableBuilder->create($request->input('class'));
        $columns = $object->getBulkChanges();

        if (!empty($columns[$inputKey]['validate'])) {
            $validator = Validator::make($request->input(), [
                'value' => $columns[$inputKey]['validate'],
            ]);

            if ($validator->fails()) {
                return $response
                    ->setError()
                    ->setMessage($validator->messages()->first());
            }
        }

        try {
            $object->saveBulkChanges($ids, $inputKey, $inputValue);
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }

        return $response->setMessage(trans('core/table::table.save_bulk_change_success'));
    }

    /**
     * @param FilterRequest $request
     * @return array|mixed
     * @throws BindingResolutionException
     * @throws Throwable
     */
    public function getFilterInput(FilterRequest $request)
    {
        $object = $this->tableBuilder->create($request->input('class'));

        $data = $object->getValueInput(null, null, 'text');
        if (!$request->input('key')) {
            return $data;
        }

        $column = Arr::get($object->getFilters(), $request->input('key'));
        if (empty($column)) {
            return $data;
        }

        if (isset($column['callback']) && method_exists($object, $column['callback'])) {
            return $object->getValueInput(
                null,
                $request->input('value'),
                $column['type'],
                call_user_func([$object, $column['callback']])
            );
        }

        return $object->getValueInput(
            null,
            $request->input('value'),
            $column['type'],
            Arr::get($column, 'choices', [])
        );
    }
    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws BindingResolutionException
     */
    public function uploadfile(Request $request, BaseHttpResponse $response){
        $value2=0;
        $value1=0;
        $fileName = basename($_FILES["Excelfile"]["name"]);
        $targetDir = url('/').'/storage/Excel/';
        $filename="toupload.xlsx";
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        if(!($fileType != "xlsx")){
            $request->file('Excelfile')->move(public_path('storage').'/Excel/',$filename);
            $attachment=public_path('storage').'/Excel/'.$filename;
            $Users=new UsersImport();
            Excel::import($Users,$attachment);
            Excel::import($Users,$attachment);
            
            return $response->setMessage(trans('Successfully Uploaded'));
        }
        
        else
        return $response->setError()
            ->setMessage(trans('Please Upload Excel file'));
    }
    /**
     * @param int $id
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws BindingResolutionException
     */
    public function duplicate($id,Request $request, BaseHttpResponse $response){
        
        
        $name;
        $product = DB::table('ec_products')->where('id', $id)->get();
        foreach($product as $products)
            $productArr = (array) $products;
        if($productArr['link']!=""){
            $delimiter = ",";
            $links=$productArr['link'];
            $links = explode($delimiter, $links);
            $size= count($links);
            for($j=0;$j<$size;$j++){
                $randomval=rand(0, 9999999999);
                $name[$j]='products/'.$randomval.'-150x150'.'.jpg';
                $contents = file_get_contents($links[$j]); // retrieve the image data
                Storage::put($name[$j], $contents); // store the image data locally
                $name[$j]='products/'.$randomval.'-540x300'.'.jpg';
                Storage::put($name[$j], $contents); // store the image data locally
                $name[$j]='products/'.$randomval.'-540x600'.'.jpg';
                Storage::put($name[$j], $contents); // store the image data locally
                $name[$j]='products/'.$randomval.'.jpg';
                Storage::put($name[$j], $contents); // store the image data locally
                $name[$j]='products/'.$randomval.'.jpg';
            }
            for($j=1;$j<$size;$j++){
                $name[0]=$name[0].'"'.','.'"'.$name[$j];
            }
            $name[0]='['.'"'.$name[0].'"'.']';
            $productArr['images']=$name[0];
        }

        $value2 = DB::select("SHOW TABLE STATUS LIKE 'ec_products'")[0]->Auto_increment;
        $category=0;
        $categoryId = DB::table('ec_product_category_product')->where('product_id', $productArr['id'])->get(['category_id']);
        foreach($categoryId as $cid){
                    $category=$cid->category_id;
                    DB::table('ec_product_category_product')->insert(['category_id'=>$category,'product_id'=>($value2)]);
                }
        
        $name=$productArr['name']." ".$randomval;
        
        DB::table('ec_products')->insert([
                'name' => $name,
                'description' => $productArr['description']." ".$randomval,
                'content' => $productArr['content']." ".$randomval,
                'status' => $productArr['status'],
                'images' => $productArr['images'],
                'sku' => $productArr['sku']." ".$randomval,
                'order' => $productArr['order'],
                'quantity' => $productArr['quantity'],
                'allow_checkout_when_out_of_stock' => $productArr['allow_checkout_when_out_of_stock'],
                'with_storehouse_management' => $productArr['with_storehouse_management'],
                'is_featured' => $productArr['is_featured'],
                'category_id' => $productArr['category_id'],
                'is_variation' => $productArr['is_variation'],
                'is_searchable' => $productArr['is_searchable'],
                'is_show_on_list' => $productArr['is_show_on_list'],
                'sale_type' => $productArr['sale_type'],
                'price' => $productArr['price'],
                'sale_price' => $productArr['sale_price'],
                'start_date' => $productArr['start_date'],
                'end_date' => $productArr['end_date'],
                'length' => $productArr['length'],
                'wide' => $productArr['wide'],
                'height' => $productArr['height'],
                'weight' => $productArr['weight'],
                'barcode' => $productArr['barcode'],
                'length_unit' => $productArr['length_unit'],
                'wide_unit' => $productArr['wide_unit'],
                'height_unit' => $productArr['height_unit'],
                'weight_unit' => $productArr['weight_unit'],
                'created_at' => $productArr['created_at'],
                'updated_at' => $productArr['updated_at'],
                'tax_id' => $productArr['tax_id'],
                'views' => $productArr['views'],
                'stock_status' => $productArr['stock_status'],
                'link' => $productArr['link'],
            ]
        );
        return $response->setMessage(('Successfully Created Duplicate Product'));
    }
    /**
     * @param int $id
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws BindingResolutionException
     */
    public function updateQuantity(int $id,Request $request, BaseHttpResponse $response){
        DB::table('ec_products')->updateOrInsert(
            ['id' => $id], // The 'id' column to match for update or insert
            ['quantity' => $request->param2] // Data to be updated or inserted
        );
    }
}


class UsersImport implements ToModel, WithHeadingRow
{
    public $i=1;
    public $value1=0;
    public $categoryName="";
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        $replaced = str_replace(' ', '-',$row['name'] );
        $replacedstart =null;
        $replacedend = null;
        $value2 = DB::select("SHOW TABLE STATUS LIKE 'ec_products'")[0]->Auto_increment;
        $value2--;
        $value1=0;
        if(!$row['start_date']){
        
            $replacedstart = str_replace('"', '',$row['start_date'] );
            $replacedstart = Carbon::parse($replacedstart)->toDateTimeString();
            if(!$row['start_date']){
            $replacedend = str_replace('"', '',$row['end_date'] ); 
            $replacedend=Carbon::parse($replacedend)->toDateTimeString();
            
        }}
        else
            $replacedstart=Carbon::now();
        
        if(!empty($row['name'])){
            if($this->i==0){
                $this->categoryName=$row['category'];
                $this->productName=$row['name'];
                $this->i++;
            }
            else{
                $id = DB::table('ec_products')->where('name', $row['name'])->get(['id']);
                if(!empty($id))
                    $id=$value2;
                if(!empty($row['seo_title'])){
                    $title=$row["seo_title"];
                    $desc=$row["seo_description"];
                    $value='[{"seo_title":"'.$title.'","seo_description":"'.$desc.'"}]';
                    $typo='Botble\Ecommerce\Models\Product';
                    DB::table('meta_boxes')->insert(array(
                        'meta_key' => 'seo_meta',
                        'meta_value' => $value,
                        'reference_id' => ($value2+1),
                        'reference_type' => $typo,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),

                    ));
                }
                if(isset($row["label"])){
                    if(!empty($row['label'])){
                        $labelId = DB::table('ec_product_labels')->where('name', $row['label'])->get(['id']);
                        foreach($labelId as $lid){
                            $value1=$lid->id;
                        }
                        if($value1!=0){
                            DB::table('ec_product_label_products')->insert(array('product_label_id'=>$value1,'product_id'=>($value2+1)));
                        }
                    }
                }
                else{
                    $labelId = DB::table('ec_product_label_products')->where('product_id', $id)->get(['product_label_id']);
                        foreach($labelId as $lid){
                            $value1=$lid->product_label_id;
                        }
                    if($value1!=0){
                        DB::table('ec_product_label_products')->updateorInsert(array('product_label_id'=>$value1,'product_id'=>($value2+1)));
                        
                    }
                }
                if(isset($row['product_collection'])){
                    if($row['product_collection']!=""){
                        $labelId = DB::table('ec_product_collection_products')->where('name', $row['product_collection'])->get(['product_id']);
                            foreach($labelId as $lid){
                                $value1=$lid->id;
                            }
                        
                        if($value1!=0){
                            DB::table('ec_product_collection_products')->updateorInsert(array('product_collection_id'=>$value1,'product_id'=>($value2+1)));
                            
                        }
                    }
                }
                else{
                    $productCollection = DB::table('ec_product_collection_products')->where('product_id',$id)->get(['product_collection_id']);
                        foreach($productCollection as $lid){
                            $value1=$lid->product_collection_id;
                        }
                    
                    if($value1!=0){
                        DB::table('ec_product_collection_products')->updateorInsert(array('product_collection_id'=>$value1,'product_id'=>($value2+1)));
                    }
                }
                if(isset($row['tag'])){
                    if($row['tag']!=""){
                        
                        $tag=$row['tag'];
                        $delimiter = ",";
                        $tags = explode($delimiter, $tag);
                        $size= count($tags);
                        for($j=0;$j<$size;$j++){
                            $tagId = DB::table('ec_product_tags')->where('name', $tags[$j])->get(['id']);
                                foreach($tagId as $tid){
                                    $value1=$tid->id;
                                }
                            if($value1!=0){
                                DB::table('ec_product_tag_product')->insert(array('tag_id'=>$value1,'product_id'=>($value2+1)));
                            }
                            
                        }
                    }
                }
                else{
                    //definition for tags
                    $tagId = DB::table('ec_product_tag_product')->where('product_id', $id)->get(['tag_id']);
                                foreach($tagId as $tid){
                                    $value1=$tid->tag_id;
                                    if($value1!=0){
                                        DB::table('ec_product_tag_product')->insert(array('tag_id'=>$value1,'product_id'=>($value2+1)));
                                    }
                                }
                }
                
                if(isset($row['related_product'])){
                    if($row['related_product']!=""){
                        $relatedProduct=$row['related_product'];
                        $delimiter = ",";
                        $relatedProduct = explode($delimiter, $relatedProduct);
                        $size= count($relatedProduct);
                        for($j=0;$j<$size;$j++){
                            $tagId = DB::table('ec_products')->where('name', $relatedProduct[$j])->get(['id']);
                                foreach($tagId as $tid){
                                    $value1=$tid->id;
                                }
                            
                            if($value1!=0){
                                DB::table('ec_product_related_relations')->insert(array('from_product_id'=>$value1,'to_product_id'=>($value2+1)));
                                
                            }
                            
                        }
                    }
                }
                if(isset($row['category'])){
                    if($row['category']!=""){
                        $cat=$row['category'];
                        $delimiter = ",";
                        $cat = explode($delimiter, $cat);
                        $size= count($cat);
                        for($j=0;$j<$size;$j++){
                            $categoryId = DB::table('ec_product_categories')->where('name', $cat[$j])->get(['id']);
                            foreach($categoryId as $cid){
                                $value1=$cid->id;
                            }
                            if($value1!=0){
                                DB::table('ec_product_category_product')->insert(array('category_id'=>$value1,'product_id'=>($value2+1)));
                                
                            }
                        }
                        $this->i++;
                    }
                }
                else{
                    $categoryId = DB::table('ec_product_category_product')->where('product_id', $id)->get(['category_id']);
                    $value1=0;
                    foreach($categoryId as $cid){
                                $value1=$cid->category_id;
                            if($value1!=0){
                                DB::table('ec_product_category_product')->insert(array('category_id'=>$value1,'product_id'=>($value2+1)));
                                
                            }
                            }
                }
                
                DB::table('slugs')->insert(array('key'=>$replaced,'reference_id'=>($value2+1),'reference_type'=>'Botble\Ecommerce\Models\Product','prefix'=>'products'));
                if(isset($row['depth'])){
                    $length=$row['depth'];
                }
                else if(isset($row['length'])){
                    $length=$row['length'];
                }
                if(isset($row['wide'])){
                    $wide=$row['wide'];
                }
                else if(isset($row['width'])){
                    $wide=$row['width'];
                }
                if($row['link']!=""){
                    $delimiter = ",";
                    $links=$row['link'];
                    $links = explode($delimiter, $links);
                    $size= count($links);
                    for($j=0;$j<$size;$j++){
                        $randomval=rand(0, 9999999999);
                        $name[$j]='products/'.$randomval.'-150x150'.'.jpg';
                        $contents = file_get_contents($links[$j]); // retrieve the image data
                        Storage::put($name[$j], $contents); // store the image data locally
                        $name[$j]='products/'.$randomval.'-540x300'.'.jpg';
                        Storage::put($name[$j], $contents); // store the image data locally
                        $name[$j]='products/'.$randomval.'-540x600'.'.jpg';
                        Storage::put($name[$j], $contents); // store the image data locally
                        $name[$j]='products/'.$randomval.'.jpg';
                        Storage::put($name[$j], $contents); // store the image data locally
                        $name[$j]='products/'.$randomval.'.jpg';
                    }
                    for($j=1;$j<$size;$j++){
                        $name[0]=$name[0].'"'.','.'"'.$name[$j];
                    }
                    $name[0]='['.'"'.$name[0].'"'.']';
                    $row['images']=$name[0];
                }
            }
            $Prod=new Product([
                'name'        => $row['name'],
                'description' => $row['description'],
                'content'     => $row['content'],
                'status'      => $row['status'],
                'images'      => $row['images'], 
                'sku'         => $row['sku'],
                'order'       => 0,
                'allow_checkout_when_out_of_stock' => $row['allow_checkout_when_out_of_stock'],
                'is_featured' => $row['is_featured'],
                'sale_type'   => $row['sale_type'],
                'sale_price'  => $row['sale_price'],
                'start_date'  => $replacedstart,
                'end_date'    => $replacedend,
                'quantity'    => $row['quantity'],
                'allow_checkout_when_out_of_stock' => '0',
                'with_storehouse_management' => '1',
                'is_featured' => '0',
                'price'       => $row['price'],
                'length'      => $length,
                'wide'        => $wide,
                'height'      => $row['height'],
                'weight'      => $row['weight'],
                'stock_status' => "in_stock",
                'link'        => $row['link'],    
            ]);
            return $Prod;
        }
        else
        return null;
        
    }
}