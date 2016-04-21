<?php

namespace yuu528;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\command\ConsoleCommandSender;

class PoliceAPI extends PluginBase
{
	//System Code
	public function onEnable()
	{
		$this->getServer()->getLogger()->info("[PoliceAPI] PoliceAPI Loaded!");
		if(!file_exists($this->getDataFolder())){
			mkdir($this->getDataFolder(), 0744, true);
			$this->getServer()->getLogger->info("[PoliceAPI] Create Data Folder");
		}

		if(!file_exists($this->getDataFolder()."tmp")){
			mkdir($this->getDataFolder()."tmp/", 0744, true);
		}

		$this->police = new Config($this->getDataFolder()."officer.yml", Config::YAML);
		$this->addon = new Config($this->getDataFolder()."tmp/plugins.yml", Config::YAML);
		//Add Configs Here
		$this->getServer()->getLogger()->info("[PoliceAPI] Loaded Config");
	}

	public function addAddon($name){
		if($this->addon->exists($name)){
			return false;
		}
			$this->addon->set($name, "enable");
			$this->addon->save();
			return true;
	}

	public function removeAddon($name){
		$this->addon->remove($name);
		$this->addon->save();
		return true;
	}

	public function getAddon(){
		return $this->addon->getAll(true);
	}

	public function isAddon($name){
		return $this->addon->exists($name);
	}

	public function onDisable(){
		foreach ($this->addon->getAll(true) as $value) {
			$this->removeAddon($value);
		}
	}

	//Game Code
	public function getPolice(){
		return $this->police->getAll(true);
	}

	public function isPolice($name){
		return $this->police->exists($name);
	}

	public function setPolice($name){
		$this->police->set($name, "police");
		$this->police->save();
		return true;
	}

	public function removePolice($name){
		$this->police->remove($name);
		$this->police->save();
		return true;
	}

	public function broadcastPolice($message){
		foreach ($this->police->getAll() as $name => $not) {
			$player = $this->getServer()->getPlayer($name);
			if(!$player instanceof Player) return;
			$player->sendMessage($message);
		}
		return true;
	}

	//Command Code
	public function onCommand(CommandSender $sender, Command $command, $label, array $args){
		switch(strtolower($command->getName())){
			case "police":
				if(!isset($args[0])) return false;
				switch(strtolower($args[0])){
					case "list":
						$all = implode(", ", $this->getPolice());
						$sender->sendMessage("[PoliceAPI] 警察一覧: \n{$all}");
						return true;
					break;

					case "add":
						if(!isset($args[1])) return false;

						$this->setPolice($args[1]);
						$this->getServer()->broadcastMessage("§a[PoliceAPI] {$sender->getName()}が{$args[1]}を警察に追加しました");
						return true;
					break;

					case "del":
						if(!isset($args[1])) return false;
						if(!$this->isPolice($args[1])){
							$sender->sendMessage("[PoliceAPI] §cそのプレイヤーは警察ではありません");
						}
						$this->removePolice($args[1]);
						$this->getServer()->broadcastMessage("§a[PoliceAPI] {$sender->getName()}が{$args[1]}を警察から削除しました");
						return true;
					break;
				}
		}
	}
}