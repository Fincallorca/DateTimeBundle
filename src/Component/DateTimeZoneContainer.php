<?php

namespace Fincallorca\DateTimeBundle\Component;

/**
 * Class DateTimeZoneContainer
 *
 * @package Fincallorca\DateTimeBundle
 */
trait DateTimeZoneContainer
{

	/**
	 * @var \DateTimeZone[]
	 */
	protected static $timeZonesServer = array();

	/**
	 * @var \DateTimeZone
	 */
	protected static $timeZoneDatabase = null;

	/**
	 * @var \DateTimeZone
	 */
	protected static $timeZoneClient = null;

	/**
	 *
	 * @return \DateTimeZone
	 */
	public static function getTimeZoneServer()
	{
		$timezoneKey = crc32(date_default_timezone_get());

		if( array_key_exists($timezoneKey, self::$timeZonesServer) )
		{
			return self::$timeZonesServer[ $timezoneKey ];
		}

		self::$timeZonesServer[ $timezoneKey ] = new \DateTimeZone(date_default_timezone_get());

		return self::$timeZonesServer[ $timezoneKey ];
	}

	/**
	 *
	 * @return \DateTimeZone
	 */
	public static function getTimeZoneDatabase()
	{
		return self::$timeZoneDatabase;
	}

	/**
	 * @param \DateTimeZone $dateTimeZoneDatabase
	 */
	public static function setTimeZoneDatabase($dateTimeZoneDatabase)
	{
		self::$timeZoneDatabase = $dateTimeZoneDatabase;
	}

	/**
	 * @return \DateTimeZone
	 */
	public static function getTimeZoneClient()
	{
		return self::$timeZoneClient;
	}

	/**
	 * @param \DateTimeZone $dateTimeZoneClient
	 */
	public static function setTimeZoneClient($dateTimeZoneClient)
	{
		self::$timeZoneClient = $dateTimeZoneClient;
	}
}