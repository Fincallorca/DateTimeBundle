<?php

declare( strict_types=1 );

namespace Fincallorca\DateTimeBundle\Component;

/**
 * Class DateTimeContainer
 *
 * @package Fincallorca\DateTimeBundle
 */
trait DateTimeContainer
{

    /**
     * @var DateTimeImmutable[]
     */
    protected static $dateTimeServer = array();

    /**
     *
     * @return DateTimeImmutable
     */
    public static function getDateTimeServer(): DateTimeImmutable
    {
        $serverTimeZone = DateTimeKernel::getTimeZoneServer();

        $timezoneKey = crc32($serverTimeZone->getName());

        if( array_key_exists($timezoneKey, self::$dateTimeServer) )
        {
            return self::$dateTimeServer[ $timezoneKey ];
        }

        $dateTimeImmutable = array_slice(self::$dateTimeServer, 0, 1)[ 0 ];

        self::$dateTimeServer[ $timezoneKey ] = $dateTimeImmutable->setTimezone($serverTimeZone);

        return self::$dateTimeServer[ $timezoneKey ];
    }

    /**
     * @param DateTimeImmutable $dateTime
     */
    public static function setDateTimeServer(DateTimeImmutable $dateTime)
    {
        $timezoneKey = crc32($dateTime->getTimezone()->getName());

        self::$dateTimeServer[ $timezoneKey ] = $dateTime;
    }
}
