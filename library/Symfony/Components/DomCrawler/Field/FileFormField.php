<?php

namespace Symfony\Components\DomCrawler\Field;

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * FileFormField represents a file form field (an HTML file input tag).
 *
 * @package    Symfony
 * @subpackage Components_DomCrawler
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 */
class FileFormField extends FormField
{
    /**
     * Sets the PHP error code associated with the field.
     *
     * @param integer $error The error code (one of UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE, UPLOAD_ERR_PARTIAL, UPLOAD_ERR_NO_FILE, UPLOAD_ERR_NO_TMP_DIR, UPLOAD_ERR_CANT_WRITE, or UPLOAD_ERR_EXTENSION)
     *
     * @throws \InvalidArgumentException When error code doesn't exist
     */
    public function setErrorCode($error)
    {
        $codes = array(UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE, UPLOAD_ERR_PARTIAL, UPLOAD_ERR_NO_FILE, UPLOAD_ERR_NO_TMP_DIR, UPLOAD_ERR_CANT_WRITE, UPLOAD_ERR_EXTENSION);
        if (!in_array($error, $codes))
        {
            throw new \InvalidArgumentException(sprintf('The error code %s is not valid.', $error));
        }

        $this->value = array('name' => '', 'type' => '', 'tmp_name' => '', 'error' => $error, 'size' => 0);
    }

    /**
     * Sets the value of the field.
     *
     * @param string $value The value of the field
     */
    public function setValue($value)
    {
        if (null !== $value && is_readable($value))
        {
            $error = UPLOAD_ERR_OK;
            $size = filesize($value);
        }
        else
        {
            $error = UPLOAD_ERR_NO_FILE;
            $size = 0;
            $value = '';
        }

        $this->value = array('name' => basename($value), 'type' => '', 'tmp_name' => $value, 'error' => $error, 'size' => $size);
    }

    /**
     * Initializes the form field.
     *
     * @throws \LogicException When node type is incorrect
     */
    protected function initialize()
    {
        if ('input' != $this->node->nodeName)
        {
            throw new \LogicException(sprintf('A FileFormField can only be created from an input tag (%s given).', $this->node->nodeName));
        }

        if ('file' != $this->node->getAttribute('type'))
        {
            throw new \LogicException(sprintf('A FileFormField can only be created from an input tag with a type of file (given type is %s).', $this->node->getAttribute('type')));
        }

        $this->setValue(null);
    }
}