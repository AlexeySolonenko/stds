<?php

namespace Stds\ViewTemplates;

use \Stds\Types\Sys;
use Stds\View\BlockBuilder;
use Stds\ViewTypes\BlockProps;
use Stds\Types\AjaxResponseSingle;
use Stds\ViewTypes\AjaxPropsBuilder;
use Stds\Types\AjaxDefs;
use Stds\Types\MediaHandlerSettings;
use Stds\Types\AjaxRequestSingle;

/**
 * @see Stds\Types\MediaHandlerSettings for hints on what props you might need
 */
class MediaViewer
{
    /**
     *
     * @param array $conf
     * @return void
     */
    public function render($conf = [])
    {
        /*
        NEXT TODO - TO SETUP PARAMS IN START FRONT PAGE TO CALL MEDIA HANDLER
        */
        /* prepare vars */
        $_ = new BlockProps();
        $aj = new AjaxDefs();
        $bb = new BlockBuilder();
        $media = new MediaHandlerSettings();
        //$upload_dir = wp_upload_dir()['basedir'];
        $req = AjaxRequestSingle::singleton();
        $res = AjaxResponseSingle::singleton();
        if (empty($conf)) {
            $conf = $req->getCargo();
        }
        if (empty($conf)) {
            $conf = [];
        }
        if($conf[$media::TYPE] == $media::PICKER){
            $picker = true;
        } else  $picker= false;

        if (empty($conf[$media::REDIR_COMEBACK_URL])) {
            $redirUrl = $_SERVER['HTTP_REFERER'];
            $redirUrl = parse_url($redirUrl);
            $redirUrl = $redirUrl['host'].$redirUrl['path'];
        } else {
            $redirUrl = $conf[$media::REDIR_COMEBACK_URL];
        }
        
        ob_start(); ?>
            <div class ="col-12 ">
                <form   method="POST" 
                        action="<?= ""; /* $_SERVER['SCRIPT_NAME']; */ ?>" 
                        name="<?= $media::MEDIA_HANDLER_FORM; ?>"
                        enctype="multipart/form-data"                
                
                >
                    <?php /* build menu */ ?>
                    <div class="row">
                        <?php if($picker): ?>
                            <input type='hidden' name='<?= $media::TYPE; ?>' value='picker'>
                        <?php endif; ?>
                        <?= $bb->render('', $this->getDirectoriesSelect($conf)); ?>
                        <?= $this->getMenu($conf); ?>
                    </div>
                    <?php /* build contents or media browser */ ?>
                    <div class="row <?= $media::MEDIA_HANDLER_BROWSER; ?> ">
                        <?= $this->getMediaBrowserContent($conf); ?>
                    </div>    
                </form>
            </div>
            <?php /* build an upload window */ ?>
            <?php if(!$picker): ?>
                <div class="col-12 <?= $media::MEDIA_HANDLER_UPLOAD_CONTAINER; ?> d-none">
                    <form 
                        id="<?= $media::UPLOAD_FORM_ID; ?>"
                        method="post"
                        action="http://transfer.tab4lioz.beget.tech/upload-redir/"
                        enctype="multipart/form-data"
                        >
                        <input  type='hidden' 
                                name='<?= $media::REDIR_COMEBACK_URL; ?> '
                                id='<?= $media::REDIR_COMEBACK_URL; ?>'
                                value="<?= $redirUrl; ?>"
                                />
                        <input 
                                type="file"
                                name="<?= $media::MEDIA_FILE_UPLOAD_FIELD; ?>"
                                id="<?= $media::MEDIA_FILE_UPLOAD_FIELD; ?>"  
                                multiple="false" />
                        <!-- <input type="hidden" name="post_id" id="post_id" value="55" /> -->
                        <?php wp_nonce_field($media::MEDIA_FILE_UPLOAD_FIELD, $media::MEDIA_FILE_UPLOAD_FIELD.'_nonce'); ?>
                        <input 
                                type="submit"
                                id="<?= $media::UPLOAD_BTN; ?>" 
                                name="<?= $media::UPLOAD_BTN; ?>"  
                                value="Upload" />
                    </form>
                <div>
            <?php endif; ?>
            <?php
        $html = ob_get_clean();
        
        $res->setHtmlString($html);
        if (empty($conf[$media::MEDIA_HANDLER_CONTAINER])) {
            $container = $aj::MANAGE_FRONT_PAGE_BODY;
        } else {
            $container = $conf[$aj::MEDIA_HANDLER_CONTAINER];
        }
        $res->setHtmlContainer($container);
        $res->setAction($aj::GET_MEDIA_VIEWER);
        
        return $html;
    }


