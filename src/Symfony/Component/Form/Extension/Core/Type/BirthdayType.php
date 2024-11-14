<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Form\Extension\Core\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BirthdayType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'years' => range((int) date('Y') - 120, date('Y')),
            'invalid_message' => 'Please enter a valid birthdate.',
        ]);

        $resolver->setAllowedTypes('years', 'array');
    }

    public function getParent(): ?string
    {
        return DateType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'birthday';
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $currentMonth = date('m');
        $currentDay = date('d');
        $view->vars['attr']['min'] ??= sprintf('%d-%s-%s', reset($options['years']), $currentMonth, $currentDay);
        $view->vars['attr']['max'] ??= sprintf('%d-%s-%s', end($options['years']), $currentMonth, $currentDay);
    }
}
