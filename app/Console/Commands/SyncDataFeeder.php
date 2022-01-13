<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class SyncDataFeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:feeder {act} {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Data Feeder';

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
        $this->info("Collect data PDDIKTI Feeder...");
        $data = GetDataFeeder($this->argument('act'));
        $table = $this->argument('table');

        DB::beginTransaction();

        try{
            DB::table($table)->insert($data);


            DB::commit();
            $this->info("Collected Data Successfully Inserted to $table table");

        }catch(\Exception $e){

            DB::rollback();

            $this->info($e);
        }


    }
}
