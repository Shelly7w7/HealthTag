<?php

declare(strict_types=1);

namespace shelly7w7\HealthTag;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase
{

    /** @var Config $config */
    protected $config;
    /** @var self $instance */
    protected static $instance;

    public function onEnable(): void
    {
        self::$instance = $this;
        $this->getServer()->getCommandMap()->register("healthtag", new HealthTagCommand($this));
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);

        $config = $this->getConfig();
        $config->reload();
    }

    public static function getInstance(): self
    {
        return self::$instance;
    }
}
