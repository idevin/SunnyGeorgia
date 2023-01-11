{{--<div class="container">--}}
{{--    <div class="ourQualities">--}}
{{--        <div class="row">--}}
{{--            <div class="col-sm-6 col-lg-3">--}}
{{--                <div class="ourQualitiesItem">--}}
{{--                    <div class="ourQualitiesItemIcon">--}}
{{--                        <i class="icon-piggy-bank"></i>--}}
{{--                    </div>--}}
{{--                    <h3 class="ourQualitiesItemTitle">{{trans('homepage.Best Price Guarantee')}}</h3>--}}
{{--                    <div class="ourQualitiesItemMessage">--}}
{{--                        {!! trans('homepage.Best Price Guarantee Block')!!}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-sm-6 col-lg-3">--}}
{{--                <div class="ourQualitiesItem">--}}
{{--                    <div class="ourQualitiesItemIcon">--}}
{{--                        <i class="icon-like"></i>--}}
{{--                    </div>--}}
{{--                    <h3 class="ourQualitiesItemTitle">{{trans('homepage.Quality control')}}</h3>--}}
{{--                    <div class="ourQualitiesItemMessage">--}}
{{--                        {!! trans('homepage.Quality control Block')!!}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-sm-6 col-lg-3">--}}
{{--                <div class="ourQualitiesItem">--}}
{{--                    <div class="ourQualitiesItemIcon">--}}
{{--                        <i class="icon-shield"></i>--}}
{{--                    </div>--}}
{{--                    <h3 class="ourQualitiesItemTitle">{{trans('homepage.Secure booking')}}</h3>--}}
{{--                    <div class="ourQualitiesItemMessage">--}}
{{--                        {!! trans('homepage.Secure booking Block')!!}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-sm-6 col-lg-3">--}}
{{--                <div class="ourQualitiesItem">--}}
{{--                    <div class="ourQualitiesItemIcon">--}}
{{--                        <i class="icon-telephone"></i>--}}
{{--                    </div>--}}
{{--                    <h3 class="ourQualitiesItemTitle">{{trans('homepage.Responsive service')}}</h3>--}}
{{--                    <div class="ourQualitiesItemMessage">--}}
{{--                        {!! trans('homepage.Responsive service Block')!!}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--</div>--}}

<clouds-decor inline-template>
    <div ref="mainBlock" class="sectionClouds d-none d-md-block">
        <div class="container">
            <div class="SectionCloudsTitle">
                <h2>{!! trans('homepage.information_text_title')!!}</h2>
            </div>
        </div>
        <div ref="decor" class="sectionCloudsOver" style="transform: translateY(230px)"></div>
    </div>
</clouds-decor>

<div class="container">
    <div class="textBlockSection">
        <div class="row">
            <div class="col-md-6 strongsize">
                {!! trans('homepage.information_text_left') !!}
            </div>
            <div class="col-md-6">
                {!!trans('homepage.information_text_right')!!}
            </div>
        </div>
    </div>
</div>
