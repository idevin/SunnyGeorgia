@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        Отзывы
                    </h3>
                    <a class="m-subheader__daterange"
                       href="{{route('control:'. $productType .'.new-review', $product->id)}}">
                        <i class="fa fa-plus-square"></i>
                        Сгенерировать отзыв
                    </a>
                </div>
                <div class="m-portlet__head-tools">
                    @include('control.'. $productType .'_block_buttons')
                </div>
            </div>
        </div>

        <!-- END: Subheader -->
        <div class="m-content">
            <reviews-table
                    route="{{route('control:'. $productType .'.reviews', $product->id)}}"
                    :fields="{{$fields}}"
            ></reviews-table>
        </div>
    </div>
@endsection
