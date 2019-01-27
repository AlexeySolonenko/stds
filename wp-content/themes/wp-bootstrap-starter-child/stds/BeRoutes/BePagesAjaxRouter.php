<?php

namespace Stds\BeRoutes;
use Stds\Types\AjaxRequestSingle;
use Stds\Types\AjaxResponseSingle;

class BePagesAjaxRouter {
    
    
    //const LOAD_ACTIVATE_HOT_OFFERS_FORM = 300;
    //const UPDATE_POST_STATUS = 301;
    //const LOAD_ADD_HOT_OFFER = 302;
    
    /**
     * @param array $post
     * @return string
     */
    public function index($post){
        $req = AjaxRequestSingle::singleton();
        $_ = new \Stds\Types\AjaxDefs();
        $ret = [];
        $dir = $req->getDirective();
       
        if($_::ADD_HOT_OFFER == $dir):
            (new \Stds\BeControllers\ManageFrontPageController())->addHotOffer($post);

        elseif($_::GET_MEDIA_OF_DIRECTORY == $dir):
            (new \Stds\ViewTemplates\MediaViewer())->getMediaBrowserContent();
        elseif($_::GET_MEDIA_VIEWER == $dir):
            (new \Stds\ViewTemplates\MediaViewer())->render();

        elseif($_::GET_MEDIA_UPLOAD_MANAGER == $dir):
            (new \Stds\ViewTemplates\MediaViewer())->getUploadManager();
        elseif($_::LOAD_ACTIVATE_HOT_OFFERS_FORM == $dir):
            (new \Stds\BeViews\ManageFrontPageView())->buildActivateHotOffers();

        elseif($_::LOAD_ADD_HOT_OFFER == $dir):
            (new \Stds\BeViews\ManageFrontPageView())->buildAddHotOffers();

        elseif($_::SUBMIT_MEDIA_HANDLER_ACTION == $dir):
            (new \Stds\BeControllers\MediaHandlerController())->handleAction();

        elseif($_::UPDATE_POST_STATUS == $dir):
            (new \Stds\BeControllers\ManageFrontPageController())->updatePostStatus($post);

        elseif($_::TEST == $dir):
            (new \Stds\BeControllers\ManageFrontPageController())->testFunction();
            
    
        endif;
    }
}