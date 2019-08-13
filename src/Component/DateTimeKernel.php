<?php

declare( strict_types=1 );

namespace Fincallorca\DateTimeBundle\Component;

use DateTimeInterface;
use Exception;
use Fincallorca\DateTimeBundle\DateTimeBundle;
use Fincallorca\DateTimeBundle\EventListener\Initializer;

/**
 * The class {@see \Fincallorca\DateTimeBundle\Component\DateTimeKernel} is neccessary to access
 * - all enabled timezones and
 * - the current server date
 * everywhere in your project.
 *
 * The listener {@see \Fincallorca\DateTimeBundle\EventListener\Initializer} tries to initialize all
 * timezones (server, database,client) by
 * 1. the http request or
 * 2. by the cli command
 * but in some cases you don't have neither a http request object nor a command request
 * (i.e. by calling `doctrine:migration:migrate`).
 * Thats why it is necessary to include a separate kernel class to provide the timezones in every case.
 *
 * @package Fincallorca\DateTimeBundle
 */
class DateTimeKernel
{
    use DateTimeZoneContainer;

    /**
     * @var DateTimeImmutable[]
     */
    protected static $dateTimeServer = array();

    /**
     * Returns the server date time as an immutable object.
     *
     * @return DateTimeImmutable
     *
     * @throws Exception
     */
    public static function getDateTimeServer(): DateTimeImmutable
    {
        $serverTimeZone = self::getTimeZoneServer();

        $timezoneKey = crc32($serverTimeZone->getName());

        if( array_key_exists($timezoneKey, self::$dateTimeServer) )
        {
            return self::$dateTimeServer[ $timezoneKey ];
        }

        if( empty(self::$dateTimeServer) )
        {
            throw new Exception(sprintf("The symfony event listener \"%s\" was not initialized. Please do not forget to initialize symfony or to enable the bundle \"%s\".",
                Initializer::class,
                DateTimeBundle::class
            ));
        }

        // the default server timezone was changed
        // -> use the first saved server time object (which is of course an immutable datetime object)
        //    change the timezone to the new server time zone and (re)save the (immutable) date time object

        /** @var DateTimeImmutable $dateTimeImmutable */
        $dateTimeImmutable = array_slice(self::$dateTimeServer, 0, 1)[ 0 ];

        self::$dateTimeServer[ $timezoneKey ] = $dateTimeImmutable->setTimezone($serverTimeZone);

        return self::$dateTimeServer[ $timezoneKey ];
    }

    /**
     * Sets the current server date time.
     *
     * @param DateTimeInterface $dateTime
     *
     * @throws Exception
     */
    public static function setDateTimeServer(DateTimeInterface $dateTime)
    {
        if( !$dateTime instanceof DateTimeImmutable )
        {
            $dateTime = DateTimeImmutable::createFromObject($dateTime);
        }

        if( $dateTime->getTimezone()->getName() !== self::getTimeZoneServer()->getName() )
        {
            $dateTime = $dateTime->setTimezone(self::getTimeZoneServer());
        }

        $timezoneKey = crc32($dateTime->getTimezone()->getName());

        self::$dateTimeServer[ $timezoneKey ] = $dateTime;
    }
}