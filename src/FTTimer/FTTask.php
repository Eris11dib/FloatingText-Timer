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

    public function __construct(FT $ft)
    {
        $this->ft = $ft;
        $this->countdown = $this->getFt()->getConfig()->get("countdown_seconds");
    }

    public function onRun(int $tick)
    {
        $this->getFt()->text->setText("§cMancano esattamente§r " . $this->countdown . " §csecondi " . $this->getFt()->getConfig()->get("motivation"));
        if ($this->countdown === 0) {
            $this->countdown = $this->getFt()->getConfig()->get("countdown_seconds");
        }
        $this->countdown--;
    }

    /**
     * @return FT
     */
    public function getFt(): FT
    {
        return $this->ft;
    }
}

