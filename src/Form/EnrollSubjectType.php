<?php
namespace App\Form;

use App\Entity\User;
use App\Entity\Subject;
use App\Entity\StudentEnrolledSubject;
use App\Form\SubjectType;
use App\Repository\StudentEnrolledSubjectRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\DataTransformer\ChoiceToValueTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Security\Core\Encoder\Argon2iPasswordEncoder;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class EnrollSubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'subject', EntityType::class, array(
                'class' => Subject::class,
                'choice_label'=>'subjectName','multiple'=>false,'expanded'=>true))
            ->add('status',ChoiceType::class,array(
                    'choices'=> array('Passed'=>'Passed','Failed'=>'Failed','Drop Out'=>'Drop_Out'),
                    'multiple'=>false,'expanded'=>true)
            )
        ;
    }
}