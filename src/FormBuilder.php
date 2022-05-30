<?php
/*======================================================================*\
||  Corona CMS						                                    ||
||  Fichier     : DakinQuelia\FormBuilder\FormBuilder.php               ||
||  Version     : 1.0.0.                                	            ||
||  Auteur(s)   : Dakin Quelia						                    ||
||  ------------------------------------------------------------------  ||
||  Copyright ©2022 Corona CMS - codé par Dakin Quelia                  ||
\*======================================================================*/
namespace DakinQuelia\FormBuilder;

use Exception;
use InvalidArgumentException;
use DakinQuelia\FormBuilder\Interfaces\FormBuilderInterface;

class FormBuilder implements FormBuilderInterface
{
    protected $form;                                       // Formulaire
    protected array $fields = [];                         // Tableau des champs du formulaire
    protected array $attr_default = [];                  // Attributs par défaut du formulaire

	/**
	*   Ceci initialise la classe.
	**/
	public function __construct()
	{
		//
	}

    /**
    *   Cette méthode de générer le code HTML du formulaire.
    *     
    *	@param string $title 		Titre du formulaire
    *   @param array $attributes    Attributs du formulaire 
    *
    *   @return FormBuilder
    **/
    public function Render(string $title, array $attributes = []): self
    {
        $this->FilterFields();
        $this->BuildForm($title, $attributes);

        return $this;
    }

	/**
	*	Cette méthode permet de créer le formulaire.
    * 
    *	@param string $title 	    Titre du formulaire  
    * 
    *   @return FormBuilder
	**/
	public function BuildForm(string $title, array $attributes = []): self
	{
        if (!$attributes['method'])
        {
            $attributes['method'] = 'GET';
        }

        $enctype = (array_key_exists('enctype', $attributes) ? ' enctype="' . $attributes['enctype'] . '"' : '');
        $class = array_key_exists('class', $attributes) ? ' class="' . $attributes['class'] . '"' : '';

        $this->form = '<form action="' . $attributes['method'] . '"' . $enctype . $class . '>';
        $this->form .= '<fieldset>';
        $this->form .= array_key_exists('legend', $attributes) ? "<legend>" . $attributes['legend'] . "</legend>" : "";

        foreach($this->GetFields() as $field)
        {
            $attr = $field['attributes'];
            $options = array_key_exists('options', $attr) ? $attr['options'] : null;
            $class = array_key_exists('class', $attr) ? ' class="' . $attr['class'] . '"' : '';
            
            if ($field['type'] === 'select' && is_array($options))
            {
                $this->form .= '<select' . $class . '>';

                foreach($options as $option)
                {
                    $this->form .= '<option value="' . $option['value'] . '">' . $option['label'] . '</option>';
                }
                
                $this->form .= '</select>';
            }
            else if ($field['type'] === 'textarea')
            {
                $this->form .= '<textarea name="' . $field['name'] .'" id="' . $field['name'] .'" ' . $class . '></textarea>';
            }
            else
            {
                $this->form .= '<input type="' . $field['type'] . '" name="' . $field['name'] .'" id="' . $field['name'] .'" ' . $class . '/>';
            }
        }

        $this->form .= '</fieldset>';
        $this->form .= '</form>';

        return $this;
	}

    /**
	*	Cette méthode ajoute un champ au formulaire.
    *   
    *	@param string $name 		Nom du champ
    *   @param string $type         Type du champ
    *	@param array $rules 		Règles de validation
    *
    *   @return FormBuilder
	**/
	public function AddField(string $name, string $type = 'text', array $attributes = [], array $rules = []): self
    {
        if (!$name || trim($name) === '')
        {
            throw new InvalidArgumentException("Le nom du champ DOIT être indiqué.");
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
    *   Cette méthode permet de filtrer les champs.
    *
    *   @return FormBuilder
    **/
    public function FilterFields(): self
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
    public function GetField(): self
    {   
        throw new Exception("Cette fonctionnalité n'est pas implémentée");
    }
}

?>