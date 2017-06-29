<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Complaint;
use Illuminate\Support\Facades\DB;

class ApiListController extends Controller
{
    const TYPE_BANK = 1;
    const TYPE_CREDIT_CARD = 2;
    const TYPE_MONEY_TRANSFER = 3;
    const TYPE_LOAN = 4;
    const TYPE_MORTGAGE = 5;
    const TYPE_DEBT_COLLECT = 6;

    static $bank_products = [
        'Bank account or service',
        'Checking or savings account',
    ];

    static $credit_card_products = [
        'Credit card',
        'Credit card or prepaid card',
        'Credit reporting',
        'Credit reporting, credit repair services, or other personal consumer reports',
        'Prepaid card'
    ];

    static $money_transfer_products = [
        'Money transfer, virtual currency, or money service',
        'Money transfers',
    ];

    static $loan_products = [
        'Consumer Loan',
        'Payday loan',
        'Payday loan, title loan, or personal loan',
        'Student loan',
        'Vehicle loan or lease'
    ];

    static $mortgage_products = [
        'Mortgage'
    ];

    static $debt_collect_products = [
        'Debt collection'
    ];

    /**
     * @param Request $request
     * @return \GuzzleHttp\Psr7\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, $this->rules());

        $type = $request->input('product_type');
        $page = $request->input('page');
        $limit = $request->input('limit');
        $offset = empty($page) ? 0 : ($page + 1) * $limit;
        $products = $this->getProducts($type);

        $query = Complaint::select('company',  DB::raw('COUNT(*) as count'))
            ->offset($offset)
            ->take($limit)
            ->groupBy('company')
            ->orderByRaw('COUNT(*) DESC');

        if( !empty($products) ) {
            $query->whereIn('product', $products);
        }

        return $query->get();
    }

    protected function getProducts($type)
    {
        $products = [];

        switch ($type) {
            case self::TYPE_BANK:
                $products = self::$bank_products;
                break;
            case self::TYPE_CREDIT_CARD:
                $products = self::$credit_card_products;
                break;
            case self::TYPE_MONEY_TRANSFER:
                $products = self::$money_transfer_products;
                break;
            case self::TYPE_LOAN:
                $products = self::$loan_products;
                break;
            case self::TYPE_MORTGAGE:
                $products = self::$mortgage_products;
                break;
            case self::TYPE_DEBT_COLLECT:
                $products = self::$debt_collect_products;
                break;
        }

        return $products;
    }

    /**
     * Get validation rules
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'product_type' => 'required',
            'page' => ['required', 'integer'],
            'limit' => ['required', 'integer']
        ];
    }
}
