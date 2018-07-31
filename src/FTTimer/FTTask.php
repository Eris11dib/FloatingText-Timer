<?php

namespace FTTimer;

use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\scheduler\Task;
use pocketmine\Player;

class FTTask extends Task{
	
	public $player;
	public $fttemp;
	public $levels;
	public $countdown;
	
	public function __construct(FT $ft){
		$this->ft = $ft;
		$this->countdown = $this->ft->ftcfg->get("countdown_seconds");
		$this->fttemp = new FloatingTextParticle($this->ft->getServer()->getLevelByName($this->ft->ftcfg->get("spawn_timer_world"))->getSpawnLocation(),"","§7---[§6Timer§7]---§r");
	}
		public function onRun($tick){
			foreach($this->ft->getServer()->getOnlinePlayers() as $player){
				$this->fttemp->setText("§cMancano esattamente§r " . $this->countdown . " §csecondi " . $this->ft->ftcfg->get("motivation"));
				$this->ft->getServer()->getLevelByName($this->ft->ftcfg->get("spawn_timer_world"))->addParticle($this->fttemp,[$player]);
			if($this->countdown === 0){
				$this->countdown = $this->ft->ftcfg->get("countdown_seconds");
				}
			}
			$this->countdown--;
		}
	}

?>
