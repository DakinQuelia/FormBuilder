<?php
/*======================================================================*\
||  FormBuilder						                                    ||
||  Fichier     : DakinQuelia\FormBuilder\Form.php                      ||
||  Version     : 1.1.0                                	                ||
||  Auteur(s)   : Dakin Quelia						                    ||
||  ------------------------------------------------------------------  ||
||  Copyright ©2022 FormBuilder - codé par Dakin Quelia                 ||
\*======================================================================*/
namespace DakinQuelia\FormBuilder;

class Form extends FormBuilder
{
	/**
	*   Ceci initialise la classe.
	**/
	public function __construct(string $title, array $attributes = [])
	{
		parent::__construct($title, $attributes);
	}

    /**
	*	Cette méthode permet de créer le formulaire.
    * 
    *	@param string $title 	    Titre du formulaire  
    *   @param array $attributes    Attributs du formulaire 
    * 
	*   @return Form
    **/
	public function Render(): string
    {
        return $this->GetForm(); 
    }
}

?>