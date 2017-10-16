<?php

namespace Fincallorca\DateTimeBundle\Component;

/**
 * Class DateTime
 *
 * @package Fincallorca\DateTimeBundle
 */
class DateTime extends \DateTime
{
	use DateTimeZoneServiceContainer;

	/**
	 * Returns the current server timestamp.
	 *
	 * @return DateTime
	 */
	public static function currentDateTime()
	{
		$date_time = static::createFromFormat('U.u', sprintf('%.6F', microtime(true)));
		return $date_time->toServerDateTime();
	}

	/**
	 * Copies and casts the submitted datetime object to a new datetime object.
	 *
	 * To keep the copy as a clone (like {@see clone()} does), submit the additional parameter `$keep_class`.
	 *
	 * @param \DateTime $date_time  the source object
	 * @param boolean   $keep_class `false` to cast the copy as {@see \Fincallorca\DateTimeBundle\DateTime} object, `true` to keep the origin class,
	 *                              default is `false`
	 *
	 * @return false|static
	 */
	public static function createFromObject(\DateTime $date_time, $keep_class = false)
	{
		if( is_object($date_time) )
		{
			$class_name = $keep_class ? get_class($date_time) : static::class;

			$parts      = explode(':', serialize($date_time));
			$parts[ 1 ] = strlen($class_name);
			$parts[ 2 ] = sprintf('"%s"', $class_name);

			return unserialize(implode(':', $parts));
		}

		return new static($date_time);
	}

	/**
	 * Parses a string into a new DateTime object according to the specified format.
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
	 * Copies and casts the submitted datetime object to a new datetime object.
	 *
	 * To keep the copy as a clone (like {@see clone()} does), submit the additional parameter `$keep_class`.
	 *
	 * @param boolean $keep_class `false` to cast the copy as {@see \Fincallorca\DateTimeBundle\DateTime} object, `true` to keep the origin class,
	 *                            default is `false`
	 *
	 * @return static
	 */
	public function duplicate($keep_class = false)
	{
		return self::createFromObject($this, $keep_class);
	}

	/**
	 * @return static
	 */
	public function toServerDateTime()
	{
		$this->setTimezone(self::$DateTimeZoneService->getDateTimeZoneServer());
		return $this;
	}

	/**
	 * @return static
	 */
	public function toDatabaseDateTime()
	{
		$this->setTimezone(self::$DateTimeZoneService->getDateTimeZoneDatabase());
		return $this;
	}

	/**
	 * @return static
	 */
	public function toClientDateTime()
	{
		$this->setTimezone(self::$DateTimeZoneService->getDateTimeZoneClient());
		return $this;
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
