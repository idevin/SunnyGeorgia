<?php
/**
 * Created by PhpStorm.

 * Date: 09.11.2017
 * Time: 15:08
 */

namespace App\Models\Tours;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class TourDay extends Model implements TranslatableContract
{
    use Translatable;
    public $timestamps = false;
    public $translatedAttributes = ['name', 'title', 'description'];
    public $fillable = ['day_order'];
    protected $with = ['translations'];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
