<?php

namespace Stds\BeControllers;

use \Stds\BeViews\ManageFrontPageView;
use \Stds\Types\AjaxDefs;
use \Stds\Types\AjaxRequestSingle;
use \Stds\Types\AjaxResponseSingle;
use \Stds\Types\Sys;
use \Stds\View\BlockBuilder;
use \Stds\ViewTypes\BlockProps;

class ManageFrontPageController
{
    const POST_STATUS_CODES =[
        ManageFrontPageView::PUBLISHED => 'publish',
        ManageFrontPageView::PENDING_PREVIEW => 'pending',
        ManageFrontPageView::DRAFT => 'draft',
    ];

    public function updatePostStatus($post)
    {
        $ret = [];
        $r = AjaxResponseSingle::singleton();
        $req = AjaxRequestSingle::singleton();

        foreach ($req->getCargo() as $key => $postStatus) {
            if (strpos($key, 'post_status_') === false) {
                continue;
            }
            $id = explode('post_status_', $key);
            $id = $id[1];
            if (empty($id)) {
                continue;
            }

            if (!in_array($postStatus, array_keys(self::POST_STATUS_CODES))) {
                $r->addWarnings('post status not registered: '.$postStatus);
                continue;
            }
        
            $ret[] = wp_update_post(
                [
                    'ID' => $id,
                    'post_status' => self::POST_STATUS_CODES[$postStatus]
                ]
            );
        }
        $r->addCargo('ret', $ret);
        return 'test';
    }
    
    public function buildFormSelector()
    {
    }

    /**
     * @return void
     */
    public function addHotOffer()
    {
        $aj = new AjaxDefs;
        $_ = new BlockProps();
        $req = AjaxRequestSingle::singleton();
        $res = AjaxResponseSingle::singleton();
        $res->addCargo('req', $req->getCargo());
        $params = [
          $_::NAME =>  $req->getCargo($_::NAME),
          $_::ALT =>  $req->getCargo($_::ALT),
          $_::SRC =>  $req->getCargo($_::SRC),
          $_::TEXT =>  $req->getCargo($_::TEXT),
          $_::TITLE=>  $req->getCargo($_::TITLE),
        ];
        $viewClass = \Stds\ViewTemplates\HotOfferCarouselItem::class;
        $postContent = [
            [
                $_::VIEW_CLASS => str_replace("\\", "\\\\", \Stds\ViewTemplates\HotOfferCarouselItem::class),
                //$_::VIEW_CLASS => $viewClass,
                $_::CONF => $params,
            ]
        ];
        try {
            $postContent = json_encode($postContent);
        } catch (\Exception $e) {
            $res->addErrors($e->getMessage());
            $res->setStatus($aj::ERROR);
            return;
        }
        if (json_last_error() !== JSON_ERROR_NONE) {
            $res->addErrors($e->getMessage());
            $res->setStatus($aj::ERROR);
            return;
        }
        $post = [
            'post_content' => $postContent,
            'post_title' => $params[$_::TITLE],
            'post_name' => $params[$_::NAME],
            //'post_category' => ['offers-hot-offers'],
            'post_category' => [
                get_term_by('slug', 'offers-hot-offers', 'category')->{'term_id'}
            ],
        ];
        $postId= wp_insert_post($post, true);
        if (!is_numeric($postId) || $postId === 0) {
            $res->addErrors($e->getMessage());
            $res->setStatus($aj::ERROR);
            return;
        }
        $res->addCargo('postId', $postId);
        $res->addCargo('post_arr', $post);
        $res->addInfo('Post inserted successfully');
    }


    public function testFunction()
    {
        $aj = new AjaxDefs;
        $_ = new BlockProps();
        $s = new Sys();
        $bb = new BlockBuilder();

        $req = AjaxRequestSingle::singleton();
        $res = AjaxResponseSingle::singleton();
        $upload_dir = wp_upload_dir()['basedir'];
        $list = get_flat_files_array_from_dir($upload_dir, $s::IMG);
        

        // use img elem to provide for future lazy load
        $imgConf = [
            [
                $_::VIEW_CLASS => \Stds\ViewBlocks\Img::class,
                $_::CONF => [
                    $_::SRC => "",
                ]
            ]
        ];

        ob_start(); 
        ?>
            <form ><?php                
                foreach($list as $img): 
                    $filename = basename($img['path']); ?>
                    <div class="form-row ">
                        <div class="col-3">
                            
                        </div>
                        <div class="col-9"><?php
                            $imgConf[0][$_::CONF][$_::SRC] = $img['baseurl'];
                            echo $bb->render('',$imgConf); ?>
                        </div>
                    </div><?php
                endforeach; ?>
            </form>
        <?php
        $html = ob_get_clean();
        $html .= "<pre>".print_r($list,true)."</pre>";
        /* handle response */
        $mediaViewer = new \Stds\ViewTemplates\MediaViewer();
        $mediaViewerTest = $mediaViewer->render();
        $res->setHtmlString($html.$mediaViewerTest);
        $res->addDebugs($upload_dir);
        
        $res->addDebugs(__DIR__);
        $res->addDebugs('cwd: '.getcwd());
        $res->setAction($aj::TEST);

        // first todo is to upload files, one size to upload, then also implement moving?


        // to return list of dirs with images, in a drop-down
    }
}
