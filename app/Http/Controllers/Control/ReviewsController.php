<?php

namespace App\Http\Controllers\Control;

use App\GeneratedReview;
use App\Http\Controllers\Controller;
use App\Models\Excursions\Excursion;
use App\Models\Tours\Tour;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ImageLib;

class ReviewsController extends Controller
{
    public function reviews($id, Request $request)
    {
        $productType = $request->segment(2);
        if ($productType === 'tours') {
            $product = Tour::findOrFail($id);
            $productName = 'tour';
        } else {
            $product = Excursion::findOrFail($id);
            $productName = 'excursion';
        }

        if ($request->ajax()) {
            //todo сделать пагинацию отзывов и фильтр
//            $not_published = $request->has("not_published");
            $reviews = $product->reviews->load('author', 'author.avatar')
//                ->filter(function($review) use ($not_published){
//                    return $review->published != $not_published;
//                })
            ;
            $generatedReviews = $product->generatedReviews
//                ->filter(function($review) use ($not_published){
//                    return $review->published != $not_published;
//                })
            ;

            return response()->json(compact('generatedReviews', 'reviews'));
        }
        $fields = collect(['id', 'Дата', 'Имя', 'Страна', 'Текст', 'Оценка'])->toJSON();

        return view('control.reviews',
            ['product' => $product, 'fields' => $fields, 'productType' => $productType]
        );
    }

    public function newReview($id, Request $request)
    {
        $productType = $request->segment(2);
        if ($productType === 'tours') {
            $product = Tour::findOrFail($id);
        } else {
            $product = Excursion::findOrFail($id);
        }
        $author = false;
        $review = new GeneratedReview();
        return view('control.review',
            compact('product', 'author', 'review', 'productType')
        );
    }

    public function getReview($id, $reviewId, Request $request)
    {
        $productType = $request->segment(2);
        if ($productType === 'tours') {
            $product = Tour::findOrFail($id);
        } else {
            $product = Excursion::findOrFail($id);
        }
        $author = true;
        if (!$review = $product->reviews->where('id', $reviewId)->load('author')->first()) {
            $author = false;
            $review = $product->generatedReviews->where('id', $reviewId)->first();
        }

        return view('control.review',
            compact('review', 'product', 'author', 'productType')
        );
    }

    public function updateReview($id, $reviewId, Request $request)
    {
        $productType = $request->segment(2);
        if ($productType === 'tours') {
            $product = Tour::findOrFail($id);
        } else {
            $product = Excursion::findOrFail($id);
        }
        $this->validate($request, [
            'avatar' => 'nullable|image',
            'author_name' => 'nullable|string',
            'author_country' => 'nullable|string',
            'body' => 'nullable|string|max:8000',
            'rating' => 'nullable|digits_between:1,5',
            'date' => 'nullable|date'
        ]);
        if (!$request->has('published')) {
            $request->merge(['published' => false]);
        }

        if ($request->hasFile('avatar')) {
            $imageName = str_random(32) . '.' . $request->file('avatar')->getClientOriginalExtension();
            $image = ImageLib::make($request->file('avatar'));
            $imageNormal = $image->resize(600, 600, function ($constraint) {
                $constraint->upsize();
            });
            $imageNormal = $imageNormal->stream();
            $t = Storage::cloud()->put('users/' . \Auth::user()->id . '/' . $imageName, $imageNormal->__toString(), 'public');
            $imageNamePath = Storage::cloud()->url('users/' . \Auth::user()->id . '/' . $imageName);
        }

        $author = true;
        if (!$review = $product->reviews->where('id', $reviewId)->load('author')->first()) {
            $author = false;
            $review = $product->generatedReviews->where('id', $reviewId)->first();
            if (isset($t) && $t) {
                $request->merge([
                    'avatar_url' => $imageNamePath,
                    'avatar_name' => $imageName
                ]);
            }
        }
        $author ?
            $product->updateReview($review->id, $request->except('avatar')) :
            $product->updateGeneratedReview($review->id, $request->except('avatar'));

        return redirect(route('control:' . $productType . '.reviews', $id));
    }

    public function generateReview($id, Request $request)
    {
        $productType = $request->segment(2);
        if ($productType === 'tours') {
            $product = Tour::findOrFail($id);
        } else {
            $product = Excursion::findOrFail($id);
        }
        $this->validate($request, [
            'avatar' => 'required|image',
            'author_name' => 'required|unique:generated_reviews',
            'author_country' => 'required|string',
            'body' => 'nullable|string|max:8000',
            'rating' => 'required|digits_between:1,5',
            'date' => 'required|date'
        ]);

        if ($request->hasFile('avatar')) {
            $imageName = str_random(32) . '.' . $request->file('avatar')->getClientOriginalExtension();
            $image = ImageLib::make($request->file('avatar'));
            $imageNormal = $image->resize(600, 600, function ($constraint) {
                $constraint->upsize();
            });
            $imageNormal = $imageNormal->stream();
            $t = Storage::cloud()->put('users/' . \Auth::user()->id . '/' . $imageName, $imageNormal->__toString(), 'public');
            $imageNamePath = Storage::cloud()->url('users/' . \Auth::user()->id . '/' . $imageName);
        }

        if (isset($t) && $t) {
            $request->merge([
                'avatar_url' => $imageNamePath,
                'avatar_name' => $imageName
            ]);
        }
        $product->createGeneratedReview($request->except('avatar'));

        return redirect(route('control:' . $productType . '.reviews', $id));
    }

    public function toggleReview($id, $reviewId, Request $request)
    {
        $productType = $request->segment(2);
        if ($productType === 'tours') {
            $product = Tour::findOrFail($id);
        } else {
            $product = Excursion::findOrFail($id);
        }

        if (!$review = $product->reviews->where('id', $reviewId)->load('author')->first()) {
            $review = $product->generatedReviews->where('id', $reviewId)->first();
        }
        $review->published = !$review->published;
        $review->save();
        return response()->json($review->published, 200);
    }
}
