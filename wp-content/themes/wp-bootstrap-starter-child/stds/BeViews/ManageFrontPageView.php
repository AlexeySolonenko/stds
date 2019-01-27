<?php

namespace Stds\BeViews;

use \Stds\BeControllers\ManageFrontPageController;
use \Stds\BeRoutes\BePagesAjaxRouter;
use \Stds\Types\AjaxDefs;
use \Stds\Types\AjaxRequestSingle;
use \Stds\Types\AjaxResponseSingle;
use \Stds\View\BlockBuilder;
use \Stds\ViewTemplates\MediaViewer;
use \Stds\ViewTypes\AjaxPropsBuilder;
use \Stds\ViewTypes\BlockProps;
use Stds\Types\MediaHandlerSettings;
use Stds\ViewTemplates\HotOfferCarouselItem;
/**
 * Builds various forms to manage content of the front page
 * 
 */
class ManageFrontPageView
{
    const SELECT_FORM = 'select_form';
    const ACTIVATE_HOT_OFFERS = 3001;
    const ADD_HOT_OFFER = 3002;
    const CURRENT_FORM = 'current_form';
    const PUBLISHED = '1';
    const PENDING_PREVIEW = '2';
    const DRAFT = '3';
 
    //TODO to to redo into blocks later
    public function buildFormSelector()
    {
        $_ = new AjaxDefs();
        $req = AjaxRequestSingle::singleton();
        $res = AjaxResponseSingle::singleton();
        $cargo = $req->getCargo();
        $mediaViewer = new MediaViewer();

        $ajaxSetup = [
            $_::ALL_FORMS => false,
            $_::CARGO => ['cargo' => 'test'],
            $_::EVENT => $_::CHANGE,
            $_::HTML_CONTAINER => $_::MANAGE_FRONT_PAGE_BODY,
            $_::FUNCTION_ => 'handleFormSelectorResponse',
            $_::FUNCTION_PREPARE => 'handleFormSelector',
            $_::GROUP => $_::BE_PAGES_ROUTER,
            $_::MESSAGE_CONTAINER => 'message_container',
            //$_::SHOW_POPUP => true,
        ];
        $ajaxSetup = (new AjaxPropsBuilder($ajaxSetup))->getClassString();
        $selectedOption = $cargo['option'];


        $formSelectorAjaxClass = $ajaxSetup;
        ob_start(); ?>
          <form name="<?php echo self::SELECT_FORM; ?>" method="POST">
    	        <div class="form-row">
    	            <div class="form-group col-6">
    	                <label for="display_form">SELECT FORM</label>
    	                <select id="display_form" class="form-control display_form <?= $ajaxSetup; ?>" name="post_status">
    	                    <option 
                                value="-1" 
                                <?= ($selectedOption == -1) ? "selected " : "" ?>
                                >--</option>
    	                    <option
                                value=<?php echo $_::LOAD_ACTIVATE_HOT_OFFERS_FORM; ?>
                                <?= ($selectedOption == $_::LOAD_ACTIVATE_HOT_OFFERS_FORM) ? "selected " : "" ?> 
                                >ACTIVATE HOT OFFERS</option>
                            <option 
                                value=<?php echo $_::LOAD_ADD_HOT_OFFER; ?> 
                                <?= ($selectedOption == $_::LOAD_ADD_HOT_OFFER) ? "selected " : "" ?>
                                >ADD HOT OFFER</option>
                            <option 
                                value=<?php echo $_::GET_MEDIA_VIEWER; ?> 
                                <?= ($selectedOption == $_::GET_MEDIA_VIEWER) ? "selected " : "" ?>
                                >GET MEDIA VIEWER</option>
    	                    <option 
                                value=<?= $_::TEST; ?> 
                                <?= ($selectedOption == $_::TEST) ? "selected " : "" ?>
                                >TEST </option>
    	                </select>
    	            </div>
    	            <!-- <div class="form-group col-3"><?php
                    // if($_::LOAD_ACTIVATE_HOT_OFFERS_FORM == $selectedOption):
                    // elseif($_::LOAD_ADD_HOT_OFFER == $selectedOption):
                    // elseif($_::GET_MEDIA_VIEWER == $selectedOption):
                    //     $mediaViewer->render();
                    //     echo $res->getHtmlString();
                    // elseif($_::TEST == $selectedOption):
                    // endif;
                    ?>
                    </div> -->
    	        </div>
            </form><?php
        $html = ob_get_clean();
        ob_end_clean();       

        return $html;
    }
    
