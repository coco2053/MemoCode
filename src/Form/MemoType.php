<?php

namespace App\Form;

use App\Entity\Memo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Language;

class MemoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('language', EntityType::class, [
                  'class' => Language::class,
                  'choice_label' => 'name',
                  'multiple' => false,
                  'expanded' => true,
            ])
            ->add('content')
            ->add('articleOrder',null,array(
              'label' => false,
              'attr' => array(
                'style' =>'visibility:hidden;'
                )))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Memo::class,
        ]);
    }
}
