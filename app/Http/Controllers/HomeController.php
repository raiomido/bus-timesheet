<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    /**
     * "NptgLocalities",
     * "StopPoints",
     * "RouteSections",
     * "Routes",
     * "JourneyPatternSections",
     * "Operators",
     * "Services",
     * "VehicleJourneys"
     * @return array
     */
    public function index() {

        $routes = [];
        foreach (File::allFiles(storage_path("/app/public/routes")) as $file) {

            if ($xml = \simplexml_load_file($file, null, LIBXML_NOCDATA)) {

                foreach (json_decode(json_encode($xml), true) as $index => $item) {

//                    if ($index == 'Routes') {
//                        return $item['Route'];
//                    }

                    $routes[] = $index;
                }

//                $routes[] = json_decode(json_encode($xml), true);
            }
        }

        return $routes;
    }
}