    /**
     * Builds either a source or destination directory select-drop-down
     * 
     * @param array $conf
     * @return array returns config for BlockBuilder-`>render()
     */
    protected function getDirectoriesSelect(array $conf)
    {
        /* prepare vars */
        $s = new Sys();
        $_ = new BlockProps();
        $aj = new AjaxDefs();
        $media = new MediaHandlerSettings();

        /* collect data */
        $upload_dir = wp_upload_dir()['basedir'];
        
        $list = get_flat_files_array_from_dir($upload_dir.'/'.$dir);
        $opts = [];
        $optConf = [
            $_::VIEW_CLASS => \Stds\ViewBlocks\Option::class,
            $_::CONF => [
                
            ]
        ];
        // foreach ($list as $asset) {
        //     $dirname = basename(dirname($asset['path']));
        //     $r->addDebugs($dirname);
        //     if (!in_array($dirname, $s::BE_DIRECTORIES)) {
        //         continue;
        //     }
        //     $text = str_replace('_', ' ', ucwords($basename, '_'));
        //     $optConf[$_::CONF] = array_merge($optConf[$_::CONF], [
        //         $_::VALUE => $basename,
        //         $_::TEXT => $text,
        //     ]);
        //     $opts[] = $optConf;
        // }
        $r = AjaxResponseSingle::singleton();
        if (!empty($conf[$media::DIR])) {
            $selectedOption = $conf[$media::DIR];
        } else {
            $selectedOption = $s::UPLOADS;
        }
        /* build options  */
        foreach ($s::MEDIA_CUSTOM_FOLDERS as $dir) {
            $dirName = explode('/', $dir);
            $dirName = $dirName[0];
            $r->addDebugs($dirName);
            $selected = "";
            if ($dir == $selectedOption) {
                $selected = "selected";
            }
            $text = str_replace('_', ' ', ucwords($dirName, '_'));
            $optConf[$_::CONF] = array_merge($optConf[$_::CONF], [
                    $_::VALUE => $dir,
                    $_::TEXT => $text,
                    $_::SELECTED => $selected,
                ]);
            $opts[] = $optConf;
        }
        /* build ajax config. On each new value selected - reload the browser content */
        $ajaxSetup = [
            $aj::ALL_FORMS => false,
            $aj::DIRECTIVE => $aj::GET_MEDIA_OF_DIRECTORY,
            $aj::EVENT => $aj::CHANGE,
            $aj::FORM => $media::MEDIA_HANDLER_FORM,
            //$_::FUNCTION_ => 'handleFormSelectorResponse',
            //$_::FUNCTION_PREPARE => 'handleFormSelector',
            $aj::GROUP => $aj::BE_PAGES_ROUTER,
            $aj::HTML_CONTAINER => $media::MEDIA_HANDLER_BROWSER,
            //$_::SHOW_POPUP => true,
        ];
        $ajaxSetup = (new AjaxPropsBuilder($ajaxSetup))->getClassString();

        if (empty($conf[$media::TARGET_DIR])) {
            $name = $media::DIR;
        } else {
            $name = $conf[$media::TARGET_DIR];
            //$ajaxSetup = null;
        }
        $selectConf = [
            $_::VIEW_CLASS => \Stds\ViewBlocks\Select::class,
            $_::CONF => [
                $_::LABEL => 'SELECT FOLDER',
                $_::OPTS => $opts,
                $_::AJAX_CLASS => $ajaxSetup,
                /* whenever directory select changes its value - reload media browser windows contents */
                $_::NAME => $name,
            ],
        ];

        return $selectConf;
    }

