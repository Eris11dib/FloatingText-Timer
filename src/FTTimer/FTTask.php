<?php

namespace FTTimer;

use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\scheduler\Task;
use pocketmine\Player;
use pocketmine\utils\Config;

class FTTask extends Task
{

    /** @var FT $ft */
    public $ft;
    /** @var $countdown */
    public $countdown;
    /** @var Player $player */
    public $player;

    public function __construct(FT $ft, Player $player)
    {
        $this->ft = $ft;
        $this->player = $player;
        $this->countdown = $this->getFt()->getConfig()->get("countdown_seconds");
    }

    public function onRun(int $tick)
    {
        $this->getFt()->text->setText("§cRemain§r " . $this->countdown . " §cseconds " . $this->getFt()->getConfig()->get("motivation"));
        $this->getFt()->getServer()->getLevelByName($this->getFt()->getConfig()->get("spawn_timer_world"))->addParticle($this->getFt()->text, [$this->getPlayer()]);
        if ($this->countdown === 0) {
            $this->countdown = $this->getFt()->getConfig()->get("countdown_seconds");
        }
        $this->countdown--;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @return FT
     */
    public function getFt(): FT
    {
        return $this->ft;
    }
}

