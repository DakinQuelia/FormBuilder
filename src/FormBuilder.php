<?php
/*======================================================================*\
||  FormBuilder						                                    ||
||  Fichier     : DakinQuelia\FormBuilder\FormBuilder.php               ||
||  Version     : 1.1.0                                	                ||
||  Auteur(s)   : Dakin Quelia						                    ||
||  ------------------------------------------------------------------  ||
||  Copyright ©2022 FormBuilder - codé par Dakin Quelia                 ||
\*======================================================================*/
namespace DakinQuelia\FormBuilder;

use Exception;
use InvalidArgumentException;
use DakinQuelia\FormBuilder\Interfaces\FormBuilderInterface;

abstract class FormBuilder implements FormBuilderInterface
{
    protected string $form = '';                           // Formulaire
    protected array $fields = [];                         // Tableau des champs du formulaire
    protected array $buttons = [];                       // Boutons du formulaire
    protected string $title = '';                       // Titre du formulaire
    protected array $attributes = [];                  // Attributs par défaut du formulaire

	/**
	*   Ceci initialise la classe.
	**/
	public function __construct(string $title, array $attributes = [])
	{
		//
        $this->title = $title;
        $this->attributes = $attributes;
	}

    /**
    *   Cette méthode de générer le code HTML du formulaire.
    *     
    *	@param string $title 		Titre du formulaire
    *   @param array $attributes    Attributs du formulaire 
    *
    *   @return string
    **/
    public function GetForm(): string
    {
        $this->FilterFields();
        $this->BuildForm($this->title, $this->attributes);

        return $this->form;
    }

    /**
    *   Cette méthode permet de générer les boutons du formulaire.
    *
    *   @return FormBuilder
    **/
    public function RenderButtons(): FormBuilder
    {
        if (!is_array($this->buttons))
        {
            throw new Exception("La liste des boutons doit être un tableau.");
        }

        foreach ($this->buttons as $button)
        {
            $attr = $button['options'];
            $label = array_key_exists('label', $attr) ? $attr['label'] : $button['name'];
            $class = array_key_exists('class', $attr) ? ' class="' . $attr['class'] . '"' : '';

            $this->form .= '<button type="' . $button['type'] . '"' . $class . '>' . $label .  '</button>';
        }

        return $this;
    }

	/**
	*	Cette méthode permet de créer le formulaire.
    * 
    *	@param string $title 	    Titre du formulaire  
    * 
    *   @return FormBuilder
	**/
	public function BuildForm(string $title, array $attributes = []): FormBuilder
	{
        if (!$attributes['method'])
        {
            $attributes['method'] = 'GET';
        }

        $enctype = (array_key_exists('enctype', $attributes) ? ' enctype="' . $attributes['enctype'] . '"' : '');
        $class = array_key_exists('class', $attributes) ? ' class="' . $attributes['class'] . '"' : '';
        $action = array_key_exists('action', $attributes) ? $attributes['action'] : '';
        $div = array_key_exists('rowclass', $attributes) ? ' class="' . $attributes['rowclass'] . '"' : '';

        $this->form = '<form method="' . $attributes['method'] . '" action="' . $action . '" ' . $enctype . $class . '>' . "\n\t";
        $this->form .= '<fieldset>' . "\n\t";
        $this->form .= array_key_exists('legend', $attributes) ? "<legend>" . $attributes['legend'] . "</legend>" . "\n\t" : "";

        foreach($this->GetFields() as $field)
        {
            $attr = $field['attributes'];
            $options = array_key_exists('options', $attr) ? $attr['options'] : [];
            $value = array_key_exists('value', $attr) ? 'value="' . $attr['value'] . '"' : '';
            $class = array_key_exists('class', $attr) ? ' class="' . $attr['class'] . '"' : '';
            $placeholder = array_key_exists('placeholder', $attr) ? ' placeholder="' . $attr['placeholder'] . '"' : '';
            $textarea_content = array_key_exists('content', $attr) ? $attr['content'] : '';

            if ($attr['label'] === null || $attr['label'] === "")
            {
                throw new Exception("Le label du champ doit être indiqué.");
            }

            $label = '<label for="' . $field['name'] . '">' . $attr['label'] . '</label>';

            switch($field['type'])
            {
                case 'select':
                    $this->form .= '<div' . $div . '>';
                    $this->form .= $label;
                    $this->form .= '<select' . $class . ' name="' . $field['name'] . '" id="' . $field['name'] . '">' . "\n\t";
    
                    foreach($options as $option)
                    {
                        $this->form .= '<option value="' . $option['value'] . '">' . $option['label'] . '</option>' . "\n\t";
                    }
                    
                    $this->form .= '</select>' . "\n\t";
                    $this->form .= '</div>';
                break;

                case 'textarea':
                    $this->form .= '<div' . $div . '>';
                    $this->form .= $label;
                    $this->form .= '<textarea name="' . $field['name'] .'" id="' . $field['name'] .'" ' . $class . '>' . $textarea_content . '</textarea>' . "\n\t";
                    $this->form .= '</div>';
                break;

                case 'radio':
                    $this->form .= '<div' . $div . '>';
                    $this->form .= '<input type="radio" name="' . $field['name'] .'" id="' . $field['name'] .'" ' . $class . '/>' . $label . "\n\t";
                    $this->form .= '</div>';
                break;

                case 'checkbox':
                    $this->form .= '<div' . $div . '>';
                    $this->form .= '<input type="checkbox" name="' . $field['name'] .'" id="' . $field['name'] .'" ' . $class . '/>' . $label . "\n\t";
                    $this->form .= '</div>';
                break;

                case 'hidden':
                    $this->form .= '<input type="hidden" name="' . $field['name'] .'" id="' . $field['name'] .'" ' . $value . '/>' . "\n\t";;
                break;

                default:
                    $this->form .= '<div' . $div . '>';
                    $this->form .= $label;
                    $this->form .= '<input type="' . $field['type'] . '" name="' . $field['name'] .'" id="' . $field['name'] .'" ' . $class . $placeholder . $value . '/>' . "\n\t";
                    $this->form .= '</div>';
                break;
            }
        }

        $this->form .= '</fieldset>' . "\n\t";

        $this->form .= '<fieldset>';
        $this->RenderButtons();
        $this->form .= '</fieldset>';

        $this->form .= '</form>' . "\n";

        return $this;
	}

