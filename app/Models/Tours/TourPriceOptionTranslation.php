<?php
/**
 * Created by PhpStorm.

 * Date: 09.11.2017
 * Time: 15:08
 */

namespace App\Models\Tours;

use Illuminate\Database\Eloquent\Model;

class TourPriceOptionTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
}
