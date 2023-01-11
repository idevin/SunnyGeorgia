<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConvertGeorgianPrefixGeToKa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:ge-to-ka';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Заменяет код грузинского языка с ge на ka в таблицах базы';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $tables = [
            'place_translations',
            'places_group_translations',
            'option_translations',
            'options_group_translations',
            'accommodation_translations',
            'excursion_translations',
            'hotel_translations',
            'page_translations',
            'ribbon_translations',
            'tour_translations',
        ];

        foreach ($tables as $table) {
            DB::table($table)->where('locale', 'ge')->update(['locale' => 'ka']);
        }
    }
}
