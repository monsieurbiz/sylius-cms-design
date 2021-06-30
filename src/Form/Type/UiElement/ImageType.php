<?php

/*
 * This file is part of Monsieur Biz' Rich Editor plugin for Sylius.
 *
 * (c) Monsieur Biz <sylius@monsieurbiz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MonsieurBiz\SyliusRichEditorPlugin\Form\Type\UiElement;

use MonsieurBiz\SyliusRichEditorPlugin\Form\Constraints\RichEditorConstraints;
use MonsieurBiz\SyliusRichEditorPlugin\Form\Type\AlignmentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType as FormTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints as Assert;

class ImageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', FileType::class, [
                'label' => 'monsieurbiz_richeditor_plugin.ui_element.monsieurbiz.image.field.image',
                'data_class' => null,
                'required' => true,
                'attr' => ['data-image' => 'true'], // To be able to manage display in form
            ])
            ->add('alt', FormTextType::class, [
                'required' => false,
                'label' => 'monsieurbiz_richeditor_plugin.ui_element.monsieurbiz.image.field.alt',
            ])
            ->add('title', FormTextType::class, [
                'required' => false,
                'label' => 'monsieurbiz_richeditor_plugin.ui_element.monsieurbiz.image.field.title',
            ])
            ->add('link', FormTextType::class, [
                'required' => false,
                'label' => 'monsieurbiz_richeditor_plugin.ui_element.monsieurbiz.image.field.link',
                'constraints' => [
                    new Assert\Url([]),
                ],
            ])
            ->add('align', AlignmentType::class)
        ;

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event): void {
            // Change image field constraints depending on submitted value
            $options = $event->getForm()->get('image')->getConfig()->getOptions();
            $options['constraints'] = RichEditorConstraints::getImageConstraints($event->getData(), 'image');
            $event->getForm()->add('image', FileType::class, $options);
        });
    }
}
