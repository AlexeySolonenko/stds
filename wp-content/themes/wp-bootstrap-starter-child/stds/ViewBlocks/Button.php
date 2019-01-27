<?php

namespace Stds\ViewBlocks;
use Stds\ViewTypes\BlockProps;

class Button
{
    /**
     * 
     */
    public function render($conf)
    {
        $_ = new BlockProps();

        $ajax_class = null;
        $class = null;
        $col_class = null;
        $data_data = null;
        $data_toggle = null;
        $disabled = null;
        $field_class = null;
        $id = null;
        $label = null;
        $label_class = null;
        $name = null;
        $row_class = null;
        $text = null;
        $type = null;
        if($conf instanceof \stdClass){
            $ajax_class = $conf->{$_::AJAX_CLASS};
            $class = $conf->{$_::CLASS_};
            $col_class = $conf->{$_::COL_CLASS};
            $data_data = $conf->{$_::DATA_DATA};
            $data_toggle = $conf->{$_::DATA_TOGGLE};
            $disabled = $conf->{$_::DISABLED};
            $field_class = $conf->{$_::FIELD_CLASS};
            $id = $conf->{$_::ID};
            $label = $conf->{$_::LABEL};
            $label_class = $conf->{$_::LABEL_CLASS};
            $name = $conf->{$_::NAME};
            $row_class = $conf->{$_::ROW_CLASS};
            $text = $conf->{$_::TEXT};
            $type = $conf->{$_::TYPE};
        } elseif(is_array($conf)){
            $ajax_class = $conf[$_::AJAX_CLASS];
            $class = $conf[$_::CLASS_];
            $col_class = $conf[$_::COL_CLASS];
            $data_data = $conf[$_::DATA_DATA];
            $data_toggle = $conf[$_::DATA_TOGGLE];
            $disabled = $conf[$_::DISABLED];
            $field_class = $conf[$_::FIELD_CLASS];
            $id = $conf[$_::ID];
            $label = $conf[$_::LABEL];
            $label_class = $conf[$_::LABEL_CLASS];
            $name = $conf[$_::NAME];            
            $row_class = $conf[$_::ROW_CLASS];
            $text = $conf[$_::TEXT];
            $type = $conf[$_::ROW_CLASS];
        }
        if(empty($id)) $id = $name;

        
        ob_start(); ?>
        <div class="<?= (empty($col_class) ? "form-group col-12 col-md-4 col-lg-2 ": $col_class); ?> <?= $name.$_::OUTER; ?>" >
            <div class="<?= (empty($row_class) ? "row " : $row_class); ?>" >
                <?php if(!empty($label[1])): ?>
                    <label for="<?= $id ?>" class ="<?= (empty($label_class) ? " col-12 " : $label_class);?>">    
                        <?= $label; ?>
                    </label>
                <?php endif; ?>
               <!-- <div class=""> -->
                    <button
                        type="<?= (empty($type) ? "text" : $type); ?>"
                        name="<?= (empty($name) ? "" : $name);?>"    
                        class=" <?= (empty($class) ? "" : $class);?> 
                                <?= (empty($ajax_class) ? "" : $ajax_class); ?>
                                <?= (empty($field_class) ? " col-12 " : $field_class); ?>
                        "
                        id="<?= (empty($id) ? "" : $id);?>"
                        <?php if(!empty($data_toggle[1])): ?> data-toggle = "<?= $data_toggle; ?> "<?php endif; ?>
                        <?php if(!empty($data_data[1])): ?> data-data = "<?= $data_data; ?> "<?php endif; ?>
                        <?= $disabled ?>
                    ><?= (empty($text)?"":$text); ?></button>
            </div>     
        </div>
        <?php
        $html = ob_get_clean();

        return $html;
    }
}
