<?php

namespace App\Repository\Admin\Setting;

use App\Models\Setting;
use Illuminate\Http\Request;

interface ISettingRepository
{
    
     public function updateSetting(Request $request, Setting $setting, array $data);

     
}