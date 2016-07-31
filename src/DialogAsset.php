<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\dialog;
use yii\web\AssetBundle;

/**
 * Class DialogAsset TODO: Write class description
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
class DialogAsset extends AssetBundle
{

    public $sourcePath = '@vendor/understeam/yii2-ajax-dialog/src/assets';

    public $js = [
        'js/yii.bootstrap-dialog.js'
    ];

    public $depends = [
        'understeam\dialog\BootstrapDialogAsset',
        'yii\widgets\PjaxAsset',
    ];
}
