<?php

declare(strict_types=1);

namespace bink702\Command;

use bink702\EasyGamemode;
use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\player\GameMode;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TF;

class gmaCommand extends Command implements PluginOwned {

    /**
     * @var EasyGamemode
     */
    private EasyGamemode $plugin;

    /**
     * @var Config
     */
    private Config $cfg;

    public function __construct(EasyGamemode $plugin)
    {
        $this->plugin = $plugin;
        $this->cfg = $this->plugin->getConfig();
        parent::__construct("gma", "Change GameMode to ADVENTURE", null, ["gma"]);
        $this->setPermission("EasyGamemode.gma");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $prefix = $this->cfg->get("Prefix");
        $usage = $this->cfg->get("ChangeMsg");

        if(!$sender instanceof Player){
            $sender->sendMessage(TF::RED."Please use command in-game");
            return true;
        }
        else
        {
            $sender->setGamemode(GameMode::ADVENTURE());
            $sender->sendMessage($prefix. $usage. TF::GREEN. "ADVENTURE");
            return true;
        }

    }

    public function getOwningPlugin(): EasyGamemode
    {
        return $this->plugin;
    }
}