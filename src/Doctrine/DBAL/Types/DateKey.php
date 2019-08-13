<?php

declare(strict_types=1);

namespace Fincallorca\DateTimeBundle\Doctrine\DBAL\Types;

use DateTimeInterface;
use Exception;
use Fincallorca\DateTimeBundle\Component\DateTime;
use Fincallorca\DateTimeBundle\Component\DateTimeKernel;

/**
 * Class DateKey
 *
 * The {@see \Fincallorca\DateTimeBundle\Doctrine\DBAL\Types\DateType} and {@see \Fincallorca\DateTimeBundle\Doctrine\DBAL\Types::DateKey} classes
 * are responsible to use `date` columns in sql as a primary key.
 *
 * @package Fincallorca\DateTimeBundle
 * @link    http://stackoverflow.com/a/27138667/4351778
 */
class DateKey extends DateTime
{
    /**
     * @param DateTimeInterface $dateTime
     *
     * @return static
     *
     * @throws Exception
     */
    public static function FromDateTime(DateTimeInterface $dateTime): DateKey
    {
        return new static($dateTime->format('Y-m-d'), DateTimeKernel::getTimeZoneDatabase());
    }

    /**
     * This method returns the date object in a way to use it as a key.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->format('Y-m-d');
    }

}