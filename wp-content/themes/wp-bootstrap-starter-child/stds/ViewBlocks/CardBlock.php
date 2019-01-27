<?php

namespace Stds\ViewBlocks;

use \Stds\ViewTypes\BlockProps;

class CardBlock {
    
    public function render($conf){
        $_ = new BlockProps();

        // WARPPER
        $wrapper_class = "";
        $wrapper_col = "";
        $wrapper_show = true;

        //NAMES & IDs
        $name = "";
        $id = "";
        $class_id = "";
        
        // CLASSES
        $card_class = "";
        $header_class = "";
        $title_class = "";
        $text_class = "";
        $text02_class = "";
        $text03_class = "";
        $body_class = "";
        $footer_class = "";
        
        // CONTENTS
        $data_data = "";
        $header = "";
        $title = "";
        $title_level = 5;
        $pre_content = "";
        $text = "";
        $text02 = "";
        $text03 = "";
        $body = "";
        $footer = "";
        $after_content = "";

        // visibility switchers
        $header_show = false;
        $title_show = false;
        $text_show = false;
        $text02_show = false;
        $text03_show = false;
        $footer_show = false;
        
        if($conf instanceof \stdClass){
            if(!empty($conf->{$_::WRAPPER_CLASS})) $wrapper_class = $conf->{$_::WRAPPER_CLASS};
            if(!empty($conf->{$_::WRAPPER_COL})) $wrapper_col = $conf->{$_::WRAPPER_COL};
            if(!empty($conf->{$_::WRAPPER_SHOW})) $wrapper_show = $conf->{$_::WRAPPER_SHOW};
            if(!empty($conf->{$_::NAME})) $name = $conf->{$_::NAME};
            if(!empty($conf->{$_::ID})) $id = $conf->{$_::ID};
            if(!empty($conf->{$_::CLASS_ID})) $class_id = $conf->{$_::CLASS_ID};
            if(!empty($conf->car{$_::CARD_CLASS})) $card_class = $conf->{$_::CARD_CLASS};
            if(!empty($conf->{$_::HEADER_CLASS})) $header_class = $conf->{$_::HEADER_CLASS};
            if(!empty($conf->{$_::TITLE_CLASS})) $title_class = $conf->{$_::TITLE_CLASS};
            if(!empty($conf->{$_::TEXT_CLASS})) $text_class = $conf->{$_::TEXT_CLASS};
            if(!empty($conf->text02_class)) $text02_class = $conf->text02_class;
            if(!empty($conf->text03_class)) $text03_class = $conf->text03_class;
            if(!empty($conf->body_class)) $body_class = $conf->body_class;
            if(!empty($conf->{$_::FOOTER_CLASS})) $footer_class = $conf->{$_::FOOTER_CLASS};
            if(!empty($conf->{$_::DATA_DATA})) $data_data = $conf->{$_::DATA_DATA};
            if(!empty($conf->{$_::HEADER_})) $header = $conf->{$_::HEADER_};
            if(!empty($conf->{$_::TITLE})) $title = $conf->{$_::TITLE};
            if(!empty($conf->{$_::PRE_CONTENT})) $pre_content = $conf->{$_::PRE_CONTENT};
            if(!empty($conf->{$_::TEXT})) $text = $conf->{$_::TEXT};
            if(!empty($conf->text02)) $text02 = $conf->text02;
            if(!empty($conf->text03)) $text03 = $conf->text03;
            if(!empty($conf->body)) $body = $conf->body;
            if(!empty($conf->{$_::FOOTER})) $footer = $conf->{$_::FOOTER};
            if(!empty($conf->{$_::AFTER_CONTENT})) $after_content = $conf->{$_::AFTER_CONTENT};
            if(!empty($conf->{$_::HEADER_SHOW})) $header_show = $conf->{$_::HEADER_SHOW};
            if(!empty($conf->{$_::TITLE_LEVEL})) $title_level= $conf->{$_::TITLE_LEVEL};
            if(!empty($conf->{$_::TITLE_SHOW})) $title_show = $conf->{$_::TITLE_SHOW};
            if(!empty($conf->{$_::TEXT_SHOW})) $text_show = $conf->{$_::TEXT_SHOW};
            if(!empty($conf->text02_show)) $text02_show = $conf->text_02_show;
            if(!empty($conf->text03_show)) $text03_show = $conf->text03_show;
            if(!empty($conf->FOOTER_SHOW)) $footer_show = $conf->{$_::FOOTER_SHOW};
        }
         elseif(is_array($conf)){
            if(!empty($conf[$_::WRAPPER_CLASS])) $wrapper_class = $conf[$_::WRAPPER_CLASS];
            if(!empty($conf[$_::WRAPPER_COL])) $wrapper_col = $conf[$_::WRAPPER_COL];
            if(!empty($conf[$_::WRAPPER_SHOW])) $wrapper_show = $conf[$_::WRAPPER_SHOW];
            if(!empty($conf[$_::NAME])) $name = $conf[$_::NAME];
            if(!empty($conf[$_::ID])) $id = $conf[$_::ID];
            if(!empty($conf[$_::CLASS_ID])) $class_id = $conf[$_::CLASS_ID];
            if(!empty($conf[$_::CARD_CLASS])) $card_class = $conf[$_::CARD_CLASS];
            if(!empty($conf[$_::HEADER_CLASS])) $header_class = $conf[$_::HEADER_CLASS];
            if(!empty($conf[$_::TITLE_CLASS])) $title_class = $conf[$_::TITLE_CLASS];
            if(!empty($conf[$_::TEXT_CLASS])) $text_class = $conf[$_::TEXT_CLASS];
            if(!empty($conf["text02_class"])) $text02_class = $conf["text02_class"];
            if(!empty($conf["text03_class"])) $text03_class = $conf["text03_class"];
            if(!empty($conf["body_class"])) $body_class = $conf["body_class"];
            if(!empty($conf[$_::FOOTER_CLASS])) $footer_class = $conf[$_::FOOTER_CLASS];
            if(!empty($conf[$_::DATA_DATA])) $data_data = $conf[$_::DATA_DATA];
            if(!empty($conf[$_::HEADER_])) $header = $conf[$_::HEADER_];
            if(!empty($conf[$_::TITLE])) $title = $conf[$_::TITLE];
            if(!empty($conf[$_::PRE_CONTENT])) $pre_content = $conf[$_::PRE_CONTENT];
            if(!empty($conf[$_::TEXT])) $text = $conf[$_::TEXT];
            if(!empty($conf["text02"])) $text02 = $conf["text02"];
            if(!empty($conf["text03"])) $text03 = $conf["text03"];
            if(!empty($conf["body"])) $body = $conf["body"];
            if(!empty($conf[$_::FOOTER])) $footer = $conf[$_::FOOTER];
            if(!empty($conf[$_::AFTER_CONTENT])) $after_content = $conf[$_::AFTER_CONTENT];
            if(!empty($conf[$_::HEADER_SHOW])) $header_show = $conf[$_::HEADER_SHOW];
            if(!empty($conf[$_::TITLE_LEVEL])) $title_level = $conf[$_::TITLE_LEVEL];
            if(!empty($conf[$_::TITLE_SHOW])) $title_show = $conf[$_::TITLE_SHOW];
            if(!empty($conf[$_::TEXT_SHOW])) $text_show = $conf[$_::TEXT_SHOW];
            if(!empty($conf["text02_show"])) $text02_show = $conf["text_02_show"];
            if(!empty($conf["text03_show"])) $text03_show = $conf["text03_show"];
            if(!empty($conf[$_::FOOTER_SHOW])) $footer_show = $conf[$_::FOOTER_SHOW];
        } 
        
        // HEADER
        $header_rendered = "";
        if($header_show || !empty($header_class) || !empty($header_name) || !empty($header) ){
            ob_start();
            ?>
            <div class="card-header <?php echo $header_class; ?> "><?php echo $header; ?></div><?php
            $header_rendered = ob_get_contents();
            ob_end_clean();
        }

        //TITLE
        $title_rendered = "";
        if(!empty($title_level)) $title_level = "h".$title_level;
        else $title_level = "h5";
        
        
        if($title_show || !empty($title_class) || !empty($title)){
            ob_start();
            ?><<?php echo $title_level;?> class="card-title <?php echo $title_class ?>"
            ><?php echo $title; ?></<?php echo $title_level; ?>><?php
            $title_rendered = ob_get_contents();
            ob_end_clean();
        }
        
        
        // TEXT 01
        $text_rendered = "";
        if(!empty($text_class) || !empty($text) || !empty($text_show)){
            ob_start();
            ?><p class="card-text <?php  echo $text_class; ?> "><?php echo $text; ?></p><?php 
            $text_rendered = ob_get_contents();
            ob_end_clean();
        }
        
        // TEXT 02
        $text02_rendered = "";
        if(!empty($text02_class) || !empty($text02) || !empty($text02_show)){
            ob_start();
            ?><p class="card-text <?php  echo $text02_class; ?> "><?php echo $text02; ?></p><?php 
            $text02_rendered = ob_get_contents();
            ob_end_clean();
        }
        
        // TEXT 03
        $text03_rendered = "";
        if(!empty($text03_class) || !empty($text03) || !empty($text03_show)){
            ob_start();
            ?><p class="card-text <?php  echo $text03_class; ?> "><?php echo $text03; ?></p><?php 
            $text03_rendered = ob_get_contents();
            ob_end_clean();
        }
        
        // FOOTER
        $footer_rendrered = "";
        if($footer_show || !empty($footer) || !empty($footer_class)){
            ob_start();
            ?><div class="card-footer <?php echo $footer_class; ?> "><?php echo $footer; ?></div><?php 
            $footer_rendered = ob_get_contents();
            ob_end_clean();
        }
        
        
        
        ob_start();
// hide/show wrapper
if($wrapper_show): ?>
<div class="<?php echo
                empty($name) ? " stds_card_wrapper " : $name."_wrapper", 
                empty($wrapper_col) ? " col " : " ".$wrapper_col." ",
                " ".$wrapper_class." ", empty($class_id) ? "" : " ".$class_id."_wrapper ";?>" <?php 
                if(!empty($id)): ?> id="<?php echo $id."_wrapper"; ?>"<?php endif;
    ?>><?php
// end show/hide wrapper
    endif; 
        // card div 
    ?>  <div class=" card <?php echo empty($class_id) ? "" : " ".$class_id." ", $card_class, $name; ?>"
            <?php if(!empty($id)): ?> id="<?php echo $id;?>" <?php endif; 
            if(!empty($data_data)): ?> data-data="<?php echo $data_data; ?>"<?php endif;

        ?> ><?php 
                // header, if any
                    if(!empty($header_rendered)) echo $header_rendered;  
                ?><div class="card-body <?php echo $body_class; ?>" 
                    ><?php echo $title_rendered, $pre_content, $body, $text_rendered, $text02_rendered, $text03_rendered,
                    $after_content, $footer_renered;
                //BODY END
                ?>
                </div>
        <?php
        // end of card div ?>
        </div>
    <?php
// /hideshow wrapper
if($wrapper_show): ?>
</div><?php 
endif; 
    
        $html = ob_get_contents();
        ob_end_clean();
        
        return $html;
        
    }
}