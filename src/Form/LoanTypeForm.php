<?php

namespace App\Form;

use App\Entity\Loan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class LoanTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('borrowedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('returnedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('vinyl', null, [
                'choice_label' => 'title',
            ]);

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $loan = $event->getData();
            $form = $event->getForm();

            $borrowedAt = $loan->getBorrowedAt();
            $returnedAt = $loan->getReturnedAt();

            if ($returnedAt && $returnedAt < $borrowedAt) {
                $form->get('returnedAt')->addError(new FormError('La date de retour doit être après la date d\'emprunt.'));
            }

            if ($borrowedAt && $borrowedAt < new \DateTimeImmutable()) {
                $form->get('borrowedAt')->addError(new FormError('La date d\'emprunt ne peut pas être dans le passé.'));
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Loan::class,
        ]);
    }
}
