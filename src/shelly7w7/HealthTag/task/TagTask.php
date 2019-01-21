<?php

namespace shelly7w7\HealthTag\task;
use pocketmine\scheduler\Task;
use pocketmine\Player;
use shelly7w7\HealthTag\Loader;

class TagTask extends Task{
	public function __construct(Loader $plugin){
		$this->plugin = $plugin;
	}
	public function onRun($currentTick){
		foreach($this->plugin->getServer()->getOnlinePlayers() as $player){
			$tag = $this->plugin->config->get("tag-format");
			$tag = str_replace("{health}", $player->getHealth(), $tag);
		    $tag = str_replace("{maxhealth}", $player->getMaxHealth(), $tag);
			$player->setNameTagVisible();
			$player->setScoreTag($tag);
		}
	}
}