<?php

namespace App\Lib;

use App\Models\Line;
use App\Models\Garage;
use App\Models\Address;
use App\Models\Schedule;
use App\Models\Location;
use App\Models\RouteSection;
use App\Models\LayoverPoint;
use App\Models\TicketMachine;
use App\Models\JourneyPattern;
use App\Models\JourneyPatternSection;
use App\Models\JourneyPatternStopUsage;

class ScheduleManager
{
    public Schedule $schedule;

    public function __construct($scheduleName)
    {
        $this->schedule = Schedule::create(['name' => $scheduleName]);
    }

    public function saveLocalities($localities): ScheduleManager
    {
        if ($localities && $this->is_multi($localities)) {
            foreach ($localities as $locality) {
                $this->createLocality($locality);
            }
        } else {
            $this->createLocality($localities);
        }

        return $this;
    }

    public function saveStopPoints($stopPoints): ScheduleManager
    {
        if ($stopPoints && $this->is_multi($stopPoints)) {
            foreach ($stopPoints as $stopPoint) {
                $this->createStopPoint($stopPoint);
            }
        } else {
            $this->createStopPoint($stopPoints);
        }

        return $this;
    }


    public function saveRouteSections($routeSections): ScheduleManager
    {

        if ($routeSections && $this->is_multi($routeSections)) {
            foreach ($routeSections as $routeSection) {
                $this->createRouteSection($routeSection);
            }
        } else {
            $this->createRouteSection($routeSections);
        }

        return $this;
    }


    private function saveRouteLinks(RouteSection $routeSection, $routeLinks): void
    {
        if ($routeLinks && $this->is_multi($routeLinks)) {
            foreach ($routeLinks as $routeLink) {
                $this->createRouteLink($routeSection, $routeLink);
            }
        } else {
            $this->createRouteLink($routeSection, $routeLinks);
        }

    }

    public function saveRoutes($routes): ScheduleManager
    {
        if ($routes && $this->is_multi($routes)) {
            foreach ($routes as $route) {
                $this->createRoute($route);
            }
        } else {
            $this->createRoute($routes);
        }

        return $this;
    }

    public function saveJourneyPatternSections($journeyPatternSections): ScheduleManager
    {
        if ($journeyPatternSections && $this->is_multi($journeyPatternSections)) {
            foreach ($journeyPatternSections as $journeyPatternSection) {
                $this->createJourneyPatternSection($journeyPatternSection);
            }
        } else {
            $this->createJourneyPatternSection($journeyPatternSections);
        }

        return $this;
    }

    public function saveOperators($operators): ScheduleManager
    {
        if ($operators && $this->is_multi($operators)) {
            foreach ($operators as $operator) {
                $this->createOperator($operator);
            }
        } else {
            $this->createOperator($operators);
        }

        return $this;
    }

    public function saveServices($services): ScheduleManager
    {
        if ($services && $this->is_multi($services)) {
            foreach ($services as $service) {
                $this->createService($service);
            }
        } else {
            $this->createService($services);
        }

        return $this;
    }

    public function saveVehicleJourneys($vehicleJourneys): ScheduleManager
    {

        if ($vehicleJourneys && $this->is_multi($vehicleJourneys)) {
            foreach ($vehicleJourneys as $vehicleJourney) {
                $this->createVehicleJourney($vehicleJourney);
            }
        } else {
            $this->createVehicleJourney($vehicleJourneys);
        }

        return $this;
    }


    /**
     * Private creator methods
     */

    private function createStopPoint($stopPoint) {
        $location = Location::firstOrCreate([
            'longitude' => $stopPoint['Place']['Location']['Longitude'],
            'latitude' => $stopPoint['Place']['Location']['Latitude'],
        ]);

        $this->schedule->stopPoints()->create([
            'common_name' => $stopPoint['Descriptor']['CommonName'],
            'atco_code' => $stopPoint['AtcoCode'],
            'locality_reference' => $stopPoint['Place']['NptgLocalityRef'],
            'stop_type' => $stopPoint['StopClassification']['StopType'],
            'timing_status' => $stopPoint['StopClassification']['OffStreet']['BusAndCoach']['Bay']['TimingStatus'],
            'administrative_area_ref'=> $stopPoint['AdministrativeAreaRef'],
            'notes' => $stopPoint['Notes'],
            'location_id' => $location->id,
        ]);
    }

    private function createLocality($locality) {
        $this->schedule->localities()->create([
            'name' => $locality['LocalityName'],
            'reference' => $locality['NptgLocalityRef'],
        ]);
    }

