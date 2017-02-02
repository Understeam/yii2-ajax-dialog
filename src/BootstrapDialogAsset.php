<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\dialog;
use yii\web\AssetBundle;

/**
 * Class BootstrapDialogAsset TODO: Write class description
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
class BootstrapDialogAsset extends AssetBundle
{

    public $sourcePath = '@bower/bootstrap3-dialog/dist';

    public $js = [
        'js/bootstrap-dialog.min.js'
    ];

    public $css = [
        'css/bootstrap-dialog.min.css'
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
