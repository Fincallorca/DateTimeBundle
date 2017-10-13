<?php

namespace Fincallorca\DateTimeBundle\DependencyInjection;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;

/**
 *
 * @package Fincallorca\DateTimeBundle
 * @link    http://symfony.com/doc/current/bundles/extension.html
 */
class DateTimeBundleExtension extends Extension
{

	/**
	 * @inheritdoc
	 */
	public function getAlias()
	{
		return 'datetime';
	}

	/**
	 * @inheritdoc
	 */
	public function load(array $configs, ContainerBuilder $container)
	{
		/** @var LoaderInterface $loader */
		$loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
		$loader->load('services.yml');

		$configuration = new Configuration();
		$config        = $this->processConfiguration($configuration, $configs);

		$container->setParameter('datetime.server', date_default_timezone_get());

		$container->setParameter('datetime.database', empty($config[ 'database' ]) ?
			$container->getParameter('datetime.server') : $config[ 'database' ]
		);

		$container->setParameter('datetime.client', empty($config[ 'client' ]) ?
			$container->getParameter('datetime.server') : $config[ 'client' ]
		);
	}

}