<?php

namespace App\Form;

use App\Entity\Aiku;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @property UserRepository $userRepository
 */
class AikuType extends AbstractType
{
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'promptNative',
                TextareaType::class,
                [
                    'attr' => ['class' => 'textarea'],
                    'required' => true,
                ]
            )
            ->add(
                'prompt',
                TextareaType::class,
                [
                    'attr' => ['class' => 'textarea'],
                    'required' => false,
                ]
            )
            ->add(
                'locale',
                LocaleType::class,
                [
                    'data' => "DE",
                    'attr' => ['class' => 'select'],
                    'required' => false,
                ]
            )
            ->add(
                'parameters',
                TextType::class,
                [
                    'attr' => ['class' => 'input'],
                    'required' => false,
                ]
            )
            ->add(
                'imageFile',
                FileType::class,
                [
                    'mapped' => false,
                    'attr' => ['class' => 'input'],
                    'required' => false,
                ]
            )
            ->add(
                'author',
                ChoiceType::class,
                [
                    'placeholder' => 'Choose an author',
                    'choices' => $this->userRepository->findAll(),
                    'choice_label' => function(?User $user) {
                        return $user ? $user->getName() : '';
                    },
                    'attr' => ['class' => 'input'],
                    'required' => true,
                ]
            )
            ->add('isPublished',
                CheckboxType::class,
                [
                    'label_attr' => ['class' => 'checkbox'],
                    'attr' => ['type' => 'checkbox'],
                    'required' => false,
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'attr' => ['class' => 'button is-primary']
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Aiku::class,
        ]);
    }
}