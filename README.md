# FormBuilder

Ce composant permet de générer des formulaires dans votre application.

## Installation

```
composer require DakinQuelia\FormBuilder
```

## Exemples d'utilisation

```php
use DakinQuelia\FormBuilder\Form;

$attr_form = [
    'method'    => 'POST',
    'class'     => 'form',
];

$attr_user = [
    'classname' => "form-control",
    'label'     => "Nom d'utilisateur",

];
$attr_test = [
    'classname' => "form-control",
    'label'     => "Champ test",
];

$rules = []; 

$form = new Form();
$form->AddField('username', 'text', $attr_user, $rules);
$form->AddField('test', 'text', $attr_test, $rules);

echo $form->Render('Titre de mon formulaire', $attr_form);
```

## Historique

#### 1.0.0 / 2022-05-29

 - Première version

## License

[GPL-2.0](https://opensource.org/licenses/GPL-3.0)

© 2022 - Dakin Quelia