<?php

declare(strict_types = 1);

namespace shelly7w7\HealthTag\FormAPI;

use pocketmine\plugin\PluginBase;

class FormAPI extends PluginBase{

    /**
     * @deprecated
     *
     * @param callable|null $function
     * @return CustomForm
     */
    public function createCustomForm(?callable $function = null) : CustomForm {
        return new CustomForm($function);
    }
}
