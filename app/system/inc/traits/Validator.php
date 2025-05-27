<?php
/**
 * Validator - for validate form
 */

trait Validator
{
    public $validationData = array(); // Validation data array

    public $validationErrors = array(); // Validation errors array

//    public $rulesArray = array(); // Temporary array for validation row rules



    /**
     * addError - you can use it in controller before isValid()
     * @param bool $key
     * @param bool $value
     */
    protected function addError($key = false, $value = false)
    {
        $this->validationErrors[$key] = $value;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->validationErrors;
    }

    /**
     * @return bool
     */
    public function isErrors()
    {
        return $this->validationErrors ? true : false;
    }

    /**
     * Start validation
     * @param string $method post|get
     * @return bool
     */
    public function startValidation($method = 'post')
    {
        // Clear data
        $this->validationData = array();

        // Clear errors
        $this->validationErrors = array();

        if ($method == 'post' && count($_POST) > 0)
            return true;
        else if ($method == 'get' && count($_GET) > 0)
            return true;

        return false;
    }


    // $this->addError('password', 'Invalid email and/or password. Please check your data and try again'); // this should be replaceable

    /**
     * @param $key
     * @param bool $name
     * @param string $rules
     * @param bool $default
     * @return bool
     */
    protected function validatePost($key, $name = false, $rules = 'trim', $default = false)
    {
        // Rules row to array
        $rulesArray = $this->processRules($rules);
        $value = $_POST[$key] ?? '';

        // Check rules
        $result = $this->checkRules($value, $key, $name, $rulesArray);

        if ($result)
            return post($key, true, $default);
        else
            return false;
    }

    /**
     * @param $key
     * @param bool $name
     * @param string $rules
     * @param bool $default
     * @return bool
     */
    protected function validateGet($key, $name = false, $rules = 'trim', $default = false)
    {
        // Rules row to array
        $rulesArray = $this->processRules($rules);
        $value = $_GET[$key] ?? '';

        // Check rules
        $result = $this->checkRules($value, $key, $name, $rulesArray);

        if ($result)
            return get($key, true, $default);
        else
            return false;
    }

    /**
     * @param $filtersRow
     * @return array
     */
    private function processRules($filtersRow)
    {
        $rulesArray = array();
        $tmpRulesArr = explode('|', $filtersRow);

        // Parse rules
        foreach ($tmpRulesArr as $name) {
            $name = mb_strtolower($name);

            // check params, ex: min_length[1], max_length[100]
            if (mb_strpos($name, '[')) {
                $rowName = trim($name, ']');
                $rowArr = explode('[', $rowName);

                $rulesArray[ $rowArr[0] ] = $rowArr[1];
            } else {
                $rulesArray[ $name ] = true;
            }
        }

        return $rulesArray;
    }

