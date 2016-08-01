<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\dialog;

use yii\base\Object;
use yii\web\JsExpression;

/**
 * Class Button TODO: Write class description
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
class Button extends Object
{

    public $id;

    public $label;

    public $cssClass;

    public $action;

    public $icon;

    public $autospin = false;

    public function serialize()
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'cssClass' => is_array($this->cssClass) ? implode(' ', $this->cssClass) : $this->cssClass,
            'icon' => is_array($this->icon) ? implode(' ', $this->icon) : $this->icon,
            'autospin' => $this->autospin,
            'action' => $this->action instanceof JsExpression ? $this->action : new JsExpression($this->action),
        ];
    }

    public function register(Dialog $dialog)
    {
    }
}