    /**
     * @return void
     */
    public function buildActivateHotOffers()
    {
        $aj = new AjaxDefs();
        $opts = [
            ['value' => self::PUBLISHED, 'text' => 'PUBLISHED'],
            ['value' => self::PENDING_PREVIEW, 'text' => 'PENDING'],
            ['value' => self::DRAFT, 'text' => 'DRAFT']
        ];
        $ajaxProps = [
            $aj::DIRECTIVE => $aj::UPDATE_POST_STATUS,
            $aj::GROUP => $aj::BE_PAGES_ROUTER
        ];
        $ajaxProps = (new AjaxPropsBuilder($ajaxProps))->getClassString();

        ob_start(); ?>
        <div class="row">
            <div class="col-12"><button type="button" id="update_posts_status" class="<?= $ajaxProps; ?> btn btn-primary">UPDATE STATUS</div><?php
            echo $this->getdHotOffersList($opts, self::PUBLISHED);
        echo $this->getdHotOffersList($opts, self::PENDING_PREVIEW);
        echo $this->getdHotOffersList($opts, self::DRAFT); ?></div><?php
        $html = ob_get_clean();
        //ob_end_clean();
        $res = AjaxResponseSingle::singleton();
        $res->setAction($aj::LOAD_ACTIVATE_HOT_OFFERS_FORM);
        $res->setHtmlString($html);
        $res->setHtmlContainer($aj::MANAGE_FRONT_PAGE_BODY);
        $res->addInfo("FORM LOADED SUCCESSFULLY");
        
    }
    
    

   /**
    * 
    *
    * @return void
    */
    public function buildAddHotOffers()
    {
        $html = $this->buildAddHotOffersMainForm();
        $_ = new BlockProps();
        $conf = [
            [
                $_::VIEW_CLASS => \Stds\ViewTemplates\HotOfferCarousel::class,
                $_::CONF => [
                    $_::NAME => 'hot_offer_01',
                    $_::TITLE => 'Hot Offer 01',
                    $_::SRC => '',
                    $_::ALT => 'Hot offer 01',
                    $_::TEXT => 'Black Friday Sale'
                ]
            ]
        ];

        // Build Return
        $res = AjaxResponseSingle::singleton();
        $res->setAction(AjaxDefs::LOAD_ADD_HOT_OFFER);
        $res->setHtmlContainer(AjaxDefs::MANAGE_FRONT_PAGE_BODY);
        $res->setHtmlString($html);
    }

