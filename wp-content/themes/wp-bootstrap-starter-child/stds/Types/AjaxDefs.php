<?php

namespace Stds\Types;

/**
 * 
 */
class AjaxDefs
{

    const ALL = -1;
    const ANY = -1;
    const EMPTY_ = -1;

    //GROUPS
    const BE_PAGES_ROUTER = 300;

    //DIRECTIVES BE PAGES
    const ADD_HOT_OFFER = 500;
    const GET_MEDIA_OF_DIRECTORY = 503;
    const GET_MEDIA_VIEWER = 509;
    const GET_MEDIA_UPLOAD_MANAGER = 511;
    const LOAD_ACTIVATE_HOT_OFFERS_FORM = 513;
    const LOAD_ADD_HOT_OFFER = 515;
    const SUBMIT_MEDIA_HANDLER_ACTION = 517;
    const SUBMIT_MEDIA_HANDLER_SELECT_ITEMS = 519;
    const TEST = 521;
    const UPDATE_POST_STATUS = 523;
    
    const BE_PAGES_DIRECTIVES = [
        self::ADD_HOT_OFFER,
        self::LOAD_ADD_HOT_OFFER,
        self::LOAD_ACTIVATE_HOT_OFFERS_FORM,
        self::TEST,
        self::UPDATE_POST_STATUS,
    ];

    //DIRECTIVES POSTER
    //TODO TODO
    const POSTER_DIRECTIVES = [
        'update_post',
        'load_post'
    ];
    
  
        
    // values
    const ERROR = 2;
    const OK = 1;
   
   
    // terms and field names
    const ACTION = 'action';
    const ALL_FORMS = 'all_forms';
    const ADD = 'add';
    const AJAX_DELIM = '___';
    const AJAX_PROPS = 'ajax-props';
    const AJAXIFY_ME = 'ajaxify_me';
    const CARGO = 'cargo';
    const CHANGE = 'change';
    const CLICK = 'click';
    const COLLECT_FORM_DATA_WITH_ARRAYS = 'collect_form_data_with_arrays';
    const CONSTS = 'consts';
    const DATA = 'data';
    const DEBUGS = 'debugs';
    const DIRECTIVE = 'directive';
    const ERRORS = 'errors';
    const EVENT = 'event';
    const FORM = 'form';
    const FUNCTION_ = 'function';
    const FUNCTION_PREPARE = 'function_prepare';
    const GROUP = 'group';
    const HTML = 'html';
    const HTML_CONTAINER = 'html_container';
    const HTML_STRING = 'html_string';
    const INFO = 'info';
    const LANG = 'lang';
    const MANAGE_FRONT_PAGE_BODY = 'manage_front_page_body';
    const MESSAGE_CONTAINER = 'message_container';
    const SHOW_POPUP = 'show_popup';
    const STATUS = 'status';
    const STDS_ROUTER = 'stds_router';
    const SUBMIT = "submit";
    const WARNINGS = 'warnings';
}
