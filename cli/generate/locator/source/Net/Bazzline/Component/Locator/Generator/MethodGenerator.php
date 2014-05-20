<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-04-24 
 */

namespace Net\Bazzline\Component\Locator\Generator;

/**
 * Class MethodGenerator
 * @package Net\Bazzline\Component\Locator\LocatorGenerator\Generator
 * @todo set return
 */
class MethodGenerator extends AbstractDocumentedGenerator
{
    /**
     * @param string $name
     * @param string $defaultValue
     * @param string $typeHint
     * @param bool $isReference
     */
    public function addParameter($name, $defaultValue = '', $typeHint = '', $isReference = false)
    {
        $parameter = array(
            'default_value' => $defaultValue,
            'name'          => $name,
            'is_reference'  => $isReference,
            'type_hint'     => $typeHint
        );

        $this->addGeneratorProperty('parameters', $parameter);
        if ($this->completeDocumentationAutomatically === true) {
            /** @var DocumentationGenerator $documentation */
            $documentation = $this->getGeneratorProperty('documentation');
            $documentation->addParameter($name, array($typeHint));
        }
    }

    /**
     * @return null|array
     */
    public function getBody()
    {
        return $this->getGeneratorProperty('body', null);
    }

    public function setIsAbstract()
    {
        $this->addGeneratorProperty('abstract', true, false);
    }

    /**
     * @param array $body
     * @param null|string|array $typeHintOfReturnValue
     */
    public function setBody(array $body, $typeHintOfReturnValue = null)
    {
        $this->addGeneratorProperty('body', $body, false);
        $this->addGeneratorProperty('has_body', true, false);
        if ((!is_null($typeHintOfReturnValue))
            && ($this->completeDocumentationAutomatically === true)) {
            /** @var DocumentationGenerator $documentation */
            $documentation = $this->getGeneratorProperty('documentation');
            $documentation->setReturn($typeHintOfReturnValue);
        }
    }

    public function markAsHasNoBody()
    {
        $this->addGeneratorProperty('has_body', false, false);
    }

    public function markAsFinal()
    {
        $this->addGeneratorProperty('final', true, false);
    }

    public function markAsPrivate()
    {
        $this->addGeneratorProperty('visibility', 'private', false);
    }

    public function markAsProtected()
    {
        $this->addGeneratorProperty('visibility', 'protected', false);
    }

    public function markAsPublic()
    {
        $this->addGeneratorProperty('visibility', 'public', false);
    }

    public function markAsStatic()
    {
        $this->addGeneratorProperty('static', true, false);
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->addGeneratorProperty('name', (string) $name, false);
    }

    /**
     * @throws InvalidArgumentException|RuntimeException
     * @return string
     */
    public function generate()
    {
        $this->generateDocumentation();
        $this->generateSignature();
        $this->generateBody();

        return $this->generateStringFromContent();
    }

    private function generateBody()
    {
        $hasBody    = $this->getGeneratorProperty('has_body', true);
        $isAbstract = $this->getGeneratorProperty('abstract', false);

        if (!$isAbstract
            && $hasBody) {
            $this->addContent($this->getBlockGenerator('{'));
            $this->addGeneratorAsContent(
                $this->getBlockGenerator(
                    $this->getGeneratorProperty('body', array('//@todo implement'))
                ),
                true
            );
            $this->addContent($this->getBlockGenerator('}'));
        }
    }

    private function generateDocumentation()
    {
        $documentation = $this->getGeneratorProperty('documentation');

        if ($documentation instanceof DocumentationGenerator) {
            $this->addGeneratorAsContent($documentation);
        }
    }

    private function generateSignature()
    {
        if ($this->canBeGenerated()) {
            $hasBody        = $this->getGeneratorProperty('has_body', true);
            $isAbstract     = $this->getGeneratorProperty('abstract', false);
            $isFinal        = $this->getGeneratorProperty('final', false);
            $isStatic       = $this->getGeneratorProperty('static', false);
            $name           = $this->getGeneratorProperty('name');
            $parameters     = $this->getGeneratorProperty('parameters', array());
            $visibility     = $this->getGeneratorProperty('visibility');

            //@todo refactor the wired usage for line and block generator
            $line = $this->getLineGenerator();

            if ($isAbstract) {
                $line->add('abstract');
            } else if ($isFinal) {
                $line->add('final');
            }

            if (!is_null($visibility)) {
                $line->add($visibility);
            }

            if ($isStatic) {
                $line->add('static');
            }

            $parameterLine = $this->getLineGenerator();
            foreach ($parameters as $parameter) {
                if ((strlen($parameter['type_hint']) > 0)
                    && (!in_array($parameter['type_hint'], $this->getNotPrintableTypeHints()))) {
                    $parameterLine->add($parameter['type_hint']);
                }
                $parameterLine->add(($parameter['is_reference'] ? '&' : '') . '$' . $parameter['name']);
                if (strlen((string) $parameter['default_value']) > 0) {
                    $parameterLine->add('= ' . (string) $parameter['default_value']);
                }
            }
            $line->add('function ' . $name . '(' . $parameterLine->generate() . ')' . ((($isAbstract) || (!$hasBody)) ? ';' : ''));
            $block = $this->getBlockGenerator($line);
            $this->addContent($block);
        }
    }
}