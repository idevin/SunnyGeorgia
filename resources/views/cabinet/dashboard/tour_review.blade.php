<div class="m-portlet m-portlet--head-solid-bg">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													{{--<i class="flaticon-map-location"></i>--}}
												</span>
                <h3 class="m-portlet__head-text">
                    Туры ожидающие проверку и потдверждение на публикацию
                </h3>
            </div>
        </div>
    </div>
    <div class="m-portlet__body">
        <table class="table">
            <thead>
            <tr>
                <th>id, создан, проверен</th>
                <th>Владелец</th>
                <th>Место</th>
                <th>{{trans('cabinet/index.Title')}}</th>
                {{--                            <th>{{trans('cabinet/index.Published')}}</th>--}}
                <th></th>
            </tr>

            </thead>

            <tbody>
            @foreach($toursForReview as $item)
                <tr>
                    <td>
                        {{$item->id}}
                        <small>{{$item->created_at}}</small>
                        @if($item->published)
                            <span class="badge badge-success">Опубликован</span>

                        @else
                            <span class="badge badge-warning">Не опубликован</span>
                        @endif
                        @if($item->reviewed)
                            <span class="badge badge-success">Проверен</span>

                        @else
                            <span class="badge badge-warning">Не проверен</span>
                        @endif
                        @if($item->reviewed && $item->published)
                            <span class="badge badge-success">Отображается</span>
                        @else
                            <span class="badge badge-primary">Скрыт</span>
                        @endif
                    </td>
                    <td>
                        @if($item->user)
                            <p><a href="{{route('control:users.view', $item->user->id)}}">
                                    <small>#{{$item->user->id}}</small>
                                </a> {{$item->user->email}} {{$item->user->first_name}} {{$item->user->last_name}}
                            </p>
                        @endif
                    </td>
                    <td>{{$item->place->name}}</td>
                    <td>{{$item->title}}</td>
                    <td>
                        <a href="{{route('control:tours.edit', $item->id)}}"><span
                                    class="fa fa-pencil"></span></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>