<?php
// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push(trans('main.Main'), route('home-1'));
});
Breadcrumbs::for('contacts', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(trans('main.Contacts'));

});
Breadcrumbs::for('about', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('О компании');

});
Breadcrumbs::for('be-partner', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(trans('main.Become a partner'));

});
Breadcrumbs::for('qa', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
//    $trail->push('Question & Answers');
    $trail->push('Вопросы и Ответы');

});

Breadcrumbs::for('legal-information', function (BreadcrumbTrail $trail) {
  $trail->parent('home');
  $trail->push(trans('main.Legal information'));
});

Breadcrumbs::for('tours.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(trans('main.Tours'));
});
Breadcrumbs::for('tours.view', function (BreadcrumbTrail $trail, $tour) {
    $trail->parent('home');
    $trail->push(trans('main.Tours'), route('tours.index'));
    $trail->push(str_title($tour->title));
});
Breadcrumbs::for('excursions.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(trans('main.Excursions'));
});
Breadcrumbs::for('excursions.view', function (BreadcrumbTrail $trail, $excursion) {
    $trail->parent('home');
    $trail->push(trans('main.Excursions'), route('excursions.index'));
    $trail->push(str_title($excursion->title));

});

$places = \App\Place::with('translations')->get();
foreach ($places as $place) {
  if($place->slug) {
    Breadcrumbs::for($place->slug, function (BreadcrumbTrail $trail) use ($place) {
        $trail->parent('home');
        $trail->push($place->name);
    });
  }
}

