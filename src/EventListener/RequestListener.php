<?php

namespace Fincallorca\DateTimeBundle\EventListener;

use Fincallorca\DateTimeBundle\Component\DateTime;
use Fincallorca\DateTimeBundle\Component\DateTimeZoneServiceContainer;
use Fincallorca\DateTimeBundle\Component\HttpFoundation\Request;
use Fincallorca\DateTimeBundle\Doctrine\DBAL\Types\DateTimeType;
use Fincallorca\DateTimeBundle\Doctrine\DBAL\Types\DateType;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class RequestListener
 *
 * @package Fincallorca\DateTimeBundle
 */
class RequestListener
{
	use DateTimeZoneServiceContainer;

	public function onKernelRequest(GetResponseEvent $event)
	{
		if( $event->isMasterRequest() )
		{
			Request::SetDateTimeZoneService(self::$DateTimeZoneService);
			DateTimeType::SetDateTimeZoneService(self::$DateTimeZoneService);
			DateTime::SetDateTimeZoneService(self::$DateTimeZoneService);

			// save all datetime objects in the configured time zone,
			// see {@link http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/cookbook/working-with-datetime.html}
			Type::overrideType('datetime', DateTimeType::class);
			Type::overrideType('datetimetz', DateTimeType::class);

			// use type `date` as primary key {@link http://stackoverflow.com/a/27138667/4351778}
			Type::overrideType('date', DateType::class);
		}
	}
}
