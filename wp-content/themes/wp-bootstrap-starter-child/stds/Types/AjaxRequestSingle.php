<?php
namespace Stds\Types;

use Stds\Types\AjaxDefs;

/**
 *  @class AjaxRequestSingle
 */
class AjaxRequestSingle
{
    /**
     * @var AjaxRequestSingle
     */
    public static $instance;

    protected $action;
    protected $cargo;
    protected $directive;
    protected $group;
    protected $status;

    /**
     * @param array $props
     * @param array $rules
     * @return AjaxRequest
     */
    private function __construct($props = [], $rules = [])
    {
        if(empty($props)) $props = $_REQUEST;
        $_ = new AjaxDefs();
        $data = $props;
        $r = new \ReflectionClass($this);
        $mainRules = [
            'action' => FILTER_SANITIZE_STRING,
            'directive' => FILTER_SANITIZE_STRING,
            'group' => FILTER_SANITIZE_STRING,
        ];

        foreach ($data as $propName => $value) {
            if ($propName == $_::CARGO) {
                continue;
            }
            if (!$r->hasProperty($propName)) {
                continue;
            }
            $classProp = $r->getProperty($propName);
            $classProp->setAccessible(true);
            $value = filter_var_array([$propName => $value], $mainRules)[$propName];
            $classProp->setValue($this, $value);
            $classProp->setAccessible(false);
        }
        if (empty($props[$_::CARGO])) {
            return;
        }
        $data = [];
        foreach ($props[$_::CARGO] as $key => $value) {
            if (empty($key) || $key == "0") {
                continue;
            }
            if (!empty($rules)) {
                $value = filter_var_array([$key => $value], $rules)[$key];
            } else {
                $value = filter_var($value, FILTER_SANITIZE_STRING);
            }
            $key = filter_var($key, FILTER_SANITIZE_STRING);
            $data[$key] = $value;
        }

        $this->cargo = $data;
    }

    /**
     * @return AjaxRequestSingle $instance
     */
    public static function singleton($reserved = [],$rules = [])
    {
        if (!isset(self::$instance)) {
            self::$instance = new AjaxRequestSingle([], $rules);
        }
        
        return self::$instance;
    }

    /**
     * @return integer
     */
    public function getAction()
    {
        return $this->action;
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
     * @return integer
     */
    public function getDirective()
    {
        return $this->directive;
    }
    /**
     * @return integer
     */
    public function getGroup()
    {
        return $this->group;
    }
    /**
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }
}
