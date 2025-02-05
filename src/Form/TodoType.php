<?php

// src/Form/TodoType.php
namespace App\Form;

use App\Entity\Todo;
use App\Entity\Categorie;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\OptionsResolver\OptionsResolver;

class TodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')

            ->add('etat', ChoiceType::class, [
                'label' => 'État',
                'choices' => [
                    'En attente' => 'en_attente',
                    'En cours' => 'en_cours',
                    'Terminé' => 'termine',
                ],
            ])

            // Champ de sélection pour la catégorie
            ->add('id_categorie', EntityType::class, [
                'class' => Categorie::class, // Entité liée
                'choice_label' => 'nom', // Assure-toi que le champ 'nom' existe dans Categorie
                'label' => 'Catégorie', // Titre du champ dans le formulaire
            ])

            ->add('users', EntityType::class, [
                'class' => User::class, // Remplace User::class par l'entité correspondante
                'choice_label' => function(User $user) {
                    return $user->getNom() . ' ' . $user->getPrenom();
                },
                'label' => 'Utilisateurs', // Titre du champ dans le formulaire
                'multiple' => true,   // Permet la sélection de plusieurs utilisateurs
                'expanded' => true,   // Affiche sous forme de cases à cocher
            ])



            ->add('ajouter', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Todo::class,
        ]);
    }
}

