<?php
/*
 *************************************************************************************************************************
 *██╗  ██╗███████╗██╗   ██╗██╗███╗   ██╗     █████╗ ██╗     ███████╗██╗  ██╗██╗███████╗     ██████╗        ███╗   ███╗   *
 *██║ ██╔╝██╔════╝██║   ██║██║████╗  ██║    ██╔══██╗██║     ██╔════╝╚██╗██╔╝██║██╔════╝    ██╔════╝        ████╗ ████║   *
 *█████╔╝ █████╗  ██║   ██║██║██╔██╗ ██║    ███████║██║     █████╗   ╚███╔╝ ██║███████╗    ██║  ███╗       ██╔████╔██║   *
 *██╔═██╗ ██╔══╝  ╚██╗ ██╔╝██║██║╚██╗██║    ██╔══██║██║     ██╔══╝   ██╔██╗ ██║╚════██║    ██║   ██║       ██║╚██╔╝██║   *
 *██║  ██╗███████╗ ╚████╔╝ ██║██║ ╚████║    ██║  ██║███████╗███████╗██╔╝ ██╗██║███████║    ╚██████╔╝██╗    ██║ ╚═╝ ██║██╗*
 *╚═╝  ╚═╝╚══════╝  ╚═══╝  ╚═╝╚═╝  ╚═══╝    ╚═╝  ╚═╝╚══════╝╚══════╝╚═╝  ╚═╝╚═╝╚══════╝     ╚═════╝ ╚═╝    ╚═╝     ╚═╝╚═╝*
 *************************************************************************************************************************
 */

class User
{
    private $db;

    // ****************************************************** CONSTRUCTOR ******************************************************
    public function __construct()
    {
        $this->db = new Connection;
    }
    /* ****************************************************** END OF CONSTRUCTOR ****************************************************** */

    // ************************************ GETTER FUNCTIONS ************************************
    public function getUsers()
    {
        $this->db->query('SELECT * FROM users');
        $results = $this->db->getRecords();
        return $results;
    }

    public function getStudents()
    {
        $this->db->query('SELECT * FROM students');
        $results = $this->db->getRecords();
        return $results;
    }

    public function getAllFDCUserByID($sessionID)
    {
        $this->db->query('SELECT * FROM solicitudes_fdc WHERE user_id = :user_id');
        $this->db->bind('user_id', $sessionID);
        $results = $this->db->getRecords();
        return $results;
    }

    public function getAllFDCByStatus($user_career)
    {
        try {
            // Prepare SQL query to fetch all records with the given user career only
            $this->db->query('SELECT * FROM solicitudes_fdc WHERE carrera = :career AND estado = "Enviado"');
            $this->db->bind('career', $user_career);

            // Execute the query and fetch the results
            $results = $this->db->getRecords();

            if ($results) {
                // Return the records from database
                return $results;
            } else {
                // Return null if the user career was not found
                return null;
            }
        } catch (PDOException $e) {
            // Handle database query error
            return null;
        }
    }

    public function getSentFDCData($user_career)
    {
        try {
            // Prepare SQL query to fetch new records with the given user career only
            $this->db->query('SELECT nControl, nombre, aPaterno, aMaterno, asunto, peticion, motivosA, motivosP, otrosM, anexos, firma_alumno, telefono, correo, observaciones, resp_solicitud FROM solicitudes_fdc WHERE carrera = :career AND estado = "Enviado"');
            $this->db->bind('career', $user_career);

            // Execute the query and fetch the results
            $results = $this->db->getRecords();

            if ($results) {
                // Return the new records from the database
                return $results;
            } else {
                // Return an empty array if no new data is found
                return [];
            }
        } catch (PDOException $e) {
            // Log the error
            error_log('Database error: ' . $e->getMessage());

            // Return an empty array or handle the error as needed
            return [];
        }
    }

    public function getActaInfo()
    {
        try {
            // Prepare SQL query to fetch new records with the given user career only
            $this->db->query('SELECT * FROM analisis_acta');

            // Execute the query and fetch the results
            $results = $this->db->getRecords();

            if ($results) {
                // Return the new records from the database
                return $results;
            } else {
                // Return an empty array if no new data is found
                return [];
            }
        } catch (PDOException $e) {
            // Log the error
            error_log('Database error: ' . $e->getMessage());

            // Return an empty array or handle the error as needed
            return [];
        }
    }

    public function getGralReqActaInfo()
    {
        try {
            // Prepare SQL query to fetch new records with the given user career only
            $this->db->query('SELECT * FROM asuntos_gen');

            // Execute the query and fetch the results
            $results = $this->db->getRecords();

            if ($results) {
                // Return the new records from the database
                return $results;
            } else {
                // Return an empty array if no new data is found
                return [];
            }
        } catch (PDOException $e) {
            // Log the error
            error_log('Database error: ' . $e->getMessage());

            // Return an empty array or handle the error as needed
            return [];
        }
    }

    public function deleteActaInfo($no_solicitud)
    {
        try {
            // Prepare SQL query to delete record with the given no_solicitud
            $this->db->query('DELETE FROM analisis_acta WHERE no_solicitud = :no_solicitud');
            $this->db->bind(':no_solicitud', $no_solicitud);

            // Execute the query
            $success = $this->db->execute();

            return $success;
        } catch (PDOException $e) {
            // Log the error
            error_log('Database error: ' . $e->getMessage());

            // Return false or handle the error as needed
            return false;
        }
    }

    public function deleteRecord($table, $column, $value)
    {
        try {
            // Prepare SQL query to delete record with the given condition
            $query = "DELETE FROM $table WHERE $column = :value";
            $this->db->query($query);
            $this->db->bind(':value', $value);

            // Execute the query
            $success = $this->db->execute();

            return $success;
        } catch (PDOException $e) {
            // Log the error
            error_log('Database error: ' . $e->getMessage());

            // Return false or handle the error as needed
            return false;
        }
    }

    public function getUserId($username)
    {
        try {
            $this->db->query('SELECT * FROM users WHERE username = :username');
            $this->db->bind(':username', $username);
            $result = $this->db->getRecord(); // Fetch as an object

            if ($result) {
                return $result->id; // Access object property with -> operator
            } else {
                return null; // Return null if the username doesn't exist
            }
        } catch (PDOException $e) {
            // Handle database query error
            return null;
        }
    }

    public function getChargeValue($userId)
    {
        try {
            $this->db->query('SELECT charge FROM users WHERE id = :id');
            $this->db->bind(':id', $userId);
            $result = $this->db->getRecord(); // Fetch as an object

            if ($result) {
                return $result->charge; // Access object property with -> operator
            } else {
                return null; // Return null if the user doesn't exist or doesn't have a charge value
            }
        } catch (PDOException $e) {
            // Handle database query error
            return null;
        }
    }

