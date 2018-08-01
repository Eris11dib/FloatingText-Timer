<?php

/*
*
* Author: Eris11dib
* Github: github.com/Eris11dib
*
*/


namespace FTTimer;

use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\Config;

class FT extends PluginBase implements Listener
{
	/** @var Config $config */
    public $config;

    /** @var FloatingTextParticle $text */
    public $text;

    public function onEnable()
    {
        if ($this->getConfig()->get("spawn_timer_world") == null) {
            $this->getLogger()->info("Vai sul config a definire il nome del mondo! il plugin è stato disabilitato");
            $this->getServer()->getPluginManager()->disablePlugin($this);
        } else {
            $this->getServer()->getPluginManager()->registerEvents($this, $this);
            $this->getLogger()->info("§6Activated");
            $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, [
                "countdown_seconds" => 60,
                "motivation" => "all'Evento",
                "spawn_timer_world" => null,
            ]);

            $this->text = new FloatingTextParticle($this->getServer()->getLevelByName($this->getConfig()->get("spawn_timer_world"))->getSpawnLocation(), "", "§7---[§6Timer§7]---§r");
        }
    }

    /**
     * @param PlayerJoinEvent $event
     */
    public function onJoin(PlayerJoinEvent $event)
    {
    	$player = $event->getPlayer();
    	if ($player instanceof Player || $player->getLevel()->getName() == $this->getConfig()->get("spawn_timer_world")){
            $this->text->setInvisible(false);
            $this->getServer()->getLevelByName($this->getConfig()->get("spawn_timer_world"))->addParticle($this->text, [$player]);
		}
        $this->getScheduler()->scheduleRepeatingTask(new FTTask($this, $player), 20);
    }

    /**
     * @param EntityLevelChangeEvent $event
     */
    public function onLevelChange(EntityLevelChangeEvent $event)
    {
        $player = $event->getEntity();
        if ($player instanceof Player || $player->getLevel()->getName() == $this->getConfig()->get("spawn_timer_world")) {
            $this->text->setInvisible(false);
            $this->getServer()->getLevelByName($this->getConfig()->get("spawn_timer_world"))->addParticle($this->text, [$player]);
        } else {
            $this->text->setInvisible(true);
            $this->getServer()->getLevelByName($this->getConfig()->get("spawn_timer_world"))->addParticle($this->text, [$player]);
        }
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
    	return $this->config;
	}
}