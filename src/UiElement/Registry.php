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

use MonsieurBiz\SyliusRichEditorPlugin\Exception\UiElementNotFoundException;
use Webmozart\Assert\Assert;

final class Registry implements RegistryInterface
{
    /**
     * @var UiElementInterface[]
     */
    private array $uiElements = [];

    /**
     * {@inheritdoc}
     */
    public function addUiElement(UiElementInterface $uiElement): void
    {
        Assert::keyNotExists($this->uiElements, $uiElement->getCode(), 'UiElement with code "%s" is already registered.');

        $this->uiElements[$uiElement->getCode()] = $uiElement;
        if (null !== $uiElement->getAlias() && $uiElement->isEnabled()) {
            $this->uiElements[$uiElement->getAlias()] = clone $uiElement;
            $uiElement->ignore();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasUiElement(string $code): bool
    {
        return \array_key_exists($code, $this->uiElements);
    }

    /**
     * {@inheritdoc}
     */
    public function getUiElement(string $code): UiElementInterface
    {
        if (!$this->hasUiElement($code)) {
            throw new UiElementNotFoundException($code);
        }

        return $this->uiElements[$code];
    }

    /**
     * {@inheritdoc}
     */
    public function getUiElements(): array
    {
        return $this->uiElements;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->uiElements;
    }
}
