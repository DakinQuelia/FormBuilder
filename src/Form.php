<?php
/*======================================================================*\
||  Corona CMS						                                    ||
||  Fichier     : DakinQuelia\FormBuilder\Form.php                      ||
||  Version     : 1.0.0.                                	            ||
||  Auteur(s)   : Dakin Quelia						                    ||
||  ------------------------------------------------------------------  ||
||  Copyright ©2022 Corona CMS - codé par Dakin Quelia                  ||
\*======================================================================*/
namespace DakinQuelia\FormBuilder;

class Form extends FormBuilder
{
    protected $form;                                        // Formulaire
    protected array $fields = [];                          // Champs

	/**
	*   Ceci initialise la classe.
	**/
	public function __construct()
	{
		parent::__construct();
	}

    /**
	*	Cette méthode permet de créer le formulaire.
    * 
    *	@param string $title 	    Titre du formulaire  
    * 
	*   @return Form
    **/
	public function Render(string $title, array $attributes = []): self
    {
        return $this->Render($title, $attributes);
    }
}

?>