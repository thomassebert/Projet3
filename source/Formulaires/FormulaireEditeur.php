<?php
namespace projet3\Formulaires;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class FormulaireEditeur extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class)
            ->add('auteur', TextType::class)
            ->add('contenu', TextareaType::class)
            ->add('image', FileType::class)
            ->add('etat', ChoiceType::class, array(
                'choices'  => array(
                    'Publier' => 'publié',
                    'Sauvegarder comme brouillon' => 'brouillon'
                    ),
                'required' => false
                ))
            ;   
    }
    
}