    /**
     *
     *
     * @param array $conf
     * @return void
     */
    protected function getMenu($conf = [])
    {
        $_ = new MediaHandlerSettings();
        $type = $conf[$_::TYPE];
        /* picker services to pick one media item and to send its' id to the server */
        if ($type == 'picker') {
            $html = $this->buildPickerMenu($conf);
        /* default is a standard media manager for view, copy and movement of media */
        } else {
            $html = $this->buildManagerMenu($conf);
        }

        return $html;
    }

    /**
     * Builds s lightened version of the menu for a picker 
     *
     * @param array $conf
     * @return string $html
     */
    protected function buildPickerMenu($conf = [])
    {
        $bb = new BlockBuilder();
        $media = new MediaHandlerSettings();
        $_ = new BlockProps();
        //$action = $this->buildHiddenPickerAction();
        /* at this stage we are dealing with a single <input name = 'src' ... img source field
            and with a single preview image */
        $pickerConf = [
            $media::PICKER_TARGET_TEXT => $media::PICKER_TARGET_TEXT,
            $media::PICKER_TARGET_IMG => $media::PICKER_TARGET_IMG,
            $media::PICKER_TARGET_IMG_NAME => $media::PICKER_TARGET_IMG_NAME,
        ];
        $pickerConf = $this->buildMediaPickerConfig($pickerConf);
        $submit = [
            $_::VIEW_CLASS => \Stds\ViewBlocks\Button::class,
            $_::CONF => [
                $_::CLASS_ => " ".$pickerConf,
                $_::TEXT => 'Select',
                $_::NAME =>  'submit',
            ]
        ];

        ob_start();
        echo $bb->render('',$submit);
        
        $html = ob_get_clean();

        return $html;
    }

    /**
     *
     * @param array $conf
     * @return string
     */
    protected function buildManagerMenu(array $conf)
    {
        $bb = new BlockBuilder();
        $action = $this->buildAction($conf);
        $media = new MediaHandlerSettings();
        /* target diretory if moving of copying */
        $conf[$media::TARGET_DIR] = $media::TARGET_DIR;
        $targetDir = $this->getDirectoriesSelect($conf);
        $submit = $this->buildSubmit($conf);
        $upload = $this->buildUpload($conf);
        ob_start();
        echo $bb->render('', $action);
        echo $bb->render('', $targetDir);
        echo $bb->render('', $submit);
        echo $bb->render('', $upload);
        $html = ob_get_clean();
        
        return $html;
    }

    /**
     *
     * @param array $conf
     * @return array config for BlockBuilder->render()
     */
    protected function buildAction(array $conf)
    {
        $_ = new BlockProps();
        $s = new Sys();
        $media = new MediaHandlerSettings();
        $aj = new AjaxDefs();

        /* ACTION */
        $opts = [];
        $optConf = [
            $_::VIEW_CLASS => \Stds\ViewBlocks\Option::class,
            $_::CONF => [
                
            ]
        ];
        $optConf[$_::CONF] = array_merge($optConf[$_::CONF], [$_::VALUE => $s::MOVE,$_::TEXT => 'MOVE']);
        $opts[] = $optConf;
        $optConf[$_::CONF] = array_merge($optConf[$_::CONF], [$_::VALUE => $s::COPY,$_::TEXT => 'COPY']);
        $opts[] = $optConf;
        $optConf[$_::CONF] = array_merge($optConf[$_::CONF], [$_::VALUE => $s::DELETE,$_::TEXT => 'DELETE']);
        $opts[] = $optConf;

        $action = [
            $_::VIEW_CLASS => \Stds\ViewBlocks\Select::class,
            $_::CONF => [
                $_::LABEL=> 'Action',
                $_::NAME => $media::MEDIA_HANDLER_ACTION,
                $_::OPTS=> $opts,
            ]
        ];

        return $action;
    }

