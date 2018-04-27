<?php

namespace Fincallorca\DateTimeBundle\EventListener;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Types\Type;
use Fincallorca\DateTimeBundle\Component\DateTimeImmutable;
use Fincallorca\DateTimeBundle\Component\DateTimeKernel;
use Fincallorca\DateTimeBundle\Component\HttpFoundation\RequestDateTimeInterface;
use Fincallorca\DateTimeBundle\Doctrine\DBAL\Types\DateTimeType;
use Fincallorca\DateTimeBundle\Doctrine\DBAL\Types\DateType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class DateTimeListener
 *
 * @package Fincallorca\DateTimeBundle
 */
class Initializer
{
	/**
	 * the container is used to get current datetime from the Kernel or the current request
	 *
	 * @var ContainerInterface
	 */
	protected $container;

	/**
	 * DateTimeListener constructor.
	 *
	 * @param ContainerInterface $container
	 *
	 * @throws DBALException
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;

		$this->initializeOverrides();
	}

	/**
	 * @throws DBALException
	 */
	protected function initializeOverrides()
	{
		// save all datetime objects in the configured time zone,
		// see {@link http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/cookbook/working-with-datetime.html}
		Type::overrideType('datetime', DateTimeType::class);
		Type::overrideType('datetimetz', DateTimeType::class);

		// use type `date` as primary key {@link http://stackoverflow.com/a/27138667/4351778}
		Type::overrideType('date', DateType::class);
	}

	/**
	 * Public method called
	 * - before controller action and
	 * - before console command.
	 *
	 */
	public function updateDateTimeKernel()
	{
		$this->updateKernelTimeZones();

		if( !$this->updateKernelDateTime() )
		{
			throw new \RuntimeException('Unable to initialize the DateTimeKernel object.');
		}
	}

	/**
	 * Updates the timezones.
	 */
	protected function updateKernelTimeZones()
	{
		DateTimeKernel::setTimeZoneDatabase(new \DateTimeZone($this->container->getParameter('datetime.database')));
		DateTimeKernel::setTimeZoneClient(new \DateTimeZone($this->container->getParameter('datetime.client')));
	}

	/**
	 * Prerequisites: Method {@see \Fincallorca\DateTimeBundle\EventListener::updateKernelTimeZones()} must be called before.
	 *
	 * @return boolean
	 */
	protected function updateKernelDateTime()
	{
		return $this->updateKernelDateTimeByRequestTime() || $this->updateKernelDateTimeByKernelStartTime() || $this->updateKernelDateTimeByCurrentServerTime();
	}

	/**
	 * @return boolean
	 */
	protected function updateKernelDateTimeByRequestTime()
	{
		$datetime = false;

		/** @var RequestStack $requestStack */
		$requestStack = $this->container->get('request_stack');

		if( !is_null($requestStack) && !is_null($requestStack->getMasterRequest()) )
		{
			$request = $requestStack->getMasterRequest();

			if( $request instanceof RequestDateTimeInterface && $request->isTimeStampFromRequest() )
			{
				$datetime = $request->getDateTime();
			}
			elseif( is_numeric($request->server->get('REQUEST_TIME_FLOAT')) )
			{
				$datetime = DateTimeImmutable::createFromFormat('U.u', $request->server->get('REQUEST_TIME_FLOAT'));
			}
			elseif( is_numeric($request->server->get('REQUEST_TIME')) )
			{
				$datetime = DateTimeImmutable::create(sprintf("@%d", $request->server->get('REQUEST_TIME')));
			}
		}

		if( $datetime !== false )
		{
			DateTimeKernel::setDateTimeServer($datetime);

			return true;
		}

		return false;
	}

	/**
	 * @return boolean
	 */
	protected function updateKernelDateTimeByKernelStartTime()
	{
		$datetime = false;

		/** @var KernelInterface $kernel */
		$kernel = $this->container->get('kernel');

		if( !is_null($kernel) && is_numeric($kernel->getStartTime()) )
		{
			$datetime = DateTimeImmutable::create(sprintf("@%d", $kernel->getStartTime()));
		}

		if( $datetime !== false )
		{
			DateTimeKernel::setDateTimeServer($datetime);

			return true;
		}

		return false;
	}


	/**
	 * @return boolean
	 */
	protected function updateKernelDateTimeByCurrentServerTime()
	{
		$datetime = DateTimeImmutable::create('now', new \DateTimeZone('+00:00'));

		if( $datetime !== false )
		{
			DateTimeKernel::setDateTimeServer($datetime);

			return true;
		}

		return false;
	}
}