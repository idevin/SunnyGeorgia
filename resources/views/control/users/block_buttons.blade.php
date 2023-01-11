<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
    <a href="{{route('control:users.view', $user->id)}}"
       class="btn btn-default {{Route::is('control:users.view') ? 'active':''}}"><i class="fa fa-user"></i></a>
    <a href="{{route('control:users.bookings', $user->id)}}"
       class="btn btn-default {{Route::is('control:users.bookings') ? 'active':''}}"><i class="fa fa-book"></i></a>
</div>