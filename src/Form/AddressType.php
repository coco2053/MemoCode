<?php

namespace App\Form;

use App\Service\GouvApi;
use App\Entity\Address;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AddressType extends AbstractType
{
    private $country;

    public function __construct(GouvApi $gouvApi, $country = null)
    {
        $this->gouvApi = $gouvApi;
        $this->country = $country;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('street', TextType::class, array(
                'label'     => 'Rue*',
                'attr'      => array('placeholder' => 'Entrez le numéro et la rue'),
                'required'  => true
            ))
            ->add('complement', TextType::class, array(
                'label'     => "Complément",
                'attr'      => array('placeholder' => 'Entrez le complément d\'adresse'),
                'required'  => false
            ))
            ->add('postalCode', TextType::class, array(	'label' => 'Code postal*',
                'required' => true,
                'error_bubbling' => true,
                'attr' => array('placeholder' => 'Entrez le code postal', 'class' => 'autoDptController')
            ))
           /* ->add('city', TextType::class,      [
                    'label' => 'Ville*',
                    "required"      => true
                ]
            )*/
            ->add('departement', EntityType::class,      [
                    "class"         => "App:Departement",
                    "required"      => false,
                    'attr' => array('class' => 'autoDptField_Dpt')
                ]
            )
            ->add('country', EntityType::class,      [
                    "class"         => "App:Country",
                    'label' => 'Pays*',
                    "required"      => true,
                    'attr' => array('class' => 'autoDptField_Country')
                ]
            )
        ;
        $builder->get('country')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $this->country = $form->getNormData()->getSlug();
                dump($this->country);
            }
        );
        $builder->get('postalCode')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $postCode = $form->getNormData();

                    $cities = $this->gouvApi->getCities($postCode);
                    dump($cities);

                    $form->getParent()->add('city', ChoiceType::class, [
                        'required'    => false,
                        'placeholder' => 'Sélectionnez votre ville',
                        'choices'     => array_combine($cities, $cities)
                    ]);


            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
