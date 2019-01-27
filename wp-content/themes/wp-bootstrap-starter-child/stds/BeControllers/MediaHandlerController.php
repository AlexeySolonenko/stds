<?php

namespace Stds\BeControllers;

use Stds\Types\AjaxRequestSingle;
use Stds\Types\AjaxResponseSingle;
use Stds\ViewTypes\BlockProps;
use Stds\Types\Sys;
use Stds\Types\MediaHandlerSettings;
use Stds\Types\AjaxDefs;

/**
 * TODO TO HANDLE CONFIRMATION IF A FILE EXISTS? OR JUST TO REJECT?
 * AT THIS STAGE JUST TO REJECT AND EMAIL THAT ERROR? OR KEEP A MESSAGE PAGE
 */
class MediaHandlerController
{


    /**
     *
     * @return void
     */
    public function handleAction()
    {
        $_ = new BlockProps();
        $s = new Sys();
        $media = new MediaHandlerSettings();
        $aj = new AjaxDefs();
        $req = AjaxRequestSingle::singleton();
        $res = AjaxResponseSingle::singleton();
        $cargo = $req->getCargo();
        
        $items = $this->getMediaItemsFromPage();
        $action = $req->getCargo($media::MEDIA_HANDLER_ACTION);
        /* arguments array - perhaps to replace with a static class ? */
        $a = [];

        if (in_array($action,[$s::MOVE,$s::COPY,$s::DELETE])):
            $this->handleFiles($items);        
        else:
            $res->addWarnings('Unknown file operation requested.');
        endif;
    }

    /**
     * returns full file names to handle and values representing actions
     *
     * @return array
     */
    protected function getMediaItemsFromPage()
    {
        $req = AjaxRequestSingle::singleton();
        $cargo = $req->getCargo();
        $media = new MediaHandlerSettings();
        $aj = new AjaxDefs();
        $items = [];

        foreach ($cargo as $key => $value) {
            $name = explode($media::SELECTED_ITEM, $key);
            if (empty($name[1])) {
                continue;
            }
            /* at this stage we will collect all values, and will sort checked not checked later */
            // if((int)$value !== 1){
            //     continue;
            // }
            
            $name = explode($aj::AJAX_DELIM, $name[1]);
            $items[$name[1]] = $value;
        }

        return $items;
    }

    /**
     *
     * @param array $items     
     * @return void
     */
    protected function handleFiles(array $items)
    {
        $_ = new BlockProps();
        $s = new Sys();
        $media = new MediaHandlerSettings();
        $aj = new AjaxDefs();
        $req = AjaxRequestSingle::singleton();
        $res = AjaxResponseSingle::singleton();
        $cargo = $req->getCargo();
    

        if ($cargo[$media::DIR] == $cargo[$media::TARGET_DIR] && $cargo[$media::MEDIA_HANDLER_ACTION] != $s::DELETE) {
            $res->addWarnings('Please, select a different directory to move file(s) to');
            return;
        }
    
        $from = wp_upload_dir()['basedir'].'/'.$cargo[$media::DIR];
        $to = wp_upload_dir()['basedir'].'/'.$cargo[$media::TARGET_DIR];
      
    
        /* TODO TO REMOVE ABSOLUTE PATH FROM FE or encode ? BUT LINK REMAINS ?? */
        /* move files and report on results */
        $toHandle= 1;
        foreach ($items as $name => $value):
            if ((int)$value == $toHandle) {
                $fileName = basename($name);
                if (!file_exists($name)) {
                    $res->addErrors('File "'.$name.'" not found');
                    continue;
                }
                
                /*TODO to check if required to move thorugh a temp buffer ?  */
                if ($cargo[$media::MEDIA_HANDLER_ACTION] == $s::MOVE) {
                    $ret = rename($name, $to.'/'.$fileName);
                } elseif ($cargo[$media::MEDIA_HANDLER_ACTION] == $s::DELETE) {
                    if($cargo[$media::DIR] != $s::BIN){
                        $to = wp_upload_dir()['basedir'].'/'.$s::BIN;
                        $ret = rename($name, $to.'/'.$fileName);
                        $res->addInfo('Files moved to bin');
                    } else {
                        $ret = unlink($name);
                        $res->addInfo('"'.$fileName.'" deleted');
                    }

                } elseif($cargo[$media::MEDIA_HANDLER_ACTION] == $s::COPY){
                    $ret = copy($name,$to.'/'.$fileName);
                }
                if (!$ret) {
                    $res->addErrors('Error handling file "'.$fileName.'"');
                }
            }
        endforeach;
        $res->setHtmlContainer($media::MEDIA_HANDLER_BROWSER);
        $conf = [];
        $conf[$media::DIR] = $cargo[$media::DIR];
        $conf[$media::TARGET_DIR] = $cargo[$media::TARGET_DIR];
        $html = (new \Stds\ViewTemplates\MediaViewer())->getMediaBrowserContent($conf);
        $res->setHtmlString($html);
    }

    

    protected function handleDelete()
    {
    }
    
    public function handleSubmitSelectedItems()
    {
    }
}
