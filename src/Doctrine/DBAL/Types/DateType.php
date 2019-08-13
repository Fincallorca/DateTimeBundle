<?php

declare( strict_types=1 );

namespace Fincallorca\DateTimeBundle\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Exception;

/**
 * Class DateType
 *
 * The {@see \Fincallorca\DateTimeBundle\Doctrine\DBAL\Types\DateType} and {@see \Fincallorca\DateTimeBundle\Doctrine\DBAL\Types::DateKey} classes are responsible to
 * use `date` columns in sql as a primary key.
 *
 * @package Fincallorca\DateTimeBundle
 *
 * @link    http://stackoverflow.com/a/27138667/4351778
 */
class DateType extends \Doctrine\DBAL\Types\DateType
{
    /**
     * {@inheritdoc}
     *
     * @throws ConversionException
     * @throws Exception
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        // convert to doctrine's datetype type
        $value = parent::convertToPHPValue($value, $platform);

        // and afterwards convert to custom type datekey
        if( !is_null($value) )
        {
            $value = DateKey::FromDateTime($value);
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'DateKey';
    }

}