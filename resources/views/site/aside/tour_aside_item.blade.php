@include('site.aside.aside_item', [
       'imageSrc' => $item->new_thumb ?? '',
       'title' => $item->title,
       'place' => $place->name,
       'slug' => $item->slug,
       'price' => $item->price,
       'newPrice' => $item->ribbon ?
         (int)(($item->price * $item->ribbon->discount) / 100) : null,
       'time' => trans_choice('base_aside.days', $item->days),
       'type' => trans('base_aside.tour'),
      'href' => route('tours.view', ['tour' => $item->slug]),
   ])