    protected function getdHotOffersList($opts, $status)
    {
        $statusString = ManageFrontPageController::POST_STATUS_CODES[$status];

        ob_start();
        //$q1 = new \WP_Query(['category_name' => 'offers-hot', 'posts_per_page' => -1, 'orderby' => 'date','post_status'=>self::POST_STATUS_CODES[$status]]);
        $bb = new BlockBuilder();
        $catObj = get_term_by('slug','offers-hot','category');
        $q1 = new \WP_Query(['category__in' => (int)[$catObj->term_id], 'post_status' => $statusString,'posts_per_page' => -1, 'orderby' => 'date']);
        $r = AjaxResponseSingle::singleton();
        $q1->have_posts();
        $loops = $q1->found_posts;
        
        for ($i = 0; $i < $loops; $i ++):
            // same posts should not be shown more than once but with different statuses
            // if ($q1->posts[$i]->post_status != $statusString) {
            //     continue;
            // }
            
            ?>
            <div class="col-12 <?php echo $q1->posts[$i]->post_name; ?>_container ">
                <div class="row">
                    <div class="col-3">
                        <form>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="post_status_<?php echo $q1->posts[$i]->post_name; ?>">POST STATUS</label>
                                    <select 
                                        id="post_status_<?php echo $q1->posts[$i]->post_name; ?>" 
                                        name="post_status_<?= $q1->posts[$i]->ID ?>" 
                                        class="form-control display_form "><?php
                                        foreach ($opts as $opt):?>
                                            <option value="<?php echo $opt['value']; ?>" 
                                                    <?php if ($opt['value'] == $status): ?>selected<?php endif; ?> 
                                                    ><?php echo $opt['text']; ?></option><?php
                                        endforeach; ?>
                                    </select>
                                    <input type="hidden" value="<?php echo $q1->posts[$i]->ID; ?>" name="post_id"> 
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-9"><?php
                        //echo $q1->posts[$i]->post_content; 
                        try {
                            $conf = json_decode($q1->posts[$i]->post_content,true);
                            if(empty($conf)) $conf = [];
                            echo $bb->render("", $conf);
                        } catch(\Exception $e){} ?>
                    </div>
            </div>
            </div><?php
        endfor;
        
        $html = ob_get_clean();
        //pob_end_clean();
        
        return $html;
    }
    /**
     *
     * @return string
     */
    protected function buildAddHotOffersMainForm()
    {
        $_ = new BlockProps();
        $aj = new AjaxDefs();
        $media = new MediaHandlerSettings();
        $ajaxSetup = [
            $aj::DIRECTIVE => $aj::ADD_HOT_OFFER,
            $aj::FUNCTION_ => 'handleLoadHotOffersSubmitClick',
            $aj::GROUP => $aj::BE_PAGES_ROUTER,
        ];
        $ajaxSetup = (new AjaxPropsBuilder($ajaxSetup))->getClassString();
        $conf = [
            [
                $_::VIEW_CLASS => \Stds\ViewBlocks\Input01::class,
                $_::CONF => [
                    $_::LABEL => "Name",
                    $_::NAME => $_::NAME,
                ]
                
            ],
            [
                $_::VIEW_CLASS => \Stds\ViewBlocks\Input01::class,
                $_::CONF => [
                    $_::LABEL => "Title",
                    $_::NAME => $_::TITLE,
                ]
                
            ],
            [
                $_::VIEW_CLASS => \Stds\ViewBlocks\Input01::class,
                $_::CONF => [
                    $_::LABEL => "Text",
                    $_::NAME => $_::TEXT,
                ]
                
            ],
            [
                $_::VIEW_CLASS => \Stds\ViewBlocks\Input01::class,
                $_::CONF => [
                    $_::LABEL => "Image",
                    //$_::NAME => $media::IMG_NAME_PREVIEW,
                    $_::CLASS_ => $media::PICKER_TARGET_TEXT,
                    $_::DISABLED => 'disabled',
                ]
                
            ],
            [
                $_::VIEW_CLASS => \Stds\ViewBlocks\Input01::class,
                $_::CONF => [
                    $_::NAME => $_::SRC,
                    $_::TYPE => 'hidden',
                    $_::CLASS_ => $media::PICKER_TARGET_IMG_NAME
                ]
                
            ],
            [
                $_::VIEW_CLASS => \Stds\ViewBlocks\Input01::class,
                $_::CONF => [
                    $_::LABEL => "Image text",
                    $_::NAME => $_::ALT,
                ]
                
            ],
            [
                $_::VIEW_CLASS => \Stds\ViewBlocks\Button::class,
                $_::CONF => [
                    $_::TEXT => "SUBMIT",
                    $_::NAME => \Stds\ViewTypes\AjaxProps::ADD,
                    $_::AJAX_CLASS => $ajaxSetup,
                ]
                
            ],
        ];
        //TODO to make tooltip for a hot offer?
        //TODO to add a submit button and to start submitting data, wihout image - set an image to a default at the first stage
        
        $bb = new \Stds\View\BlockBuilder();
        $pickerConf = [
            $media::TYPE => $media::PICKER,
        ];
        
        ob_start(); ?>
            <form method="POST" name="add_hot_offers_main_form">
                <div class="form-row">
                    <?= $bb->render(null, $conf); ?>
                </div>
            </form>
            <div class="form-row">
                <?= (new HotOfferCarouselItem())->render([$_::TITLE => 'title',$_::TEXT => 'Text',$_::IMG_CLASS => $media::PICKER_TARGET_IMG]); ?>
            </div>
            <div class="form-row">
                <?= (new MediaViewer())->render($pickerConf); ?>
            </div>
        <?php
        
        //TODO
        // make toaster automatic processor
        // complete transfer to objects, exclude returns
        // save config in wp with add post
        // start images
        // check js private props see ajax response class
        
        $html = ob_get_clean();
        
        return $html;
    }
}
