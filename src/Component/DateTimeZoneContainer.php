<?php

declare( strict_types=1 );

namespace Fincallorca\DateTimeBundle\Component;

use DateTimeZone;

/**
 * Class DateTimeZoneContainer
 *
 * @package Fincallorca\DateTimeBundle
 */
trait DateTimeZoneContainer
{

    /**
     * @var DateTimeZone[]
     */
    protected static $timeZonesServer = array();

    /**
     * @var DateTimeZone
     */
    protected static $timeZoneDatabase = null;

    /**
     * @var DateTimeZone
     */
    protected static $timeZoneClient = null;

    /**
     *
     * @return DateTimeZone
     */
    public static function getTimeZoneServer(): DateTimeZone
    {
        $timezoneKey = crc32(date_default_timezone_get());

        if( array_key_exists($timezoneKey, self::$timeZonesServer) )
        {
            return self::$timeZonesServer[ $timezoneKey ];
        }

        self::$timeZonesServer[ $timezoneKey ] = new DateTimeZone(date_default_timezone_get());

        return self::$timeZonesServer[ $timezoneKey ];
    }

    /**
     *
     * @return DateTimeZone
     */
    public static function getTimeZoneDatabase(): DateTimeZone
    {
        return self::$timeZoneDatabase;
    }

    /**
     * @param DateTimeZone $dateTimeZoneDatabase
     */
    public static function setTimeZoneDatabase(DateTimeZone $dateTimeZoneDatabase)
    {
        self::$timeZoneDatabase = $dateTimeZoneDatabase;
    }

    /**
     * @return DateTimeZone
     */
    public static function getTimeZoneClient(): DateTimeZone
    {
        return self::$timeZoneClient;
    }

    /**
     * @param DateTimeZone $dateTimeZoneClient
     */
    public static function setTimeZoneClient(DateTimeZone $dateTimeZoneClient)
    {
        self::$timeZoneClient = $dateTimeZoneClient;
    }
}
