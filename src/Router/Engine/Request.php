<?php

namespace MvcLite\Router\Engine;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Entities\File;
use MvcLite\Router\Engine\Exceptions\UndefinedInputException;
use MvcLite\Router\Engine\Exceptions\UndefinedParameterException;

/**
 * Request manager class.
 *
 * @author belicfr
 */
class Request
{
    /** Current request URI. */
    private string $uri;

    /** Current request inputs. */
    private array $inputs;

    /** Current request parameters. */
    private array $parameters;

    /** Current request files. */
    private array $files;

    public function __construct()
    {
        $this->uri = $_SERVER["REQUEST_URI"];

        $this->saveInputs();
        $this->saveParameters();
        $this->saveFiles();
    }

    /**
     * Saves $_POST values and returns its neutralized version.
     *
     * @return array Inputs array
     */
    private function saveInputs(): array
    {
        $inputs = [];

        foreach ($_POST as $inputKey => $inputValue)
        {
            $inputs[$inputKey] = htmlspecialchars($inputValue);
        }

        return $this->inputs = $inputs;
    }

    /**
     * @return array Current request inputs
     */
    public function getInputs(): array
    {
        return $this->inputs;
    }

    /**
     * @param string $key Input key
     * @param bool $neutralize If input value must be neutralized
     * @return string|null Input value if exists; else NULL
     */
    public function getInput(string $key, bool $neutralize = true): ?string
    {
        if (!in_array($key, array_keys($this->getInputs())))
        {
            return null;
        }

        $input = $this->getInputs()[$key];

        return $neutralize
            ? $input
            : htmlspecialchars_decode($input);
    }

    /**
     * @return string Decoded current request URI
     */
    public function getUri(): string
    {
        return urldecode($this->uri);
    }

    /**
     * Saves $_GET values and returns them.
     *
     * @return array Parameters array
     */
    private function saveParameters(): array
    {
        return $this->parameters = $_GET;
    }

    /**
     * @return array Current request parameters
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param string $key Parameter key
     * @return string Parameter value
     */
    public function getParameter(string $key): ?string
    {
        return $this->getParameters()[$key] ?? null;
    }

    /**
     * Saves $_GET values and returns them.
     *
     * @return array Files array
     */
    public function saveFiles(): array
    {
        $this->files = [];

        foreach ($_FILES as $fileKey => $file)
        {
            $this->files[$fileKey] = new File(
                $file["name"], $file["full_path"], $file["type"],
                $file["tmp_name"], $file["error"], $file["size"],
            );
        }

        return $this->files;
    }

    /**
     * @return array Current request files array
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    public function getFile(string $name): ?File
    {
        return $this->getFiles()[$name] ?? null;
    }
}