<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminCurrencyAddRequest;
use App\Models\Admin\Currency;
use App\Repositories\Admin\CurrencyRepository;
use Illuminate\Http\Request;
use MetaTag;
class CurrencyController extends AdminBaseController
{
    private $currencyRepository;

    public function __construct()
    {
        parent::__construct();
        $this->currencyRepository = app(CurrencyRepository::class);
    }


    public function index()
    {
        $currency = $this->currencyRepository->getAllCurrency();

        MetaTag::setTags(['title' => 'Валюта']);
        return view('blog.admin.currency.index', compact('currency'));
    }

    public function addCurrency(AdminCurrencyAddRequest $request)
    {
        if ($request->isMethod('post')){
            $data = $request->input();
            /*dd($data);*/
            $currency = (new Currency())->create($data);
            if ($request->base == 'on'){
                $this->currencyRepository->switchBaseCurr();
                $currency->base = '1';
            }
            $currency->save();
//            dd($currency);
            if ($currency){
                return redirect('/admin/currency/add')
                    ->with(['success' => 'Валюта добавлен']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Ошибка добавления валюта'])
                    ->withInput();
            }
        } else {
            if ($request->isMethod('get')) {
                MetaTag::setTags(['title' => 'Добавление твалюты']);
                return view('blog.admin.currency.add');
            }
        }
    }


    /** AdminCurrencyEditRequest и AdminCurrencyAddRequest содержит одно и то же правил */
    public function editCurrency(AdminCurrencyAddRequest $request, $id)
    {
        if (empty($id)) {
            return back()->withErrors(['msg' => "Запсиь {$id} не найдена!"]);
        }

        if ($request->isMethod('post'))
        {
            $currency = Currency::fing($id);
            $currency->title = $request->title;
            $currency->code = $request->code;
            $currency->symbol_left = $request->symbol_left;
            $currency->symbol_righft = $request->symbol_right;
            $currency->value = $request->value;
            $currency->base = $request->base ? '1' : '0';
            $currency->save();

            if ($currency) {
                return redirect('/admin/currency/edit', $id)
                    ->with(['success' => 'Сохранено']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Ошибка'])
                    ->withInput();
            }

        } else {
            if ($request->isMethod('get')) {

                $currency = $this->currencyRepository->getInfoCurrency($id);
                MetaTag::setTags(['title' => 'Редактирование валюты']);
                return view('blog.admin.currency.edit', compact('currency'));
            }
        }
    }


    public function deleteCurrency($id)
    {
        if (empty($id)) {
            return back()->withErrors(['msg' => "Запсиь {$id} не найдена!"]);
        }

        $delete = $this->currencyRepository->deleteCurr($id);
        if ($delete) {
            return redirect('/admin/currency/index')
                ->with(['success' => 'Удален']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка удаления']);
        }
    }

}
