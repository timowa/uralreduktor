<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductCategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;

/**
 * Class ProductCategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

    public function fetchAttributes()
    {
        return $this->fetch(\App\Models\ProductAttribute::class);
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\ProductCategory::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product-category');
        CRUD::setEntityNameStrings('Категория редуктора', 'Категории редукторов');
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
            'name'      => 'icon', // The db column name
            'label'     => 'Изображение', // Table column heading
            'type'      => 'image',
             'disk'   => 'public',
             'height' => '50px',
             'width'  => '50px',
        ]);
        CRUD::addColumn([
            'label'=>'Название',
            'name'=>'name'
        ]);

//        echo '<script>console.log('.json_encode(storage_path()).')</script>';
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
        CRUD::setValidation(ProductCategoryRequest::class);
        CRUD::addField([
            'label'=>'Название',
            'name'=>'name',
            'wrapper'=>[
                'class'=>'col-lg-6'
            ],
        ]);
        CRUD::addField([
            'name'  => 'slug',
            'target'  => 'name',
            'apply_edit'=>'apply_edit', //name of checkbox that apply editing field
            'label' => "Slug",
            'type'  => 'slug',
            'wrapper'=>[
                'class'=>'col-lg-6'
            ],
            'attributes'=>[
                'readonly'=>'readonly'
            ]
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
            'name'  => 'icon',
            'label' => 'Image',
            'type'  => 'browse'
        ]);
        CRUD::addField([
            'name'=>'attributes',
            'label'=>'Атрибуты',
            'type'=>'select2_multiple',
            'entity'=>'attributes',
            'model'=>'App\Models\ProductAttribute'
        ]);
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
