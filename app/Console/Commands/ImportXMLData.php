<?php

namespace App\Console\Commands;

use App\Lib\ScheduleManager;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportXMLData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:xml';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import xml';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (File::allFiles(storage_path("/app/public/routes")) as $file) {

            if ($xml = \simplexml_load_file($file, null, LIBXML_NOCDATA)) {

                $data = json_decode(json_encode($xml), true);

                $manager = new ScheduleManager($data['@attributes']['FileName']);

                $manager
                    ->saveLocalities($data['NptgLocalities']['AnnotatedNptgLocalityRef'])
                    ->saveStopPoints($data['StopPoints']['StopPoint'])
                    ->saveRouteSections($data['RouteSections']['RouteSection'])
                    ->saveRoutes($data['Routes']['Route'])
                    ->saveJourneyPatternSections($data['JourneyPatternSections']['JourneyPatternSection'])
                    ->saveOperators($data['Operators']['Operator'])
                    ->saveServices($data['Services']['Service'])
                    ->saveVehicleJourneys($data['VehicleJourneys']['VehicleJourney'])
                ;
            }
        }
    }
}
