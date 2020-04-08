<?php

namespace App\Form;

use App\Entity\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
//use FOS\CKEditorBundle\Form\Type\CKEditorType;

class TextType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('content', CKEditorType::class)
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
            'data_class' => Text::class,
        ]);
    }
}
