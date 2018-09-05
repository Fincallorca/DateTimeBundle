<?php

namespace Fincallorca\DateTimeBundle\Component;

/**
 * Class DateTime
 *
 * @package Fincallorca\DateTimeBundle
 */
class DateTime extends \DateTime
{
	/**
	 * @var static|null
	 */
	protected static $today = null;

	/**
	 * Returns the server time of today.
	 *
	 * @return static
	 */
	public static function today()
	{
		if( is_null(self::$today) )
		{
			self::$today = self::currentDateTime()->toServerDateTime();
		}

		return self::$today;
	}

	/**
	 * Returns the current server time.
	 *
	 * @return static
	 */
	public static function currentDateTime()
	{
		$date_time = static::createFromFormat('U.u', sprintf('%.6F', microtime(true)));
		return $date_time->toServerDateTime();
	}

	/**
	 * Parses a string into a new DateTime object according to the specified format.
	 *
	 * @param string             $format Format accepted by date().
	 * @param string             $time   String representing the time.
	 * @param \DateTimeZone|null $object [optional] A DateTimeZone object representing the desired time zone.
	 *
	 * @return static|boolean
	 *
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
	 * Copies and casts the submitted datetime object to a new DateTime object.
	 *
	 * @param \DateTimeInterface $dateTime the source object
	 *
	 * @return false|static
	 */
	public static function createFromObject($dateTime)
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
	 * Returns a new DateTime object.
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
    public function duplicate()
    {
        return clone $this;
    }

	/**
	 * @return integer
	 */
	protected function getAbsoluteMonths()
	{
		return intval($this->format('Y')) * 12 + intval($this->format('m'));
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
	 * Adds an amount of months to the current date.
	 *
	 * **ATTENTION**: If the current date is the 31/30/29 and the target month has less days then the current month, the day will be set to the last
	 * day of the target month.
	 *
	 * Example: Current date is '2017-01-30 17:00:00' and you want to add '1 month', then the result will be '2017-02-28 17:00:00'.
	 *
	 * @param integer $month
	 *
	 * @return false|static
	 */
	public function addMonth($month)
	{
		$absolute_months = $this->getAbsoluteMonths();

		$this->add(\DateInterval::createFromDateString(sprintf('%d month', $month)));

		if( $absolute_months + $month !== $this->getAbsoluteMonths() )
		{
			$this->subDays((int) $this->format('d'));
		}

		return $this;
	}

	/**
	 * Subs an amount of months from the current date.
	 *
	 * **ATTENTION**: If the current date is the 31/30/29 and the target month has less days then the current month, the day will be set to the last
	 * day of the target month.
	 *
	 * Example: Current date is '2017-03-31 17:00:00' and you want to sub '1 month', then the result will be '2017-02-28 17:00:00'.
	 *
	 * @param int $month
	 *
	 * @return false|static
	 */
	public function subMonth($month)
	{
		$absolute_months = $this->getAbsoluteMonths();

		$this->sub(\DateInterval::createFromDateString(sprintf('%d month', $month)));

		if( $absolute_months - $month !== $this->getAbsoluteMonths() )
		{
			$this->subDays((int) $this->format('d'));
		}

		return $this;
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

	/**
	 * @return false|static
	 */
	public function toStartOfMonth()
	{
		return $this->setDate($this->format('Y'), $this->format('m'), 1)->toStartOfDay();
	}

	/**
	 * @return false|static
	 */
	public function toEndOfMonth()
	{
		return $this->setDate($this->format('Y'), $this->format('m'), $this->format('t'))->toEndOfDay();
	}

}