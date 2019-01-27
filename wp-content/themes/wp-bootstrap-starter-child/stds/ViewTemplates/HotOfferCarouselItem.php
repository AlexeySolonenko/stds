<?php

namespace Stds\ViewTemplates;

use Stds\ViewTypes\BlockProps;
use Stds\ViewBlocks\CardBlock;
use Stds\View\BlockBuilder;
use Stds\Types\FrontPage;

class HotOfferCarouselItem
{
    const HOT_OFFER_CAROUSEL_ITEM = 'hot_offer_carousel_item';

    /**
     * @param array $data[
     *                  BlockProps::NAME,
     *                  BlockProps::SRC,
     *                  BlockProps::ALT,
     *                  BlockProps::TITLE,
     *                  BlockProps::TEXT,
     *                  ]
     *
     * @return string
     */
    public function render(array $data)
    {
        $_ = new BlockProps();
        
        $img = $this->buildImg($data);
        $text = $this->buildText($data);
        ob_start(); ?>
        <div class="row <?= self::HOT_OFFER_CAROUSEL_ITEM," ",$data[$_::NAME] ?> ">
            <div class="col-6">
                <?= $img ?>
            </div>
            <div class="col-6">
                <div class="row">
                    <?= $text ?>
                </div>
            </div>
        </div><?php

        $html = ob_get_clean();
        
        return $html;
    }

    public function buildImg(array $data)
    {
        $_ = new BlockProps;
        $b = new BlockBuilder();
       
        $conf =  [
            [
                $_::VIEW_CLASS => \Stds\ViewBlocks\Img::class,
                $_::CONF => [
                    $_::CLASS_ => " d-block w-100 ". $data[$_::IMG_CLASS],
                    $_::SRC => $data[$_::SRC],
                    $_::ALT => $data[$_::ALT],

                ]
            ]
        ];
        
        $img = $b->render('', $conf);
        
        return $img;
    }

    public function buildText(array $data)
    {
        $_ = new BlockProps();
        $b = new BlockBuilder();
        $c = new CardBlock();
        $conf =  [
            [
                $_::VIEW_CLASS => \Stds\ViewBlocks\CardBlock::class,
                $_::CONF => [
                    $_::WRAPPER_SHOW => false,
                    $_::TITLE => $data[$_::TITLE],
                    $_::TITLE_LEVEL => 3,
                    $_::TEXT => $data[$_::TEXT],
                ]
            ]
        ];

        $text = $b->render('', $conf);

        return $text;
    }
}
