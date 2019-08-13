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
    protected static $timeZones = array();

    /**
     * @var DateTimeZone[]
     */
    protected static $timeZonesServer = array();

    /**
     * @var DateTimeZone|null
     */
    protected static $timeZoneDatabase = null;

    /**
     * @var DateTimeZone|null
     */
    protected static $timeZoneClient = null;

    /**
     * Returns `true` if the submitted string is a valid timezone name, else `false`.
     *
     * @param string $timeZone the name of the timezone
     *
     * @return boolean
     *
     * @link http://us.php.net/manual/en/timezones.others.php
     */
    public static function isValidTimezone(string $timeZone): bool
    {
        return in_array($timeZone, DateTimeZone::listIdentifiers());
    }

    /**
     * Returns the timezone object of the passed timezone name.
     *
     * @param string $timeZone the name of the timezone
     *
     * @return DateTimeZone
     */
    public static function getTimeZoneByName(string $timeZone): DateTimeZone
    {
        if( !self::isValidTimezone($timeZone) )
        {
            throw new \UnexpectedValueException(sprintf('Unable instantiate the time zone of "%s"', $timeZone));
        }

        $timezoneKey = crc32($timeZone);

        if( array_key_exists($timezoneKey, self::$timeZonesServer) )
        {
            return self::$timeZones[ $timezoneKey ];
        }

        self::$timeZones[ $timezoneKey ] = new DateTimeZone($timeZone);

        return self::$timeZones[ $timezoneKey ];
    }

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
        return self::getTimeZoneByName(date_default_timezone_get());
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
     *
     * @internal Use only in the event listener {@see \Fincallorca\DateTimeBundle\EventListener\Initializer} or in tests!
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