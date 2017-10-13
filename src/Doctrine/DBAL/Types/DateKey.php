<?php

namespace Fincallorca\DateTimeBundle\Doctrine\DBAL\Types;

/**
 * Class DateKey
 *
 * The {@see \Fincallorca\DateTimeBundle\Doctrine\DBAL\Types\DateType} and {@see \Fincallorca\DateTimeBundle\Doctrine\DBAL\Types::DateKey} classes
 * are responsible to use `date` columns in sql as a primary key.
 *
 * @package Fincallorca\DateTimeBundle
 * @link    http://stackoverflow.com/a/27138667/4351778
 */
class DateKey extends \DateTime
{

	/**
	 * @param \DateTime $date_time
	 *
	 * @return static
	 */
	public static function FromDateTime($date_time)
	{
		return new static($date_time->format('Y-m-d'));
	}

	/**
	 * This method returns the date object in a way to use it as a key.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->format('Y-m-d');
	}

}