<?php

namespace PiloudeDakar\PlayerJoinMessage;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{

    private mixed $config;
    private string $joinMessage;
    private string $leaveMessage;
    
    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        if (!file_exists($this->getDataFolder() . 'config.yml')){
            fopen($this->getDataFolder() . 'config.yml', 'x+');
            file_put_contents($this->getDataFolder() . 'config.yml', '#You can use the variable "$player" to write player name
joinMessage: 
leaveMessage:');
        }
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->joinMessage = $this->config->get("joinMessage");
        $this->leaveMessage = $this->config->get("leaveMessage");

    }

    public function onPlayerJoin(PlayerJoinEvent $event)
    {

        $player = $event->getPlayer()->getName();
        if (!$this->joinMessage === null) {
            $event->setJoinMessage(stristr($this->joinMessage, '$player', true) . $player . substr(stristr($this->joinMessage, '$player'), 7));
        }
    }

    public function onPlayerQuit(PlayerQuitEvent $event)
    {
        $player = $event->getPlayer()->getName();
        if (!$this->leaveMessage === null) {
            $event->setQuitMessage(stristr($this->leaveMessage, '$player', true) . $player . substr(stristr($this->leaveMessage, '$player'), 7));
        }
    }
}