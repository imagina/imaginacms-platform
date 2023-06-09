<?php

namespace Modules\Icommercecredibanco\Console;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Icommercecredibanco\Http\Controllers\Api\IcommerceCredibancoApiController;
// Repositories
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class CheckUpdateOrders extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'icredibanco:checkupdateorders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find all orders with status processing, check their status with the Credibanco API and update in system';

    private $order;

    private $credibancoApiController;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        OrderRepository $order,
        IcommerceCredibancoApiController $credibancoApiController
    ) {
        parent::__construct();
        $this->order = $order;
        $this->credibancoApiController = $credibancoApiController;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $this->info('Icommercecredibanco Command: START');
        \Log::info('Icommercecredibanco Command: START');

        $orders = $this->order->getItemsBy((object) ['filter' => (object) ['status' => 1], 'include' => []]);
        $this->line('Icommercecredibanco Command: Order Processing: '.$orders->count());
        \Log::info('Icommercecredibanco Command: Order Processing: '.$orders->count());

        if ($orders->count() > 0) {
            $this->line('');
            $bar = $this->output->createProgressBar(count($orders));

            $bar->start();
            foreach ($orders as $order) {
                $request = ['id' => $order->id];
                $response = $this->credibancoApiController->getUpdateOrder(new Request($request));
                $bar->advance();
            }
            $bar->finish();
            $this->line('');
            $this->line('');
        }

        $this->info('Icommercecredibanco Command: END');
        \Log::info('Icommercecredibanco Command: END');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    /*
    protected function getArguments()
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }
    */

    /**
     * Get the console command options.
     *
     * @return array
     */
    /*
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
    */
}
