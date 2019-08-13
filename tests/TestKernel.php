<?php

namespace Fincallorca\DateTimeBundle\Test;

use DateTimeInterface;
use Exception;
use Fincallorca\DateTimeBundle\Component\DateTimeImmutable;
use Fincallorca\DateTimeBundle\DateTimeBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel
{
    /**
     * @var EventDispatcherInterface
     **/
    protected $dispatcher = null;

    /**
     * @var DateTimeImmutable
     */
    protected static $dateTime = null;

    /**
     * @var mixed[]
     */
    protected $dateTimeConfig = null;

    /**
     * @return DateTimeInterface
     *
     * @throws Exception
     */
    protected static function getDateTime(): DateTimeInterface
    {
        if( is_null(self::$dateTime) )
        {
            self::$dateTime = DateTimeImmutable::current();
        }

        return self::$dateTime;
    }

    /**
     * TestKernel constructor.
     *
     * {@inheritDoc}
     *
     * @param array $dateTimeConfig
     *
     */
    public function __construct(string $environment, bool $debug, array $dateTimeConfig = array())
    {
        $this->dateTimeConfig = $dateTimeConfig;

        $this->dispatcher = new EventDispatcher();

        parent::__construct($environment, $debug);
    }

    /**
     * {@inheritDoc}
     */
    public function registerBundles()
    {
        if( $this->getEnvironment() === 'test' )
        {
            yield new DateTimeBundle();
        }
    }

    /**
     * {@inheritDoc}
     *
     * @throws Exception
     */
    public function getCacheDir()
    {
        return sprintf('%s/var/cache/%s/%s', $this->getProjectDir(), self::getDateTime()->format('Y-m-d\TH:i:s.u'), $this->environment);
    }

    /**
     * {@inheritDoc}
     */
    public function getLogDir()
    {
        return $this->getProjectDir() . '/var/logs';
    }

    /**
     * {@inheritDoc}
     *
     * @throws Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(function (ContainerBuilder $container) {
            $container->loadFromExtension('datetime', $this->dateTimeConfig);
        });
    }

//    /**
//     * {@inheritdoc}
//     */
//    public function boot()
//    {
//        parent::boot();
//        $this->dispatchKernelRequestEvent();
//    }
//
//    /**
//     * @throws DBALException
//     */
//    protected function dispatchKernelRequestEvent()
//    {

//    }
}