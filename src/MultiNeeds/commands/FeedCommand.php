<?php

namespace MultiNeeds\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\event\Listener;
use MultiNeeds\Main;

class FeedCommand extends Command {

    public function __construct() {
        parent::__construct(
            "feed", 
            "Restore hunger bar", 
            "/feed", 
            []
        );
        $this->setPermission("multineeds.command.feed");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return false;
        }

        if (!$sender->hasPermission("multineeds.command.feed")) {
            $sender->sendMessage("You do not have permission to use this command.");
            return false;
        }

        $sender->getHungerManager()->setFood($sender->getHungerManager()->getMaxFood());
        $sender->getHungerManager()->setSaturation(20);
        $config = Main::getInstance()->getConfig();
        $sender->sendMessage($config->getNested("feed.success-message", "Your hunger bar has been restored."));

        return true;
    }
}
