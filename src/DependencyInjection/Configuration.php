<?php

declare( strict_types=1 );

namespace Fincallorca\DateTimeBundle\DependencyInjection;

use DateTimeZone;
use Fincallorca\DateTimeBundle\Component\DateTimeZoneContainer;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Fincallorca\DateTimeBundle
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('datetime');

        // @formatter:off
        $treeBuilder->getRootNode()
            ->info('DateTime Bundle Configuration')
            ->children()
                ->scalarNode('database')
                    ->info('The timezone of the datetime values which are saved and will be saved in the database. If empty, the server timezone (see `date_default_timezone_get`) wil be choosen.')
                    ->defaultNull()
                    ->cannotBeEmpty()
                    ->validate()
                        ->ifTrue(function ($_value) { return $this->isInvalidTimezone($_value); })
                        ->thenInvalid('Invalid timezone "%s" for config parameter "datetime.client" set. Please check https://www.php.net/manual/en/timezones.america.php.')
                    ->end()
                ->end()
                ->scalarNode('client')
                    ->info('The timezone of the client. If not set, the value of `date_default_timezone_get` will be chosen.')
                    ->defaultNull()
                    ->cannotBeEmpty()
                    ->validate()
                        ->ifTrue(function ($_value) { return $this->isInvalidTimezone($_value); })
                        ->thenInvalid('Invalid timezone "%s" for config parameter "datetime.client" set. Please check https://www.php.net/manual/en/timezones.america.php.')
                    ->end()
                ->end()
            ->end();
        // @formatter:on

        return $treeBuilder;
    }

    /**
     * Returns `true` if the submitted string is *not* a valid timezone, else `false`.
     *
     * @param string|null $timezoneName
     *
     * @return boolean
     *
     * @link http://us.php.net/manual/en/timezones.others.php
     *
     */
    protected function isInvalidTimezone(?string $timezoneName): bool
    {
        return is_null($timezoneName) ? false : ( !DateTimeZoneContainer::isValidTimezone($timezoneName) );
    }
}