    /**
     *
     * @param array $conf
     * @return array config for BlockBuilder->render()
     */
    protected function buildSubmit(array $conf)
    {
        $_ = new BlockProps();
        $s = new Sys();
        $media = new MediaHandlerSettings();
        $aj = new AjaxDefs();
        if (empty($conf[$media::HTML_CONTAINER])) {
            $htmlContainer = $media::MEDIA_HANDLER_BROWSER;
        } else {
            $htmlContainer = $conf[$media::HTML_CONTAINER];
        }
        /* submit button */
        $ajaxSetup = [
            $aj::ALL_FORMS => true,
            $aj::COLLECT_FORM_DATA_WITH_ARRAYS => true,
            $aj::DIRECTIVE => $aj::SUBMIT_MEDIA_HANDLER_ACTION,
            $aj::EVENT => $aj::CLICK,
            //$_::FUNCTION_ => 'handleFormSelectorResponse',
            //$_::FUNCTION_PREPARE => 'handleFormSelector',
            $aj::GROUP => $aj::BE_PAGES_ROUTER,
            //$aj::HTML_CONTAINER => $htmlContainer,
            //$_::SHOW_POPUP => true,
        ];
        $ajaxSetup = (new AjaxPropsBuilder($ajaxSetup))->getClassString();
        $submit = [
            $_::VIEW_CLASS => \Stds\ViewBlocks\Button::class,
            $_::CONF => [
                $_::AJAX_CLASS => $ajaxSetup,
                $_::TEXT => 'Submit',
                $_::NAME =>  'submit',
            ]
        ];

        return $submit;
    }

    /**
     *
     * @param array $conf
     * @return array config for BlockBuilder->render()
     */
    protected function buildUpload(array $conf)
    {
        $_ = new BlockProps();
        $s = new Sys();
        $media = new MediaHandlerSettings();
        $aj = new AjaxDefs();
        if (empty($conf[$media::HTML_CONTAINER])) {
            $htmlContainer = $media::MEDIA_HANDLER_BROWSER;
        } else {
            $htmlContainer = $conf[$media::HTML_CONTAINER];
        }

        $upload = [
            $_::VIEW_CLASS => \Stds\ViewBlocks\Button::class,
            $_::CONF => [
                $_::TEXT => 'Go To Upload',
                $_::NAME => $media::SWITCH_UPLOAD_WINDOW_BTN,
            ]
        ];

        return $upload;
    }

    /**
     *
     * @return void
     */
    public function getMediaUploadManager()
    {
        $aj = new AjaxDefs();
        $bb = new BlockBuilder();
        $media = new MediaHandlerSettings();
        $s = new Sys();

        ob_start();
        


        $html = ob_get_clean();

        $res = AjaxResponseSingle::singleton();
        $res->setHtmlContainer($media::MEDIA_HANDLER_BROWSER);
        $res->setHtmlString($html);
        $res->setAction($aj::GET_MEDIA_OF_DIRECTORY);
    }

    /**
     *
     * @param array $conf
     * @param array $mediaItem
     * @return array config for BlockBuilder->render()
     */
    protected function buildThumb(array $conf, array $mediaItem)
    {
        $aj = new AjaxDefs;
        $_ = new BlockProps();
        $s = new Sys();
        $bb = new BlockBuilder();

        /* @TODO TO HANDLE IMAGES, OTHER MEDIA TYPES, ETC. */
        /* @TODO TO ADD LAZY LOAD OF IMAGES  */
        $filepath = $mediaItem['path'];
        $filename = basename($filepath);
        $imgConf = [
            [
                $_::VIEW_CLASS => \Stds\ViewBlocks\ColRowBlock::class,
                $_::CONF => [
                    $_::COL_CLASS => 'col-8 col-md-10 col-lg-11'
                ],
                $_::CHILDREN => [
                    /* child 0 */
                    [
                        $_::VIEW_CLASS => \Stds\ViewBlocks\ColBlock::class,
                        $_::CONF => [
                            $_::COL_CLASS => 'col-12',
                        ],
                        $_::CHILDREN =>  [
                            [
                                $_::VIEW_CLASS => \Stds\ViewBlocks\Img::class,
                                $_::CONF => [
                                    //$_::COL_CLASS => ''
                                    $_::SRC => $mediaItem['baseurl'],
                                ],
                            ]
                        ]
                    ],
                    /* child 1 */
                    [
                        $_::VIEW_CLASS => \Stds\ViewBlocks\ColBlock::class,
                        $_::CONF => [
                            $_::COL_CLASS => 'col-12',
                            $_::CONTENT => $filename,
                        ]
                    ],
                ]
            ]
        ];

        return $imgConf;
    }

