<?php
    /**
     * Validates data.
     * @param array $inputData user data.
     * @param array $errors the error array.
     * @param array $data The actual dta to send to the server.
     * @return Bool true if validation succeeds.
     */
    function isUserValid($inputData, &$errors, &$data)
    {
        // name
        $nameRegex = '/^[A-Za-z]+([\'\-\s][A-Za-z]+)*$/';
        if (!isset($inputData['fullname']))
            $errors['fullname'] = "Full name is required!";
        else if (trim($inputData['fullname']) === "")
            $errors['fullname'] = "Full name can not be empty!";
        else if (!preg_match($nameRegex, $inputData['fullname']))
            $errors['fullname'] = "Invalid name!";

        // email
        if (!isset($inputData['email']))
            $errors['email'] = "Email is required!";
        else if (!filter_var($inputData['email'], FILTER_VALIDATE_EMAIL))
            $errors['email'] = "Invalid email!";

        // password
        $passRegex = '/^(?=.*[0-9])(?=.*[!@#$%&])[A-Za-z0-9@$!&#]{8,}$/';
        if (!isset($inputData['password']))
            $errors['password'] = "Password is required!";
        else if ($inputData['email'] !== "admin@ikarrental.hu") {
            if (!preg_match($passRegex, $inputData['password']))
                $errors['password'] = "Invalid password";
            else if (!isset($inputData['password-check']))
                $errors['password-check'] = "Type password again!";
            else if ($inputData['password']!==$inputData['password-check'])
                $errors['password-check'] = "Passwords do not match!";
        }

        return count($errors) === 0;
    }

    /**
     * Validates data.
     * @param array $inputData user data.
     * @param array $errors the error array.
     * @return Bool true if validation succeeds.
     */
    function isLoginValid($inputData, &$errors)
    {
        if (!isset($inputData['email']) || !isset($inputData['password']))
            $errors['global'] = "Missing keys";

        if (trim($inputData['email']) === "")
            $errors['email'] = "Email is missing";

        if (trim($inputData['password']) === "")
            $errors['password'] = "Password is missing";

        return count($errors) === 0;
    }


    /**
     * Validates data.
     * @param array $inputData user data.
     * @param array $errors the error array.
     * @param array $data The actual dta to send to the server.
     * @return Bool true if validation succeeds.
     */
    function isCarValid($inputData, &$errors, &$data)
    {
        if (!isset($inputData['brand']) || !isset($inputData['model']) || !isset($inputData['year']) || !isset($inputData['transmission']) || !isset($inputData['fuel_type']) || !isset($inputData['passengers']) || !isset($inputData['daily_price_huf']) || !isset($inputData['image']))
            $errors['global'] = "Missing keys";

        if (trim($inputData['brand']) === "")
            $errors['brand'] = "Brand is missing";

        if (trim($inputData['model']) === "")
            $errors['model'] = "Model is missing";

        if ($inputData['year'] < 1000)
            $errors['year'] = "Invalid number";

        if ($inputData['passengers'] < 0)
            $errors['passengers'] = "Invalid number";

        if ($inputData['daily_price_huf'] < 0)
            $errors['daily_price_huf'] = "Invalid number";

        if (trim($inputData['image']) === "")
            $errors['image'] = "Image URL is missing";

        return count($errors) === 0;
    }

