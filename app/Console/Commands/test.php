<?php

namespace App\Console\Commands;

use App\Domains\Core\Application\GetComposition;
use App\MessageBus;
use Illuminate\Console\Command;

class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private MessageBus $messageBus)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $id = $this->argument('id');


        $composition = $this->messageBus->dispatch(new GetComposition($id));

        $this->output->writeln(json_encode($composition, JSON_PRETTY_PRINT));

        return self::SUCCESS;
    }
}