    private function createRouteSection($routeSection) {

        $model = $this->schedule->routeSections()->create([
            'reference' => $routeSection['@attributes']['id'],
        ]);

        $this->saveRouteLinks($model, $routeSection['RouteLink']);
    }

    private function createRouteLink(RouteSection $routeSection, $routeLink) {
        $model = $routeSection->routeLinks()->create([
            'from' => $routeLink['From']['StopPointRef'],
            'to' => $routeLink['To']['StopPointRef'],
            'distance' => $routeLink['Distance'],
            'direction' => $routeLink['Direction'],
        ]);

        $ids = [];

        foreach ($routeLink['Track']['Mapping']['Location'] as $location) {
            $ids[] = Location::firstOrCreate([
                'longitude' => $location['Longitude'],
                'latitude' => $location['Latitude'],
            ])->id;
        }

        $model->locations()->attach($ids);
    }

    private function createRoute($route) {
        $this->schedule->routes()->create([
            'private_code' => $route['PrivateCode'],
            'description' => $route['Description'],
            'route_section_ref' => $route['RouteSectionRef'],
        ]);
    }

    private function createJourneyPatternSection($journeyPatternSection)
    {
        $model = $this->schedule->journeyPatternSections()->create();
        $links = $journeyPatternSection['JourneyPatternTimingLink'];

        if ($this->is_multi($links)) {
            foreach ($links as $journeyPatternTimingLink) {
                $this->createJourneyJourneyPatternTimingLink($model, $journeyPatternTimingLink);
            }
        } else {
            $this->createJourneyJourneyPatternTimingLink($model, $links);
        }
    }

    private function createJourneyJourneyPatternTimingLink(JourneyPatternSection $journeyPatternSection, $journeyPatternTimingLink)
    {
        $from = JourneyPatternStopUsage::firstOrCreate([
            'sequence_number' => $journeyPatternTimingLink['From']['@attributes']['SequenceNumber'],
            'activity' => $journeyPatternTimingLink['From']['Activity'],
            'dynamic_destination_display' => $journeyPatternTimingLink['From']['DynamicDestinationDisplay'],
            'stop_point_ref' => $journeyPatternTimingLink['From']['StopPointRef'],
            'timing_status' => $journeyPatternTimingLink['From']['TimingStatus']
        ]);

        $to = JourneyPatternStopUsage::firstOrCreate([
            'sequence_number' => $journeyPatternTimingLink['To']['@attributes']['SequenceNumber'],
            'activity' => $journeyPatternTimingLink['To']['Activity'],
            'dynamic_destination_display' => $journeyPatternTimingLink['To']['DynamicDestinationDisplay'],
            'stop_point_ref' => $journeyPatternTimingLink['To']['StopPointRef'],
            'timing_status' => $journeyPatternTimingLink['To']['TimingStatus']
        ]);

        $journeyPatternSection->journeyPatternTimingLinks()->create([
            'from_id' => $from->id,
            'to_id' => $to->id,
            'route_link_ref' => $journeyPatternTimingLink['RouteLinkRef'],
            'run_time' => $journeyPatternTimingLink['RunTime'],
        ]);
    }

    private function createOperator($operator) {
//        dd($operator);
        $model = $this->schedule->operators()->create([
            'name' => $operator['TradingName'],
            'reference' => $operator['@attributes']['id'],
            'national_code' => $operator['NationalOperatorCode'],
            'code' => $operator['OperatorCode'],
            'short_name' => $operator['OperatorShortName'],
            'name_on_licence' => $operator['OperatorNameOnLicence'],
            'licence_number' => $operator['LicenceNumber'],
            'licence_classification' => $operator['LicenceClassification'],
        ]);

        $ids = [];

        foreach ($operator['OperatorAddresses']['CorrespondenceAddress']['Line'] as $operatorAddress) {
            $address = Address::firstOrCreate(['name' => $operatorAddress]);
            $ids[] = $address->id;
        }

        $garageIds = [];
        $garages = $operator['Garages']['Garage'];

        if ($this->is_multi($garages)) {
            foreach ($garages as $garage) {
                $garageIds[] = $this->createGarage($garage)->id;
            }
        } else {
            $garageIds[] = $this->createGarage($garages)->id;
        }

        $model->addresses()->attach($ids);
        $model->garages()->attach($garageIds);
    }

    private function createGarage($garage) {
        $location = Location::firstOrCreate([
            'longitude' => $garage['Location']['Longitude'],
            'latitude' => $garage['Location']['Latitude'],
        ]);

        return Garage::firstOrCreate([
            'name'=> $garage['GarageName'],
            'code' => $garage['GarageCode'],
            'location_id' => $location->id
        ]);
    }

