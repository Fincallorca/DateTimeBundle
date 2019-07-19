<?php

declare( strict_types=1 );

namespace Fincallorca\DateTimeBundle\Component\HttpFoundation;

use Exception;
use Fincallorca\DateTimeBundle\Component\DateTimeImmutable;
use Symfony\Component\HttpFoundation\Request as BaseRequest;

/**
 * Class Request
 *
 * @package Fincallorca\DateTimeBundle
 */
class Request extends BaseRequest implements RequestDateTimeInterface
{
    /**
     * the request's timestamp
     *
     * @var integer|float
     */
    protected $timeStamp = null;

    /**
     * `true` if the time was fetched from server variables (*REQUEST_TIME_FLOAT* or *REQUEST_TIME*), else `false`
     *
     * @var boolean
     */
    protected $timeStampFromRequest = false;

    /**
     * the timestamp as an immutable datetime object
     *
     * @var DateTimeImmutable
     */
    protected $dateTime = null;

    /**
     * {@inheritdoc}
     */
    public function getTimeStamp()
    {
        if( !is_null($this->timeStamp) )
        {
            return $this->timeStamp;
        }

        if( $this->server->has('REQUEST_TIME_FLOAT') )
        {
            $this->timeStamp            = (int) $this->server->get('REQUEST_TIME_FLOAT');
            $this->timeStampFromRequest = true;
        }
        elseif( $this->server->has('REQUEST_TIME') )
        {
            $this->timeStamp            = (int) $this->server->get('REQUEST_TIME');
            $this->timeStampFromRequest = true;
        }
        else
        {
            $this->timeStamp = time();
        }

        return $this->timeStamp;
    }

    /**
     * {@inheritdoc}
     */
    public function isTimeStampFromRequest(): bool
    {
        $this->getTimeStamp();

        return $this->timeStampFromRequest;
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function getDateTime(): DateTimeImmutable
    {
        if( !is_null($this->dateTime) )
        {
            return $this->dateTime;
        }

        $this->dateTime = false;

        if( $this->timeStampFromRequest )
        {
            $this->dateTime = is_float($this->server->get('REQUEST_TIME_FLOAT')) ?
                DateTimeImmutable::createFromFormat('U.u', sprintf('%.6f', $this->server->get('REQUEST_TIME_FLOAT'))) :
                DateTimeImmutable::create(sprintf("@%d", $this->server->get('REQUEST_TIME')));
        }

        if( $this->dateTime === false )
        {
            $this->dateTime = new DateTimeImmutable('now', new \DateTimeZone('+00:00'));
        }

        return $this->dateTime;
    }

}
