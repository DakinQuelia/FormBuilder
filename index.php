<?php
define('ROOT', __DIR__);

require(ROOT . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');

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

$attr_select = [
    'options'   => [
        [ 
            'label' => 'Test 1',
            'value' => 'Valeur 1'
        ],
        [ 
            'label' => 'Test 2',
            'value' => 'Valeur 2'
        ],
    ]
];

$rules = []; 

$form = new Form();
$form->AddField('username', 'text', $attr_user, $rules);
$form->AddField('test', 'text', $attr_test, $rules);
$form->AddField('selection', 'select', $attr_test, $rules);

var_dump($form->Render('Titre de mon formulaire', $attr_form));

?>