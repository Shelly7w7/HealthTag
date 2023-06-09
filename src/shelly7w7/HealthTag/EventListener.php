<?php

declare(strict_types=1);

namespace shelly7w7\HealthTag;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityRegainHealthEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\player\Player;

class EventListener implements Listener {

	private Main $plugin;

	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}

	public function onPlayerJoin(PlayerJoinEvent $event): void {
		Main::getInstance()->updateScoreTag($event->getPlayer());
	}

	public function onEntityDamageEvent(EntityDamageEvent $event): void {
		$entity = $event->getEntity();
		if($entity instanceof Player) {
			Main::getInstance()->updateScoreTag($entity);
		}
	}

	public function onEntityRegainHealth(EntityRegainHealthEvent $event): void {
		$entity = $event->getEntity();
		if($entity instanceof Player) {
			Main::getInstance()->updateScoreTag($entity);
		}
	}

}