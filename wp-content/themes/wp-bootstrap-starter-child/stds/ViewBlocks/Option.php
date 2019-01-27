<?php

namespace Stds\ViewBlocks;

use \Stds\ViewTypes;
use \Stds\View\BlockBuilder;
use \Stds\ViewTypes\BlockProps;

class Option {

    public function render($conf)
    {
        $_ = new BlockProps();

        $ajax_class = null;
        $disabled = null;
        $id = null;
        $name = null;
        $placeholder = null;
        $selected = null;
        $text = null;
        $value = null;

        if($conf instanceof \stdClass){
            $ajax_class = $conf->{$_::AJAX_CLASS};
            $disabled = $conf->{$_::DISABLED};
            $id = $conf->{$_::ID};
            $name = $conf->{$_::NAME};
            $selected = $conf->{$_::SELECTED};
            $text = $conf->{$_::TEXT};
            $value = $conf->{$_::VALUE};
  
        } elseif(is_array($conf)){
            $ajax_class = $conf[$_::AJAX_CLASS];
            $disabled = $conf[$_::DISABLED];
            $id = $conf[$_::ID];
            $name = $conf[$_::NAME];
            $selected = $conf[$_::SELECTED];
            $text = $conf[$_::TEXT];
            $value = $conf[$_::VALUE];
        }
        if(empty($id)) $id = $name;
    
        ob_start();?>
            <option
                name="<?= (empty($name) ? "" : $name);?>"
                class="<?= (empty($class) ? "" : $class);?> <?= (empty($ajax_class) ? "" : $ajax_class);?>"
                id="<?= (empty($id) ? "" : $id);?>"
                value="<?= (empty($value) ? "" : $value);?>"
                <?= $disabled,$selected ?> 
                > <?= $text ?>  </option>
          <?php
        $html = ob_get_clean();

        return $html;    
    }
}