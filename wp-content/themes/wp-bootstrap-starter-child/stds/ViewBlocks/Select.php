<?php

namespace Stds\ViewBlocks;

use \Stds\ViewTypes\BlockProps;
use Stds\View\BlockBuilder;

class Select
{
    public function render($conf)
    {
        $_ = new BlockProps();
        $bb = new BlockBuilder();

        $ajax_class = null;
        $col_class = null;
        $disabled = null;
        $field_class = null;
        $id = null;
        $label = null;
        $label_class = null;
        $name = null;
        $opts = null;
        $placeholder = null;
        $required = null;
        $row_class = null;
        $value = null;
        if($conf instanceof \stdClass){
            $ajax_class = $conf->{$_::AJAX_CLASS};
            $col_class = $conf->{$_::COL_CLASS};
            $disabled = $conf->{$_::DISABLED};
            $field_class = $conf->{$_::FIELD_CLASS};
            $id = $conf->{$_::ID};
            $label = $conf->{$_::LABEL};
            $label_class = $conf->{$_::LABEL_CLASS};
            $name = $conf->{$_::NAME};
            $opts = $conf->{$_::OPTS};
            $placeholder = $conf->{$_::PLACEHOLDER};
            $required = $conf->{$_::REQUIRED};
            $row_class = $conf->{$_::ROW_CLASS};
            $value= $conf[$_::VALUE];
        } elseif(is_array($conf)){
            $ajax_class = $conf[$_::AJAX_CLASS];
            $col_class = $conf[$_::COL_CLASS];
            $disabled = $conf[$_::DISABLED];
            $field_class = $conf[$_::FIELD_CLASS];
            $id = $conf[$_::ID];
            $label = $conf[$_::LABEL];
            $label_class = $conf[$_::LABEL_CLASS];
            $name = $conf[$_::NAME];
            $opts = $conf[$_::OPTS];
            $placeholder = $conf[$_::PLACEHOLDER];
            $required = $conf[$_::REQUIRED];
            $row_class = $conf[$_::ROW_CLASS];
            $value = $conf[$_::VALUE];
        }
        if(empty($id)) $id = $name;
    
        ob_start();?>
            <div class="<?= (empty($col_class) ? "form-group col-12 col-md-6 col-lg-4 ": $col_class); ?>  
            <?= $name.$_::OUTER; ?>">
                <div class="<?= (empty($row_class) ? "row":$row_class); ?>">
                    <?php if(!empty($label[1])): ?>
                        <label for="<?= $id ?>" class ="<?= (empty($label_class) ? "" : $label_class);?>">
                            <?= $label; ?>
                        </label>
                    <?php endif; ?>
                    <div class="<?= (empty($field_class) ? "" : $field_class); ?>">
                        <select
                            name="<?= (empty($name) ? "" : $name);?>"
                            class="<?= (empty($class) ? "" : $class);?> <?= (empty($ajax_class) ? "" : $ajax_class);?>"
                            id="<?= (empty($id) ? "" : $id);?>"
                            placeholder="<?= (empty($placeholder) ? "" : $placeholder);?>"
                            <?= $disabled,$required ?>
                            > <?php
                                foreach ($opts as $opt) {
                                    if($opt[$_::CONF][0][$_::VALUE] == $value){
                                        $opt[$_::CONF][0][$_::SELECTED] = 'selected';
                                    }
                                    echo $bb->render('', $opt);
                                } ?>
                            </select>
                    </div>
                </div>
            </div><?php
        $html = ob_get_clean();

        return $html;    
    }
}
