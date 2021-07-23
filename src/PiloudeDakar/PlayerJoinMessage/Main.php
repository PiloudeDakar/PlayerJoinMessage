<?php

namespace PiloudeDakar\PlayerJoinMessage;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        if (!file_exists($this->getDataFolder() . 'config.yml')){
            fopen($this->getDataFolder() . 'config.yml', 'x+');
            file_put_contents($this->getDataFolder() . 'config.yml', '#You can use the variable "$player" to write player name
joinMessage: 
leaveMessage:');
        }
    }

    public function onPlayerJoin(PlayerJoinEvent $event)
    {
        $config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $player = $event->getPlayer()->getName();
        if (!$config->get("joinMessage") === null) {
            $event->setJoinMessage(stristr($config->get("joinMessage"), '$player', true) . $player . substr(stristr($config->get("joinMessage"), '$player'), 7));
        }
    }

    public function onPlayerQuit(PlayerQuitEvent $event)
    {
        $config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $player = $event->getPlayer()->getName();
        if (!$config->get("leaveMessage") === null) {
            $event->setQuitMessage(stristr($config->get("leaveMessage"), '$player', true) . $player . substr(stristr($config->get("leaveMessage"), '$player'), 7));
        }
    }
}