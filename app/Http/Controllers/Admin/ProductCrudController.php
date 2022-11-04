<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\NumericalAttribute;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\ProductSeries;
use App\Models\StringAttribute;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation{store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation{update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation{ clone as traitClone; }



    public function setup()
    {
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function fetchAttributesFromSeries(Request $request)
    {
        $result = [];
        $series = ProductSeries::find($request->id);
        $category = $series->category;
        $allAttributes = $category->attributes;
        foreach($allAttributes as $attribute){
            if($attribute->field_type=='text'){
                $result[]=[
                    'type'=>'text',
                    'id'=>$attribute->id
                ];
            }
        }
        $attributes = DB::table('attribute_value_series')->where('series_id',$request->id)->pluck('attribute_id')->countBy()->keys();
//        dd($series->attributes());
        foreach ($attributes as $attribute){
            $strAttributes = $series->strAttributes()->where('attribute_id',$attribute)->get();
            $numAttributes = $series->numAttributes()->where('attribute_id',$attribute)->get();
            $svgAttributes = $series->svgAttributes()->where('attribute_id',$attribute)->get();
            if($strAttributes->isNotEmpty()){
                foreach ($strAttributes as $item){
                    $result[$attribute][$item->id]=$item->value;
                }
            }
            if($numAttributes->isNotEmpty()){
                foreach ($numAttributes as $item){
                    $result[$attribute][$item->id]=$item->value;
                }
            }
            if($svgAttributes->isNotEmpty()){
                foreach ($svgAttributes as $item){
                    $result[$attribute][$item->id]=$item->value;
                }
            }
        }

        return response()->json($result);
    }
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    private function createTiny($label,$name,$tab = false,$fake=false,$store_in = ''){
        $field = [
            'name'=>$name,
            'label'=>$label,
            'type'  => 'tinymce',
            'options'=>[
                'plugins'=>'code table lists',
                'newline_behavior ' => 'linebreak',
                'toolbar'=>'formatselect | fontsizeselect | undo redo | alignleft aligncenter alignright | styles | bold italic | link image | bullist | code | removeformat | lineheight',
                'menubar'=>false,
            ],
        ];
        if($tab){
            $field['tab']=$tab;
        }
        if($fake){
            $field['fake']=$fake;
            $field['store_in']=$store_in;
        }
        return $field;
    }
    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name'=>'name',
            'label'=>'Название'
        ]);
        CRUD::addColumn([
            'name'=>'series_id',
            'label'=>'Серия',
            'entity'=>'series',
            'attribute'=>'name',
            'model'=>'App\Models\ProductSeries'
        ]);
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductRequest::class);
        CRUD::addFields(array(
          [
              'name'=>'name',
              'label'=>'Название',
              'wrapper'=>[
                  'class'=>'col-lg-6'
              ],
              'type'=>'text'
          ],
            [
                'name'=>'slug',
                'label'=>'SLUG',
                'type'=>'slug',
                'attributes'=>[
                    'readonly'=>'readonly'
                ],
                'wrapper'=>[
                    'class'=>'col-lg-6'
                ],
                'target'=>'name'
            ],
            [
                'name'=>'series_id',
                'label'=>'Серия',
                'type'=>'select2',
                'entity'=>'series',
                'model'=>'App\Models\ProductSeries',
                'attributes'=>[
                    'data-source'=>backpack_url('product/fetch/attributes-from-series'),
                ],
                'allows_null'=>false
            ],
          [
              'name'=>'images',
              'label'=>'Изображения',
              'type'=>'browse_multiple',
              'sortable'=>true
          ],

            $this->createTiny('Описание','description','Описание'),
            $this->createTiny('Характеристики','product_characteristics','Характеристики'),
            [
                'name'=>'dimensions',
                'label'=>'Размеры',
                'type'=>'repeatable',
                'subfields'=>[
                    [
                        'name'=>'title',
                        'label'=>'Подзаголовок'
                    ],
                    [
                        'name'=>'content',
                        'label'=>'Изображение',
                        'type'=>'browse',
                    ]
                ],
                'max_rows' => 10,
                'tab'=>'Размеры'
            ],
        ));
        $attributes = ProductAttribute::get();
        $relations = ['strAttributes','numAttributes','svgAttributes'];
        $product = $this->crud->getCurrentEntry();
        foreach ($attributes as $attribute){
            $options = [];
            $values = [];
            $name = "{$attribute->attribute_type}_";
            foreach ($relations as $relation){
                if($attribute->{$relation}->isEmpty()) continue;
                foreach($attribute->{$relation} as $value){
                    $options[$value->id]=$value->value;
                }
            }
            if($product){
                if(!is_null($this->crud->getCurrentEntry()->series)){
                    $series = $this->crud->getCurrentEntry()->series;
                    $options = [];
                    foreach ($relations as $relation){
                        if($series->{$relation}->isEmpty()) continue;
                        foreach($series->{$relation}()->where('attribute_id',$attribute->id)->get() as $value){
                            $options[$value->id]=$value->value;
                        }
                    }
                }
                foreach ($relations as $relation){
                    $curAttributes = $product->{$relation}()->where('attribute_id',$attribute->id)->get();
                    if($curAttributes->isEmpty()) continue;
                    foreach ($curAttributes as $item){
                        $values[] = $item->id;
                    }
                }
            }

            $field = [
                'label'=>$attribute->name,
                'tab'=>'Атрибуты'
            ];

            if($attribute->field_type != 'text'){
                $field = $field + [
                        'options'=>$options,
                        'attributes'=>[
                            'data-attributes'=>$attribute->id
                        ],
                        'value'=>$values,
                        'type'=>'select2_from_array',
                        'name'=>$name.$attribute->id,
                        'placeholder'=>'Выбрать'

                    ];
                if($attribute->field_type=='select2_multiple'){
                    $field['allows_multiple']=true;
                    $field['placeholder']='Выбрать несколько';
                }
                if($attribute->field_type == 'select2_multiple' && $attribute->has_default_value == 1){
                    $field['wrapper']=['class'=>'col-md-6'];
                    $fieldForDefault = $field;
                    $fieldForDefault = array_merge($fieldForDefault, [
                        'name'=>'default_'.$attribute->id,
                        'allows_multiple'=>false,
                        'label'=>$attribute->name.' по умолчанию',
                        'allows_null'=>false,
                        'fake'=>true,
                        'store_in'=>'other_attributes',
                    ]);
                    if(isset($product->other_attributes['default_'.$attribute->id])){
                        $fieldForDefault['value']=$product->other_attributes['default_'.$attribute->id];
                    }
                    $fields[] = $fieldForDefault;
                }
            }else{
                $field = $field + [
                    'name'=>$attribute->name,
                    'fake'=>true,
                    'store_in'=>'other_attributes',
                    'placeholder'=>'Написать'
                    ];
            }
            if(empty($options) && $attribute->field_type != 'text'){
                $field['attributes']['hidden-by-default'] = '';
            }
            $fields[] = $field;

        }
        CRUD::addFields($fields);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
        Widget::add()->type('script')->content(asset('js/admin/forms/fetchAttributesBySeries.js'));

    }

    public static function addDimensionsField(){
        ob_start();
        CRUD::addField(
            [
                'name'=>'dimensions',
                'label'=>'Размеры',
                'type'=>'repeatable',
                'subfields'=>[
                    [
                        'name'=>'title',
                        'label'=>'Подзаголовок'
                    ],
                    [
                        'name'=>'content',
                        'label'=>'Изображение',
                        'type'=>'browse',
                    ]
                ],
                'max_rows' => 5,
                'tab'=>'Размеры'
            ]
        );
        return ob_get_clean();
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
    public function store(){
        $response = $this->traitStore();
        $product = $this->crud->getCurrentEntry();
        $product->crudAttachAttributes($this->crud->getRequest()->request);
        return $response;
    }
    public function update(){
        $response = $this->traitUpdate();
        $product = $this->crud->getCurrentEntry();
        $product->removeAllParams();
        $product->crudAttachAttributes($this->crud->getRequest()->request);
        return $response;
    }
    public function clone($id)
    {
        $this->crud->hasAccessOrFail('clone');
        $this->crud->setOperation('clone');

        $product = Product::find($id);
        $productName = $product->name;
        $newProductName = $productName.' - копия';
        $countSameName = Product::where('name',$newProductName)->count();
        if($countSameName>0)
            $newProductName.='('.$countSameName.')';
        $newProduct = $product->replicate()->fill([
            'name'=>$newProductName,
            'slug'=>fake()->unique()->slug
        ]);
        $newProduct->save();
    }
}
