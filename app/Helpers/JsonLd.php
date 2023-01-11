<?php

namespace App\Helpers;

class JsonLd
{
    public function travelAction($travel)
    {
        return [
            '@context' => 'http://schema.org',
            '@type' => 'TravelAction',
            'toLocation' => [
                "@type" => 'City',
                //"name" => $travel->place->name,
            ],
        ];
    }
}