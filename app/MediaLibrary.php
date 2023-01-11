<?php

namespace App;

use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class MediaLibrary extends BaseMedia
{
    protected $table = 'media_library';
}
