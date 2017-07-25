<?php
namespace projet3\Formulaires;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


class FormulaireCommentaire extends AbstractType
{
	
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('auteur_commentaire', TextType::class)
            ->add('contenu_commentaire', TextareaType::class)
            ->add('email', EmailType::class)
            ->add('id_commentaire_reponse', HiddenType::class)
            ->add('niveau_commentaire', HiddenType::class)
            ->add('signalement', HiddenType::class)
        ;
    }
    
}

