<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Valid;

class SignUpType extends AbstractType
{
    /**
     * [buildForm]
     * @param  FormBuilderInterface $builder
     * @param  array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array(
                'label'     => 'Adresse email*',
                'attr'      => array('placeholder' => 'Entrez l\'adresse email'),
                'required'  => true))

            ->add('username', TextType::class, array(
                'label'     => 'Nom d\'utilisateur*',
                'attr'      => array('placeholder' => 'Entrez le nom d\'utilisateur'),
                'required'  => true))

            ->add('password', PasswordType::class, array(
                'label'     => 'Mot de passe*',
                'attr'      => array('placeholder' => 'Entrez le mot de passe'),
                'required'  => true))
            ->add('confirm_password', PasswordType::class, array(
                'label'     => 'Confirmation mot de passe*',
                'attr'      => array('placeholder' => 'Retappez le mot de passe'),
                'required'  => true))
            ->add('address', AddressType::class, [
                'label'     => 'Adresse',
                'constraints'     => [ new Valid()]
            ])
            ;
    }

    /**
     * [configureOptions]
     * @param  OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
