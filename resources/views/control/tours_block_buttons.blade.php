<div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested dropdown">
    <a href="{{route('control:tours.edit', $product->id)}}"
       class="btn btn-default {{Route::is('control:tours.edit') ? 'active':''}}"><i class="fa fa-file-alt"></i></a>
    <a href="{{route('control:tours.accommodation', $product->id)}}"
       class="btn btn-default {{Route::is('control:tours.accommodation') ? 'active':''}}"><i
                class="fa fa-building"></i></a>
    <a href="{{route('control:tours.calendar', $product->id)}}"
       class="btn btn-default {{Route::is('control:tours.calendar') ? 'active':''}}"><i class="fa fa-calendar-alt"></i></a>
    <a href="{{route('control:tours.reviews', $product->id)}}"
       class="btn--calendar btn btn-default {{Route::is('control:tours.reviews') ? 'active':''}}"><i class="fa fa-comments"></i></a>
</div>
