<?php


namespace App\Repositories\Admin;

use App\Models\Admin\Currency;
use App\Models\Admin\Currency as Model;

class CurrencyRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getModelClass()
    {
        return Model::class;
    }

    /** All currency */
    public function getAllCurrency()
    {
        $curr = $this->startConditions()::all();
        return $curr;
    }

    /** Switch Base Currency = 0 */
    public function switchBaseCurr()
    {
        $id = \DB::table('currencies')
            ->where('base','=','1')
            ->get()
            ->all();
        if ($id) {
            $id = $id->id;
            $new = Currency::find($id);
            $new->base = '0';
//            dd($new);
            $new->save();
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка Базовой валюты еще нет'])
                ->withInput();
        }
    }

/** Get info by id*/
    public function getInfoCurrency($id)
    {
        $currency = $this->startConditions()->find($id);
        return $currency;
    }

    public function deleteCurr($id)
    {
        $currency = $this->startConditions()->where('id', $id)->forceDelete();
        return $currency;
    }
}
