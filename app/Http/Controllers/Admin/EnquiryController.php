<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use App\Models\Enquiry;
use Inertia\Inertia;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Enquiries/Index', [
            'filters' => Request::all('search', 'trashed'),
            'enquiries' => Enquiry::orderByName()
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($enquiry) {
                    return [
                        'id' => $enquiry->id,
                        'name' => $enquiry->name,
                        'email' => $enquiry->email,
                        'subject' => $enquiry->subject,
                        'created_at' => $enquiry->created_at->format('M/d/Y'),
                        'deleted_at' => $enquiry->deleted_at,
                    ];
                }),
        ]);
    }

    /**
     * Show the specified resource.
     * @param Enquiry $enquiry
     * @return Response
     */
    public function show(Enquiry $enquiry)
    {
        return Inertia::render('Enquiries/Show', [
            'enquiry' => [
                'id' => $enquiry->id,
                'name' => $enquiry->name,
                'email' => $enquiry->email,
                'phone' => $enquiry->phone,
                'subject' => $enquiry->subject,
                'message' => $enquiry->message,
                'created_at' => $enquiry->created_at->format('M/d/Y'),
                'deleted_at' => $enquiry->deleted_at,
            ],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param Enquiry $enquiry
     * @return Response
     */
    public function destroy(Enquiry $enquiry)
    {
        $enquiry->delete();

        return Redirect::back()->with('success', 'Enquiry deleted.');
    }

    /**
     * Remove the specified resource from storage.
     * @param Enquiry $enquiry
     * @return Response
     */
    public function restore(Enquiry $enquiry)
    {
        $enquiry->restore();

        return Redirect::back()->with('success', 'Enquiry restored.');
    }
}
