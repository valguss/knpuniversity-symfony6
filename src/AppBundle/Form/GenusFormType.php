<?php

namespace AppBundle\Form;

use AppBundle\Entity\Genus;
use AppBundle\Repository\SubFamilyRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class GenusFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder
			->add('name')
			->add('subFamily', null, [
				'placeholder' => 'Choose a sub family',
				'query_builder' => function(SubFamilyRepository $repo) {
					return $repo->createAlphabeticalQueryBuilder();
                }
			])
			->add('speciesCount')
			->add('funFact')
			->add('isPublished', ChoiceType::class, [
				'choices' => [
					'Yes' => true,
					'No' => false
				]
			])
			->add('firstDiscoveredAt', DateType::class, [
				'widget' => 'single_text',
				'attr' => [
					'class' => 'js-datepicker'
				],
				'html5' => false
			]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
		$resolver->setDefaults([
			'data_class' => Genus::class
		]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_genus_form_type';
    }
}
