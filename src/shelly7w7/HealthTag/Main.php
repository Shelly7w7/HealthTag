<?php

declare(strict_types=1);

namespace shelly7w7\HealthTag;

use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class Main extends PluginBase {

	use SingletonTrait;

	public function onEnable(): void {
		self::setInstance($this);
		$this->getServer()->getCommandMap()->register("healthtag", new HealthTagCommand($this));
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);

		$config = $this->getConfig();
		$config->reload();
	}

	public function updateScoreTag(Player $player): void{
		if($this->getConfig()->get("type") === "custom") {
			$player->setScoreTag(str_replace(["{health}", "{maxhealth}"], [$player->getHealth(), $player->getMaxHealth()], Main::getInstance()->getConfig()->getNested("customformat")));
		} else if(Main::getInstance()->getConfig()->get("type") === "bar") {
			$player->setScoreTag(str_repeat("§a|", (int)round($player->getHealth(), 0)) . str_repeat("§c|", (int)round($player->getMaxHealth() - $player->getHealth(), 0)));
		} else {
			$player->setScoreTag("Invalid type chosen for healthtag");
		}
	}

}
