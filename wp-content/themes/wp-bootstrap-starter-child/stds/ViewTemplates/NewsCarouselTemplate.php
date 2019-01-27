<?php
namespace Stds\ViewTemplates;

use \Stds\ViewTypes\NewsCarousel;

//if(!class_exists('NewsCarousel')) require(get_stylesheet_directory().'/inc/poster/view_types/NewsCarousel.php');

class NewsCarouselTemplate{
    
    public function render($data){
        if(is_array($data)){
            $content = $data['content'];
            $content_class = $data['content_class'];
        } elseif($data instanceof NewsCarousel){
            $content = $data->getContent();
            $content_class = $data->getContentClass();
        }
        
        ob_start();
        ?>
<div class=" <?php echo empty($content_class) ? "row" :  $content_class ?> ">
    <?php echo empty($content) ? "default content" :  $content ?>
</div>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        
        return $html;
    }
}


?>