<?php

namespace Stds\ViewBlocks;

use \Stds\ViewTypes\BlockProps;

class Input01 {

    public function render($conf){
        $_ = new BlockProps();

        $ajax_class = null;
        $checked = null;
        $class = null;
        $col_class = null;
        $disabled = null;
        $field_class = null;
        $id = null;
        $label = null;
        $label_after = null;
        $label_after_class = null;
        $label_class = null;
        $name = null;
        $placeholder = null;
        $required = null;
        $row_class = null;
        $type = null;
        if($conf instanceof \stdClass){
            $ajax_class = $conf->{$_::AJAX_CLASS};
            $checked = $conf->{$_::CHECKED};
            $class = $conf->{$_::CLASS_};
            $col_class = $conf->{$_::COL_CLASS};
            $disabled = $conf->{$_::DISABLED};
            $field_class = $conf->{$_::FIELD_CLASS};
            $id = $conf->{$_::ID};
            $label = $conf->{$_::LABEL};
            $label_after = $conf->{$_::LABEL_AFTER};
            $label_after_class = $conf->{$_::LABEL_AFTER_CLASS};
            $label_class = $conf->{$_::LABEL_CLASS};
            $name = $conf->{$_::NAME};
            $placeholder = $conf->{$_::PLACEHOLDER};
            $required = $conf->{$_::REQUIRED};
            $row_class = $conf->{$_::ROW_CLASS};
            $type = $conf->{$_::TYPE};
        } elseif(is_array($conf)){
            $ajax_class = $conf[$_::AJAX_CLASS];
            $checked = $conf[$_::CHECKED];
            $class = $conf[$_::CLASS_];
            $col_class = $conf[$_::COL_CLASS];
            $disabled = $conf[$_::DISABLED];
            $field_class = $conf[$_::FIELD_CLASS];
            $id = $conf[$_::ID];
            $label = $conf[$_::LABEL];
            $label_after = $conf[$_::LABEL_AFTER];
            $label_after_class = $conf[$_::LABEL_AFTER_CLASS];
            $label_class = $conf[$_::LABEL_CLASS];
            $name = $conf[$_::NAME];
            $placeholder = $conf[$_::PLACEHOLDER];
            $required = $conf[$_::REQUIRED];
            $row_class = $conf[$_::ROW_CLASS];
            $type = $conf[$_::TYPE];
        }
        if(empty($id)) $id = $name;
        if($type !='hidden'):
            ob_start();?>
                <div class="<?= (empty($col_class) ? "form-group col-12 col-md-6 col-lg-4 ": $col_class); ?>  
                <?= $name.$_::OUTER; ?>">
                    <div class="<?= (empty($row_class) ? "row":$row_class); ?>">
                        <?php if(!empty($label[1])): ?>
                            <label for="<?= $id ?>" class ="<?= (empty($label_class) ? " col-12 " : $label_class);?>">
                                <?= $label; ?>
                            </label>
                        <?php endif; ?>
                        <div class="<?= (empty($field_class) ? " col-12 " : $field_class); ?>">
                            <input 
                                type="<?= (empty($type) ? "text" : $type); ?>"
                                name="<?= (empty($name) ? "" : $name);?>"
                                class="<?= (empty($class) ? "" : $class);?> <?= (empty($ajax_class) ? "" : $ajax_class);?>"
                                id="<?= (empty($id) ? "" : $id);?>"
                                placeholder="<?= (empty($placeholder) ? "" : $placeholder);?>"
                                <?= $disabled,$required,$checked ?>
                                >
                        </div>
                        <?php if(!empty($label_after[1])): ?>
                            <label for="<?= $id ?>" class ="<?= (empty($label_after_class) ? " col-12 " : $label_after_class);?>">
                                <?= $label_after; ?>
                            </label>
                        <?php endif; ?>
                    </div>
                </div><?php
            $html = ob_get_clean();
        else:
            ob_start();?>
             <input 
                                type="<?= (empty($type) ? "text" : $type); ?>"
                                name="<?= (empty($name) ? "" : $name);?>"
                                class="<?= (empty($class) ? "" : $class);?> <?= (empty($ajax_class) ? "" : $ajax_class);?> d-none"
                                id="<?= (empty($id) ? "" : $id);?>"
                                placeholder="<?= (empty($placeholder) ? "" : $placeholder);?>"
                                <?= $disabled,$required,$checked ?>
                                ><?
            $html = ob_get_clean();
        endif;
        
        return $html;        
    }
}