<?php

declare(strict_types=1);

namespace shelly7w7\HealthTag;

use pocketmine\scheduler\Task;

class TagTask extends Task{

	public function onRun(int $tick) : void{
		foreach(Main::getInstance()->getServer()->getOnlinePlayers() as $player){
			$player->setNameTagVisible(true);
			$player->setScoreTag(str_replace(["{health}", "{maxhealth"], [$player->getHealth(), $player->getMaxHealth()], Main::getInstance()->getHealthTagConfig()->get("tag-format")));
		}
	}
}