<?php

namespace Fincallorca\DateTimeBundle\Component;

use Fincallorca\DateTimeBundle\Service\DateTimeZoneService;

/**
 * Trait DateTimeZoneServiceContainer
 *
 * @package Fincallorca\DateTimeBundle
 */
trait DateTimeZoneServiceContainer
{
	/**
	 * @var DateTimeZoneService
	 */
	protected static $DateTimeZoneService = null;

	/**
	 * @param DateTimeZoneService $date_time_zone_service
	 *
	 * @return \DateTimeZone
	 */
	public static function SetDateTimeZoneService(DateTimeZoneService $date_time_zone_service)
	{
		self::$DateTimeZoneService = $date_time_zone_service;
	}
}
