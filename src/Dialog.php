<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\dialog;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\bootstrap\Html;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * Dialog class represents one dialog window attached to specific url
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
class Dialog extends Widget
{

    /**
     * @var string|array URL of page to be displayed in dialog
     */
    public $url;

    /**
     * @var string identity of PJAX container. If not set will be generated automatically
     */
    public $containerId;


    /**
     * @var string CSS selector of objects which will produce dialog pop-up
     */
    public $selector;

    /**
     * @var string name of JavaScript variable to which BootstrapDialog object will be saved
     */
    public $jsName;

    /**
     * @var bool whether open dialog on page load
     */
    public $open = false;

    /**
     * @var Button[] dialog buttons
     */
    public $buttons = [];

    /**
     * @var array custom dialog options
     * @see http://nakupanda.github.io/bootstrap3-dialog/#available-options
     */
    public $dialogOptions = [];

    /**
     * @var array pjax options
     */
    public $pjaxOptions = [];

    public function init()
    {
        if ($this->containerId === null) {
            $this->containerId = 'bootstrap-dialog-' . $this->getId();
        }
        if ($this->selector === null) {
            $this->selector = "[data-dialog=\"{$this->containerId}\"]";
        }
        parent::init();
    }

    public function run()
    {
        $this->registerAssets();
        echo Html::tag('div', '', [
            'id' => $this->getId(),
        ]);
        parent::run();
    }

    protected function getClientOptions()
    {
        return [
            'url' => $this->url ? Url::to($this->url) : null,
            'containerId' => $this->containerId,
            'jsName' => $this->jsName,
            'dialogOptions' => $this->dialogOptions,
            'selector' => $this->selector,
            'buttons' => $this->serializeButtons(),
            'open' => $this->open,
            'pjaxOptions' => $this->pjaxOptions,
        ];
    }

    protected function serializeButtons()
    {
        $buttons = [];
        foreach ($this->buttons as $button) {
            if (!is_object($button)) {
                $button = Yii::createObject($button);
            }
            $buttons[] = $button->serialize();
        }
        return $buttons;
    }

    protected function registerButtons()
    {
        foreach ($this->buttons as $button) {
            if (!is_object($button)) {
                $button = Yii::createObject($button);
            }
            $button->register($this);
        }
    }

    protected function registerAssets()
    {
        DialogAsset::register($this->getView());
        $options = $this->getClientOptions();
        $optionsJson = Json::encode($options);
        $this->view->registerJs(<<<JS
$('#{$this->id}').yiiBootstrapDialog($optionsJson);
JS
        );
        $this->registerButtons();
    }
}
