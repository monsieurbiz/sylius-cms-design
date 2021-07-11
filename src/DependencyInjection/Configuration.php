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

namespace MonsieurBiz\SyliusRichEditorPlugin\DependencyInjection;

use MonsieurBiz\SyliusRichEditorPlugin\UiElement\UiElement;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('monsieurbiz_sylius_richeditor');
        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = /** @scrutinizer ignore-deprecated */ $treeBuilder->root('monsieurbiz_sylius_richeditor');
        }

        $this->addUiElements($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $rootNode
     */
    private function addUiElements(ArrayNodeDefinition $rootNode): void
    {
        /** @scrutinizer ignore-call */
        $rootNode
            ->children()
                ->scalarNode('upload_directory')->end()
                ->scalarNode('default_element')->defaultValue('monsieurbiz.html')->end()
                ->scalarNode('default_element_data_field')->defaultValue('content')->end()
                ->arrayNode('ui_elements')
                    ->useAttributeAsKey('code', false)
                    ->defaultValue([])
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('title')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('description')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('alias')->end()
                            ->scalarNode('icon')->isRequired()->cannotBeEmpty()->end()
                            ->booleanNode('enabled')->defaultTrue()->end()
                            ->arrayNode('classes')
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->scalarNode('form')->isRequired()->cannotBeEmpty()->end()
                                    ->scalarNode('ui_element')->defaultValue(UiElement::class)->end()
                                ->end()
                            ->end()
                            ->arrayNode('templates')
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->scalarNode('admin_form')
                                        ->defaultValue('@MonsieurBizSyliusRichEditorPlugin/Admin/form.html.twig')
                                    ->end()
                                    ->scalarNode('admin_render')->isRequired()->cannotBeEmpty()->end()
                                    ->scalarNode('front_render')->isRequired()->cannotBeEmpty()->end()
                                ->end()
                            ->end()
                            ->arrayNode('tags')
                                ->defaultValue([])
                                ->scalarPrototype()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end()
        ;
    }
}
