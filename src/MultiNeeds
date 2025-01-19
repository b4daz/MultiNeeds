<?php

namespace MultiNeeds;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use MultiNeeds\commands\CoordinatesCommand;
use MultiNeeds\commands\NightVisionCommand;
use MultiNeeds\commands\FeedCommand;
use MultiNeeds\commands\HealCommand;

class Main extends PluginBase {

    private static $instance;

    public function onEnable(): void {
        self::$instance = $this;
        $this->getLogger()->info("MultiNeeds plugin enabled!");

        $this->getServer()->getCommandMap()->register("coordinates", new CoordinatesCommand());
        $this->getServer()->getCommandMap()->register("nightvision", new NightVisionCommand());
        $this->getServer()->getCommandMap()->register("feed", new FeedCommand());
        $this->getServer()->getCommandMap()->register("heal", new HealCommand());
    }

    public function onDisable(): void {
        $this->getLogger()->info("MultiNeeds plugin disabled!");
    }

    public static function getInstance(): Main {
        return self::$instance;
    }
}
