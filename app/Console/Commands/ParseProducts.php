<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ParseProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parseProducts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses all products from categories and writes them into database';

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
     * @return int
     */
    public function handle()
    {
        $parse = app("App\Service\ParserService")->parser();
//        $parse = true;
        if($parse) {
            echo 'Products successfully parsed'. PHP_EOL;
        }
        return Command::SUCCESS;
    }
}
