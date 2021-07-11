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

namespace MonsieurBiz\SyliusRichEditorPlugin\UiElement;

use Symfony\Contracts\Translation\TranslatorInterface;

trait UiElementTrait
{
    /**
     * @var MetadataInterface
     */
    protected MetadataInterface $metadata;

    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * @var bool
     */
    protected bool $ignored = false;

    /**
     * {@inheritdoc}
     */
    public function setMetadata(MetadataInterface $metadata): void
    {
        $this->metadata = $metadata;
    }

    /**
     * {@inheritdoc}
     */
    public function setTranslator(TranslatorInterface $translator): void
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode(): string
    {
        return $this->metadata->getCode();
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias(): ?string
    {
        return $this->metadata->getAlias();
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled(): bool
    {
        return $this->metadata->isEnabled();
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return $this->metadata->getParameter('title');
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return $this->metadata->getParameter('description');
    }

    /**
     * {@inheritdoc}
     */
    public function getIcon(): string
    {
        return $this->metadata->getParameter('icon');
    }

    /**
     * {@inheritdoc}
     */
    public function getFormClass(): string
    {
        return $this->metadata->getClass('form');
    }

    /**
     * {@inheritdoc}
     */
    public function getAdminFormTemplate(): string
    {
        return $this->metadata->getTemplate('admin_form');
    }

    /**
     * {@inheritdoc}
     */
    public function getAdminRenderTemplate(): string
    {
        return $this->metadata->getTemplate('admin_render');
    }

    /**
     * {@inheritdoc}
     */
    public function getFrontRenderTemplate(): string
    {
        return $this->metadata->getTemplate('front_render');
    }

    public function ignore(): void
    {
        $this->ignored = true;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'code' => $this->getCode(),
            'description' => $this->translator->trans($this->getDescription()),
            'icon' => $this->getIcon(),
            'title' => $this->translator->trans($this->getTitle()),
            'ignored' => $this->ignored,
            'tags' => $this->metadata->getTags(),
        ];
    }
}
