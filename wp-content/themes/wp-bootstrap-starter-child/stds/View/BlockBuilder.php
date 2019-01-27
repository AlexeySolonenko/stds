<?php
namespace Stds\View;

use \Stds\ViewBlocks\ColRowBlock;
use \Stds\ViewTypes\BlockProps;

/**
 * 
 * 
 */
class BlockBuilder{
    
    /**
     * @var BlockProps
     */
    protected $_;
    
    /**
     * 
     * 
     */
    public function __construct(){
        $this->_ = new BlockProps();
    }
    const EMPTY_STRING = "";
    /**
     * @param mixed $dum a prospective for future development
     * @param array $data
     * @param bool $firstRecursion to be deprecated if testing successfull
     */
    public function render($dum = '', array $blocks = [], bool $firstRecursion = true) {
        
        $_ = new BlockProps();
        $html = $content = "";
        $blocks = $this->normalizeBlocks($blocks);
        
        //todo to add sorting
        
        foreach($blocks as $block) {
            $content = "";
            if(!$this->validateBlock($block)) {
                continue;
            }
            
            if(!empty($block[$_::CHILDREN])) {
                $children = $this->normalizeBlocks($block[$_::CHILDREN]);
                foreach($children as $child) { 
                    $content .= $this->render("", $child, false);
                }
            } else {
                $content .= $block[$_::CONF][$_::CONTENT];
            }
            
            if($block[$_::CONF] instanceof \stdClass){
                $block[$_::CONF]->{$_::CONTENT} = $content;
            } else {
                $block[$_::CONF][$_::CONTENT] = $content;
            }
            
            $class = $block[$_::VIEW_CLASS];
            $_c = new $class();
            $html .= $_c->render($block[$_::CONF]);
        }
        
        return $html;
        
    }
    
    /**
     * 
     * $param array $block
     */
    protected function normalizeBlocks($blocks){
        $_ = new BlockProps();
        $singleBlock = (isset($blocks[$_::VIEW_CLASS])) ? true : false;
        if($singleBlock) $blocks = [$blocks];
        
        return $blocks;
    }
    /**
     * 
     * $param array $block
     * 
     */
    protected function validateBlock($block){
        $_ = new BlockProps();
        if(!isset($block[$_::VIEW_CLASS])){
            return false;
        }
        
        if(!class_exists($block[$_::VIEW_CLASS])){
            return false;
        }
        
        return true;
    }
    
}