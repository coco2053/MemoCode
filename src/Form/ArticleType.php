<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('texts', CollectionType::class, array(
                'entry_type'   => TextType::class,
                'entry_options' => ['label' => false],
                'label' => false,
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype'    => true,
                'required' => false
            ))
            ->add('memos', CollectionType::class, array(
                'entry_type'   => MemoType::class,
                'entry_options' => ['label' => false],
                'label' => false,
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype'    => true,
                'required' => true
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
