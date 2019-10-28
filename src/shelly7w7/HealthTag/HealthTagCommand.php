<?php
declare(strict_types=1);
namespace shelly7w7\HealthTag;

use pocketmine\Player;
use shelly7w7\HealthTag\FormAPI\CustomForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use function implode;

class HealthTagCommand extends Command
{

    /** @var Main */
    private $plugin;

    public function __construct(Main $plugin)
    {
        parent::__construct("healthtag", "Configure healthtag settings", "/healthtag", ["ht"]);
        $this->setPermission("healthtag.configure");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void
    {
        if (!$this->testPermissionSilent($sender)) {
            $sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
            return;
        }
        $action = $args[0] ?? "";
        if (empty($args)) {
            $sender->sendMessage(TextFormat::RED . "Invalid arguments," . TextFormat::YELLOW . "  use '/healthtag help' for more information.");
            return;
        }
        if ($action === "help") {
            $sender->sendMessage(TextFormat::RED . "/healthtag help >" . TextFormat::YELLOW . " Lists all available commands." . TextFormat::EOL . TextFormat::RED . "/healhtag settype [bar/custom] >" . TextFormat::YELLOW . "  Set's the health format type." . TextFormat::EOL . TextFormat::RED . "/healthtag setcustomformat [format] >" . TextFormat::YELLOW . "  Set's format for custom type. Use {maxhealth} and/or {health}." . TextFormat::EOL . TextFormat::RED . "/healthtag reload >" . TextFormat::YELLOW . "  Reload configuration file without restarting the server.");
        } else if ($action === "settype") {
            if(empty($args[1])) {
                $sender->sendMessage(TextFormat::RED . "/healthtag settype" . TextFormat::YELLOW . " bar/custom");
            } else if ($args[1] === "bar") {
                Main::getInstance()->getConfig()->set("type", "bar");
                Main::getInstance()->getConfig()->save();
                $sender->sendMessage(TextFormat::RED . "Healthtag type has been set to " . TextFormat::YELLOW . $args[1] . TextFormat::RED . ".");
            } else if ($args[1] === "custom") {
                Main::getInstance()->getConfig()->set("type", "custom");
                Main::getInstance()->getConfig()->save();
                $sender->sendMessage(TextFormat::RED . "Healthtag type has been set to " . TextFormat::YELLOW . $args[1] . TextFormat::RED . ".");
            } else {
                $sender->sendMessage(TextFormat::RED . "Invalid type. Available types:" . TextFormat::EOL . TextFormat::YELLOW . "- bar" . TextFormat::EOL . TextFormat::YELLOW . "- custom");
            }
        } else if ($action === "setcustomformat") {
            if (empty($args[1])) {
                $this->setCustomFormat($sender->getServer()->getPlayer($sender->getName()));
            } else {
                array_shift($args);
                Main::getInstance()->getConfig()->set("customformat", implode(" ", $args));
                Main::getInstance()->getConfig()->save();
                $sender->sendMessage(TextFormat::RED . "Successfully changed the custom format for healthtag," . TextFormat::YELLOW . " reload the file to update the changes '/healthtag reload'.");
            }
        } else if ($action === "reload") {
            Main::getInstance()->getConfig()->reload();
            $sender->sendMessage(TextFormat::RED . "Successfully reloaded configuration file.");
        }else{
            $sender->sendMessage(TextFormat::RED . "Invalid arguments," . TextFormat::YELLOW . "  use '/healthtag help' for more information.");
        }
    }

    public function setCustomFormat(Player $sender)
    {
        $form = new CustomForm(function (Player $sender, $data) {
            if ($data != null) {
                Main::getInstance()->getConfig()->set("customformat", implode("", $data));
                Main::getInstance()->getConfig()->save();
                $sender->sendMessage(TextFormat::RED . "Successfully changed the custom format for healthtag," . TextFormat::YELLOW . " reload the file to update the changes '/healthtag reload'.");
            }
        });
        $form->setTitle("HealthTag");
        $form->addInput("Set the format for custom type in the following input. Use {health} or {maxhealth} to show the health.", "E.G {health}HP/{maxhealth}HP", Main::getInstance()->getConfig()->get("customformat"));
        $form->addLabel("Now, to proceed and save your new format proceed by tapping/clicking 'submit' or cancel the process by exiting the UI.");
        $form->sendToPlayer($sender);
    }
}
