<?php

namespace Stds\FeControllers;
use Stds\View\BlockBuilder;

class FrontPageController {
    
    
    public function getHotOffers(){
        $bb = new BlockBuilder();
        $catObj = get_term_by('slug','offers-hot','category');
        $q1 = new \WP_Query(['category__in' => (int)[$catObj->term_id], 'post_status' => 'publish','posts_per_page' => -1, 'orderby' => 'date']);
        //$q1 = new \WP_Query(['category_name' => 'offers-hot-offers', 'posts_per_page' => -1, 'orderby' => 'date','post_status'=>'publish']);
        $q1->have_posts();
        $html = "";
        $three = 0;
        $largeScreen = 0;
        $active = true;
        ob_start();
        $loops = $q1->found_posts + $q1->found_posts % 3;
        $loops = $q1->found_posts;
        for($i = 0; $i < $loops; $i++){ ?>
            <div class="carousel-item  <?php if($active) echo "active" ?>">
                <div class="row"> 
                    <div class="col-12 d-block d-md-none"><?php 
                        echo $bb->render("",json_decode($q1->posts[$i]->post_content,true));?>
                    </div><?php
                        for($t = 0;$t < 3; $t++): 
                            if($largeScreen >= $q1->found_posts):
                                $largeScreen = 0;
                            endif;
                            if($t > ($q1->found_posts-1)) continue;?>
                            <div class="col-4 d-none d-md-block"><?php
                                echo $bb->render("",json_decode($q1->posts[$largeScreen]->post_content,true));?>
                            </div><?php
                            $largeScreen++;
                        endfor;?>
                </div>
            </div><?php
            if($active) $active = false;
        }
        
        $html = ob_get_clean();
    
        
        return $html;
        
    }
    
}