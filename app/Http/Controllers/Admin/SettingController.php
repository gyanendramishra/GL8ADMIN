<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\SettingRequest;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Yaml\Yaml;
use App\Models\Setting;
use Inertia\Inertia;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Settings/Index', [
            'settings' => Setting::select('key', 'value')
                ->get()
                ->mapWithKeys(function ($setting) {
                    return [$setting->key => $setting->value];
                })
        ]);
    }

    /**
     * Update the specified resource.
     * @param SettingRequest $request
     * @return Response
     */
    public function update(SettingRequest $request)
    {
        DB::beginTransaction();
        try {
            $settings = $request->except(['logo', 'favicon']);
            foreach ($settings as $key => $value) {
                Setting::where('key', $key)->update(['value' => $value]);
            }
            if (Request::file('logo')) {
                Setting::where('key', 'logo')->update(['value' => Request::file('logo')->store('logos')]);
            }
            if (Request::file('favicon')) {
                Setting::where('key', 'favicon')->update(['value' => Request::file('favicon')->store('favicons')]);
            }

            $allSettings = Setting::get()->pluck('value', 'key');
            $yaml = Yaml::dump($allSettings->toArray(), 4, 60);

            Storage::disk('local')->put('settings.yml', $yaml);
            // Db commit
            DB::commit();
            return Redirect::back()->with('success', 'Settings has been updated updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return Redirect::route('admin.settings')->with('error', 'Something went wrong. Please try again later.');
        }
    }
}
