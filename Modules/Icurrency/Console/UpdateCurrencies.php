<?php

namespace Modules\Icurrency\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Modules\Icurrency\Entities\Currency;
use Illuminate\Support\Facades\Log;

class UpdateCurrencies extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'currencies:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command update the currencies to current TRM.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $currencies = Currency::noDefaultCurrency();
      foreach ($currencies as $currency){
          $this->updateCurrency($currency->code);
      }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [

        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }

    private  function updateCurrency($from_currency)
    {
        $defaultCurrency = Currency::defaultCurrency();
        $apikey = env('CURRCONV_APIKEY');
        $from_Currency = urlencode($from_currency);
        $to_Currency = urlencode($defaultCurrency->code);
        $query =  "{$from_Currency}_{$to_Currency}";
        $json = file_get_contents("https://free.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey={$apikey}");
        $obj = json_decode($json, true);
        $val = floatval($obj["$query"]);
        Currency::where('code', $from_currency)->update(['value' => $val]);
        Log::info("Update Currency {$from_currency}, {$query},  new value: {$val}");
    }
}
