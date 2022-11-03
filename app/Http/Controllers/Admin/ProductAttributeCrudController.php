<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductAttributeRequest;
use App\Models\NumericalAttribute;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;

/**
 * Class ProductAttributeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductAttributeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation{store as traitStore;}
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation{update as traitUpdate;}
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

    public function fetchStrAttributes(){
        return [];
    }
    public function fetchNumAttributes(){
        return [];
    }
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\ProductAttribute::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product-attribute');
        CRUD::setEntityNameStrings('product attribute', 'product attributes');
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

        CRUD::addFields([
                [
                    'name'=>'name',
                    'label'=>'Название атрибута',
                    'type'=>'text',
                    'wrapper'=>[
                        'class'=>'col-lg-6'
                    ],
                ],
                [
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
                ],
                [
                    'label'=>'Можно указать значение по умолчанию',
                    'type'=>'checkbox',
                    'name'=>'has_default_value',
                ],
                [
                    'name'=>'attribute_type',
                    'label'=>'Тип значения',
                    'type'=>'select2_from_array',
                    'options'=>[
                        'string'=>'Строка',
                        'num'=>'Число',
                        'svg'=>'Иконка'
                    ],
                    'wrapper'=>[
                        'class'=>'col-md-6'
                    ]
                ],
                [
                    'name'=>'field_type',
                    'label'=>'Укажите как поле будет отображаться на странице редактирования серий и редукторов',
                    'type'=>'select2_from_array',
                    'options'=>[
                        'text'=>'Текстовое поле',
                        'select2'=>'Выбор',
                        'select2_multiple'=>'Выбор нескольких',
                    ],
                    'tab'=>'Функциональное'
                ],
                [
                    'name'=>'show_in_configurator',
                    'label'=>'Показывать в конфигураторе?',
                    'type'=>'checkbox',
                    'tab'=>'Функциональное'
                ],
                [
                    'name'=>'configurator_field_type',
                    'label'=>'Укажите как поле будет отображаться в конфигураторе',
                    'type'=>'select2_from_array',
                    'options'=>[
                        'radio'=>'Радио кнопка',
                        'radio_with_svg'=>'Радио кнопка с изображением',
                        'select'=>'Выбор',
                    ],
                    'tab'=>'Функциональное'
                ],
                [
                    'name'=>'strAttributes',
                    'label'=>'Значение',
                    'type'=>'relationship',
                    'inline_create' => [ 'entity' => 'string-attribute' ]

                ],
                [
                    'name'=>'numAttributes',
                    'label'=>'Значение',
                    'type'=>'relationship',
                    'inline_create' => [ 'entity' => 'numerical-attribute' ]
                ],
                [
                    'name'=>'svgAttributes',
                    'label'=>'Значение',
                    'type'=>'relationship',
                    'inline_create' => [ 'entity' => 'svg-attribute' ]
                ]
        ]

        );
        Widget::add()->type('script')->content(asset('js/admin/forms/fetchAttributesStrOrInt.js'));


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

}
