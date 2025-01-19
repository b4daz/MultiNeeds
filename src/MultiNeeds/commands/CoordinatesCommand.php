<?php

namespace MultiNeeds\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\GameRulesChangedPacket;
use pocketmine\network\mcpe\protocol\types\BoolGameRule;
use pocketmine\player\Player;
use MultiNeeds\Main;

class CoordinatesCommand extends Command {

    public function __construct() {
        parent::__construct(
            "coordinates", 
            "Toggle coordinates display", 
            "/coordinates <on|off>", 
            ["coords", "co"]
        );
        $this->setPermission("multineeds.command.coordinates");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return false;
        }

        if (!$sender->hasPermission("multineeds.command.coordinates")) {
            $sender->sendMessage("You do not have permission to use this command.");
            return false;
        }

        if (count($args) < 1) {
            $sender->sendMessage("Usage: /coordinates <on|off>");
            return false;
        }

        $config = Main::getInstance()->getConfig();

        switch (strtolower($args[0])) {
            case "on":
                $this->setCoordinates($sender, true);
                $sender->sendMessage($config->getNested("coordinates.enabled-message", "Coordinates have been enabled."));
                break;

            case "off":
                $this->setCoordinates($sender, false);
                $sender->sendMessage($config->getNested("coordinates.disabled-message", "Coordinates have been disabled."));
                break;

            default:
                $sender->sendMessage("Usage: /coordinates <on|off>");
        }

        return true;
    }

    private function setCoordinates(Player $player, bool $state): void {
        $packet = new GameRulesChangedPacket();
        $packet->gameRules = ["showcoordinates" => new BoolGameRule($state, false)];
        $player->getNetworkSession()->sendDataPacket($packet);
    }
}