    /**
     * @param $value - field value
     * @param $key - field name
     * @param $name - label
     * @param array $rulesArray - rules array
     * @return bool
     */
    private function checkRules($value, $key, $name, array $rulesArray)
    {
        // $rulesArray can contain values: required|trim|strip_tags|email|password|url|min_length[1]|max_length[10]|min[1]|max[5]|min_count[1]|max_count[5]|is_file

        // trim
        if (array_key_exists('trim', $rulesArray))
            $value = trim($value);

        // strip_tags
        if (array_key_exists('strip_tags', $rulesArray))
            $value = strip_tags($value);

        // Required
        if (array_key_exists('required', $rulesArray)) {
            if (!$value && !is_array($value))
                $this->validationErrors[ $key ] = 'The ' . $name . ' field is required.';
        }

        // Email
        if (array_key_exists('email', $rulesArray)) {
            if (!mb_strlen($value) && !array_key_exists('required', $rulesArray)) {
                return true;
            } else if (!checkEmail($value)) {
                $this->validationErrors[$key] = 'The ' . $name . ' field must contain a valid email address.';
                return false;
            }
        }

        // Email
        if (array_key_exists('password', $rulesArray)) {
            if (!mb_strlen($value) && !array_key_exists('required', $rulesArray)) {
                return true;
            } else if (!checkPassword($value)) {
                $this->validationErrors[$key] = 'The ' . $name . ' field must be at least 8 characters long, including 1 char A-Z, 1 char a-z, 1 char 0-9.';
                return false;
            }
        }

        // Url
        if (array_key_exists('url', $rulesArray)) {
            if (!mb_strlen($value) && !array_key_exists('required', $rulesArray)) {
                return true;
            } else if (!checkURL($value)) {
                $this->validationErrors[$key] = 'The ' . $name . ' field must contain a valid URL.';
                return false;
            }
        }

        // Min length
        if (array_key_exists('min_length', $rulesArray)) {
            if (!mb_strlen($value) && !array_key_exists('required', $rulesArray)) {
                return true;
            } else if (mb_strlen($value) < intval($rulesArray['min_length'])) {
                $this->validationErrors[$key] = 'The ' . $name . ' field must be at least ' . $rulesArray['min_length'] . ' characters in length.';
                return false;
            }
        }

        // Max length
        if (array_key_exists('max_length', $rulesArray)) {
            if (!mb_strlen($value) && !array_key_exists('required', $rulesArray)) {
                return true;
            } else if (mb_strlen($value) > intval($rulesArray['max_length'])) {
                $this->validationErrors[$key] = 'The ' . $name . ' field cannot exceed ' . $rulesArray['max_length'] . ' characters in length.';
                return false;
            }
        }

        if (array_key_exists('max_words', $rulesArray)) {
            if (!str_word_count($value) && !array_key_exists('required', $rulesArray)) {
                return true;
            } else if (str_word_count($value) > intval($rulesArray['max_words'])) {
                $this->validationErrors[$key] = 'The ' . $name . ' field cannot exceed ' . $rulesArray['max_words'] . ' words in length.';
                return false;
            }
        }

        // Tel
        if (array_key_exists('tel', $rulesArray)) {
            if (!mb_strlen($value) && !array_key_exists('required', $rulesArray)) {
                return true;
            } else if (!checkPhoneNumber($value)) {
                $this->validationErrors[$key] = 'The ' . $name . ' field must contain a valid phone number. Format: +7 (123) 456-78-90 or 8-123-456-78-90, etc.';
                return false;
            }
        }

        // Min range
        if (array_key_exists('min', $rulesArray)) {
            if (!mb_strlen($value) && !array_key_exists('required', $rulesArray)) {
                return true;
            } else if ($value < intval($rulesArray['min'])) {
                $this->validationErrors[$key] = 'The ' . $name . ' field must contain a number greater than ' . $rulesArray['min'];
                return false;
            }
        }

        // Max range
        if (array_key_exists('max', $rulesArray)) {
            if (!mb_strlen($value) && !array_key_exists('required', $rulesArray)) {
                return true;
            } else if ($value > intval($rulesArray['max'])) {
                $this->validationErrors[$key] = 'The ' . $name . ' field must contain a number less than ' . $rulesArray['max'];
                return false;
            }
        }


        // MIN count // interests[] - checkboxes
        if (array_key_exists('min_count', $rulesArray)) {
            if (is_array($value) && !array_key_exists('required', $rulesArray)) {
                return true;
            } else if (is_array($value) && count($value) < intval($rulesArray['min_count'])) {
                $this->validationErrors[$key] = 'The ' . $name . ' field must contain minimum ' . $rulesArray['min_count'] . ' item(s)';
                return false;
            }
        }

        // MAX count // interests[] - checkboxes
        if (array_key_exists('max_count', $rulesArray)) {
            if (is_array($value) && !array_key_exists('required', $rulesArray)) {
                return true;
            } else if (count($value) > intval($rulesArray['max_count'])) {
                $this->validationErrors[$key] = 'The ' . $name . ' field must contain maximum ' . $rulesArray['max_count'] . ' item(s)';
                return false;
            }
        }

        // is_file
        if (array_key_exists('is_file', $rulesArray)) {
            if (!mb_strlen($value) && !array_key_exists('required', $rulesArray)) {
                return true;
            } else if (!isFileName($value)) {
                $this->validationErrors[$key] = 'The ' . $name . ' field must contain a valid file name.';
                return false;
            }
        }

//        // CI errors lang:
//        $lang['form_validation_isset']			= 'The {field} field must have a value.';
//        $lang['form_validation_valid_email']		= 'The {field} field must contain a valid email address.';
//        $lang['form_validation_valid_url']		= 'The {field} field must contain a valid URL.';
//        $lang['form_validation_valid_ip']		= 'The {field} field must contain a valid IP.';
//        $lang['form_validation_exact_length']		= 'The {field} field must be exactly {param} characters in length.';
//        $lang['form_validation_alpha']			= 'The {field} field may only contain alphabetical characters.';
//        $lang['form_validation_alpha_numeric']		= 'The {field} field may only contain alpha-numeric characters.';
//        $lang['form_validation_alpha_numeric_spaces']	= 'The {field} field may only contain alpha-numeric characters and spaces.';
//        $lang['form_validation_alpha_dash']		= 'The {field} field may only contain alpha-numeric characters, underscores, and dashes.';
//        $lang['form_validation_numeric']		= 'The {field} field must contain only numbers.';
//        $lang['form_validation_is_numeric']		= 'The {field} field must contain only numeric characters.';
//        $lang['form_validation_integer']		= 'The {field} field must contain an integer.';
//        $lang['form_validation_regex_match']		= 'The {field} field is not in the correct format.';
//        $lang['form_validation_matches']		= 'The {field} field does not match the {param} field.';
//        $lang['form_validation_differs']		= 'The {field} field must differ from the {param} field.';
//        $lang['form_validation_is_unique'] 		= 'The {field} field must contain a unique value.';
//        $lang['form_validation_is_natural']		= 'The {field} field must only contain digits.';
//        $lang['form_validation_is_natural_no_zero']	= 'The {field} field must only contain digits and must be greater than zero.';
//        $lang['form_validation_decimal']		= 'The {field} field must contain a decimal number.';
//        $lang['form_validation_less_than']		= 'The {field} field must contain a number less than {param}.';
//        $lang['form_validation_less_than_equal_to']	= 'The {field} field must contain a number less than or equal to {param}.';
//        $lang['form_validation_greater_than']		= 'The {field} field must contain a number greater than {param}.';
//        $lang['form_validation_greater_than_equal_to']	= 'The {field} field must contain a number greater than or equal to {param}.';
//        $lang['form_validation_error_message_not_set']	= 'Unable to access an error message corresponding to your field name {field}.';
//        $lang['form_validation_in_list']		= 'The {field} field must be one of: {param}.';

        return true;
    }

