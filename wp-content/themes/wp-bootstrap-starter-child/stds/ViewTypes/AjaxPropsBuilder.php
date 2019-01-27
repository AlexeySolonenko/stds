<?php

namespace Stds\ViewTypes;

use Stds\Types\AjaxDefs;

/**
 * @class AjaxPropsBuilder
 */
class AjaxPropsBuilder
{
    protected $action = "stds_router";
    protected $all_forms = true;
    protected $cargo = [];
    protected $collect_form_data_with_arrays;
    protected $directive;
    protected $event = 'click';
    protected $form = '';
    protected $function = false;
    protected $function_prepare = false;
    protected $group = "";
    protected $html_container = "";
    protected $message_container = "";
    protected $show_popup = true;
    protected $status = 1;


    
    /**
     * Class Construction Function
     * @param array $params
     */
    public function __construct(array $props = [])
    {
        $this->initProps($props);
    }

    /**
     *
     * @param array $props
     * @return void
     */
    public function initProps(array $props = [])
    {
        if (empty($props)) {
            return;
        }
        foreach ($props as $prop => $value) {
            $setter = str_replace("_", "", "set" . ucwords($prop, "_"));
            if (!method_exists($this, $setter)) {
                continue;
            }
        
            $this->{$setter}($value);
        }
    }


    /**
     * @return string
     */
    public function getClassString()
    {
        $_ = new AjaxDefs();
        $class_string = [$_::AJAXIFY_ME];
        $r = new \ReflectionClass($this);
        $props = $r->getProperties();
        foreach ($props as $prop) {
            $json = false;
            if ($_::CARGO == $prop->getName()) {
                $json = true;
            }
            $getter = str_replace("_", "", "get" . ucwords($prop->getName(), "_"));
            if (!method_exists($this, $getter)) {
                continue;
            }
            //if ($json === true) {
            try {
                $value = base64_encode(json_encode($this->{$getter}(), JSON_NUMERIC_CHECK));
            } catch (\Exception $e) {
                $value = $this->{$getter}();
            }
            //} else {
            //$value = $this->{$getter}();
            //}
            $class_string[] = $_::AJAX_PROPS.$_::AJAX_DELIM.$prop->getName().$_::AJAX_DELIM.$value;
        }
        
        return implode(' ', $class_string);
    }


    // region GETTERS

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
    /**
     * @return string
     */
    public function getAllForms()
    {
        return $this->all_forms;
    }
    /**
    * @return mixed
    */
    public function getCargo($key= null)
    {
        if (empty($key)) {
            return $this->cargo;
        } else {
            return $this->cargo[$key];
        }
    }
    /**
     * @return bool
     */
    public function getCollectFormDataWithArrays()
    {
        return  $this->collect_form_data_with_arrays;
    }
    /**
     * @return int
     */
    public function getDirective()
    {
        return $this->directive;
    }
    /**
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }
    /**
     * @return string
     */
    public function getForm()
    {
        return $this->form;
    }
    /**
     * @return string
     */
    public function getFunction()
    {
        return $this->function;
    }
    /**
     * @return string
     */
    public function getFunctionPrepare()
    {
        return $this->function_prepare;
    }
    /**
     * @return int
     */
    public function getGroup()
    {
        return $this->group;
    }
    /**
    * @return int
    */
    public function getHtmlContainer()
    {
        return $this->html_container;
    }
    /**
     * @return string
     */
    public function getMessageContainer()
    {
        return $this->message_container;
    }
    /**
     * @return bool
     */
    public function getShowPopup()
    {
        return $this->show_popup;
    }
    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }
    // endregion GETTERS
    
    // region SETTERS
    /**
     * @param string $action
     * @return AjaxPropsBuilder $this
     */
    public function setAction(string $action)
    {
        $this->action = $action;
        
        return $this;
    }
    /**
     * @param bool $all_forms
     * @return AjaxPropsBuilder $this
     */
    public function setAllForms(bool $all_forms)
    {
        $this->all_forms = $all_forms;
        
        return $this;
    }
    /**
     * @param array $cargo
     *
     * @return AjaxPropsBuilder $this
     */
    public function setCargo(array $cargo)
    {
        $this->cargo = $cargo;

        return $this;
    }
    /**
     *
     * @param string $key
     * @param mixed $cargo
     *
     * @return AjaxPropsBuilder $this
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
     * @return AjaxPropsBuilder $this
     */
    public function clearCargo()
    {
        $this->cargo = [];

        return $this;
    }
    /**
     *
     * @param bool $collectFormDataWithArrays
     * @return void
     */
    public function setCollectFormDataWithArrays($collectFormDataWithArrays)
    {
        $this->collect_form_data_with_arrays = $collectFormDataWithArrays;

        return $this;
    }

    /**
     * @param int $directive
     * @return AjaxPropsBuilder $this
     */
    public function setDirective(int $directive)
    {
        $this->directive = $directive;
        
        return $this;
    }
    /**
     * @param string $event
     * @return AjaxPropsBuilder $this
     */
    public function setEvent(string $event)
    {
        $this->event = $event;
        
        return $this;
    }
    /**
     * @param string $form
     * @return AjaxPropsBuilder $this
     */
    public function setForm(string $form)
    {
        $this->form = $form;
        
        return $this;
    }
    /**
     * @param string $function
     * @return AjaxPropsBuilder $this
     */
    public function setFunction(string $function)
    {
        $this->function = $function;
        
        return $this;
    }
    /**
     * @param string $function_prepare
     * @return AjaxPropsBuilder $this
     */
    public function setFunctionPrepare(string $function_prepare)
    {
        $this->function_prepare = $function_prepare;
        
        return $this;
    }
    /**
     * @param int $group
     * @return AjaxPropsBuilder $this
     */
    public function setGroup(int $group)
    {
        $this->group = $group;
        
        return $this;
    }
    /**
     * @param int $htmlContainer
     * @return AjaxPropsBuilder $this
     */
    public function setHtmlContainer(string $htmlContainer)
    {
        $this->html_container = $htmlContainer;
        
        return $this;
    }
    /**
     * @param string $message_container
     * @return AjaxPropsBuilder $this
     */
    public function setMessageContainer(string $message_container)
    {
        $this->message_container = $message_container;

        return $this;
    }
    /**
     * @param bool $showPopup
     * @return AjaxPropsBuilder $this
     */
    public function setShowPopup(bool $showPopup)
    {
        $this->show_popup = $showPopup;
        
        return $this;
    }

    /**
     * @param int $status
     * @return AjaxPropsBuilder $this
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
        
        return $this;
    }

    // endregion SETTERS
}
