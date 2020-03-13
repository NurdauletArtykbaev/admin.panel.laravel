<?php


namespace App\Repositories\Admin;

use App\Models\Admin\Category as Model;
use Menu as LavMenu;
use function foo\func;


class CategoryRepository extends CoreRepository
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function getModelClass()
    {
        return Model::class;
    }

    public function buildMenu($arrMenu)
    {
        //Вложенная меню
        $mBuilder = LavMenu::make('MyNav', function ($m) use ($arrMenu)
        {
            foreach ($arrMenu as $item)
            {
                if($item->parent_id == 0) {
                    $m->add($item->title, $item->id)
                        ->id($item->id);
                } else {
                    if ($m->find($item->parent_id)){
                        $m->find($item->parent_id)
                            ->add($item->title, $item->id)
                            ->id($item->id);
                    }
                }
            }
        });
        return $mBuilder;

    }


    public function checkChildren($id)
    {
        $children = $this->startConditions()
            ->where('parent_id', $id)
            ->count();
        return $children;
    }


    public function checkParentProducts($id)
    {
        $parent = \DB::table('products')
            ->where('category_id', $id)
            ->count();
        return $parent;
    }


    public function deleteCategory($id)
    {
        $delete = $this->startConditions()
            ->find($id)
            ->forcedelete();
        return $delete;

    }


    public function getComboBosCategories()
    {
        $columns = implode(',', [
            'id',
            'parent_id',
            'title',
            'CONCAT (id, ". ", title) AS combo_title',
        ]);

        $result = $this->startConditions()
            ->selectRaw($columns)
            ->toBase()
            ->get();
        return $result;
    }



    public function checkUniqueName($name, $parent_id)
    {
        $name = $this->startConditions()
            ->where('title', '=', $name)
            ->where('parent_id', '=', $parent_id)
            ->exists();
        return $name;
    }

}
