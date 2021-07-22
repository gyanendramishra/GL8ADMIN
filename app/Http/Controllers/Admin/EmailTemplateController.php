<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\EmailTemplateRequest;
use App\Models\EmailTemplate;
use Inertia\Inertia;
use Config;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return Inertia::render('EmailTemplates/Index', [
            'filters' => Request::all('search', 'trashed'),
            'emailTemplates' => EmailTemplate::orderBySubject()
                ->filter(Request::only('search', 'trashed'))
                ->paginate(Config::get('pagination.admin_per_page'))
                ->withQueryString()
                ->through(function ($emailTemplate) {
                    return [
                        'id' => $emailTemplate->id,
                        'name' => $emailTemplate->name,
                        'subject' => $emailTemplate->subject,
                        'created_at' => $emailTemplate->created_at->format('M/d/Y')
                    ];
                })
        ]);
    }

    /**
     * Show the resource edit view.
     * @param EmailTemplate $emailTemplate
     * @return Response
     */
    public function edit(EmailTemplate $emailTemplate)
    {
        return Inertia::render('EmailTemplates/Edit', [
            'emailTemplate' => [
                'id' => $emailTemplate->id,
                'name' => $emailTemplate->name,
                'subject' => $emailTemplate->subject,
                'content' =>  $emailTemplate->content,
            ]
        ]);
    }

    /**
     * Update the specified resource.
     * @param EmailTemplateRequest $request
     * @param EmailTemplate $emailTemplate
     * @return Response
     */
    public function update(EmailTemplateRequest $request, EmailTemplate $emailTemplate)
    {
        try {
            $emailTemplate->update(Request::only('subject', 'content'));
            return Redirect::route('admin.email-templates.index')->with('success', 'Email template has been updated updated successfully.');
        } catch (\Exception $e) {
            return Redirect::route('admin.email-templates.index')->with('error', 'Something went wrong. Please try again later.');
        }
    }

    /**
     * Preview the specified resource.
     * @param Request $request
     * @param EmailTemplate $emailTemplate
     * @return Response
     */
    public function show(Request $request, EmailTemplate $emailTemplate)
    {
        try {
            $user = \App\Models\User::inRandomOrder()->first();
            return (new \App\Mails\Admin\PasswordChanged($user))->render();
        } catch (\Exception $e) {
            return Redirect::route('admin.email-templates.index')->with('error', 'Something went wrong. Please try again later.');
        }
    }
}
