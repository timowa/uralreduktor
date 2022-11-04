<?php

namespace App\Configurator;

class RadioWithSvgField extends ConfiguratorField
{
    protected static string $view = 'radio_with_svg';

    public function getSvg($path){
        echo file_get_contents(asset('storage/'.$path));
    }
}
