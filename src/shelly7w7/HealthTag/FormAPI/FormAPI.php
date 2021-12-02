<?php

declare(strict_types=1);

namespace shelly7w7\HealthTag\FormAPI;

use pocketmine\plugin\PluginBase;

class FormAPI extends PluginBase{

    /**
     * @param callable $function
     *
     * @return CustomForm
     * @deprecated
     *
     */
    public function createCustomForm(callable $function = null) : CustomForm{
        return new CustomForm($function);
    }

}
