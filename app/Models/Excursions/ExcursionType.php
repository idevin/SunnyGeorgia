<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 09.11.2017
 * Time: 15:08
 */

namespace App\Models\Excursions;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ExcursionType extends Model implements TranslatableContract
{
    use Translatable;
    public $timestamps = false;
    public $translatedAttributes = ['name'];
}
