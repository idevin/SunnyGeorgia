<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CopySlugToRuSlug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copy:slug-to-ru-slug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Копирует слаг в русский перевод слага';

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
            ['places', 'place_translations', 'place_id'],
            ['excursions', 'excursion_translations', 'excursion_id'],
            ['pages', 'page_translations', 'page_id'],
            ['tours', 'tour_translations', 'tour_id'],
        ];

        foreach ($tables as $table) {
            $rows = DB::table($table[0])->get();
            foreach ($rows as $row) {
                if (isset($row->slug)) {
                    DB::table($table[1])
                        ->where($table[2], $row->id)
                        ->where('locale', 'ru')
                        ->update(['slug' => $row->slug]);
                }
            }
        }
    }
}