    /**
     *
     * @param array $conf
     * @param array $mediaItem
     * @return array conf for BlockBuilder->render()
     */
    protected function buildCheckBox(array $conf, array $mediaItem)
    {
        $aj = new AjaxDefs;
        $_ = new BlockProps();
        $s = new Sys();
        $bb = new BlockBuilder();
        $m = new MediaHandlerSettings();
        /* @TODO TO HANDLE IMAGES, OTHER MEDIA TYPES, ETC. */
        /* @TODO TO ADD LAZY LOAD OF IMAGES  */
        $filepath = $mediaItem['path'];
        $filename = basename($filepath);
        $img = [
            $_::VIEW_CLASS => \Stds\ViewBlocks\Img::class,
            $_::CONF => [
                //$_::COL_CLASS => ''
                $_::SRC => $mediaItem['baseurl'],
            ],
        ];
        $img = (new BlockBuilder())->render('',$img);

        $checkBoxConf = [
            [
                $_::VIEW_CLASS => \Stds\ViewBlocks\ColRowBlock::class,
                $_::CONF => [
                    $_::COL_CLASS => 'col-12'
                ],
                $_::CHILDREN => [
                    /* child 0 */
                    // [
                    //     $_::VIEW_CLASS => \Stds\ViewBlocks\ColBlock::class,
                    //     $_::CONF => [
                    //         $_::COL_CLASS => 'col-12',
                    //     ],
                    //     $_::CHILDREN =>  [
                    //         [
                    //             $_::VIEW_CLASS => \Stds\ViewBlocks\Img::class,
                    //             $_::CONF => [
                    //                 //$_::COL_CLASS => ''
                    //                 $_::SRC => $mediaItem['baseurl'],
                    //             ],
                    //         ]
                    //     ]
                    // ],
                    [
                        $_::VIEW_CLASS => \Stds\ViewBlocks\Input01::class,
                        $_::CONF => [
                            $_::COL_CLASS => 'col-12',
                            $_::LABEL_AFTER =>$img,
                            $_::LABEL_AFTER_CLASS => 'col-8 col-md-10 col-lg-11',
                            $_::TYPE => $_::CHECKBOX,
                            $_::NAME => $m::SELECTED_ITEM.$aj::AJAX_DELIM.$filepath,
                            $_::CLASS_ => $m::SELECTED_ITEM.$m::DELIM.$mediaItem['baseurl'],
                        ],
                    ],
                    /* child 1 */
                    [
                        $_::VIEW_CLASS => \Stds\ViewBlocks\ColBlock::class,
                        $_::CONF => [
                            $_::COL_CLASS => 'col-12',
                            $_::CONTENT => $filename,
                        ]
                    ],
                ]
            ]
        ];

        return $checkBoxConf;
    }

