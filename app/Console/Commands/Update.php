<?php

namespace App\Console\Commands;

use App\Currency;
use DateTime;
use Illuminate\Console\Command;


class Update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update exchange rates from an online source';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->updateCurrency();
    }

    /**
     * Fetch rates from the API
     *
     * @return void
     */
    private function updateCurrency()
    {
        $this->info('Updating currency exchange');

        $content = $this->request();

        $json = json_decode($content);

        if (!$json) {
            $this->error('Request failed');
            return;
        }

        $json = $json[0];

        $timestamp = (new DateTime())->setTimestamp(strtotime($json->date));

        $currencyCollection = collect($json->currencies)->keyBy('code');

        $defaultCurrency = $currencyCollection->get('USD');

        $currencies = Currency::query()->get();

        foreach ($currencies as $currency) {
            $currencyArray = $currencyCollection->get($currency->code);

            if ($currencyArray) {
                if ($defaultCurrency->code == $currency->code) {
                    $gel = Currency::query()->where(['code' => 'GEL'])->first();

                    $gel->update([
                        'exchange_rate' => $defaultCurrency->rate,
                        'updated_at' => $timestamp
                    ]);
                } else {
                    $total = ($currencyArray->quantity / $currencyArray->rate) * $defaultCurrency->rate;
                    $currency->update([
                        'exchange_rate' => $total,
                        'updated_at' => $timestamp
                    ]);
                }
            }
        }

        $this->info('Updated!');
    }

    /**
     * Make the request to the sever.
     *
     * @return string
     */
    private function request()
    {
        $url = 'https://nbg.gov.ge/gw/api/ct/monetarypolicy/currencies/en/json';
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
        curl_setopt($ch, CURLOPT_MAXCONNECTS, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
