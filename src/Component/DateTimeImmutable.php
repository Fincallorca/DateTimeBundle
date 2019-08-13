<?php

declare( strict_types=1 );

namespace Fincallorca\DateTimeBundle\Component;

use Exception;

/**
 * Class DateTimeImmutable
 *
 * @package Fincallorca\DateTimeBundle
 */
class DateTimeImmutable extends \ExtDateTime\DateTimeImmutable
{
    /**
     * {@inheritDoc}
     *
     * Overrides {@see \ExtDateTime\DateTimeImmutable::current()} to change the timezone to server time.
     *
     * @return static
     *
     * @throws Exception
     */
    public static function current()
    {
        /** @var DateTimeImmutable $dateTime */
        $dateTime = parent::current();
        return $dateTime->toServerDateTime();
    }

    /**
     * Returns the server time of today.
     *
     * @return static
     *
     * @throws Exception
     *
     * @deprecated Please use {@see \Fincallorca\DateTimeBundle\Component\DateTimeImmutable::current()} instead. This function will be removed in v2.0.
     *
     * @todo remove in v2.0
     */
    public static function today()
    {
        return static::current();
    }

    /**
     * Returns the current server time.
     *
     * @return static
     *
     * @throws Exception
     *
     * @deprecated Please use {@see \Fincallorca\DateTimeBundle\Component\DateTimeImmutable::current()} instead. This function will be removed in v2.0.
     *
     * @todo remove in v2.0
     */
    public static function currentDateTime()
    {
        return static::current();
    }

    /**
     * Changes the timezone to the server's timezone.
     *
     * @return static
     */
    public function toServerDateTime()
    {
        return $this->setTimezone(DateTimeKernel::getTimeZoneServer());
    }

    /**
     * Changes the timezone to the database's timezone.
     *
     * @return static
     */
    public function toDatabaseDateTime()
    {
        return $this->setTimezone(DateTimeKernel::getTimeZoneDatabase());
    }

    /**
     * Changes the timezone to the client's timezone.
     *
     * @return static
     */
    public function toClientDateTime()
    {
        return $this->setTimezone(DateTimeKernel::getTimeZoneClient());
    }

}
