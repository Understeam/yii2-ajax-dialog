<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\dialog;

use Yii;
use yii\base\Widget;
use yii\bootstrap\Html;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * Class Dialog TODO: Write class description
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
class Dialog extends Widget
{

    public $url;

    public $containerId;

    public $pjaxId;

    public $selector;

    public $jsName;

    public $open = false;

    /**
     * @var Button[]
     */
    public $buttons = [];

    public $dialogOptions = [];

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
            'url' => Url::to($this->url),
            'containerId' => $this->containerId,
            'pjaxId' => $this->pjaxId,
            'jsName' => $this->jsName,
            'dialogOptions' => $this->dialogOptions,
            'selector' => $this->selector,
            'buttons' => $this->serializeButtons(),
            'open' => $this->open,
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

    protected function registerAssets()
    {
        DialogAsset::register($this->getView());
        $options = $this->getClientOptions();
        $optionsJson = Json::encode($options);
        $this->view->registerJs(<<<JS
$('#{$this->id}').yiiBootstrapDialog($optionsJson);
JS
        );
    }
}
