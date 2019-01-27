<?php

namespace Stds\ViewTypes;

class NewsCarousel{
    
    protected $content;
    protected $content_class;
    
    public function toArray(){
        $r = new ReflectionClass($this);
        $props = $r->getProperties();
        $arr = [];
        foreach($props as $prop){
            $prop->setAccessible(true);
            $arr[$prop->getName()] = $prop->getValue($this);
            $prop->setAccessible(false);
        }
        
        return $arr;
    }
    
    public function getContent(){
        return $this->content;
    }
    
    public function getContentClass(){
        return $this->content_class;
    }
    
    public function setContent($content){
        $this->content = $content;
        
        return $this;
    }
    
     public function setContentClass($content_class){
        $this->content_class = $content_class;
        
        return $this;
    }
    
    
}