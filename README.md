# FormBuilder

Ce composant permet de générer des formulaires dans votre application.

## Installation

```
composer require DakinQuelia\FormBuilder
```

## Exemples d'utilisation

```php
$attr_form = [
    'method'        => 'POST',
    'class'         => 'form',
    'legend'        => 'Informations',
    'rowclass'      => 'row',
];

$attr_user = [
    'class'         => "form-control",
    'label'         => "Nom d'utilisateur",
];
$attr_test = [
    'class'         => "form-control",
    'label'         => "Champ test",
    'placeholder'   => 'Mon placeholder'
];

$attr_radio = [ 
    'label'         => "Bouton Radio", 
    'class'         => "form-radio" 
];

$attr_select = [
    'class'         => "form-control",
    'label'         => "Champ test",
    'options'       => [
        [ 
            'label' => 'Test 1',
            'value' => 'Valeur 1'
        ],
        [ 
            'label' => 'Test 2',
            'value' => 'Valeur 2'
        ],
        [ 
            'label' => 'Test 3',
            'value' => 'Valeur 3'
        ],
    ]
];

$attr_textarea = [
    'class'         => "form-control",
    'label'         => "Champ test",
    'content'       => "Mon contenu"
];

$button_submit = [ 
    'label'         => 'Envoyer',
    'class'         => 'button'
];

$button_cancel = [ 
    'label'         => 'Annuler',
    'class'         => 'button'
];

$rules = []; 

$form = new Form('Titre de mon formulaire', $attr_form);
$form->AddField('username', 'text', $attr_user, $rules);
$form->AddField('test', 'text', $attr_test, $rules);
$form->AddField('radio', 'radio', $attr_radio, $rules);
$form->AddField('selection', 'select', $attr_select, $rules);
$form->AddField('message', 'textarea', $attr_textarea, $rules);
$form->AddButton('submit', 'submit', $button_submit);
$form->AddButton('canel', 'button', $button_cancel);

echo $form->Render();
```

## Historique

#### 1.1.0 / 2022-05-31

 - Ajout du rendu des boutons
 - Correction d'un bug mineur

#### 1.0.0 / 2022-05-29

 - Première version

## License

[GPL-2.0](https://opensource.org/licenses/GPL-3.0)

© 2022 - Dakin Quelia