    /**
	*	Cette méthode ajoute un champ au formulaire.
    *   
    *	@param string $name 		Nom du champ
    *   @param string $type         Type du champ           (text, number, textarea, radio, checkbox)
    *   @param array $attributes    Attributs du champ
    *	@param array $rules 		Règles de validation
    *
    *   @return FormBuilder
	**/
	public function AddField(string $name, string $type = 'text', array $attributes = [], array $rules = []): FormBuilder
    {
        if (!$name || trim($name) === '')
        {
            throw new InvalidArgumentException("Le nom du champ DOIT être indiqué et ne peut contenir aucun espace ou caractères spéciaux.");
        }

        if (!$type || trim($type) === '') 
        {
            throw new InvalidArgumentException("Le type du champ DOIT être indiqué.");
        }

        $this->fields[$name] = [
            'name'          => $name,
            'type'          => $type, 
            'attributes'    => $attributes,
            'rules'         => $rules
        ];
    
        return $this;
    }

    /**
    *   Cette méthode permet d'ajouter des boutons au formulaire.
    *
    *   @return FormBuilder
    **/
    public function AddButton(string $name, string $type = 'button', array $options = []): FormBuilder
    {
        if (!$name || trim($name) === '')
        {
            throw new InvalidArgumentException("Le nom du bouton DOIT être indiqué et ne peut contenir aucun espace ou caractères spéciaux.");
        }

        // Traitement du bouton
        $this->buttons[$name] = [
            'name'          => $name,
            'type'          => $type, 
            'options'       => $options,
        ];

        return $this;
    }

    /**
    *   Cette méthode permet de filtrer les champs.
    *
    *   @return FormBuilder
    **/
    public function FilterFields(): FormBuilder
    {
        if (empty($this->fields))
        {
            return null;
        }

        $this->fields = array_filter($this->fields, function($field) 
        {
            return !is_null($field) && !is_object($field) || !is_array($field);
        });

        return $this;
    }

    /**
    *   Cette méthode permet de vérifier si le formulaire est valide.
    *
    *   @return bool
    **/
    public function IsValid(): bool
    {
        return true;
    }

    /**
    *   Cette méthode permet de formatter le nom label pour le champ.
    *   
    *   @param string $name         Nom du champ
    *   
    *   @return string
    **/
    public function FormatLabel(string $name): string
    {
        if (!$name) 
        {
            return null;
        }

        return ucfirst(str_replace('_', ' ', $name));
    }

    /**
    *   Cette méthode vérifie si le champ existe dans le tableau des champs.
    *
    *   @param string $name         Nom du champ
    *
    *   @return bool
    **/
    public function Has(string $name): bool
    {
        return array_key_exists($name, $this->fields);
    }

    /**
    *   Cette méthode récupère toutes les règles du champ. 
    *
    *   @return array
    **/
    public function GetRulesField(): array
    {
        return [];
    }

    /**
    *   Cette méthode permet de récupérer le type de champ.
    *
    *   @param string $field         Nom du champ 
    *
    *   @return string 
    **/
    public function GetTypeField(string $field): string
    {
        return '';
    }

    /**
    *   Cette méthode récupère tous les champs. 
    *
    *   @return array
    **/
    public function GetFields(): array
    {
        return $this->fields;
    }

    /**
    *   Cette méthode permet de récupérer un champ et de pouvoir l'afficher.
    *
    *   @return FormBuilder
    **/
    public function GetField(): FormBuilder
    {   
        throw new Exception("Cette fonctionnalité n'est pas implémentée");
    }
}

?>