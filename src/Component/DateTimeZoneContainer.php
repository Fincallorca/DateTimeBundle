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
     * Returns the default server timezone.
     *
     * To set the default server timezone use {@see \date_default_timezone_get()} or the related `php.ini` configuration.
     *
     * @return DateTimeZone
     *
     * @see \date_default_timezone_get()
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
     * Returns the default database timezone.
     *
     * @return DateTimeZone
     */
    public static function getTimeZoneDatabase(): DateTimeZone
    {
        return self::$timeZoneDatabase;
    }

    /**
     * Sets the default database timezone.
     *
     * @param DateTimeZone $dateTimeZoneDatabase
     */
    public static function setTimeZoneDatabase(DateTimeZone $dateTimeZoneDatabase)
    {
        self::$timeZoneDatabase = $dateTimeZoneDatabase;
    }

    /**
     * Returns the client's default timezone.
     *
     * @return DateTimeZone
     */
    public static function getTimeZoneClient(): DateTimeZone
    {
        return self::$timeZoneClient;
    }

    /**
     * Sets the client's default timezone.
     *
     * @param DateTimeZone $dateTimeZoneClient
     */
    public static function setTimeZoneClient(DateTimeZone $dateTimeZoneClient)
    {
        self::$timeZoneClient = $dateTimeZoneClient;
    }
}
