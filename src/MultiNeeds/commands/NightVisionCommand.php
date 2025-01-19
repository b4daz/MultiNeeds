<?php

namespace MultiNeeds\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use MultiNeeds\Main;

class NightVisionCommand extends Command {

    public function __construct() {
        parent::__construct(
            "nightvision", 
            "Toggle night vision effect", 
            "/nightvision <on|off>", 
            ["nv", "vision"]
        );
        $this->setPermission("multineeds.command.nightvision");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return false;
        }

        if (!$sender->hasPermission("multineeds.command.nightvision")) {
            $sender->sendMessage("You do not have permission to use this command.");
            return false;
        }

        if (count($args) < 1) {
            $sender->sendMessage("Usage: /nightvision <on|off>");
            return false;
        }

        $config = Main::getInstance()->getConfig();
        $duration = $config->getNested("nightvision.effect-duration", 300) * 20;

        switch (strtolower($args[0])) {
            case "on":
                $this->enableNightVision($sender, $duration);
                $sender->sendMessage($config->getNested("nightvision.enabled-message", "Night vision has been enabled."));
                break;

            case "off":
                $this->disableNightVision($sender);
                $sender->sendMessage($config->getNested("nightvision.disabled-message", "Night vision has been disabled."));
                break;

            default:
                $sender->sendMessage("Usage: /nightvision <on|off>");
        }

        return true;
    }

    private function enableNightVision(Player $player, int $duration): void {
        $effect = new EffectInstance(VanillaEffects::NIGHT_VISION(), $duration, 0, false);
        $player->getEffects()->add($effect);
    }

    private function disableNightVision(Player $player): void {
        $player->getEffects()->remove(VanillaEffects::NIGHT_VISION());
    }
}
