@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        @if($review->id)
                            Редактировать Отзыв
                        @else
                            Добавить отзыв
                        @endif
                    </h3>
                </div>
            </div>
        </div>

        <!-- END: Subheader -->
        <div class="m-content">
            <div class="m-portlet m-portlet--mobile">
                <form @if($review->id)
                        action="{{route('control:' . $productType . '.update-review', ['id' => $product->id, 'reviewId' => $review->id])}}"
                      @else
                        action="{{route('control:' . $productType . '.generate-review', $product->id)}}"
                      @endif
                      enctype="multipart/form-data"
                      method="post"
                >
                    {!! csrf_field() !!}
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Тема: {{$product->title}}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                <label for="author_name">
                                    Имя:
                                </label>
                                <input id="author_name"
                                       class="form-control m-input @if($errors->has('author_name')) is-invalid @endif"
                                       type="text"
                                       name="author_name"
                                       value="{{$review->author->display_name ?? $review->author_name ?? old('author_name')}}"
                                       @if($author)
                                       disabled
                                       @endif
                                >
                                @if($errors->has('author_name'))
                                <div class="invalid-feedback">{{$errors->first('author_name')}}</div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="author_country">
                                    Страна:
                                </label>
                                <input id="author_country"
                                       class="form-control m-input @if($errors->has('author_country')) is-invalid @endif"
                                       type="text"
                                       name="author_country"
                                       required
                                       value="{{$review->author->country ?? $review->author_country ?? old('author_country')}}"
                                       @if($author)
                                       disabled
                                        @endif
                                >
                                @if($errors->has('author_country'))
                                    <div class="invalid-feedback">{{$errors->first('author_country')}}</div>
                                @endif
                            </div>
                            <div class="col-lg-2">
                                <label for="avatar">
                                    Новый аватар:
                                </label>
                                <input id="avatar"
                                       class="form-control m-input @if($errors->has('avatar')) is-invalid @endif"
                                       type="file"
                                       name="avatar"
                                       @if($author)
                                       disabled
                                        @elseif(! $review->avatar_url)
                                       required
                                        @endif
                                >
                                @if($errors->has('avatar'))
                                    <div class="invalid-feedback">{{$errors->first('avatar')}}</div>
                                @endif
                            </div>
                            <div class="col-lg-2">
                                <img style="height: 75px" src="{{$review->avatar_url ?? $review->author->avatar->url ?? ''}}" alt="">
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                <label for="rating">
                                    Оценка:
                                </label>
                                <input id="rating"
                                       class="form-control m-input @if($errors->has('rating')) is-invalid @endif"
                                       type="number"
                                       name="rating"
                                       max="5"
                                       min="1"
                                       required
                                       value="{{$review->rating ?? old('rating') }}"
                                       @if($author)
                                       disabled
                                       @endif
                                >
                                @if($errors->has('rating'))
                                    <div class="invalid-feedback">{{$errors->first('rating')}}</div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="date">
                                    Дата:
                                </label>
                                <datepicker
                                        name="date"
                                        required
                                        input-class="form-control m-input @if($errors->has('date')) is-invalid @endif"
                                        value="{{$review->date ?? $review->updated_at ?? old('date')}}"
                                        @if($author)
                                        disabled
                                        @endif
                                ></datepicker>
                                @if($errors->has('date'))
                                    <div class="invalid-feedback">{{$errors->first('date')}}</div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="published">
                                    Статус:
                                </label>
                                <div class="form-control m-input">
                                    <label class="m-checkbox">
                                        <input type="checkbox"
                                               name="published"
                                               @if($review->published ?? old('published'))
                                               checked
                                               @endif
                                        >
                                        Опубликованно
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-12">
                                <label for="body">
                                    Отзыв:
                                </label>
                                <limited-textarea id="body"
                                                  className="form-control m-input @if($errors->has('body')) danger @endif"
                                                  :max="2000"
                                                  :rows="10"
                                                  name="body"
                                                  value="{{$review->body ?? old('body')}}"
                                ></limited-textarea>
                                @if($errors->has('body'))
                                    <div class="invalid-feedback">{{$errors->first('body')}}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot">
                        <a href="{{route('control:'. $productType .'.reviews', $product->id)}}"
                           type="reset"
                           class="btn btn-default"
                        >Назад</a>
                        <button type="submit" class="btn btn-primary">{{trans('main.Save changes')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
