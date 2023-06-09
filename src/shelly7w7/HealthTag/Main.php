<?php

declare(strict_types=1);

namespace shelly7w7\HealthTag;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;

class Main extends PluginBase {

	use SingletonTrait;

	protected Config $config;

	public function onEnable(): void {
		self::setInstance($this);
		$this->getServer()->getCommandMap()->register("healthtag", new HealthTagCommand($this));
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);

		$config = $this->getConfig();
		$config->reload();
	}
}
