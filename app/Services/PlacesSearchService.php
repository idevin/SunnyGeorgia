<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 16.02.2018
 * Time: 18:50
 */

namespace App\Services;

use App\Place;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class PlacesSearchService
{
  private $instance;

  function __construct($forInstance)
  {
    $this->instance = $forInstance;
  }

  public function get()
  {
    return Place::whereHas($this->instance, function ($query) {
      $query
        ->where('published', true)
        ->where('reviewed', true);

      if ($this->instance === 'excursions') {
        $query->whereHas('availabilities', function (Builder $query) {
          $query->whereDate('date', '>=', Carbon::tomorrow())
            ->where('amount', '>', 0);
        });
      }
      if ($this->instance === 'tours') {
        $date = [Carbon::tomorrow(), Carbon::tomorrow()->addMonths(12)];
        $query->whereHas('availability', function (Builder $query) use ($date) {
          $query->whereBetween('date', $date)
            ->where('amount', '>', 0);
        });
      }
    })
    ->join('place_translations', function ($join) {
      $join->on('places.id', '=', 'place_translations.place_id')
        ->where('locale', '=', app()->getLocale());
    })
    ->select(['places.id', 'place_translations.name'])
    ->get();
  }
}
