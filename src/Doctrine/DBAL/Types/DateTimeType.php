<?php

declare( strict_types=1 );

namespace Fincallorca\DateTimeBundle\Doctrine\DBAL\Types;

use Exception;
use Fincallorca\DateTimeBundle\Component\DateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeType as BaseDateTimeType;
use Fincallorca\DateTimeBundle\Component\DateTimeKernel;

/**
 * Class UTCDateTimeType is used to save all datetime values in database as UTC.
 *
 * @package Fincallorca\DateTimeBundle
 *
 * @link    http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/cookbook/working-with-datetime.html
 */
class DateTimeType extends BaseDateTimeType
{

    /**
     * {@inheritdoc}
     *
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        // create a Fincallorca DateTime object (if i.e. a \DateTime was submitted)
        if( !$value instanceof DateTime )
        {
            $value = DateTime::createFromObject($value);
        }

        // convert to database date time zone
        if( $value instanceof DateTime )
        {
            $value->toDatabaseDateTime();
        }

        return parent::convertToDatabaseValue($value, $platform);
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        // return null value
        if( is_null($value) )
        {
            return $value;
        }

        // return already converted value
        if( $value instanceof DateTime )
        {
            return $value;
        }

        // if value is a datetime but not a Fincallorca DateTime object
        // return the object as a Fincallorca DateTime object
        if( $value instanceof \DateTime )
        {
            return DateTime::createFromObject($value);
        }

        // convert value to a DateTime object
        $converted = DateTime::createFromFormat(
            $platform->getDateTimeFormatString(),
            $value,
            DateTimeKernel::getTimeZoneDatabase()
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