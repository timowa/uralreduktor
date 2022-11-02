<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductSeriesRequest;
use App\Models\NumericalAttribute;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\StringAttribute;
use App\Models\SvgAttribute;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Class ProductSeriesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductSeriesCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation{store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation{update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

    protected function fetchAttributesFromCategory(Request $request)
    {
        $category = ProductCategory::find($request->id);
        $attributes = $category->attributes;
        if($attributes->isNotEmpty()){
            $result = [
                'success'=>true,
                'attributes'=>$attributes
            ];
        }else{
            $result = [
                'success'=>false
            ];
        }
        return response()->json($result);
    }
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\ProductSeries::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product-series');
        CRUD::setEntityNameStrings('Серия редуктора', 'Серии редуторов');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        CRUD::addColumn([
            'name'=>'name',
            'label'=>'Название'
        ]);
        CRUD::addColumn([
            'name'=>'category_id',
            'label'=>'Категория',
            'type'=>'select',
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
        CRUD::setValidation(ProductSeriesRequest::class);

        CRUD::addField([
            'name'=>'name',
            'label'=>'Название',
            'wrapper'=>[
                'class'=>'col-lg-6'
            ]
        ]);
        CRUD::addField([
            'name'  => 'slug',
            'target'  => 'name', // will turn the title input into a slug
            'label' => "Slug",
            'type'  => 'slug',
            'wrapper'=>[
                'class'=>'col-lg-6'
            ],
            'attributes'=>[
                'readonly'=>'readonly'
            ],
            'apply_edit'=>'apply_edit', //name of checkbox that apply editing field
        ]);
        CRUD::addField([
            'label'=>'Разрешить редактирование slug',
            'type'=>'checkbox',
            'name'=>'apply_edit',
            'wrapper'=>[
                'class'=>'col-lg-6 py-3'
            ],
        ]);
        CRUD::addField([
            'name'=>'category_id',
            'type'=>'select2',
            'label'=>'Категория',
            'entity'=>'category',
            'attribute'=>'name',
            'model'=>'App\Models\ProductCategory',
            'attributes'=>[
                'data-source'=>route('product-series.fetchAttributesFromCategory'),
            ],
        ]);
        $attributes = ProductAttribute::get();
        $relations = ['strAttributes','numAttributes','svgAttributes'];
        $fields = [];
        foreach ($attributes as $attribute){
            if($attribute->field_type=='text') continue;
            $options = [];
            $values = [];
            $name = "{$attribute->attribute_type}_";
            foreach ($relations as $relation){
                if($attribute->{$relation}->isEmpty()) continue;
                foreach($attribute->{$relation} as $value){
                    $options[$value->id]=$value->value;
                }
            }
            if($this->crud->getCurrentEntry()){
                $series = $this->crud->getCurrentEntry();
                foreach ($relations as $relation){
                    $curAttributes = $series->{$relation}()->where('attribute_id',$attribute->id)->get();
                    if($curAttributes->isEmpty()) continue;
                    foreach ($curAttributes as $item){
                        $values[] = $item->id;
                    }
                }
            }

                $field = [
                'name'=>$name.$attribute->id,
                'label'=>$attribute->name,
                'tab'=>'Характеристики'
            ];
                $field = $field + [
                    'options'=>$options,
                    'attributes'=>[
                        'data-attributes'=>$attribute->id
                    ],
                    'value'=>$values,
                        'type'=>'select2_from_array'
                    ];
                if($attribute->field_type=='select2_multiple'){
                    $field['allows_multiple']=true;
                }
            $fields[] = $field;

        }
        CRUD::addFields($fields);

        Widget::add()->type('script')->content(asset('js/admin/forms/fetchAttributes.js'));
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
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
        $series = $this->crud->getCurrentEntry();
        $series->crudAttachAttributes($this->crud->getRequest()->request);
        return $response;
    }
    public function update(){
        $response = $this->traitUpdate();
        $series = $this->crud->getCurrentEntry();
        $series->removeAllParams();
        $series->crudAttachAttributes($this->crud->getRequest()->request);
        return $response;
    }
}
