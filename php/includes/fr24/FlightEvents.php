<?php

namespace fr24;

class FlightEvents {
    
    const AIRPORT_ICAO = [
        'LHR', 'BMA', 'MMX', 'BQH',
        'ISB', 'LCA', 'TXL', 'KRK',
        'BMA', 'ARN', 'BER', 'BEG'
    ];

    const FLIGHT_STATE = [
        'on-ground'     => 'Flight :flight was seen on ground at :origin',
        'taxi-out'      => 'Flight :flight is taxiing to runway at :origin',
        'take-off'      => 'Flight :flight is taking off from :origin destined for :destination',
        'cruise'        => 'Flight :flight from :origin is cruising en route to :destination at :altitude ft',
        'holding'       => 'Flight :flight from :origin is in a holding pattern awaiting arrival at :destination',
        'landing'       => 'Flight :flight from :origin has started approach to :destination',
        'landed'        => 'Flight :flight from :origin has landed at :destination'
    ];

    const AIRLINE_IATA = [
        'SK', 'BA', 'AA', 'DY',
        'FR', 'IB', 'VS', 'KL',
        'TK', 'AF', 'LH', 'LX'
    ];

    const MAX_EVENTS = 30;

    private static function randomItem( array $items ): string {
        return $items[ array_rand( $items ) ];
    }

    private static function generate(): string {
        $origin = self::randomItem(FlightEvents::AIRPORT_ICAO);

        $event = [
            ':origin'       => $origin,
            ':destination'  => self::randomItem( array_diff(FlightEvents::AIRPORT_ICAO, [ $origin ]) ), 
            ':flight'       => self::randomItem(FlightEvents::AIRLINE_IATA) . rand(80,9000), 
            ':altitude'     => rand(250,420) . '00'
        ];

        return str_replace( 
            array_keys($event), 
            array_values($event), 
            self::randomItem(FlightEvents::FLIGHT_STATE)
        );
    }

    /** 
     * Generates an array list ( of random length ) of aviation event strings with every call
     *
     * @return string[]
     */
    public static function fetch(): array {
        return array_map( 'fr24\FlightEvents::generate', array_fill(0, rand(1, FlightEvents::MAX_EVENTS), NULL) );
    }
}