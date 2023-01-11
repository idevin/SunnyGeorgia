<?php

namespace App\Http\Controllers\Control;

use App\Http\Controllers\Controller;
use App\Models\Pages\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public $locales;

    public $routes = [
        "main",
        "about",
        "contacts",
        "qa",
        "rules",
        "terms",
        "be-partner",
        "tours",
        "excursions",
        "legal-information"
    ];

    public function __construct()
    {
        $this->locales = config('translatable.locales');
    }

    public function index()
    {
        //
        $pages = Page::all();
        return view('control.pages.index')->with(compact('pages'));
    }

    public function create()
    {
        //
        $locales = $this->locales;

        $slugs = Page::all()->pluck('slug');
        $routes = collect($this->routes)->diff($slugs);
        return view('control.pages.edit')->with(compact('locales', 'routes'));
    }

    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'slug' => 'required'
        ]);

        $page = Page::create($request->except('translations'));

        //create page_translations
        $translations = $request->input('translations');

        foreach ($translations as $locale => $translation) {
            $translation['page_id'] = $page->id;
            $translation['locale'] = $locale;
            $page->translations()->create($translation);
        }

        return redirect()->route('control:pages.index');
    }

    public function edit(Page $page)
    {
        //
        $locales = $this->locales;

        $slugs = Page::all()->pluck('slug');
        $routes = collect($this->routes)->diff($slugs);
        $routes[] = $page->slug;

        return view('control.pages.edit')->with(compact('page', 'locales', 'routes'));
    }

    public function update(Page $page, Request $request)
    {
        $page->fill($request->input('translations'));
        $page->save();
        return redirect()->route('control:pages.edit', $page->id);

    }

    public function destroy($id)
    {
        //
        $page = Page::find($id);
        $page->translations()->delete();
        $page->delete();
        return redirect()->route('control:pages.index');
    }
}
