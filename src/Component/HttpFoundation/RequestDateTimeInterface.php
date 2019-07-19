<?php

declare( strict_types=1 );

namespace Fincallorca\DateTimeBundle\Component\HttpFoundation;

use Fincallorca\DateTimeBundle\Component\DateTimeImmutable;

/**
 * Interface RequestDateTimeInterface
 *
 * @package Fincallorca\DateTimeBundle
 */
interface RequestDateTimeInterface
{
    /**
     * Initializes the request timestamp (and datetime) and returns `true` if the time was fetched from
     * server variables (*REQUEST_TIME_FLOAT* or *REQUEST_TIME*), else `false`.
     *
     * @return boolean
     */
    public function isTimeStampFromRequest(): bool;

    /**
     * Returns the timestamp of the request.
     *
     * @return float|integer
     */
    public function getTimeStamp();

    /**
     * Returns the timestamp as an immutable datetime object. Always in UTC!
     *
     * @return DateTimeImmutable
     */
    public function getDateTime(): DateTimeImmutable;

}
