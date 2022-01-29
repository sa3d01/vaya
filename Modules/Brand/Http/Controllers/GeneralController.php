<?php

namespace Modules\Brand\Http\Controllers;

use App\Models\Config;

class GeneralController extends MasterController
{
    public function configs()
    {
        return $this->sendResponse([
            'ratio' => (int)Config::value('ratio'),
            'about' =>  [
                'ar' => Config::value('about_ar')??"",
                'en' => Config::value('about_en')??""
            ],
            'policy'=>  [
                'ar' => Config::value('policy_ar')??"",
                'en' => Config::value('policy_en')??""
            ],
        ]);
    }

}
