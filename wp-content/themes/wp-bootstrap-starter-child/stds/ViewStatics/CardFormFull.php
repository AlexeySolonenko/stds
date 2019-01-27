<?php

namespace \Stds\ViewStatics;

class CardFormFull {
    
    
    public function render(){
        $form = "";
        
        ob_start();?>
        <form>
            
            
        </form>
        
        
        
        <?php
        $form = ob_get_contents();
        ob_end_clean();
        
        return $form;
    }
    
}