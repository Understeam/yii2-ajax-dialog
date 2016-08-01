# Yii2 AJAX Dialog

Этот виджет позволяет легко подключить ajax загрузку контента внутрь всплывающих окон
[Bootstrap 3 Dialog](http://nakupanda.github.io/bootstrap3-dialog).

## Установка

```
$ composer require understeam/yii2-ajax-dialog:~0.1 --prefer-dist
```

## Controller и View

Первое, что требуется сделать - это view, который будет загружаться внутрь окна. Здесь ничего особенного.
Создается view файл, который рендерится из контроллера по запросу, например `['popup/show']`.

```php
<?php

namespace app\controllers;

use yii\web\Controller;

class PopupController extends Controller
{

    public function actionShow()
    {
        return $this->render('show');
    }

}
```

Внутри view необходимо обернуть отображаемую часть в виджет `DialogContainer`:

```php
<?php
$this->title = "Popup title!";
\understeam\dialog\DialogContainer::begin();
?>
<h1>Hello! This is popup</h1>
<?php
\understeam\dialog\DialogContainer::end();
?>
```

Через `$this->title` можно задать заголовок всплывающего окна.

Так как для загрузки используется `Pjax`, встроенный в Yii2, все ассеты, подключаемые внутри этого view
будут подключены на страницу, в которой будет отображён попап. Это позволяет безопасно использовать,
например, `ActiveForm` с клиентской и ajax валидацией.

## Подключение модального окна

Чтобы вставить модальное окно на страницу, можно использовать следующий код:

```php
<?=\understeam\dialog\Dialog::widget([
    'url' => ['popup/show'],    // URL содержимого
    'open' => true,             // Открыть окно при загрузке
]) ?>
```

Этот пример откроет модальное сразу при загрузке страницы. Чтобы этого избежать, можно назначить селектор
или вызвать открытие окна из js кода.

```php
<?=\understeam\dialog\Dialog::widget([
    'url' => ['popup/show'],    // URL содержимого
    'jsName' => 'myPopup',      // Имя js переменной, в которую будет сохранён объект модального окна
    // Для вызова окна достаточно выполнить window.myPopup.open()
    'selector' => 'a.showPopup', // Селектор, при клике на который будет совершено открытие окна
]) ?>
```

## Кнопки

Кнопки в модальное окно добавляются через свойство `buttons`:

```php
<?=\understeam\dialog\Dialog::widget([
    'url' => ['popup/show'],    // URL содержимого
    'buttons' => [
        \understeam\dialog\CloseButton::className(), // Кнопка "закрыть"
        [
            'class' => \understeam\dialog\Button::className(),
            'id' => 'btn-custom',
            'label' => 'Custom',
            'action' => 'function(){alert("custom button")}',
            'cssClass' => ['btn-warning'],
            'icon' => 'glyphicon glyphicon-ok',
        ],
    ]
]) ?>
```

Вы можете создавать свои кнопки, см. пример.

## ActiveForm

Для отображение в окне `ActiveForm` с предопределёнными кнопками `Submit` и `Close` можно использовать
виджет `ActiveFormDialog`.

```php
<?=\understeam\dialog\ActiveFormDialog::widget([
    'url' => ['popup/show'],
    'jsName' => 'myPopup',
]) ?>
```

View при этом модифицировать не нужно

## Передаваемые переменные

При отображении окна через JS имеется возможность передать в него динамические данные:

```javascript
function openPopup(name, phone) {
    myPopup.setData('options', {name: name, phone: phone});
    myPopup.open();
}
```

При этом подстановка данных произойдёт в поля ввода текста с data аттрибутом `data-dialog-attr`:

```html
<input type="text" value="" name="name" data-dialog-attr="name" />
<input type="text" value="" name="phone" data-dialog-attr="phone" />
```

Или при выводе ActiveForm:

```php
<?php
/**
 * @var \yii\base\Model $model
 */
?>
<?php \understeam\dialog\DialogContainer::begin() ?>
<?php $form = \yii\bootstrap\ActiveForm::begin() ?>
<?= $form->field($model, 'name')->textInput([
    'data-dialog-attr' => 'name',
]); ?>
<?= $form->field($model, 'phone')->textInput([
    'data-dialog-attr' => 'phone',
]); ?>
<?php $form->end() ?>
<?php \understeam\dialog\DialogContainer::end() ?>
```

## TODO

1. Валидация ActiveForm
2. Больше настроек для BootstrapDialog
