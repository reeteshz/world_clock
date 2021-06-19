<?php

namespace Drupal\world_clock\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\world_clock\CurrentTimeAtLocation;
use Drupal\Core\Config\ConfigFactory;

/**
 * Provides a 'World Clock Block' Block.
 *
 * @Block(
 *   id = "world_clock_block",
 *   admin_label = @Translation("World Clock"),
 *   category = @Translation("World Clock"),
 * )
 */
class WorldClockBlock extends BlockBase  implements ContainerFactoryPluginInterface{
  
    /**
     * @var $account \Drupal\Core\Session\AccountProxyInterface
     */
    protected $CurrentTimeAtLocation;
    protected $ConfigFactory;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param array $configuration
     * @param string $plugin_id
     * @param mixed $plugin_definition
     *
     * @return static
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
        $configuration,
        $plugin_id,
        $plugin_definition,
        $container->get('world_clock.current_time_at_location'),
        $container->get('config.factory'),
    );
    }

    /**
     * @param array $configuration
     * @param string $plugin_id
     * @param mixed $plugin_definition
     * @param Drupal\world_clock\CurrentTimeAtLocation $currentTime
     * @param Drupal\Core\Config\ConfigFactory $ConfigFactory
     */
    public function __construct(array $configuration, $plugin_id, $plugin_definition, CurrentTimeAtLocation $CurrentTimeAtLocation, ConfigFactory $ConfigFactory) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->CurrentTimeAtLocation = $CurrentTimeAtLocation;
        $this->ConfigFactory = $ConfigFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function build() {
    $current_time = $this->CurrentTimeAtLocation->getCurrentTime();
    $config = $this->ConfigFactory->get('clock_configuration.settings');
    return [
        '#theme' => 'world_clock__custom_ui',
        '#data' => ["country" => $config->get('country'), "city" => $config->get('city'), "time" => $current_time, "timezone" => $config->get('timezone')],
    ];
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheMaxAge() {
    return 60;
    }

}