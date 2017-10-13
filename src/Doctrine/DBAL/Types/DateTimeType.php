<?php

namespace Fincallorca\DateTimeBundle\Doctrine\DBAL\Types;

use Fincallorca\DateTimeBundle\Component\DateTime;
use Fincallorca\DateTimeBundle\Component\DateTimeZoneServiceContainer;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeType as BaseDateTimeType;

/**
 * Class UTCDateTimeType is used to save all datetime values in database as UTC.
 *
 * @package Fincallorca\DateTimeBundle
 * @link    http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/cookbook/working-with-datetime.html
 */
class DateTimeType extends BaseDateTimeType
{
	use DateTimeZoneServiceContainer;

	/**
	 * {@inheritdoc}
	 */
	public function convertToDatabaseValue($value, AbstractPlatform $platform)
	{
		if( $value instanceof \DateTime )
		{
			$value = DateTime::createFromObject($value);
		}

		if( $value instanceof DateTime )
		{
			$value->toDatabaseDateTime();
		}

		return parent::convertToDatabaseValue($value, $platform);
	}

	/**
	 * {@inheritdoc}
	 */
	public function convertToPHPValue($value, AbstractPlatform $platform)
	{
		if( null === $value || $value instanceof \DateTime )
		{
			return $value;
		}

		$converted = DateTime::createFromFormat(
			$platform->getDateTimeFormatString(),
			$value,
			self::$DateTimeZoneService->getDateTimeZoneDatabase()
		)->toServerDateTime();

		if( !$converted )
		{
			throw ConversionException::conversionFailedFormat(
				$value,
				$this->getName(),
				$platform->getDateTimeFormatString()
			);
		}

		return $converted;
	}
}