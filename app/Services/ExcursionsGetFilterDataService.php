<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 16.02.2018
 * Time: 18:50
 */

namespace App\Services;


use App\Currency;
use App\Models\Excursions\Excursion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ExcursionsGetFilterDataService
{

    private $queryBuilder;

    private $place;
    private $date;
    private $priceFrom = 0.1;
    private $priceTo;
    private $priceCurrency;
    private $currencies;

    private $result;

    private $qw_person = [];
    private $qw_group = [];

    private $qw_availabilities = [];

    public function __construct()
    {
        $this->result = collect([]);
        $this->qw_person = [
            ['excursion_prices.price_type', '=', 'adult'],
            ['excursions.type', '=', 'person'],
            ['excursions.published', '=', true],
            ['excursions.reviewed', '=', true]
        ];
        $this->qw_group = [
            ['excursion_prices.price_type', '=', 'group'],
            ['excursions.type', '=', 'group'],
            ['excursions.published', '=', true],
            ['excursions.reviewed', '=', true]
        ];

        $this->qw_availabilities = [
            ['excursion_availabilities.amount', '>', 0]
        ];

        $this->currencies = Currency::all();


        $this->queryBuilder = Excursion::query();
    }

    public function from($place = null)
    {
        $this->place = intval($place);

        if ($this->place) {
            $this->qw_person[] = ['excursions.place_id', '=', $this->place];
            $this->qw_group[] = ['excursions.place_id', '=', $this->place];
        }

        return $this;
    }

    public function date($date)
    {
        if ($date) {
            $this->date = Carbon::parse($date);
            $this->qw_availabilities[] = ['excursion_availabilities.date', "=", $this->date->toDateString()];
        } else {
            $this->date = Carbon::now();
            $this->qw_availabilities[] = ['excursion_availabilities.date', ">", $this->date->toDateString()];
            $this->qw_availabilities[] = ['excursion_availabilities.date', "<", $this->date->addMonth()->toDateString()];
        }

        return $this;
    }

    public function price($from = null, $to = null, Currency $currency = null)
    {
        $this->priceFrom = $from ? (int)$from : 0.1;
        $this->priceTo = $to ? (int)$to : 1000000;

        $this->priceCurrency = $currency ?: Currency::query()
            ->where('code', currency()->getUserCurrency())
            ->firstOrFail();

        $k = floatval($this->priceCurrency->exchange_rate);

        $this->queryBuilder
            ->select(
                'excursions.*',
                'excursion_prices.price_type as price_type',
                DB::raw('min(excursion_prices.price * ' . $k . ' / CAST(currencies.exchange_rate as numeric(17,2))) as m_price')
            )
            ->join('excursion_availabilities', function ($join) {
                $join->on('excursions.id', '=', 'excursion_availabilities.excursion_id')
                    ->where($this->qw_availabilities);
            });

        $this->queryBuilder
            ->join('currencies', 'excursions.currency_id', '=', 'currencies.id')
            ->join('excursion_prices', function ($join) {
                $join->on('excursions.id', '=', 'excursion_prices.excursion_id')
                    ->where(function ($q) {
                        foreach ($this->currencies as $cur) {
                            $q->orWhere(function ($curQur) use ($cur) {
                                $curQur->where('excursions.currency_id', '=', $cur->id)
                                    ->where('excursion_prices.price', '>=', \currency($this->priceFrom, $this->priceCurrency->code, $cur->code, false))
                                    ->where('excursion_prices.price', '<=', \currency($this->priceTo, $this->priceCurrency->code, $cur->code, false));
                            });
                        };
                    });
            });

        return $this;
    }

    public function get()
    {
        $this->queryBuilder
            ->whereNotNull("excursion_prices.price")
            ->where($this->qw_person)
            ->orWhere($this->qw_group)
            ->groupBy('excursions.id')
            ->groupBy('excursion_prices.price_type');

        $this->result = $this->queryBuilder->get();

        $maxPrice = $this->result->max('price');

        return $this->result;
    }
}
