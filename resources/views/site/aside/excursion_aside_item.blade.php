@include('site.aside.aside_item', [
        'imageSrc' => $item->new_thumb ?? '',
        'title' => $item->title,
        'place' => $item->place_name,
        'slug' => $item->slug,
        'price' => $item->price,
        'newPrice' => $item->ribbon ?
          (int)(($item->price * $item->ribbon->discount) / 100) : null,
        'type' => trans('base_aside.excursion'),
        'time' => trans_choice('base_aside.hours', $item->duration),
        'href' => route('excursions.view', ['excursion' => $item->slug]),
])