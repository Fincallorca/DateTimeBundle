<?php

namespace Fincallorca\DateTimeBundle\Component;

/**
 * Class DateTimeImmutable
 *
 * @package Fincallorca\DateTimeBundle
 */
class DateTimeImmutable extends \DateTimeImmutable
{

	/**
	 * Returns the current server timestamp.
	 *
	 * @return static
	 */
	public static function currentDateTime()
	{
		$date_time = static::createFromFormat('U.u', sprintf('%.6F', microtime(true)));
		return $date_time->toServerDateTime();
	}

	/**
	 * Copies and casts the submitted datetime object to a new DateTimeImmutable object.
	 *
	 * @param \DateTimeInterface $dateTime the source object
	 *
	 * @return false|static
	 */
	public static function createFromObject(\DateTimeInterface $dateTime)
	{
		if( is_object($dateTime) )
		{
			$class_name = static::class;

			$parts      = explode(':', serialize($dateTime));
			$parts[ 1 ] = strlen($class_name);
			$parts[ 2 ] = sprintf('"%s"', $class_name);

			return unserialize(implode(':', $parts));
		}

		return new static($dateTime);
	}

	/**
	 * Parses a string into a new DateTimeImmutable object according to the specified format.
	 *
	 * @param string        $format Format accepted by date().
	 * @param string        $time   String representing the time.
	 * @param \DateTimeZone $object A DateTimeZone object representing the desired time zone.
	 *
	 * @return static|boolean
	 * @link http://php.net/manual/en/datetime.createfromformat.php
	 */
	public static function createFromFormat($format, $time, $object = null)
	{
		$datetime = is_null($object) ?
			parent::createFromFormat($format, $time) :
			parent::createFromFormat($format, $time, $object);

		if( !is_object($datetime) )
		{
			throw new \InvalidArgumentException('Invalid arguments for createFromFormat().');
		}

		return static::createFromObject($datetime);
	}

	/**
	 * Returns a new DateTimeImmutable object.
	 *
	 * @param string $time
	 * @param null   $timezone
	 *
	 * @return false|static
	 */
	public static function create($time = 'now', $timezone = null)
	{
		return new static($time, $timezone);
	}

	/**
	 * @return static
	 */
	public function toServerDateTime()
	{
		return $this->setTimezone(DateTimeKernel::getTimeZoneServer());
	}

	/**
	 * @return static
	 */
	public function toDatabaseDateTime()
	{
		return $this->setTimezone(DateTimeKernel::getTimeZoneDatabase());
	}

	/**
	 * @return static
	 */
	public function toClientDateTime()
	{
		return $this->setTimezone(DateTimeKernel::getTimeZoneClient());
	}

	/**
	 * @param integer $hours
	 *
	 * @return static
	 */
	public function addHours($hours)
	{
		return $this->add(\DateInterval::createFromDateString(sprintf('%d hour', $hours)));
	}

	/**
	 * @param integer $hours
	 *
	 * @return static
	 */
	public function subHours($hours)
	{
		return $this->addHours(0 - $hours);
	}

	/**
	 * @param integer $days
	 *
	 * @return static
	 */
	public function addDays($days)
	{
		return $this->add(\DateInterval::createFromDateString(sprintf('%d day', $days)));
	}

	/**
	 * @param integer $days
	 *
	 * @return static
	 */
	public function subDays($days)
	{
		return $this->addDays(0 - $days);
	}

	/**
	 * @return false|static
	 */
	public function toEndOfDay()
	{
		return $this->setTime(23, 59, 59);
	}

	/**
	 * @return false|static
	 */
	public function toStartOfDay()
	{
		return $this->setTime(0, 0, 0);
	}

}
