<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\dialog;
use yii\web\JsExpression;

/**
 * Class CloseButton TODO: Write class description
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
class CloseButton extends Button
{

    public $id = 'dialog-btn-close';

    public $label = 'Close';

    public $icon = 'glyphicon glyphicon-remove';

    public $cssClass = 'btn-default pull-left';

    public function init()
    {
        $this->action = new JsExpression(<<<JS
function (dialog) {
    dialog.close();
}
JS
        );
        parent::init();
    }

}
