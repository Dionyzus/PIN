<?php

namespace App\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class StudentSubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        $builder
            ->setMethod($options['method'])
            ->setAction($options['action'])
            ->add(
                'studentMap',
                'entity',
                [
                    'error_bubbling' => true,
                    'class' => 'App\Entity\Student',
                    'property' => 'studentId',
                    'multiple' => false,
                    'expanded' => false,
                    'empty_value' => '',
                    'query_builder' => function (EntityRepository $repo)
                    {
                        return $repo->createQueryBuilder('st')->orderBy('st.studentId', 'ASC');
                    },
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Student is required.'
                            ]
                        )
                    ]
                ]
            )
            ->add(
                'subjectMap',
                'entity',
                [
                    'error_bubbling' => true,
                    'class' => 'App\Entity\Subject1',
                    'property' => 'code',
                    'multiple' => false,
                    'expanded' => false,
                    'empty_value' => '',
                    'query_builder' => function (EntityRepository $repo)
                    {
                        return $repo->createQueryBuilder('sb')->orderBy('sb.code', 'ASC');
                    },
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Subject is required.'
                            ]
                        )
                    ]
                ]
            );
    }

    public function getName()
    {
        return 'studentsubject';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => 'App\Entity\StudentSubject']
        );
    }
}