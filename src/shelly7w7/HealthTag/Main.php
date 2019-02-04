<?php

declare(strict_types=1);

namespace shelly7w7\HealthTag;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase{

	/** @var Config $config */
	protected $config;
	/** @var self $instance */
	protected static $instance;

	public function onEnable() : void{
		self::$instance = $this;
		@mkdir($this->getDataFolder());
		$this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
		$this->getScheduler()->scheduleRepeatingTask(new TagTask(), 10);
	}

	public function getHealthTagConfig() : Config{
		return $this->config;
	}

	public static function getInstance() : self{
		return self::$instance;
	}
}