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

class gmcCommand extends Command implements PluginOwned {

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
        parent::__construct("gmc", "Change GameMode to CREATIVE", null, ["gmc"]);
        $this->setPermission("EasyGamemode.gmc");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        $prefix = $this->cfg->get("Prefix");
        $usage = $this->cfg->get("ChangeMsg");

        if(!$sender instanceof Player){
            $sender->sendMessage(TF::RED."Please use command in-game");
            return true;
        }
        else
        {
            $sender->setGamemode(GameMode::CREATIVE());
            $sender->sendMessage($prefix. $usage. TF::GREEN. "CREATIVE");
            return true;
        }

    }

    public function getOwningPlugin(): EasyGamemode
    {
        return $this->plugin;
    }
}