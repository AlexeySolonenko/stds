<?php

namespace Stds\ViewBlocks;

use Stds\ViewTypes\BlockProps;

class Img
{
    public function render($conf)
    {
        $_ = new BlockProps();
        $class = null;
        $class_id = null;
        $name = null;
        $src = null;
        $id = null;
        $alt = null;
        if (is_array($conf)) :
            $class = $conf[$_::CLASS_];
            $class_id = $conf[$_::CLASS_ID];
            $name = $conf[$_::NAME];
            $src = $conf[$_::SRC];
            $id = $conf[$_::ID];
            $alt = $conf[$_::ALT]; 
        elseif ($conf instanceof \stdClass) :
            $class = $conf->{$_::CLASS_};
            $class_id = $conf->{$_::CLASS_ID};
            $name = $CONF->{$_::NAME};
            $src = $conf->{$_::SRC};
            $id = $conf->{$_::ID};
            $alt = $conf->{$_::ALT};
        endif;
        ob_start(); ?>
        <img class="<?= (empty($class) ? 'd-block w-100 ' : $class); ?> <?= $class_id; ?>"
            src="<?= (empty($src) ? '' : $src); ?>" id="<?= $id; ?>"
        <?php if(!empty($name)):?>name="<?= $name; ?>"<?php endif; ?>
            alt="<?= (empty($alt) ? 'Image' : $alt); ?>"><?php
        $html = ob_get_clean();

        return $html;
    }
}
