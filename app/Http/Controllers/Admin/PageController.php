<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\PageRequest;
use Inertia\Inertia;
use App\Models\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Pages/Index', [
            'filters' => Request::all('search', 'trashed'),
            'pages' => Page::orderByTitle()
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($page) {
                    return [
                        'id' => $page->id,
                        'title' => $page->title,
                        'created_at' => $page->created_at->format('M/d/Y'),
                        'deleted_at' => $page->deleted_at,
                    ];
                }),
        ]);
    }

    /**
     * Show the resource edit view.
     * @param Page $faq
     * @return Response
     */
    public function edit(Page $page)
    {
        return Inertia::render('Pages/Edit', [
            'page' => [
                'id' => $page->id,
                'title' => $page->title,
                'meta_title' => $page->meta_title,
                'meta_keyword' => $page->meta_keyword,
                'meta_description' => $page->meta_description,
                'excerpt' => $page->excerpt,
                'content' => $page->content,
            ]
        ]);
    }
    /**
     * Update the specified resource.
     * @param PageRequest $request
     * @param Page $page
     * @return Response
     */
    public function update(PageRequest $request, Page $page)
    {
        try{
            $page->update(Request::only('title', 'excerpt', 'content', 'meta_title', 'meta_keyword', 'meta_description'));
            return Redirect::route('admin.pages.index')->with('success', 'Page has been updated updated successfully.');
        }catch(\Exception $e){
            return Redirect::route('admin.pages.index')->with('error', 'Something went wrong. Please try again later.');
        }
    }

    /**
     * Destroy the specified resource.
     * @param Page $page
     * @return Response
     */
    public function destroy(Page $page)
    {
        try{
            $page->delete();
            return Redirect::route('admin.pages.index')->with('success', 'Page has been deleted successfully.');
        }catch(\Exception $e){
            return Redirect::route('admin.pages.index')->with('error', 'Something went wrong. Please try again later.');
        }
    }

}
