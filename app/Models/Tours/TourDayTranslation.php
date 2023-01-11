<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 09.11.2017
 * Time: 15:08
 */

namespace App\Models\Tours;

use Illuminate\Database\Eloquent\Model;

class TourDayTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'title', 'description'];
}
