<?php

declare(strict_types=1);

namespace bink702;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\TextFormat as TF;

use bink702\Command\gmaCommand;
use bink702\Command\gmcCommand;
use bink702\Command\gmsCommand;
use bink702\Command\gmspcCommand;
use pocketmine\utils\Config;

class EasyGamemode extends PluginBase implements Listener {

    /** @var EasyGamemode */
    public static EasyGamemode $instance;
    /**
     * @var bool
     */
    public bool $debug;
    /**
     * @var Config
     */
    private Config $cfg;
    /**
     * @var mixed
     */
    private $version;
    private string $current;

    public static function getInstance() : self {
        return self::$instance;
    }

    protected function onLoad(): void
    {
        // Default Config
        $this->current = "1.0.1";
        $this->debug = false;

        $this->saveDefaultConfig();
        $this->version = $this->getConfig()->get("Config");
        if($this->debug == true)
        {
            $this->getLogger()->info("the plugin uses the current version ". $this->version);
        }
    }

    protected function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getCommandMap()->register("gmc", new gmcCommand($this));
        $this->getServer()->getCommandMap()->register("gma", new gmaCommand($this));
        $this->getServer()->getCommandMap()->register("gms", new gmsCommand($this));
        $this->getServer()->getCommandMap()->register("gmspc", new gmspcCommand($this));
        $this->cfg = $this->getConfig();
        self::$instance = $this;
        if($this->version != $this->current)
        {
            $this->getLogger()->warning(TF::RED . "the plugin uses the current version of " . TF::GREEN . $this->current . TF::RED . " the plugin_data version ". TF::BLUE . $this->version);
            $this->getServer()->shutdown();
        }
    }

    public function onJoin (PlayerJoinEvent $event): bool
    {
        $p = $event->getPlayer();
        $dfgm = $this->getServer()->getGamemode();
        if($this->cfg->get("DefaultGM") == true)
        {
            $p->setGamemode($dfgm);
        }
        return true;
    }

}