    public function getStudFDCByUser($stud_username)
    {
        try {
            $this->db->query('SELECT nControl FROM solicitudes_fdc WHERE stud_username = :stud_username');
            $this->db->bind(':stud_username', $stud_username);
            $result = $this->db->getRecord(); // Fetch as an object

            if ($result) {
                return $result->nControl; // Access object property with -> operator
            } else {
                return null; // Return null if the username doesn't exist
            }
        } catch (PDOException $e) {
            // Handle database query error
            return null;
        }
    }

    public function getStudId($username)
    {
        try {
            $this->db->query('SELECT * FROM students WHERE username = :username');
            $this->db->bind(':username', $username);
            $result = $this->db->getRecord(); // Fetch as an object

            if ($result) {
                return $result->id; // Access object property with -> operator
            } else {
                return null; // Return null if the username doesn't exist
            }
        } catch (PDOException $e) {
            // Handle database query error
            return null;
        }
    }

    public function getStudInfo($stud_username)
    {
        try {
            $this->db->query('SELECT * FROM students WHERE stud_username = :stud_username');
            $this->db->bind(':stud_username', $stud_username);
            $result = $this->db->getRecord(); // Fetch as an object

            if ($result) {
                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            // Handle database query error
            return null;
        }
    }

    public function getUserImageForSession()
    {
        // Check if the user is logged in and their session ID is set
        if (isset($_SESSION['id'])) {
            try {
                // Get the user's image URL from the database based on their ID (session ID)
                $userId = $_SESSION['id']; // Change 'id' to your session ID variable name
                $this->db->query('SELECT image_data FROM users WHERE id = :id');
                $this->db->bind(':id', $userId);
                $result = $this->db->getRecord(); // Fetch as an object

                if ($result) {
                    // User with the provided session ID exists, return the image URL
                    return $result->image_data;
                } else {
                    // User with the provided session ID does not exist, return null
                    return null;
                }
            } catch (PDOException $e) {
                // Handle database query error
                return null;
            }
        } else {
            // Handle the case where the user is not logged in or the session ID is not set
            return null;
        }
    }

    public function getStudImageForSession($userId)
    {
        try {
            // Get the user's image URL from the database based on their ID (session ID)
            $this->db->query('SELECT image_data FROM students WHERE stud_username = :userId');
            $this->db->bind(':userId', $userId);
            $result = $this->db->getRecord(); // Fetch as an object

            if ($result) {
                // User with the provided session ID exists, return the image URL
                return $result->image_data;
            } else {
                // User with the provided session ID does not exist, return null
                return null;
            }
        } catch (PDOException $e) {
            // Handle database query error
            return null;
        }
    }

    public function getUserNameForSession()
    {
        // Check if the user is logged in and their session ID is set
        if (isset($_SESSION['id'])) {
            try {
                // Get the user's name from the database based on their ID (session ID)
                $userId = $_SESSION['id'];
                $this->db->query('SELECT firstname FROM users WHERE id = :id');
                $this->db->bind(':id', $userId);
                $result = $this->db->getRecord();

                if ($result) {
                    // User with the provided session ID exists, return the name
                    return $result->firstname;
                } else {
                    // User with the provided session ID does not exist, return null
                    return null;
                }
            } catch (PDOException $e) {
                // Log the exception or handle it appropriately
                return $e->getMessage();
            }
        } else {
            // Handle the case where the user is not logged in or the session ID is not set
            return null;
        }
    }

    public function getUserNameAndRegistrationDateForSession()
    {
        // Check if the user is logged in and their session ID is set
        if (isset($_SESSION['id'])) {
            try {
                // Get the user's name and registration date from the database based on their ID (session ID)
                $userId = $_SESSION['id'];
                $this->db->query('SELECT firstname, charge, gender, created_at FROM users WHERE id = :id');
                $this->db->bind(':id', $userId);
                $result = $this->db->getRecord();

                if ($result) {
                    // User with the provided session ID exists
                    $userName = $result->firstname;
                    $charge = $result->charge;
                    $gender = $result->gender;
                    $registrationDate = date('d/m/y', strtotime($result->created_at));

                    return array('name' => $userName, 'charge' => $charge, 'gender' => $gender, 'registration_date' => $registrationDate);
                } else {
                    // User with the provided session ID does not exist, return null
                    return null;
                }
            } catch (PDOException $e) {
                // Handle database query error
                return null;
            }
        } else {
            // Handle the case where the user is not logged in or the session ID is not set
            return null;
        }
    }

    public function getUserById($id)
    {
        try {
            // Get user data by ID from the database
            $this->db->query('SELECT * FROM users WHERE id = :id');
            $this->db->bind(':id', $id);
            $user = $this->db->getRecord(); // Fetch as an object

            return $user; // Return the user object if found
        } catch (PDOException $e) {
            // Handle database query error
            return $e;
        }
    }

    public function getUsersById($user_id)
    {
        try {
            // Get user data by ID from the database
            $this->db->query('SELECT * FROM users WHERE id != :user_id');
            $this->db->bind(':user_id', $user_id);
            $user = $this->db->getRecords(); // Fetch as an object

            return $user; // Return the user object if found
        } catch (PDOException $e) {
            // Handle database query error
            return $e;
        }
    }

    public function getUserCareerByName($username)
    {
        try {
            // Prepare SQL query to fetch career associated with the given username
            $this->db->query('SELECT career FROM users WHERE username = :username');
            $this->db->bind(':username', $username);

            // Execute the query and fetch the result
            $result = $this->db->getRecord();

            if ($result) {
                // Return the career if the username was found
                return $result->career;
            } else {
                // Return null if the token was not found
                return null;
            }
        } catch (PDOException $e) {
            // Handle database query error
            $e->getMessage();
        }
    }

    public function getFDCNotifs($user_career)
    {
        try {
            // Prepare SQL query to fetch notifications associated with the given career
            $this->db->query('SELECT nControl, message, DATE_FORMAT(date, "%d/%m/%y") AS formattedDate FROM notificationsFDC WHERE career = :user_career');
            $this->db->bind(':user_career', $user_career);

            // Execute the query and fetch the result
            $results = $this->db->getRecords();

            // Return the notifications if any were found
            return $results;
        } catch (PDOException $e) {
            // Handle database query error
            return null;
        }
    }

    public function getStudCareerByNCtrl($username)
    {
        try {
            // Prepare SQL query to fetch career associated with the given username
            $this->db->query('SELECT stud_career FROM students WHERE stud_username = :username');
            $this->db->bind(':username', $username);

            // Execute the query and fetch the result
            $result = $this->db->getRecord();

            if ($result) {
                // Return the career if the username was found
                return $result->stud_career;
            } else {
                // Return null if the token was not found
                return null;
            }
        } catch (PDOException $e) {
            // Handle database query error
            $e->getMessage();
        }
    }

    public function getCurrentPassword($userId)
    {
        $this->db->query('SELECT password FROM users WHERE id = :userId');
        $this->db->bind(':userId', $userId);
        $row = $this->db->getRecord();

        if ($row) {
            return $row->password; // Return the hashed password from the database
        } else {
            return false; // User not found or some other error occurred
        }
    }

    public function getEmailByToken($token)
    {
        try {
            // Prepare a SQL query to fetch the email associated with the given token
            $this->db->query('SELECT email FROM password_reset_tokens WHERE token = :token');
            $this->db->bind(':token', $token);

            // Execute the query and fetch the result
            $result = $this->db->getRecord();

            if ($result) {
                // Return the email if the token was found
                return $result->email;
            } else {
                // Return null if the token was not found
                return null;
            }
        } catch (PDOException $e) {
            // Handle database query error
            return null;
        }
    }

    public function getCurrentPasswordStud($stud_username)
    {
        $this->db->query('SELECT stud_password FROM students WHERE stud_username = :stud_username');
        $this->db->bind(':stud_username', $stud_username);
        $row = $this->db->getRecord(); // Specify fetching as object

        if ($row) {
            return $row->stud_password; // Return the hashed password from the database
        } else {
            return false; // User not found or some other error occurred
        }
    }

    public function getCurrentUserPasswd($username)
    {
        $this->db->query('SELECT password FROM users WHERE username = :username');
        $this->db->bind(':username', $username);
        $row = $this->db->getRecord();

        if ($row) {
            return $row->password; // Return the hashed password from the database
        } else {
            return false; // User not found or some other error occurred
        }
    }

    /* ****************************************************** END OF GETTERS ****************************************************** */

    public function registerUser($data)
    {
        try {
            // Sanitize each input value
            $firstname = filter_var($data['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
            $usernameReg = filter_var($data['usernameReg'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $gender = filter_var($data['gender'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $charge = filter_var($data['charge'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Password is already hashed, so no need to sanitize it
            $this->db->bind(':passwordReg', $data['passwordReg']);

            // Sanitize the image-related fields
            $profile_image = filter_var($data['profile_image'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $file_name = filter_var($data['file_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $file_type = filter_var($data['file_type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Check if 'career' exists in the $data array before sanitizing
            if (isset($data['career'])) {
                $career = filter_var($data['career'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            } else {
                $career = ''; // Set an empty value for 'career' if it's not provided
            }

            // Insert user data into the database
            $this->db->query('INSERT INTO users (firstname, email, username, password, gender, charge, career, created_at, profile_image, file_name, file_type)
            VALUES (:firstname, :email, :usernameReg, :passwordReg, :gender, :charge, :career, NOW(), :profile_image, :file_name, :file_type)');

            // Bind sanitized values
            $this->db->bind(':firstname', $firstname);
            $this->db->bind(':email', $email);
            $this->db->bind(':usernameReg', $usernameReg);
            $this->db->bind(':passwordReg', $data['passwordReg']);
            $this->db->bind(':gender', $gender);
            $this->db->bind(':charge', $charge);
            $this->db->bind(':career', $career);
            $this->db->bind(':profile_image', $profile_image);
            $this->db->bind(':file_name', $file_name);
            $this->db->bind(':file_type', $file_type);

            // Execute the query
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Inside your User model class
    public function usernameExists($username)
    {
        // Check if a user with the provided username exists
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);
        $userByUsername = $this->db->getRecord();

        return $userByUsername; // Return true if a user with the same username exists
    }

    public function userEmailExists($email)
    {
        // Check if a user with the provided email exists
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $userByEmail = $this->db->getRecord();

        return $userByEmail; // Return true if a user with the same email exists
    }

    public function usernameStudentExists($username)
    {
        // Check if a user with the provided username exists
        $this->db->query('SELECT * FROM students WHERE stud_username = :username');
        $this->db->bind(':username', $username);
        $userByUsername = $this->db->getRecord();

        if ($userByUsername) {
            // A user with the same username exists
            return "El usuario ya existe con ese número de control"; // Return an error message
        }

        return false; // Return false if no user with the same username exists
    }

    public function setRememberToken($userId, $token, $expiration)
    {
        // Prepare the SQL query to update the remember_token and expiration for the user
        $sql = "UPDATE users SET remember_token = :token, remember_token_expiration = :expiration WHERE id = :userId";

        // Bind the values to the placeholders
        $this->db->query($sql);
        $this->db->bind(':token', $token);
        $this->db->bind(':expiration', date('Y-m-d H:i:s', $expiration));
        $this->db->bind(':userId', $userId);

        // Execute the query
        if ($this->db->execute()) {
            return true; // Update successful
        } else {
            return false; // Update failed
        }
    }


    public function authentication($data)
    {
        // Validate the $data parameter
        if (!is_array($data) || empty($data['username']) || empty($data['password'])) {
            return 'Hay campos vacíos, comprueba e intenta de nuevo';
        }

        $username = filter_var($data['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = trim($data['password']);

        try {
            // Get a query for the username record
            $this->db->query('SELECT * FROM users WHERE username = :username');

            // Bind values
            $this->db->bind(':username', $username);

            // Execute
            $user = $this->db->getRecord(); // Fetch as an object

            if ($user) {
                // User with the provided username exists
                $storedPasswordHash = $user->password; // Access object properties with -> operator

                // Password is correct, user is authenticated
                if (password_verify($password, $storedPasswordHash)) {
                    // Check if the checkbox is set to on and 'remember_token' cookie is set
                    if (isset($data['remember']) && $data['remember'] === 'on') {

                        // Generate a unique token
                        $rememberToken = bin2hex(random_bytes(32));

                        // Set the token in the database and remember for a certain period
                        $expiration = strtotime('+1 hour');
                        $this->setRememberToken($user->id, $rememberToken, $expiration);

                        // Store the token in a cookie
                        setcookie('remember_token', $rememberToken, $expiration, '/', '', false, true);
                    }
                    return true;
                } else {
                    // Invalid password, return message
                    return 'Contraseña incorrecta';
                }
            } else {
                // User with the provided username does not exist, return message
                return 'El nombre de usuario no existe';
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    public function authenticationStud($data)
    {
        // Validate the $data parameter
        if (!is_array($data) || empty($data['usernameStud']) || empty($data['passwordStud'])) {
            return 'Hay campos vacíos, comprueba e intenta de nuevo';
        }

        $stud_username = filter_var($data['usernameStud'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $stud_password = trim($data['passwordStud']);

        try {
            // Get a query for the username record
            $this->db->query('SELECT * FROM students WHERE stud_username = :stud_username');

            // Bind values
            $this->db->bind(':stud_username', $stud_username);

            // Execute
            $student = $this->db->getRecord(); // Fetch as an object

            if ($student) {
                // User with the provided username exists
                $storedPasswordHash = $student->stud_password; // Access object properties with -> operator

                // Password is correct, user is authenticated
                if (password_verify($stud_password, $storedPasswordHash)) {
                    return true;
                } else {
                    // Invalid password, return message
                    return 'Contraseña incorrecta';
                }
            } else {
                // User with the provided username does not exist, return message
                return 'El nombre de usuario con ese número de control no existe';
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    public function addFDC($fdcData)
    {
        // Validate and sanitize the input data
        $nControlA = filter_var($fdcData['nControlA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $nombreA = filter_var($fdcData['nombreA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $aPaternoA = filter_var($fdcData['aPaternoA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $aMaternoA = filter_var($fdcData['aMaternoA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $carreraA = filter_var($fdcData['carreraA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $asuntoA = filter_var($fdcData['asuntoA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $peticionA = filter_var($fdcData['peticionA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $fechaFDC = filter_var($fdcData['fechaFDC'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $motivosAcaA = filter_var($fdcData['motivosAcaA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $motivosPerA = filter_var($fdcData['motivosPerA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $otrosMA = filter_var($fdcData['otrosMA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $firmaA = filter_var($fdcData['firmaA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $telefonoA = filter_var($fdcData['telefonoA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $correoA = filter_var($fdcData['correoA'], FILTER_SANITIZE_EMAIL);
        $estadoFDC = filter_var($fdcData['estadoFDC'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // File names are in an array, so no need to sanitize them individually
        $anexosA = $fdcData['anexosA'];

        try {
            // Insert user data into the database
            $this->db->query('INSERT INTO solicitudes_fdc (nControl, nombre, aPaterno, aMaterno, carrera, asunto, peticion, fecha, motivosA, motivosP, otrosM, anexos, firma_alumno, telefono, correo, estado)
            VALUES (:nControlA, :nombreA, :aPaternoA, :aMaternoA, :carreraA, :asuntoA, :peticionA, :fechaFDC, :motivosAcaA, :motivosPerA, :otrosMA, :anexosA, :firmaA, :telefonoA, :correoA, :estadoFDC)');

            // Link values
            $this->db->bind(':nControlA', $nControlA);
            $this->db->bind(':nombreA', $nombreA);
            $this->db->bind(':aPaternoA', $aPaternoA);
            $this->db->bind(':aMaternoA', $aMaternoA);
            $this->db->bind(':carreraA', $carreraA);
            $this->db->bind(':asuntoA', $asuntoA);
            $this->db->bind(':peticionA', $peticionA);
            $this->db->bind(':fechaFDC', $fechaFDC);
            $this->db->bind(':motivosAcaA', $motivosAcaA);
            $this->db->bind(':motivosPerA', $motivosPerA);
            $this->db->bind(':otrosMA', $otrosMA);
            $this->db->bind(':anexosA', json_encode($anexosA)); // Store file names as JSON
            $this->db->bind(':firmaA', $firmaA); // Updated to use the signature image path
            $this->db->bind(':telefonoA', $telefonoA);
            $this->db->bind(':correoA', $correoA);
            $this->db->bind(':estadoFDC', $estadoFDC);

            // Execute the query
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    public function sendFDCObs($data)
    {
        try {
            // Loop through each selected ID and update the observation
            foreach ($data['selectedIds'] as $nControl) {
                $this->db->query('UPDATE solicitudes_fdc SET observaciones = :observation WHERE nControl = :nControl');
                $this->db->bind(':observation', $data['observation']);
                $this->db->bind(':nControl', $nControl);

                // Execute the query
                if (!$this->db->execute()) {
                    // If the query fails for any nControl, return false
                    return false;
                }
            }

            // If all queries executed successfully, return true
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function sendFDCNotif($data)
    {
        try {
            $this->db->query('INSERT INTO notificationsFDC (nControl, career, message, date)
            VALUES (:nControl_stud, :stud_career, :message, NOW())');

            // Bind values
            $this->db->bind(':nControl_stud', $data['nControl_stud']);
            $this->db->bind(':stud_career', $data['stud_career']);
            $this->db->bind(':message', $data['message']);

            // Execute
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    public function gralReqData($data)
    {
        try {
            $this->db->query('INSERT INTO asuntos_gen (responsableActa, nom_alumActa, nCtrlAlumAct, carAlumAct, resolAct)
            VALUES (:responsableAG, :nomAlumAG, :nCtrlAlumAG, :careerSelAG, :resolucionAG)');

            // Bind values
            $this->db->bind(':responsableAG', $data['responsableAG']);
            $this->db->bind(':nomAlumAG', $data['nomAlumAG']);
            $this->db->bind(':nCtrlAlumAG', $data['nCtrlAlumAG']);
            $this->db->bind(':careerSelAG', $data['careerSelAG']);
            $this->db->bind(':resolucionAG', $data['resolucionAG']);

            // Execute
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    public function sendComment($data)
    {
        try {
            $this->db->query('INSERT INTO comments (firstname, comment, comment_date)
        VALUES (:firstname, :comment, NOW())');

            // Bind values
            $this->db->bind(':firstname', $data['firstname']);
            $this->db->bind(':comment', $data['comment']);

            // Execute
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            // Log the exception or handle it appropriately
            return $e->getMessage();
        }
    }

    public function editFDC($fdcData)
    {
        // Validate and sanitize the input data
        $EditnControlA = filter_var($fdcData['UpnControlA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $EditnombreA = filter_var($fdcData['UpnombreA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $EditaPaternoA = filter_var($fdcData['UpaPaternoA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $EditaMaternoA = filter_var($fdcData['UpaMaternoA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $EditcarreraA = filter_var($fdcData['UpcarreraA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $EditasuntoA = filter_var($fdcData['UpasuntoA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $EditpeticionA = filter_var($fdcData['UppeticionA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $EditfechaFDC = filter_var($fdcData['UpfechaFDC'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $EditmotivosAcaA = filter_var($fdcData['UpmotivosAcaA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $EditmotivosPerA = filter_var($fdcData['UpmotivosPerA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $EditotrosMA = filter_var($fdcData['UpotrosMA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $EditfirmaA = filter_var($fdcData['EditfirmaA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $EdittelefonoA = filter_var($fdcData['UptelefonoA'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $EditcorreoA = filter_var($fdcData['UpcorreoA'], FILTER_SANITIZE_EMAIL);

        // File names are in an array, so no need to sanitize them individually
        $EditanexosA = $fdcData['UpanexosA'];

        try {
            // Insert user data into the database
            $this->db->query(
                'UPDATE solicitudes_fdc SET
                nControl = :EditnControlA,
                nombre = :EditnombreA,
                aPaterno = :EditaPaternoA,
                aMaterno = :EditaMaternoA,
                carrera = :EditcarreraA,
                asunto = :EditasuntoA,
                peticion = :EditpeticionA,
                fecha = :EditfechaFDC,
                motivosA = :EditmotivosAcaA,
                motivosP = :EditmotivosPerA,
                otrosM = :EditotrosMA,
                anexos = :EditanexosA,
                firma_alumno = :EditfirmaA,
                telefono = :EdittelefonoA,
                correo = :EditcorreoA
                WHERE nControl = :EditnControlA'
            );

            // Link values
            $this->db->bind(':EditnControlA', $EditnControlA);
            $this->db->bind(':EditnombreA', $EditnombreA);
            $this->db->bind(':EditaPaternoA', $EditaPaternoA);
            $this->db->bind(':EditaMaternoA', $EditaMaternoA);
            $this->db->bind(':EditcarreraA', $EditcarreraA);
            $this->db->bind(':EditasuntoA', $EditasuntoA);
            $this->db->bind(':EditpeticionA', $EditpeticionA);
            $this->db->bind(':EditfechaFDC', $EditfechaFDC);
            $this->db->bind(':EditmotivosAcaA', $EditmotivosAcaA);
            $this->db->bind(':EditmotivosPerA', $EditmotivosPerA);
            $this->db->bind(':EditotrosMA', $EditotrosMA);
            $this->db->bind(':EditanexosA', json_encode($EditanexosA)); // Store file names as JSON
            $this->db->bind(':EditfirmaA', $EditfirmaA); // Updated to use the signature image path
            $this->db->bind(':EdittelefonoA', $EdittelefonoA);
            $this->db->bind(':EditcorreoA', $EditcorreoA);

            // Execute the query
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    public function addUser($data)
    {
        try {
            // Sanitize data
            $sanitizedData = $this->sanitizeData($data);

            // Prepare SQL query
            $this->db->query('INSERT INTO users (firstname, email, username, password, gender, charge, career, created_at)
            VALUES (:firstname, :email, :username, :password, :gender, :charge, :career, NOW())');

            // Bind sanitized values
            $this->db->bind(':firstname', $sanitizedData['firstname']);
            $this->db->bind(':email', $sanitizedData['email']);
            $this->db->bind(':username', $sanitizedData['username']);
            $this->db->bind(':password', $sanitizedData['password']);
            $this->db->bind(':gender', $sanitizedData['gender']);
            $this->db->bind(':charge', $sanitizedData['charge']);
            $this->db->bind(':career', $sanitizedData['career']);

            // Execute
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            // Handle exception
            error_log('Error adding user: ' . $e->getMessage());
            return false;
        }
    }

    private function sanitizeData($data)
    {
        // Use appropriate sanitization methods for each field
        $sanitizedData = [
            'firstname' => filter_var($data['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'email' => filter_var($data['email'], FILTER_SANITIZE_EMAIL),
            'username' => filter_var($data['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            // Hash the password
            'gender' => filter_var($data['gender'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'charge' => filter_var($data['charge'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'career' => filter_var($data['career'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        ];

        return $sanitizedData;
    }

    public function addStudent($data)
    {
        try {
            $this->db->query('INSERT INTO students (stud_username, stud_password, stud_career, stud_charge, stud_gender)
            VALUES (:nControl_stud, :password_stud, :stud_career, :stud_charge, :stud_gender)');

            // Link values
            $this->db->bind(':nControl_stud', $data['nControl_stud']);
            $this->db->bind(':password_stud', $data['password_stud']);
            $this->db->bind(':stud_career', $data['stud_career']);
            $this->db->bind(':stud_charge', $data['stud_charge']);
            $this->db->bind(':stud_gender', $data['stud_gender']);

            // Execute
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function getStudObservation($stud_username)
    {
        try {
            $this->db->query('SELECT observaciones FROM solicitudes_fdc WHERE stud_username = :stud_username');
            $this->db->bind(':stud_username', $stud_username);
            $result = $this->db->getRecord(); // Fetch as an object

            if ($result) {
                return $result->observaciones;
            } else {
                return null; // Return null if the username doesn't exist
            }
        } catch (PDOException $e) {
            // Handle database query error
            return null;
        }
    }



    public function getStudFDCInfo($stud_username)
    {
        try {
            $this->db->query('SELECT * FROM solicitudes_fdc WHERE nControl = :stud_username');
            $this->db->bind(':stud_username', $stud_username);
            $result = $this->db->getRecords(); // Fetch as an object

            if ($result) {
                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            // Handle database query error
            return null;
        }
    }

    public function getFDCByNControl($nControl)
    {
        try {
            // Adjust the SQL query based on your database schema
            $this->db->query('SELECT * FROM solicitudes_fdc WHERE nControl = :nControl');
            $this->db->bind(':nControl', $nControl);
            $result = $this->db->getRecord(); // Fetch as an object

            if ($result) {
                return $result; // Return the entire result object
            } else {
                return null; // Return null if no data found for the given nControl
            }
        } catch (PDOException $e) {
            // Handle database query error
            return null;
        }
    }

    public function getFDCStatus($stud_username)
    {
        try {
            // Adjust the SQL query based on your database schema
            $this->db->query('SELECT estado FROM solicitudes_fdc WHERE nControl = :stud_username');
            $this->db->bind(':stud_username', $stud_username);
            $result = $this->db->getRecord(); // Fetch as an object

            if ($result) {
                return $result->estado; // Return the entire result object
            } else {
                return null; // Return null if no data found for the given nControl
            }
        } catch (PDOException $e) {
            // Handle database query error
            return null;
        }
    }

    public function setFDCStatus($usernameStud, $fdc_status)
    {
        try {
            // Prepare SQL query
            $this->db->query('UPDATE solicitudes_fdc SET estado = :fdc_status WHERE nControl = :usernameStud');

            // Bind sanitized values
            $this->db->bind(':fdc_status', $fdc_status);
            $this->db->bind(':usernameStud', $usernameStud);

            // Execute
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Handle exception
            error_log('Error sending fdc: ' . $e->getMessage());
            return false;
        }
    }

    public function deleteUserDataById($id)
    {
        // Step 1: Retrieve the filename associated with the user
        $this->db->query('SELECT `file_name` FROM `users` WHERE `id` = :id');
        $this->db->bind(':id', $id);
        $fetch = $this->db->getRecord();

        if ($fetch) {
            $fileName = $fetch->file_name;

            // Step 2: Delete the user's record from the users table
            $this->db->query('DELETE FROM `users` WHERE `id` = :id');
            $this->db->bind(':id', $id);

            if ($this->db->execute()) {
                // Step 3: Construct the path to the image file
                $imagePath = "../public/img/uploads/" . $fileName; // Adjust the path accordingly

                // Step 4: Check if the file exists before attempting to delete it
                if (file_exists($imagePath) && is_file($imagePath)) {
                    // Step 5: Delete the file
                    unlink($imagePath);

                    // Step 6: Return a value indicating that the record and file were successfully deleted
                    return true;
                } else {
                    // Step 7: Return a value indicating that the record was deleted, but the file was not found
                    return true;
                }
            } else {
                // Step 8: Return a value indicating that the record deletion failed
                return false;
            }
        } else {
            // Step 9: Return a value indicating that the record was not found
            return false;
        }
    }

    public function deleteStudDataById($stud_id)
    {
        // Step 1: Retrieve the filename associated with the user
        $this->db->query('SELECT `filename` FROM `students` WHERE `stud_id` = :stud_id');
        $this->db->bind(':stud_id', $stud_id);
        $fetch = $this->db->getRecord();

        if ($fetch) {
            $fileName = $fetch->filename;

            // Step 2: Delete the user's record from the users table
            $this->db->query('DELETE FROM `students` WHERE `stud_id` = :stud_id');
            $this->db->bind(':stud_id', $stud_id);

            if ($this->db->execute()) {
                // Step 3: Construct the path to the image file
                $imagePath = "../public/img/uploads/" . $fileName; // Adjust the path accordingly

                // Step 4: Check if the file exists before attempting to delete it
                if (file_exists($imagePath) && is_file($imagePath)) {
                    // Step 5: Delete the file
                    unlink($imagePath);

                    // Step 6: Return a value indicating that the record and file were successfully deleted
                    return true;
                } else {
                    // Step 7: Return a value indicating that the record was deleted, but the file was not found
                    return true;
                }
            } else {
                // Step 8: Return a value indicating that the record deletion failed
                return false;
            }
        } else {
            // Step 9: Return a value indicating that the record was not found
            return false;
        }
    }

    public function saveFileImage($fileTmpName, $usernameReg)
    {
        // Create a directory with the usernameReg as the folder name
        $targetDirectory = '../public/img/students/' . $usernameReg . '/';
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        // Generate a unique filename to avoid overwriting existing files
        $targetFilePath = $targetDirectory . uniqid() . '.png';

        // Move the uploaded file to the server
        if (move_uploaded_file($fileTmpName, $targetFilePath)) {
            return $targetFilePath;
        } else {
            return false; // File save failed
        }
    }

    public function uploadFilesFDC($fileInfo, $nControlA)
    {
        // Security checks and sanitation
        $file = $fileInfo;

        // Check for file upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return null; // Upload error
        }

        // Additional security checks and validation
        $allowedExtensions = array('pdf', 'png', 'jpg');
        $maxFileSize = 2 * 1024 * 1024; // 2MB in bytes

        $imageFileName = $file['name'];
        $imageFileType = strtolower(pathinfo($imageFileName, PATHINFO_EXTENSION));
        $imageFileSize = $file['size'];

        if (!in_array($imageFileType, $allowedExtensions)) {
            // Security violation, do not proceed with the upload
            echo json_encode(array("status" => "error", "message" => "Sólo se permiten archivos JPG y PNG"));
            return;
        }

        if ($imageFileSize > $maxFileSize) {
            // Security violation, do not proceed with the upload
            echo json_encode(array("status" => "error", "message" => "El tamaño del archivo supera el límite máximo (2MB)"));
            return;
        }

        // Create a folder for each 'nControlA'
        $targetDirectory = '../public/fdc_files/' . $nControlA . '/'; // Desired directory for FDC files
        if (!is_dir($targetDirectory)) {
            // Create the directory if it doesn't exist
            mkdir($targetDirectory, 0755, true);
        }

        // Check if a file with the same name already exists
        $existingFiles = glob($targetDirectory . $imageFileName);
        if (!empty($existingFiles)) {
            // Remove existing files
            foreach ($existingFiles as $existingFile) {
                unlink($existingFile);
            }
        }

        $targetFilePath = $targetDirectory . $imageFileName;

        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            return $targetFilePath;
        } else {
            return false; // File upload failed
        }
    }

    public function uploadSignatureImage()
    {
        // Define the folder path for signature images
        $nControlA = $_POST['nControlA'];
        $targetDirectory = '../public/fdc_files/' . $nControlA . '/signatures/';

        try {
            // Sanitize the $editnControlA variable to avoid security issues
            $nControlA = basename($nControlA);

            // Create the folder if it doesn't exist
            if (!is_dir($targetDirectory)) {
                mkdir($targetDirectory, 0755, true);
            }

            // Decode the base64 image data
            $image_parts = explode(';base64,', $_POST['firmaA']);
            $image_type_aux = explode('image/', $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            // Generate the filename using $editnControlA
            $file = $targetDirectory . $nControlA . '.' . $image_type;

            // Check if a file with the same name already exists
            if (file_exists($file)) {
                // Remove existing file
                unlink($file);
            }

            // Save the image to the specified folder
            if (file_put_contents($file, $image_base64)) {
                return $file;
            } else {
                throw new Exception('Error al cargar la firma');
            }
        } catch (Exception $e) {
            // Handle the exception, log the error, or return an error message as needed
            return $e;
        }
    }

    public function ReuploadSignatureImage()
    {
        // Define the folder path for signature images
        $editnControlA = $_POST['EditnControlA'];
        $targetDirectory = '../public/fdc_files/' . $editnControlA . '/signatures/';

        try {
            // Sanitize the $editnControlA variable to avoid security issues
            $editnControlA = basename($editnControlA);

            // Create the folder if it doesn't exist
            if (!is_dir($targetDirectory)) {
                mkdir($targetDirectory, 0755, true);
            }

            // Decode the base64 image data
            $image_parts = explode(';base64,', $_POST['EditfirmaA']);
            $image_type_aux = explode('image/', $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            // Generate the filename using $editnControlA
            $file = $targetDirectory . $editnControlA . '.' . $image_type;

            // Check if a file with the same name already exists
            if (file_exists($file)) {
                // Remove existing file
                unlink($file);
            }

            // Save the image to the specified folder
            if (file_put_contents($file, $image_base64)) {
                return $file;
            } else {
                throw new Exception('Error al cargar la firma');
            }
        } catch (Exception $e) {
            // Handle the exception, log the error, or return an error message as needed
            return $e->getMessage();
        }
    }


    public function clearRememberToken($userId)
    {
        // Prepare the SQL query to clear the remember_token for the user
        $sql = "UPDATE users SET remember_token = NULL WHERE id = :userId";

        // Bind the user ID to the placeholder
        $this->db->query($sql);
        $this->db->bind(':userId', $userId);

        // Execute the query
        if ($this->db->execute()) {
            return true; // Update successful
        } else {
            return false; // Update failed
        }
    }

    public function verifyPasswordResetToken($token)
    {
        try {
            // Query the database to find the token
            $this->db->query('SELECT * FROM password_reset_tokens WHERE token = :token');
            $this->db->bind(':token', $token);
            $tokenInfo = $this->db->getRecord();

            if ($tokenInfo) {
                // Check if the token is not expired
                $expirationTime = strtotime($tokenInfo->expiration);
                $currentTime = time();

                if ($expirationTime > $currentTime) {
                    // Token is valid
                    return true;
                }
            }
        } catch (PDOException $e) {
            // Handle database query error here, e.g., log the error or return false
            return $e;
        }

        return false; // Token is invalid or expired
    }

    public function invalidatePasswordResetToken($token)
    {
        try {
            // Delete the token from the database
            $this->db->query('DELETE FROM password_reset_tokens WHERE token = :token');
            $this->db->bind(':token', $token);

            // Execute the query
            if ($this->db->execute()) {
                return true; // Token deleted successfully
            }
        } catch (PDOException $e) {
            // Handle database query error here, e.g., log the error or return false
            return $e;
        }

        return false; // Token deletion failed
    }

    public function storePasswordResetToken($email, $token, $expiration)
    {
        try {
            // Check if a token already exists for the given email
            $this->db->query('SELECT * FROM password_reset_tokens WHERE email = :email');
            $this->db->bind(':email', $email);
            $existingToken = $this->db->getRecord();

            if ($existingToken) {
                // Update the existing token with the new values
                $this->db->query('UPDATE password_reset_tokens SET token = :token, expiration = :expiration WHERE email = :email');
                $this->db->bind(':token', $token);
                $this->db->bind(':expiration', date('Y-m-d H:i:s', $expiration));
                $this->db->bind(':email', $email);
            } else {
                // Insert a new token into the database
                $this->db->query('INSERT INTO password_reset_tokens (email, token, expiration) VALUES (:email, :token, :expiration)');
                $this->db->bind(':email', $email);
                $this->db->bind(':token', $token);
                $this->db->bind(':expiration', date('Y-m-d H:i:s', $expiration));
            }

            // Execute the query
            if ($this->db->execute()) {
                return true; // Token stored or updated successfully
            }
        } catch (PDOException $e) {
            // Handle database query error
            return $e->getMessage();
        }

        return false; // Token storage or update failed
    }

    public function updatePasswordByEmail($email, $newPassword)
    {
        try {
            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Prepare a SQL query to update the user's password
            $this->db->query('UPDATE users SET password = :password WHERE email = :email');
            $this->db->bind(':password', $hashedPassword);
            $this->db->bind(':email', $email);

            // Execute the query
            if ($this->db->execute()) {
                // Password updated successfully
                return true;
            } else {
                // Password update failed
                return false;
            }
        } catch (PDOException $e) {
            // Handle database query error here, e.g., log the error or return false
            return false;
        }
    }

    public function updatePassword($userId, $newPassword)
    {
        try {
            // Hash the new password
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Prepare a SQL query to update the user's password
            $this->db->query('UPDATE users SET password = :newPassword WHERE id = :userId');
            $this->db->bind(':newPassword', $hashedNewPassword);
            $this->db->bind(':userId', $userId);

            // Execute the query
            if ($this->db->execute()) {
                // Password updated successfully
                return true;
            } else {
                // Password update failed
                return false;
            }
        } catch (PDOException $e) {
            // Handle database query error here, e.g., log the error or return false
            return false;
        }
    }

    public function updateProfileImage($userId, $profileImagePath)
    {
        try {
            // Prepare a SQL query to update the user's profile image path
            $this->db->query('UPDATE users SET profile_image = :profileImage WHERE id = :userId');
            $this->db->bind(':profileImage', $profileImagePath);
            $this->db->bind(':userId', $userId);

            // Execute the query
            if ($this->db->execute()) {
                // Profile image path updated successfully
                return true;
            } else {
                // Profile image path update failed
                return false;
            }
        } catch (PDOException $e) {
            // Handle database query error here, e.g., log the error or return false
            return false;
        }
    }

    public function updateProfileImgStud($stud_username, $profileImagePath)
    {
        try {
            // Prepare a SQL query to update the user's profile image path
            $this->db->query('UPDATE students SET profile_picture = :profileImage WHERE stud_username = :stud_username');
            $this->db->bind(':profileImage', $profileImagePath);
            $this->db->bind(':stud_username', $stud_username);

            // Execute the query
            if ($this->db->execute()) {
                // Profile image path updated successfully
                return true;
            } else {
                // Profile image path update failed
                return false;
            }
        } catch (PDOException $e) {
            // Handle database query error here, e.g., log the error or return false
            return false;
        }
    }

    public function updateUserField($user_id, $field, $value)
    {
        try {
            $query = "UPDATE users SET $field = :value WHERE id = :user_id";
            $this->db->query($query);
            $this->db->bind(':user_id', $user_id);
            $this->db->bind(':value', $value);

            if ($this->db->execute()) {
                return "Update successful";
            } else {
                return "Update failed";
            }
        } catch (PDOException $e) {
            // Return a generic error message
            return "Update failed. Please try again later." . $e->getMessage();
        }
    }

    public function updateFieldsByUsername($username, $field, $value)
    {
        try {
            if ($field === 'modified_at') {
                $query = "UPDATE users SET $field = NOW() WHERE username = :username";
            } else {
                $query = "UPDATE users SET $field = :value, modified_at = NOW() WHERE username = :username";
            }

            $this->db->query($query);
            $this->db->bind(':username', $username);

            // Bind :value only when $field is not 'modified_at'
            if ($field !== 'modified_at') {
                $this->db->bind(':value', $value);
            }

            if ($this->db->execute()) {
                return "Update successful";
            } else {
                return "Update failed";
            }
        } catch (PDOException $e) {
            return "Update failed. Please try again later." . $e->getMessage();
        }
    }

    public function updateUserFieldStud($stud_username, $field, $value)
    {
        try {
            $query = "UPDATE students SET $field = :value WHERE stud_username = :stud_username";
            $this->db->query($query);
            $this->db->bind(':stud_username', $stud_username);
            $this->db->bind(':value', $value);

            if ($this->db->execute()) {
                return "Update successful";
            } else {
                return "Update failed";
            }
        } catch (PDOException $e) {
            // Handle database query error
            return $e->getMessage();
        }
    }

    public function updateLastActivityTime($userId)
    {
        try {
            $currentTime = time();
            $formattedTime = date('Y-m-d H:i:s', $currentTime);

            $query = "UPDATE users SET last_login = :lastLogin WHERE id = :userId";
            $this->db->query($query);
            $this->db->bind(':lastLogin', $formattedTime);
            $this->db->bind(':userId', $userId);

            // Use prepare and execute to run a prepared statement
            if ($this->db->execute()) {
                return true;
            } else {
                // Log or handle the failure
                error_log("Database Error: Execution failed");
                return false;
            }
        } catch (PDOException $e) {
            // Log or handle the error
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function updateUserStatus($userId, $status)
    {
        try {
            $query = "UPDATE users SET status = :status WHERE id = :userId";
            $this->db->query($query);
            $this->db->bind(':status', $status);
            $this->db->bind(':userId', $userId);

            if ($this->db->execute()) {
                return true;
            } else {
                // Log or handle the failure
                error_log("Database Error: Execution failed");
                return false;
            }
        } catch (PDOException $e) {
            // Log or handle the error
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function fetchComments()
    {
        try {
            // Fetch comments from the database
            $this->db->query('SELECT firstname, comment, comment_date FROM comments');
            $result = $this->db->getRecords();

            if ($result) {
                // Comments exist, return the result
                return $result;
            } else {
                // No comments found, return an empty array
                return array();
            }
        } catch (PDOException $e) {
            // Handle database query error
            return null;
        }
    }

    public function InitDataActa($initData)
    {
        try {
            // Convert 'dd/mm/yyyy' to 'yyyy-mm-dd'
            $dateActa = isset($initData['dateActa']) ? DateTime::createFromFormat('d/m/Y', $initData['dateActa'])->format('Y-m-d') : date('Y-m-d');

            // Convert 12-hour time to 24-hour time format
            $timeActa = isset($initData['timeActa']) ? date("H:i:s", strtotime($initData['timeActa'])) : date("H:i:s");

            // Set default value for noMembers if not provided
            $noMembers = isset($initData['noMembers']) ? $initData['noMembers'] : 17;

            // Convert 'dd/mm/yyyy' to 'yyyy-mm-dd' for celebrated_at
            $celebrated_at = isset($initData['celebrated_at']) ? DateTime::createFromFormat('d/m/Y', $initData['celebrated_at'])->format('Y-m-d') : null;

            $this->db->query('SELECT * FROM acta_academica WHERE nameSesActa = :nameSesActa');
            $this->db->bind(':nameSesActa', $initData['nameSesActa']);
            $this->db->execute();

            if ($this->db->rowCount() > 0) {
                $this->db->query('UPDATE acta_academica 
                              SET acta_time = :timeActa, acta_date = :dateActa, noMembersActa = :noMembers,
                                  nameMemActa = :nameMemActa, guest_charge = :guest_Charge, celebrated_at = :celebrated_at
                              WHERE nameSesActa = :nameSesActa');

                $this->db->bind(':timeActa', $timeActa);
                $this->db->bind(':dateActa', $dateActa);
                $this->db->bind(':noMembers', $noMembers);

                if (isset($initData['guest_fname']) && isset($initData['guest_charge'])) {
                    $this->db->bind(':nameMemActa', $initData['guest_fname']);
                    $this->db->bind(':guest_Charge', $initData['guest_charge']);
                } else {
                    $this->db->bind(':nameMemActa', null);
                    $this->db->bind(':guest_Charge', null);
                }

                $this->db->bind(':celebrated_at', $celebrated_at);
                $this->db->bind(':nameSesActa', $initData['nameSesActa']);

                $this->db->execute();
            } else {
                $this->db->query('INSERT INTO acta_academica (acta_time, acta_date, noMembersActa, nameMemActa, nameSesActa, guest_charge, celebrated_at)
            VALUES (:timeActa, :dateActa, :noMembers, :nameMemActa, :nameSesActa, :guest_Charge, :celebrated_at)');

                $this->db->bind(':nameSesActa', $initData['nameSesActa']);
                $this->db->bind(':celebrated_at', $celebrated_at);
                $this->db->bind(':timeActa', $timeActa);
                $this->db->bind(':dateActa', $dateActa);
                $this->db->bind(':noMembers', $noMembers);

                if (isset($initData['guest_fname']) && isset($initData['guest_charge'])) {
                    $this->db->bind(':nameMemActa', $initData['guest_fname']);
                    $this->db->bind(':guest_Charge', $initData['guest_charge']);
                } else {
                    $this->db->bind(':nameMemActa', null);
                    $this->db->bind(':guest_Charge', null);
                }

                $this->db->execute();
            }

            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function rquestData($rquestsData)
    {
        try {
            // Check if a record with the same no_solicitud already exists
            $this->db->query('SELECT * FROM analisis_acta WHERE no_solicitud = :no_solicitud');
            $this->db->bind(':no_solicitud', $rquestsData['folio']);
            $this->db->execute();

            if ($this->db->rowCount() > 0) {
                // Record with the same no_solicitud already exists, update the values
                $this->db->query('UPDATE analisis_acta 
                              SET nom_alumAct = :nom_alumAct, nCtrlAlumActa = :nCtrlAlumActa, 
                              asuntoActa = :asuntoActa, resolucionAct = :resolucionAct, 
                              recomenActa = :recomenActa 
                              WHERE no_solicitud = :no_solicitud');
            } else {
                // Proceed with the insertion since there is no existing record with the same no_solicitud
                $this->db->query('INSERT INTO analisis_acta (no_solicitud, nom_alumAct, nCtrlAlumActa, 
                              asuntoActa, resolucionAct, recomenActa) 
                              VALUES (:no_solicitud, :nom_alumAct, :nCtrlAlumActa, 
                              :asuntoActa, :resolucionAct, :recomenActa)');
            }

            // Bind sanitized values
            $this->bindAnalisisActaValues($rquestsData);

            // Execute the query
            $this->db->execute();

            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    private function bindAnalisisActaValues($rquestsData)
    {
        // Bind sanitized values
        $this->db->bind(':no_solicitud', $rquestsData['folio']);
        $this->db->bind(':nom_alumAct', $rquestsData['full_name']);
        $this->db->bind(':nCtrlAlumActa', $rquestsData['nCtrlAlum']);
        $this->db->bind(':asuntoActa', $rquestsData['asunto']);
        $this->db->bind(':resolucionAct', $rquestsData['resolucion']);
        $this->db->bind(':recomenActa', $rquestsData['recomendacion']);
    }

    public function getActaData($noActa)
    {
        try {
            $this->db->query('SELECT * FROM acta_academica WHERE noActa = :noActa');
            $this->db->bind(':noActa', $noActa);
            $result = $this->db->getRecord(); // Fetch as an object

            if ($result) {
                return $result; // Return the entire result object
            } else {
                return null; // Return null if no data found for the given nControl
            }
        } catch (PDOException $e) {
            // Handle database query error
            return null;
        }
    }

    public function fetchFDCData()
    {
        try {
            $this->db->query('SELECT carrera, COUNT(nControl) AS record_count FROM solicitudes_fdc GROUP BY carrera');
            $result = $this->db->getRecords(); // Fetch as an associative array

            if ($result) {
                return $result; // Return the entire result array
            } else {
                return null; // Return null if no data found for the given nControl
            }
        } catch (PDOException $e) {
            // Handle database query error
            return null;
        }
    }

    public function graficaData()
    {
        try {
            $this->db->query('SELECT MONTHNAME(fechaActaProm) AS monthname, AVG(totalCarActa) AS amount FROM grafica_acta GROUP BY monthname');
            // Fetch all rows as an associative array
            $result = $this->db->getRecords();

            if ($result) {
                return $result; // Return the entire result array
            } else {
                return null; // Return null if no data found for the given nControl
            }
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
}
