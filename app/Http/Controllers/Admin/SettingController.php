<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Http\Requests\StoreSettingRequest;
use App\Repository\Admin\Setting\SettingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{

    public $setting;

    public function __construct(SettingRepository $setting)
    {
        $this->setting = $setting;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSettingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSettingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Setting $setting)
    {
        if(! $setting) {
            return response()->json('setting does not exist');
        }

        $settingId = Cache::remember('setting:'. $request->id, 60, function() use ($setting) {
            return $setting;
        });

        return response()->json([
            'status' => true,
            'setting' => $settingId
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSettingRequest  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        
        if(! $setting) {
            return response()->json('setting does not exist');
        }

        $request->validate([
            'header_logo' => 'required',
            'footer_logo' => 'required',
            'footer_desc' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'facebook' => 'required',
            'instagram' => 'required',
            'youtube' => 'required',
            'about_title' => 'required',
            'about_desc' => 'required',
        ]);

       $data = $request->all();

       $this->setting->updateSetting($request, $setting, $data);

       Cache::put('setting', $setting);

        return response()->json([
            'message' => 'Setting Updated Successfully',
            'setting' => $setting,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
