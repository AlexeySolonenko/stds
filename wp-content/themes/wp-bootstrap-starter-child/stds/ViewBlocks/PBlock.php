<?php

namespace Stds\ViewBlocks;

use \Stds\ViewTypes\BlockProps;

class PBlock {
    
    public function render($conf){
          $_ = new BlockProps();
        $text = null;
        $class = null;
        
        if($conf instanceof \stdClass){
            $text = $conf->{$_::TEXT};
            $class = $conf->{$_::CLASS_};
        }
         elseif(is_array($conf)){
            $text = $conf[$_::TEXT];
            $class = $conf[$_::CLASS_];
        } /*elseif($data instanceof NewsCarousel){
            $content = $data->getContent();
            $content_class = $data->getContentClass();
        }
        */ 

        
        ob_start();
        ?>
        
<p class=" <?php echo empty($class) ? "  " :  $class; ?> ">
        <?php echo empty($text) ? "" :  $text ?>
</p>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        
        return $html;
        
    }
}