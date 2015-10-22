<?php

namespace Ent\Validator;

/**
 * Description of NoOtherEntityExists
 *
 * @author egrondin
 */
class NoOtherEntityExists extends \DoctrineModule\Validator\NoObjectExists
{

    private $id;
    private $additionalFields = null;

    public function __construct(array $options)
    {
        parent::__construct($options);
        if (!isset($options['id'])) {
            throw new InvalidArgumentException('Key "id" must be specified in the options for others');
        }
        if (!isset($options['id_getter'])) {
            throw new InvalidArgumentException('Key "id_getter" must be specified in the options for others');
        }
        if (isset($options['additionalFields'])) {
            $this->additionalFields = $options['additionalFields'];
        }
        $this->id = $options['id'];
        $this->id_getter = $options['id_getter'];
    }

    public function isValid($value, $context = null)
    {
        if (null !== $this->additionalFields && is_array($context)) {
            $value = (array) $value;
            foreach ($this->additionalFields as $field) {
                if (!isset($context[$field])) {
                    throw new InvalidArgumentException('Field "' . $field . '"Unspecified in additionalFields');
                }
                $value[] = $context[$field];
            }
        }
        $value = $this->cleanSearchValue($value);
        $match = $this->objectRepository->findOneBy($value);
        if (is_object($match) && $match->{$this->id_getter}() != $this->id) {
            if (is_array($value)) {
                $str = '';
                foreach ($value as $field) {
                    if ($str != '') {
                        $str .= ', ';
                    }
                    $str .= $field;
                }
                $value = $str;
            }
            $this->error(self::ERROR_OBJECT_FOUND, $value);
            return false;
        }
        return true;
    }

}
