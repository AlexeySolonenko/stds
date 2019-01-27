<?php

namespace Stds\ViewBlocks;

use \Stds\ViewTypes\BlockProps;

class ColBlock {
    
    public function render($conf){
          $_ = new BlockProps();
        $after_content = null;
        $col_class = null;
        $content = null;
        $content_class = null;
        $pre_content = null;
        
        if($conf instanceof \stdClass){
            $after_content = $conf->{$_::AFTER_CONTENT};
            $col_class = $conf->{$_::COL_CLASS};
            $content = $conf->{$_::CONTENT};
            $content_class = $conf->{$_::CONTENT_CLASS};
            $pre_content = $conf->{$_::PRE_CONTENT};
        }
         elseif(is_array($conf)){
            $after_content = $conf[$_::AFTER_CONTENT];
            $col_class = $conf[$_::COL_CLASS];
            $content = $conf[$_::CONTENT];
            $content_class = $conf[$_::CONTENT_CLASS];
            $pre_content = $conf[$_::PRE_CONTENT];
        } /*elseif($data instanceof NewsCarousel){
            $content = $data->getContent();
            $content_class = $data->getContentClass();
        }
        */ 

        ob_start();
        ?>
        <div class=" <?php echo empty($col_class) ? " col-auto " :  $col_class; ?> ">
                <?php echo empty($pre_content) ? "" : $pre_content; ?>
                <?php echo empty($content) ? "" :  $content; ?>
                <?php echo empty($after_content) ? "" : $after_content; ?>
        </div>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        
        return $html;
        
    }
}