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
		$entity = $event->getPlayer();

		if(Main::getInstance()->getConfig()->get("type") === "custom") {
			$entity->setScoreTag(str_replace(["{health}", "{maxhealth}"], [$entity->getHealth(), $entity->getMaxHealth()], Main::getInstance()->getConfig()->getNested("customformat")));
		} else if(Main::getInstance()->getConfig()->get("type") === "bar") {
			$entity->setScoreTag(str_repeat("§a|", (int)round($entity->getHealth(), 0)) . str_repeat("§c|", (int)round($entity->getMaxHealth() - $entity->getHealth(), 0)));
		} else {
			$entity->setScoreTag("Invalid type chosen for healthtag");
		}
	}

	public function onEntityDamageEvent(EntityDamageEvent $event): void {
		$entity = $event->getEntity();

		if($entity instanceof Player) {
			if(Main::getInstance()->getConfig()->get("type") === "custom") {
				$entity->setScoreTag(str_replace(["{health}", "{maxhealth}"], [$entity->getHealth(), $entity->getMaxHealth()], Main::getInstance()->getConfig()->getNested("customformat")));
			} else if(Main::getInstance()->getConfig()->get("type") === "bar") {
				$entity->setScoreTag(str_repeat("§a|", (int)round($entity->getHealth(), 0)) . str_repeat("§c|", (int)round($entity->getMaxHealth() - $entity->getHealth(), 0)));
			} else {
				$entity->setScoreTag("Invalid type chosen for healthtag");
			}
		}
	}

	public function onEntityRegainHealth(EntityRegainHealthEvent $event): void {
		$entity = $event->getEntity();

		if($entity instanceof Player) {
			if(Main::getInstance()->getConfig()->get("type") === "custom") {
				$entity->setScoreTag(str_replace(["{health}", "{maxhealth}"], [$entity->getHealth(), $entity->getMaxHealth()], Main::getInstance()->getConfig()->getNested("customformat")));
			} else if(Main::getInstance()->getConfig()->get("type") === "bar") {
				$entity->setScoreTag(str_repeat("§a|", (int)round($entity->getHealth(), 0)) . str_repeat("§c|", (int)round($entity->getMaxHealth() - $entity->getHealth(), 0)));
			} else {
				$entity->setScoreTag("Invalid type chosen for healthtag");
			}
		}
	}

}