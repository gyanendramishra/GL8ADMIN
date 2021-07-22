<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Models\Enquiry;
use Inertia\Inertia;
use Exception;
use Config;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Enquiries/Index', [
            'filters' => Request::all('search', 'status', 'trashed'),
            'enquiries' => Enquiry::orderByName()
                ->filter(Request::only('search', 'status', 'trashed'))
                ->paginate(Config::get('pagination.admin_per_page'))
                ->withQueryString()
                ->through(function ($enquiry) {
                    return [
                        'id' => $enquiry->id,
                        'name' => $enquiry->name,
                        'email' => $enquiry->email,
                        'subject' => $enquiry->subject,
                        'is_read' => $enquiry->is_read,
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
        if (!$enquiry->is_read) {
            $enquiry->is_read = true;
            $enquiry->save();
        }
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
        try {
            $enquiry->delete();
            return Redirect::route('admin.enquiries.index')->with('success', 'Enquiry deleted.');
        } catch (Exception $e) {
            return Redirect::route('admin.enquiries.index')->with('error', 'Something  went wrong. Please try again later.');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param Enquiry $enquiry
     * @return Response
     */
    public function restore(Enquiry $enquiry)
    {
        try {
            $enquiry->restore();
            return Redirect::route('admin.enquiries.index')->with('success', 'Enquiry restored.');
        } catch (Exception $e) {
            return Redirect::route('admin.enquiries.index')->with('error', 'Something  went wrong. Please try again later.');
        }
    }
}
