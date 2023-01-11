<div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested dropdown">
    <a href="{{route('control:excursions.edit', $product->id)}}"
       class="btn--info btn btn-default {{Route::is('control:excursions.edit') ? 'active':''}}"><i class="fa fa-file-alt"></i></a>
    <a href="{{route('control:excursions.calendar', $product->id)}}"
       class="btn--calendar btn btn-default {{Route::is('control:excursions.calendar') ? 'active':''}}"><i class="fa fa-calendar-alt"></i></a>
    <a href="{{route('control:excursions.reviews', $product->id)}}"
       class="btn--calendar btn btn-default {{Route::is('control:excursions.reviews') ? 'active':''}}"><i class="fa fa-comments"></i></a>
</div>