    private function createService($service) {

        $model = $this->schedule->services()->create([
            'service_code' => $service['ServiceCode'],
            'private_code' => $service['PrivateCode'],
            'start_date' => $service['OperatingPeriod']['StartDate'],
            'end_date' => $service['OperatingPeriod']['EndDate'],
            'operating_period' => implode(', ', $service['OperatingProfile']['RegularDayType']['DaysOfWeek']['MondayToSunday'] ?? []),
            'bank_holiday_days_of_operation' => implode(', ', $service['BankHolidayOperation']['DaysOfOperation'] ?? []),
            'bank_holiday_days_of_non_operation' => implode(', ', $service['BankHolidayOperation']['DaysOfNonOperation'] ?? []),
            'registered_operator_ref' => $service['RegisteredOperatorRef'],
            'mode' => $service['Mode'],
            'standard_service_origin' => $service['StandardService']['Origin'],
            'standard_service_destination' => $service['StandardService']['Destination'],
        ]);

        $journeyPatternIds = [];
        $journeyPatterns = $service['StandardService']['JourneyPattern'];
        $lines = $service['Lines']['Line'];

        if ($this->is_multi($journeyPatterns)) {
            foreach ($journeyPatterns as $journeyPattern) {
                $journeyPatternModel = $this->createJourneyPattern($journeyPattern);

                $journeyPatternIds[] = $journeyPatternModel->id;
            }
        } else {
            $journeyPatternModel = $this->createJourneyPattern($journeyPatterns);
            $journeyPatternIds[] = $journeyPatternModel->id;
        }

        $lineIds = [];

        $lineIds[] = $this->createLine($lines)->id;

        $model->journeyPatterns()->attach($journeyPatternIds);
        $model->lines()->attach($lineIds);
    }

    private function createJourneyPattern($journeyPattern) {
        return JourneyPattern::firstOrCreate([
            'reference' => $journeyPattern['@attributes']['id'],
            'destination_display' => $journeyPattern['DestinationDisplay'],
            'direction' => $journeyPattern['Direction'],
            'route_ref' => $journeyPattern['RouteRef'],
            'journey_pattern_section_refs' => $journeyPattern['JourneyPatternSectionRefs']
        ]);
    }

    private function createLine($line) {
        return Line::firstOrCreate([
            'name'=> $line['LineName'],
            'reference'=> $line['@attributes']['id']
        ]);
    }

    private function createVehicleJourney($vehicleJourney) {

        if (isset($vehicleJourney['LayoverPoint'])) {
            $location = Location::firstOrCreate([
                'longitude' => $vehicleJourney['LayoverPoint']['Location']['Longitude'],
                'latitude' => $vehicleJourney['LayoverPoint']['Location']['Latitude'],
            ]);

            $layoverPoint = LayoverPoint::firstOrCreate([
                'name' => $vehicleJourney['LayoverPoint']['Name'],
                'duration' => $vehicleJourney['LayoverPoint']['Duration'],
                'location_id' => $location->id,
            ]);
        }

        $ticketMachine = TicketMachine::firstOrCreate([
            'service_code' => $vehicleJourney['Operational']['TicketMachine']['TicketMachineServiceCode'],
            'journey_code' => $vehicleJourney['Operational']['TicketMachine']['JourneyCode'],
        ]);

        $this->schedule->vehicleJourneys()->create([
            'private_code' => $vehicleJourney['PrivateCode'],
            'operating_period' => implode(', ', $vehicleJourney['OperatingProfile']['RegularDayType']['DaysOfWeek']['MondayToSunday'] ?? []),
            'bank_holiday_days_of_operation' => implode(', ', $vehicleJourney['BankHolidayOperation']['DaysOfOperation'] ?? []),
            'bank_holiday_days_of_non_operation' => implode(', ', $vehicleJourney['BankHolidayOperation']['DaysOfNonOperation'] ?? []),
            'garage_ref' => $vehicleJourney['GarageRef'],
            'vehicle_journey_code' => $vehicleJourney['VehicleJourneyCode'],
            'service_ref' => $vehicleJourney['ServiceRef'],
            'line_ref' => $vehicleJourney['LineRef'],
            'journey_pattern_ref'=>  $vehicleJourney['JourneyPatternRef'],
            'departure_time' =>  $vehicleJourney['DepartureTime'],
            'layover_point_id' => $layoverPoint->id ?? null,
            'ticket_machine_id' => $ticketMachine->id ?? null,
        ]);
    }

    private function is_multi($arr): bool
    {

        if (!is_array($arr)) return false;

        $rv = array_filter($arr, 'is_array');

        if(count($rv) > 0 && isset($arr[0])) return true;

        return false;
    }

}