<?php

namespace App\Console\Commands;

use App\Models\Excursions\Excursion;
use Illuminate\Console\Command;

class CopyExcursionPlaceToPlaces extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'excursions-place:copy';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Convert excursion start place one-to-many to many-to-many ';

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
    $excursions = Excursion::all()->sortBy('id');

    foreach ($excursions as $excursion) {
      if (isset($excursion->place_id) && $excursion->place_id !== 0) {
        $excursion->places()->sync([$excursion->place_id]);
        dump('excursion', $excursion->id, 'place', $excursion->place_id);
      }
    }


  }
}
