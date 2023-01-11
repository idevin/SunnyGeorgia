<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 09.11.2017
 * Time: 15:08
 */

namespace App\Models\Excursions;

use Illuminate\Database\Eloquent\Model;

class ExcursionTypeTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
}
