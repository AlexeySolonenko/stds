<?php

namespace Stds\Types;

use Stds\Types\AjaxDefs;

class AjaxResponseSingle implements \JsonSerializable
{
    const OK = AjaxDefs::OK;
    const ERROR = AjaxDefs::ERROR;

    /**
     * @var integer
     */
    protected $action;
    protected $cargo = [];
    protected $consts = [];
    protected $debugs = [];
    protected $errors = [];
    protected $html = [];
    protected $htmlContainer = "";
    protected $htmlString = "";
    protected $info = [];
    /**
     * @var AjaxResponseSingle
     */
    protected static $instance = null;
    protected $lang = [];
    protected $showPopupMessages = true;
    protected $status;
    protected $warnings = [];

    private function __construct()
    {
    }
    /**
     * @return AjaxResponseSingle $this;
     */
    public static function singleton()
    {
        if (!isset(self::$instance)) {
            self::$instance = new AjaxResponseSingle();
        }
        
        return self::$instance;
    }

    /**
     *
     * @return array
     */
    public function getArray()
    {
        $_ = new AjaxDefs();
        $arr = [
            $_::ACTION => $this->getAction(),
            $_::CARGO => $this->getCargo(),
            $_::CONSTS => $this->getConsts(),
            $_::DEBUGS => $this->getDebugs(),
            $_::ERRORS => $this->getErrors(),
            $_::HTML => $this->getHtml(),
            utf8_encode($_::HTML_STRING) => utf8_encode($this->getHtmlString()),
            $_::HTML_CONTAINER => $this->getHtmlContainer(),
            $_::INFO => $this->getInfo(),
            $_::LANG => $this->getLang(),
            $_::STATUS => $this->getStatus(),
            $_::WARNINGS => $this->getWarnings(),
        ];

        foreach ($arr as $key => $val) {
            if (empty($val)) {
                unset($arr[$key]);
            }
        }
        return $arr;
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        $arr = $this->getArray();
        try {
            $json = json_encode($arr);
        } catch (\Exception $e) {
            $this->clearCargo();
            $this->clearHtml();
            $this->clearInfo();
            $this->clearConsts();
            $this->setHtmlContainer("");
            $this->setHtmlString("");
            $this->addErrors($e->getMessage());
            return json_encode($this->getArray());
        }
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->clearCargo();
            $this->clearHtml();
            $this->clearInfo();
            $this->clearConsts();
            $this->setHtmlContainer("");
            $this->setHtmlString("");
            $this->addErrors(\json_last_error_msg());
            return json_encode($this->getArray());
        }
        return json_encode($arr);
    }

    //#region GETTERS
    /**
     * @return integer
     */
    public function getAction()
    {
        return $this->action;
    }
    /**
     * @param integer|string $key
     * @return array|mixed
     */
    public function getCargo($key = null)
    {
        if (!empty($key)) {
            return $this->cargo[$key];
        } else {
            return $this->cargo;
        }
    }
    /**
     * @param integer|string $key
     * @return void
     */
    public function getConsts($key = null)
    {
        if (!empty($key)) {
            return $this->consts[$key];
        } else {
            return $this->consts;
        }
    }
    /**
     * @param integer|string $key
     * @return array|string
     */
    public function getDebugs($key = null)
    {
        if (!empty($key)) {
            return $this->debugs[$key];
        } else {
            return $this->debugs;
        }
    }

    /**
     * @param integer|string $key
     * @return array|string
     */
    public function getErrors($key = null)
    {
        if (!empty($key)) {
            return $this->errors[$key];
        } else {
            return $this->errors;
        }
    }
    /**
     * @param integer|string $key
    * @return array|string
    */
    public function getHtml($key = null)
    {
        if (!empty($key)) {
            return $this->html[$key];
        } else {
            return $this->html;
        }
    }
    /**
     * 
     * @return string
     */
    public function getHtmlContainer(){
        return $this->htmlContainer;
    }
    /**
     * @return string
     */
    public function getHtmlString()
    {
        return $this->htmlString;
    }
    /**
     * @param integer|string $key
    * @return array
    */
    public function getInfo($key = null)
    {
        if (!empty($key)) {
            return $this->info[$key];
        } else {
            return $this->info;
        }
    }
    /**
     * @param integer|string $key
     * @return string|string[]
     */
    public function getLang($key = null)
    {
        if (!empty($key)) {
            return $this->lang($key);
        } else {
            return $this->lang;
        }
    }
    /**
     * @return void
     */
    public function getShowPopupMessages()
    {
    return $this->showPopupMessages;
    }
    /**
    * @param integer|string $key
    * @return integer
    */
    public function getStatus($key = null)
    {
        return $this->status;
    }
    /**
    * @param integer|string $key
    * @return array
    */
    public function getWarnings($key = null)
    {
        if (!empty($key)) {
            return $this->warnings[$key];
        } else {
            return $this->warnings;
        }
    }
    //#endregion GETTERS
    //#region SETTERS
    /**
     * Undocumented function
     *
     * @param integer $action
     * @return void
     */
    public function setAction(int $action)
    {
        $this->action = (int)$action;

        return $this;
    }
    /**
     * Undocumented function
     *
     * @param  $key
     * @param mixed $cargo
     * @return void
     */
    public function addCargo(string $key, $cargo = null)
    {
        if ($key == "0" || empty($key)) {
            throw new \Exception("Cargo key must not be empty");
        }
        $this->cargo[$key] = $cargo;
        return $this;
    }

    /**
     * @return $this
     */
    public function clearCargo()
    {
        $this->cargo = [];
        return $this;
    }
    /**
     * @param string|string[] $consts
     * @param integer|string|null $key
     * @param boolean $keepFormatting
     * @return $this
     */
    public function addConsts($consts, $key= null, $keepFormatting = false)
    {
        if (!empty($key)) {
            if ($keepFormatting) {
                $this->consts[$key] = "<pre>".$consts."</pre>";
            } else {
                $this->consts[$key] = $consts;
            }
        } else {
            if (!is_array($consts)) {
                $consts = [$consts];
            }
            foreach ($consts as $const) {
                if ($keepFormatting) {
                    $this->consts[] = "<pre>".$const."</pre>";
                } else {
                    $this->consts[] = $const;
                }
            }
        }

        return $this;
    }
    /**
     * @return $this
     */
    public function clearConsts()
    {
        $this->consts = [];
        return $this;
    }
    /**
     * @param string|string[] $debugs
     * @param integer|string|null $key
     * @param boolean $keepFormatting
     * @return $this
     */
    public function addDebugs($debugs, $key= null, $keepFormatting = false)
    {
        if (!empty($key)) {
            if ($keepFormatting) {
                $this->debugs[$key] = "<pre>".$debugs."</pre>";
            } else {
                $this->debugs[$key] = $debugs;
            }
        } else {
            if (!is_array($debugs)) {
                $debugs = [$debugs];
            }
            foreach ($debugs as $debug) {
                if ($keepFormatting) {
                    $this->debugs[] = "<pre>".$debug."</pre>";
                } else {
                    $this->debugs[] = $debug;
                }
            }
        }

        return $this;
    }
    /**
     * @return $this
     */
    public function clearDebugs()
    {
        $this->debugs = [];
        return $this;
    }
    
    /**
     * @param string|string[] $errors
     * @param integer|string|null $key
     * @param boolean $keepFormatting
     * @return $this
     */
    public function addErrors($errors, $key= null, $keepFormatting = false)
    {
        if (!empty($key)) {
            if ($keepFormatting) {
                $this->errors[$key] = "<pre>".$errors."</pre>";
            } else {
                $this->errors[$key] = $errors;
            }
        } else {
            if (!is_array($errors)) {
                $errors = [$errors];
            }
            foreach ($errors as $error) {
                if ($keepFormatting) {
                    $this->errors[] = "<pre>".$error."</pre>";
                } else {
                    $this->errors[] = $error;
                }
            }
        }

        return $this;
    }
    /**
     * @return $this
     */
    public function clearErrors()
    {
        $this->errors = [];
        return $this;
    }
    /**
     * @param string|string[] $html
     * @param integer|string|null $key
     * @param boolean $keepFormatting
     * @return $this
     */
    public function addHtml($html, $key= null, $keepFormatting = false)
    {
        if (!empty($key)) {
            if ($keepFormatting) {
                $this->html[$key] = "<pre>".$html."</pre>";
            } else {
                $this->html[$key] = $html;
            }
        } else {
            if (!is_array($html)) {
                $html = [$html];
            }
            foreach ($html as $htmlItem) {
                if ($keepFormatting) {
                    $this->html[] = "<pre>".$htmlItem."</pre>";
                } else {
                    $this->html[] = $htmlItem;
                }
            }
        }

        return $this;
    }
    /**
     * @return $this
     */
    public function clearHtml()
    {
        $this->html = [];
        return $this;
    }
    /**
     *
     * @param string $htmlContainer
     * @return $this
     */
    public function setHtmlContainer(string $htmlContainer)
    {
        $this->htmlContainer = $htmlContainer;
        
        return $this;
    }
    /**
     * @param string|mixed $htmlString
     * @param boolean $keepFormatting
     * @return $this
     */
    public function setHtmlString($htmlString = "", $keepFormatting = false)
    {
        if (!is_string($htmlString)) {
            if ($keepFormatting) {
                $htmlString = print_r($htmlString, true);
            } else {
                $htmlString = "<pre>".print_r($htmlString, true)."</pre>";
            }
        }
        $this->htmlString = (string)$htmlString;
        $this->string = (string)$htmlString;
        return $this;
    }
    /**
     * @param string|string[] $info
     * @param integer|string|null $key
     * @param boolean $keepFormatting
     * @return $this
     */
    public function addInfo($info, $key= null, $keepFormatting = false)
    {
        if (!empty($key)) {
            if ($keepFormatting) {
                $this->info[$key] = "<pre>".$info."</pre>";
            } else {
                $this->info[$key] = $info;
            }
        } else {
            if (!is_array($info)) {
                $info = [$info];
            }
            foreach ($info as $inf) {
                if ($keepFormatting) {
                    $this->info[] = "<pre>".$inf."</pre>";
                } else {
                    $this->info[] = $inf;
                }
            }
        }

        return $this;
    }
    /**
     * @return $this
     */
    public function clearInfo()
    {
        $this->info = [];
        return $this;
    }
    /**
         * @param string|string[] $lang
         * @param integer|string|null $key
         * @param boolean $keepFormatting
         * @return $this
         */
    public function addLang($lang, $key= null, $keepFormatting = false)
    {
        if (!empty($key)) {
            if ($keepFormatting) {
                $this->lang[$key] = "<pre>".$lang."</pre>";
            } else {
                $this->lang[$key] = $lang;
            }
        } else {
            if (!is_array($lang)) {
                $lang = [$lang];
            }
            foreach ($lang as $langItem) {
                if ($keepFormatting) {
                    $this->lang[] = "<pre>".$langItem."</pre>";
                } else {
                    $this->lang[] = $langItem;
                }
            }
        }

        return $this;
    }
    /**
     * @return $this
     */
    public function clearLang()
    {
        $this->lang = [];
        return $this;
    }
    /**
     * @return $this
     */
    public function setShowPopupMessages()
    {
        $this->showPopupMessages = true;
        return $this;
    }
    /**
     * @return $this
     */
    public function resetShowPopupMessages()
    {
        $this->showPopupMessages = false;
        return $this;
    }
    /**
     * @param integer $status
     * @return $this
     */
    public function setStatus(int $status)
    {
        $this->status = (int)$status;
        return $this;
    }
    /**
     * @param string|string[] $warnings
     * @param integer|string|null $key
     * @param boolean $keepFormatting
     * @return $this
     */
    public function addWarnings($warnings, $key= null, $keepFormatting = false)
    {
        if (!empty($key)) {
            if ($keepFormatting) {
                $this->warnings[$key] = "<pre>".$warnings."</pre>";
            } else {
                $this->warnings[$key] = $warnings;
            }
        } else {
            if (!is_array($warnings)) {
                $warnings = [$warnings];
            }
            foreach ($warnings as $warning) {
                if ($keepFormatting) {
                    $this->warnings[] = "<pre>".$warning."</pre>";
                } else {
                    $this->warnings[] = $warning;
                }
            }
        }

        return $this;
    }
    /**
     * @return $this
     */
    public function clearWarnings()
    {
        $this->warnings = [];
        return $this;
    }
    //#endregion SETTERS
}