    /**
     *
     * @param array $conf
     * @return string
     */
    public function getMediaBrowserContent(array $conf = [])
    {
        $aj = new AjaxDefs();
        $bb = new BlockBuilder();
        $media = new MediaHandlerSettings();
        $s = new Sys();        /* if this function called locally, from this controller, use $conf from args
         otherwise = use data from $_REQUEST */
        if (empty($conf)) {
            $req= AjaxRequestSingle::singleton();
            $conf = $req->getCargo();
        }
        if (empty($conf)) {
            $conf = [];
        }
        $picker = (($conf[$media::TYPE] == 'picker') ? true: false);
        
        $selectPane = $this->buildMediaBrowserSelectPane($conf);
        $viewPane = "";
        if(!$picker) $viewPane = $this->buildMediaBrowserViewPane($conf);

        ob_start(); ?>
                <div class="<?php echo(!$picker ? 'col-6' : 'col-12')," ",$media::MEDIA_HANDLER_SELECT_PANE; ?>">
                <div class="row">
                    <?= $selectPane; ?>
                </div>
                <?php if(!$picker): ?>
                    </div>
                    <div class="col-6 <?= $media::MEDIA_HANDLER_VIEW_PANE; ?> " >
                    <div class="row">
                        <?= $viewPane; ?>
                    </div>
                <?php else: ?>
                    </div>
                <?php endif; ?>
                <?php
            $html = ob_get_clean();
        //$html = "";
        
    
        $res = AjaxResponseSingle::singleton();
        $res->setHtmlContainer($media::MEDIA_HANDLER_BROWSER);
        $res->setHtmlString($html);
        $res->setAction($aj::GET_MEDIA_OF_DIRECTORY);


        return $html;
    }

    /**
     * 
     * @param array $conf
     * @return string
     */
    protected function buildMediaBrowserSelectPane(array $conf)
    {
        $aj = new AjaxDefs();
        $bb = new BlockBuilder();
        $media = new MediaHandlerSettings();
        $s = new Sys();        
        $selectPane = '';
         /* resolve target directory */
        if (empty($conf[$media::DIR])) {
            $dir = Sys::UPLOADS;
        } else {
            $dir = $conf[$media::DIR];
        }
    
        if (in_array($dir, Sys::MEDIA_CUSTOM_FOLDERS)):
        /* prepare select pane content (left, for both, browser and picker, but no for viewer */
        $list = get_flat_files_array_from_dir($dir, $s::IMG);
        
        foreach ($list as $item) {
            $selectPane .= $bb->render('', $this->buildCheckBox($conf, $item));
            //$selectPane .= $bb->render('', $this->buildThumb($conf, $item));
        }
        endif;

        return $selectPane;
    }

    /**
     *
     * @param array $conf
     * @return string
     */
    protected function buildMediaBrowserViewPane(array $conf)
    {
        $media = new MediaHandlerSettings();
        /* @TODO to handle all media types */
        $viewPane = '';
        if (empty($conf[$media::TARGET_DIR])) {
            $dir = Sys::UPLOADS;
        } else {
            $dir = $conf[$media::TARGET_DIR];
        }
        if (in_array($dir, Sys::MEDIA_CUSTOM_FOLDERS)):
             
            $list = get_flat_files_array_from_dir($dir, Sys::IMG);
            foreach ($list as $item) {
                $viewPane .= (new BlockBuilder())->render('', $this->buildThumb($conf, $item));
            }
        endif;

        return $viewPane;
    }

    /**
     * Builds a class string to be handled by front end.
     * Front end takes this class string and fills picker_target_text with the name of the selected image
     * and picker_target_text with the url of the selected image
     * @TODO to 
     *
     * @param array $conf
     * @return void
     */
    protected function buildMediaPickerConfig($conf = [])
    {
        $m = new MediaHandlerSettings();
        $class_string = [];
        $class_string[] = $m::PICKERIFY_ME;
        $class_string[] = $m::PICKERIFY_ME.$m::DELIM.$m::PICKER_TARGET_TEXT.$m::DELIM.$conf[$m::PICKER_TARGET_TEXT];
        $class_string[] = $m::PICKERIFY_ME.$m::DELIM.$m::PICKER_TARGET_IMG.$m::DELIM.$conf[$m::PICKER_TARGET_IMG];
        $class_string[] = $m::PICKERIFY_ME.$m::DELIM.$m::PICKER_TARGET_IMG_NAME.$m::DELIM.$conf[$m::PICKER_TARGET_IMG_NAME];

        return implode(' ',$class_string);
    }
}
