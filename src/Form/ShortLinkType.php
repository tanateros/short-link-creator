<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Class ShortLinkType
 *
 * @package App\Form
 */
class ShortLinkType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('link', UrlType::class, [
                'required' => true,
                'help' => 'Attention: input url need with protocol (http:// ot https://)',
            ])
            ->add('Create short link', SubmitType::class, [
                'attr' => [
                    'class' => 'btn-primary btn-lg btn-block'
                ]
            ])
        ;
    }
}
