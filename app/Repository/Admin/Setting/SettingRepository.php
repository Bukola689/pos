<?php

namespace App\Repository\Admin\Setting;

use App\Models\Setting;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;


class SettingRepository implements ISettingRepository
{

     public function updateSetting(Request $request,Setting $setting, array $data)
     {
      $setting->header_logo = $request->header_logo;
      $setting->footer_logo  = $request->footer_logo;
      $setting->footer_desc  = $request->footer_desc;
      $setting->email  = $request->email;
      $setting->phone  = $request->phone;
      $setting->address  = $request->address;
      $setting->facebook  = $request->facebook;
      $setting->instagram  = $request->instagram;
      $setting->youtube  = $request->youtube;
      $setting->about_title  = $request->about_title;
      $setting->about_desc  = $request->about_desc;
      $setting->update();
     }

    

}