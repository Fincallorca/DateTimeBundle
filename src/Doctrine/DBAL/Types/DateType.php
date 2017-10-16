<?php

namespace Fincallorca\DateTimeBundle\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Class DateType
 *
 * The {@see \Fincallorca\DateTimeBundle\Doctrine\DBAL\Types\DateType} and {@see \Fincallorca\DateTimeBundle\Doctrine\DBAL\Types::DateKey} classes are responsible to
 * use `date` columns in sql as a primary key.
 *
 * @package Fincallorca\DateTimeBundle
 * @link    http://stackoverflow.com/a/27138667/4351778
 */
class DateType extends \Doctrine\DBAL\Types\DateType
{
	/**
	 * {@inheritdoc}
	 */
	public function convertToPHPValue($value, AbstractPlatform $platform)
	{
		$value = parent::convertToPHPValue($value, $platform);
		if( $value !== null )
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