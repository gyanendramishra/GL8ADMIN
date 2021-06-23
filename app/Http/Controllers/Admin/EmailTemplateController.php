<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\EmailTemplateRequest;
use App\Models\EmailTemplate;
use App\Models\EmailHook;
use App\Models\EmailLayout;
use Inertia\Inertia;

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
                ->paginate()
                ->withQueryString()
                ->through(function ($emailTemplate) {
                    return [
                        'id' => $emailTemplate->id,
                        'emailHook' => $emailTemplate->emailHook->name,
                        'emailLayout' => $emailTemplate->emailLayout->name,
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
                'email_hook_id' => $emailTemplate->email_hook_id,
                'email_layout_id' => $emailTemplate->email_layout_id,
                'subject' => $emailTemplate->subject,
                'content' => $emailTemplate->content,
            ],
            'emailHooks' => EmailHook::isActive()
                ->get()
                ->transform(function ($emailHook) {
                    return [
                        'id' => $emailHook->id,
                        'name' => $emailHook->name
                    ];
                }),
            'emailLayouts' => EmailLayout::isActive()
                ->get()
                ->transform(function ($emailLayout) {
                    return [
                        'id' => $emailLayout->id,
                        'name' => $emailLayout->name
                    ];
                })
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
        try{
            $emailTemplate->update(Request::only('email_hook_id', 'email_layout_id', 'subject', 'content'));
            return Redirect::route('admin.email-templates.index')->with('success', 'Email template has been updated updated successfully.');
        }catch(\Exception $e){
            return Redirect::route('admin.email-templates.index')->with('error', 'Something went wrong. Please try again later.');
        }
    }

}
