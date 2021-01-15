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

final class Metadata implements MetadataInterface
{
    /**
     * @var string
     */
    private string $code;

    /**
     * @var array
     */
    private array $parameters;

    /**
     * Metadata constructor.
     *
     * @param string $code
     * @param array $parameters
     */
    private function __construct(string $code, array $parameters)
    {
        if (!isset($parameters['classes'], $parameters['templates'])) {
            throw new \InvalidArgumentException('Classes and Templates must be specified in parameters.');
        }
        if (1 !== substr_count($code, '.')) {
            throw new \InvalidArgumentException('The Code should contain one dot (.).');
        }
        $this->code = $code;
        $this->parameters = $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromCodeAndConfiguration(string $code, array $parameters): self
    {
        return new self($code, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias(): ?string
    {
        return $this->parameters['alias'] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function getCamelCasedCode(): string
    {
        return (string) preg_replace_callback('/\.([a-z])/i', function($match) {
            return strtoupper($match[1]);
        }, $this->getCode());
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled(): bool
    {
        return $this->parameters['enabled'];
    }

    /**
     * {@inheritdoc}
     */
    public function getParameter(string $name)
    {
        if (!$this->hasParameter($name)) {
            throw new \InvalidArgumentException(sprintf('Parameter "%s" is not configured for resource "%s".', $name, $this->getCode()));
        }

        return $this->parameters[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function hasParameter(string $name): bool
    {
        return \array_key_exists($name, $this->parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getClass(string $name): string
    {
        if (!$this->hasClass($name)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" is not configured for resource "%s".', $name, $this->getCode()));
        }

        return $this->parameters['classes'][$name];
    }

    /**
     * {@inheritdoc}
     */
    public function hasClass(string $name): bool
    {
        return isset($this->parameters['classes'][$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate(string $name): string
    {
        if (!$this->hasTemplate($name)) {
            throw new \InvalidArgumentException(sprintf('Template "%s" is not configured for resource "%s".', $name, $this->getCode()));
        }

        return $this->parameters['templates'][$name];
    }

    /**
     * {@inheritdoc}
     */
    public function hasTemplate(string $name): bool
    {
        return isset($this->parameters['templates'][$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function getServiceId(string $serviceName): string
    {
        $code = explode('.', $this->code);

        return sprintf('%s.%s.%s', $code[0], $serviceName, $code[1]);
    }

    /**
     * {@inheritdoc}
     */
    public function getTags(): array
    {
        return $this->parameters['tags'] ?? [];
    }
}
