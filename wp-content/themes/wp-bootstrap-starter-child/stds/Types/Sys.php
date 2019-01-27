<?php

namespace Stds\Types;

class Sys {

    // MEDIA CUSTOM FOLDERS
    const BIN = 'bin';
    const FRONT_PAGE = 'front_page';
    const HOT_OFFERS = 'hot_offers';
    const UPLOADS = 'uploads';


    const MEDIA_CUSTOM_FOLDERS = [
        self::BIN,
        self::FRONT_PAGE,
        self::HOT_OFFERS,
        self::UPLOADS,
    ];


    const BASE_DIR = '/home/t/tab4lioz/transfer/public_html/wp-content/';
    const UPLOAD_URL = 'http://transfer.tab4lioz.beget.tech/upload-redir/';


    const IMG = 9;
    const SOUND = 11;

    const MEDIA_TYPES = [
        self::IMG => ["jpeg","jpg","bmp","png"],
        self::SOUND
    ];

    const BE_DIRECTORIES = [
      
    ];

    /* MEDIA ACTIONS */
    const MOVE = 5;
    const COPY = 7;
    const DELETE = 9;
    

}