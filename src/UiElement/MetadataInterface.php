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

interface MetadataInterface
{
    /**
     * @param string $code
     * @param array $parameters
     *
     * @return MetadataInterface
     */
    public static function fromCodeAndConfiguration(string $code, array $parameters): self;

    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @return string
     */
    public function getAlias(): ?string;

    /**
     * @return string
     */
    public function getCamelCasedCode(): string;

    /**
     * @return bool
     */
    public function isEnabled(): bool;

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function getParameter(string $name);

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasParameter(string $name): bool;

    /**
     * @return array
     */
    public function getParameters(): array;

    /**
     * @param string $name
     *
     * @return string
     */
    public function getClass(string $name): string;

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasClass(string $name): bool;

    /**
     * @param string $name
     *
     * @return string
     */
    public function getTemplate(string $name): string;

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasTemplate(string $name): bool;

    /**
     * @param string $serviceName
     *
     * @return string
     */
    public function getServiceId(string $serviceName): string;

    /**
     * @return array
     */
    public function getTags(): array;
}
