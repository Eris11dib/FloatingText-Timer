<?php

/*
*
* Author: Eris11dib
* Github: github.com/Eris11dib
*
*/


namespace FTTimer;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\Config;

class FT extends PluginBase implements Listener{
	
		public $ftcfg;
		
		public function onEnable(){
			$this->getServer()->getPluginManager()->registerEvents($this,$this);
			$this->getLogger()->info("§6Activated");
			$this->ftcfg = new Config($this->getDataFolder() . "config.yml", Config::YAML,[
			"countdown_seconds" => 60,
			"motivation" => "all'Evento",
			"spawn_timer_world" => "lobby"
			]);
		}
		public function onJoin(PlayerJoinEvent $ev){
			$this->getScheduler()->scheduleRepeatingTask(new FTTask($this),20);
		}
	}

?>
