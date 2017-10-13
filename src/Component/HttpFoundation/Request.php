<?php

namespace Fincallorca\DateTimeBundle\Component\HttpFoundation;

use Fincallorca\DateTimeBundle\Component\DateTime;
use Fincallorca\DateTimeBundle\Component\DateTimeZoneServiceContainer;
use Symfony\Component\HttpFoundation\Request as BaseRequest;

/**
 * Class Request
 *
 * @package Fincallorca\DateTimeBundle
 */
class Request extends BaseRequest
{

	use DateTimeZoneServiceContainer;

	/**
	 * all used timezones to avoid multiple instantiations
	 *
	 * the key is the label of the timezone, i.e. `'UTC'`
	 *
	 * @var \DateTimeZone[]
	 */
	protected $dateTimeZone = array();

	/**
	 * the datetime objects of the current request,
	 * as array to provide datetime objects in multiple time zones
	 *
	 * the key is the label of the timezone, i.e. `'UTC'`
	 *
	 * @var DateTime[]
	 */
	protected $dateTime = array();

	/**
	 *
	 * @return integer
	 */
	public function getTimestamp()
	{
		return $this->server->get('REQUEST_TIME');
	}

	/**
	 * @param string $timezone
	 *
	 * @return \DateTimeZone
	 */
	protected function getDateTimeZone($timezone)
	{
		if( !array_key_exists($timezone, $this->dateTimeZone) )
		{
			$this->dateTimeZone[ $timezone ] = new \DateTimeZone($timezone);
		}

		return $this->dateTimeZone[ $timezone ];
	}

	/**
	 * @param string|null $timezone
	 *
	 * @return \DateTime
	 */
	public function getDateTime($timezone = null)
	{
		if( is_null($timezone) )
		{
			$timezone = self::$DateTimeZoneService->getDateTimeZoneServer()->getName();
		}

		if( !array_key_exists($timezone, $this->dateTime) )
		{
			$this->dateTime[ $timezone ] = DateTime::createFromFormat('U', $this->getTimestamp())->setTimezone($this->getDateTimeZone($timezone));
		}

		return $this->dateTime[ $timezone ];
	}
}
