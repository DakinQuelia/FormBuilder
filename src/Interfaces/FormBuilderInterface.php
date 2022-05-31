<?php
/*======================================================================*\
||  FormBuilder					                                        ||
||  Fichier     :                                                       ||
||        DakinQuelia\FormBuilder\Interfaces\FormBuilderInterface.php   ||
||  Version     : 1.1.0                                	                ||
||  Auteur(s)   : Dakin Quelia						                    ||
||  ------------------------------------------------------------------  ||
||  Copyright ©2022 FormBuilder - codé par Dakin Quelia                 ||
\*======================================================================*/
namespace DakinQuelia\FormBuilder\Interfaces;

interface FormBuilderInterface
{
    /**
    *   Cette méthode de générer le code HTML du formulaire.
    *     
    *	@param string $title 		Titre du formulaire
    *   @param array $attributes    Attributs du formulaire 
    *
    *   @return FormBuilder
    **/
    public function GetForm(): string;

    /**
    *   Cette méthode permet de générer les boutons du formulaire.
    *
    *   @return FormBuilder
    **/
    public function RenderButtons(): self;

	/**
	*	Cette méthode permet de construire le formulaire.
    *
    *	@param string $title 		Titre du formulaire
    *   @param array $attributes    Attributs du formulaire 
    *   
    *   @return void
	**/
	public function BuildForm(string $title, array $attributes = []): self;

	/**
	*	Cette méthode ajoute un champ au formulaire.
    *   
    *	@param string $name 		Nom du champ
    *   @param string $type         Type du champ
    *	@param array $rules 		Règles de validation
    *
    *   @return FormBuilder
	**/
	public function AddField(string $name, string $type, array $rules): self;

    /**
    *   Cette méthode permet d'ajouter des boutons au formulaire.
    *
    *   @return FormBuilder
    **/
    public function AddButton(string $name, string $type = 'button', array $options = []): self;

    /**
    *   Cette méthode permet de filtrer les champs.
    *
    *   @return FormBuilder
    **/
    public function FilterFields(): self;
    
    /**
    *   Cette méthode permet de vérifier si le formulaire est valide.
    *
    *   @return void
    **/
    public function IsValid(): bool;

    /**
    *   Cette méthode permet de formatter le nom label pour le champ.
    *   
    *   @param string $name         Nom du champ
    *   
    *   @return string
    **/
    public function FormatLabel(string $name): string;

    /**
    *   Cette méthode vérifie si le champ existe dans le tableau des champs.
    *
    *   @param string $name         Nom du champ
    *
    *   @return bool
    **/
    public function Has(string $name): bool;

    /**
    *   Cette méthode récupère toutes les règles du champ. 
    *
    *   @return array
    **/
    public function GetRulesField(): array;

    /**
    *   Cette méthode récupère tous les champs. 
    *
    *   @return array
    **/
    public function GetFields(): array;

    /**
    *   Cette méthode permet de récupérer un champ et de pouvoir l'afficher.
    **/
    public function GetField(): self;
}

?>