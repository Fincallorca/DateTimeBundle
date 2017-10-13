<?php

namespace Fincallorca\DateTimeBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class DateTimeZoneService
 *
 * @package Fincallorca\DateTimeBundle
 */
class DateTimeZoneService
{

	/**
	 * ATTENTION: Do not access this variable directly, use {@see \Fincallorca\DateTimeBundle\Component\DateTime::GetDateTimeZoneServer()} instead
	 *
	 * @var \DateTimeZone
	 */
	protected $dateTimeZoneServer = null;

	/**
	 * ATTENTION: Do not access this variable directly, use {@see \Fincallorca\DateTimeBundle\Component\DateTime::GetDateTimeZoneDatabase()} instead
	 *
	 * @var \DateTimeZone
	 */
	protected $dateTimeZoneDatabase = null;

	/**
	 * ATTENTION: Do not access this variable directly, use {@see \Fincallorca\DateTimeBundle\Component\DateTime::GetDateTimeZoneClient()} instead
	 *
	 * @var \DateTimeZone
	 */
	protected $dateTimeZoneClient = null;

	/**
	 * {@inheritdoc}
	 */
	public function __construct(ContainerInterface $container = null)
	{
		$this->dateTimeZoneServer   = new \DateTimeZone($container->getParameter('datetime.server'));
		$this->dateTimeZoneDatabase = new \DateTimeZone($container->getParameter('datetime.database'));
		$this->dateTimeZoneClient   = new \DateTimeZone($container->getParameter('datetime.client'));
	}

	/**
	 *
	 * @return \DateTimeZone
	 */
	public function getDateTimeZoneServer()
	{
		return $this->dateTimeZoneServer;
	}

	/**
	 *
	 * @return \DateTimeZone
	 */
	public function getDateTimeZoneDatabase()
	{
		return $this->dateTimeZoneDatabase;
	}

	/**
	 * @return \DateTimeZone
	 */
	public function getDateTimeZoneClient()
	{
		return $this->getDateTimeZoneClient();
	}
}