    // TODO this function
    public function isValid()
    {
        if (!$this->validationErrors)
            return true;
        else
            return false;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function isValide(array $data)
    {
        foreach ($this->elements as $key => $value)
        {
            $localError = 0;
            // Required
            if ($value['filter']['required'] === true) {
                if (!$data[$key]) {
                    if ($value['setError']['required'])
                        $this->setError($value['setError']['required']);
                    else
                        $this->setError($key.'_required');
                    $localError = 1;
                }
            }

            // E-mail
            if ($value['filter']['email'] === true) {
                if ($value['filter']['required'] !== true && !$data[$key] && $value['filter']['return'] === false) {
                    //
                } elseif (!checkEmail($data[$key])) {
                    if ($value['setError']['email'])
                        $this->setError($value['setError']['email']);
                    else
                        $this->setError($key.'_email');
                    $localError = 1;
                }
            }

            // Password
            if ($value['filter']['password'] === true) {
                if ($value['filter']['required'] !== true && !$data[$key] && $value['filter']['return'] === false) {
                    //
                } elseif (!checkPassword($data[$key])) {
                    if ($value['setError']['password'])
                        $this->setError($value['setError']['password']);
                    else
                        $this->setError($key.'_password');
                    $localError = 1;
                }
            }

            // Number
            if ($value['filter']['number'] === true) {
                if ($value['filter']['required'] !== true && !$data[$key] && $value['filter']['return'] === false) {
                    //
                } elseif (!is_numeric($data[$key]) && $data[$key]!= 0) {
                    if ($value['setError']['number'])
                        $this->setError($value['setError']['number']);
                    else
                        $this->setError($key.'_number');
                    $localError = 1;
                }
            }

            // Regx
            if ($value['filter']['regx']) {
                if ($value['filter']['required'] !== true && !$data[$key] && $value['filter']['return'] === false) {
                    //
                } elseif (!preg_match($value['filter']['regx'], trim($data[$key]))) {
                    if ($value['setError']['regx'])
                        $this->setError($value['setError']['regx']);
                    else
                        $this->setError($key.'_regx');
                    $localError = 1;
                }
            }

            // Equal
            if ($value['filter']['equal']) {
                if ($value['filter']['required'] !== true && !$data[$key] && $value['filter']['return'] === false) {
                    //
                } elseif ($data[$key] != $data[$value['filter']['equal']]) {
                    if ($value['setError']['equal'])
                        $this->setError($value['setError']['equal']);
                    else
                        $this->setError($key.'_equal_'.$value['filter']['equal']);
                    $localError = 1;
                }
            }

            // Length min
            if ($value['filter']['lengthMin']) {
                if ($value['filter']['required'] !== true && !$data[$key] && $value['filter']['return'] === false) {
                    //
                } elseif (mb_strlen($data[$key]) < intval($value['filter']['lengthMin'])) {
                    if ($value['setError']['lengthMin'])
                        $this->setError($value['setError']['lengthMin']);
                    else
                        $this->setError($key.'_lengthMin');
                    $localError = 1;
                }
            }

            // Length max
            if ($value['filter']['lengthMax']) {
                if ($value['filter']['required'] !== true && !$data[$key] && $value['filter']['return'] === false) {
                    //
                } elseif (mb_strlen($data[$key]) > intval($value['filter']['lengthMax'])) {
                    if ($value['setError']['lengthMax'])
                        $this->setError($value['setError']['lengthMax']);
                    else
                        $this->setError($key.'_lengthMax');
                    $localError = 1;
                }
            }

            // Range min
            if ($value['filter']['rangeMin']) {
                if ($value['filter']['required'] !== true && !$data[$key] && $value['filter']['return'] === false) {
                    //
                } elseif ($data[$key] < intval($value['filter']['rangeMin'])) {
                    if ($value['setError']['rangeMin'])
                        $this->setError($value['setError']['rangeMin']);
                    else
                        $this->setError($key.'_rangeMin');
                    $localError = 1;
                }
            }

            // Range max
            if ($value['filter']['rangeMax']) {
                if ($value['filter']['required'] !== true && !$data[$key] && $value['filter']['return'] === false) {
                    //
                } elseif ($data[$key] > intval($value['filter']['rangeMax'])) {
                    if ($value['setError']['rangeMax'])
                        $this->setError($value['setError']['rangeMax']);
                    else
                        $this->setError($key.'_rangeMax');
                    $localError = 1;
                }
            }

            if ($localError == 0) {
                if ($value['filter']['required'] !== true && !$data[$key] && $value['filter']['return'] === false) {
                    //
                } else {
                    $this->data[$key] = $data[$key];
                }
            }
        }

        if (empty($this->validationErrors))
            return true;
        else
            return false;
    }

}
/* End of file */