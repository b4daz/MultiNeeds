<?php

namespace MultiNeeds\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\event\Listener;
use MultiNeeds\Main;

class HealCommand extends Command {

    public function __construct() {
        parent::__construct(
            "heal", 
            "Restore player health", 
            "/heal", 
            []
        );
        $this->setPermission("multineeds.command.heal");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return false;
        }

        if (!$sender->hasPermission("multineeds.command.heal")) {
            $sender->sendMessage("You do not have permission to use this command.");
            return false;
        }

        $sender->setHealth($sender->getMaxHealth());
        $config = Main::getInstance()->getConfig();
        $sender->sendMessage($config->getNested("heal.success-message", "Your health has been restored."));

        return true;
    }
}
