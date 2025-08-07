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

// Use library for email send
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include the necessary classes from the PHPOffice Word
use PhpOffice\PhpWord\TemplateProcessor;

class Pages extends Controller
{
    private $modelUser;

    public function __construct()
    {
        $this->modelUser = $this->loadModel('User');
    }

    /**
     * Send an email using PHPMailer.
     *
     * @param string $toEmail The recipient's email address.
     * @param string $subject The subject of the email.
     * @param string $body The content of the email.
     *
     * @return bool True if the email was sent successfully, false otherwise.
     */

    protected function sendEmail($toEmail, $subject, $body)
    {
        // Adjust the path to autoload.php as needed
        require_once '../public/libraries/vendor/autoload.php';

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Your SMTP server host
            $mail->SMTPAuth = true;
            $mail->Username = 'al3xander4976@gmail.com'; // Your SMTP username
            $mail->Password = 'obww oudu ygft kewl'; // Your SMTP password
            $mail->SMTPSecure = 'ssl'; // Enable TLS encryption; `ssl` also accepted
            $mail->Port = 465; // TCP port to connect to

            //Recipients
            $mail->setFrom('al3xander4976@gmail.com', 'Kevin'); // Your email address and name
            $mail->addAddress($toEmail); // Recipient email address
            //$mail->addReplyTo('reply@example.com', 'Reply Name'); // Reply-to email address and name

            //Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function index()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the regular user is logged in and redirect to the homepage
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            $userId = $_SESSION['id'] ?? null;
            $status = 'Online';
            if ($userId !== null) {
                $this->modelUser->updateUserStatus($userId, $status);
            }
            header("Location: " . BASE_URL . 'dashboard/homepage');
            exit;
        }

        // Check if the student is logged in and redirect to the student dashboard
        if (isset($_SESSION["stud_loggedin"]) && $_SESSION["stud_loggedin"] === true) {
            header("Location: " . BASE_URL . 'student/student');
            exit;
        }

        // If not logged in, display the login page
        $this->view('login/login');
    }

    public function login()
    {
        start_session_if_not_started();

        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            header("Location: " . BASE_URL . 'dashboard/homepage');
            exit;
        } else if (isset($_SESSION["stud_loggedin"]) && $_SESSION["stud_loggedin"] === true) {
            header("Location: " . BASE_URL . 'student/student');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'username' => filter_var(trim($_POST['username']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'password' => filter_var(trim($_POST['password']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'remember' => isset($_POST['remember']) ? filter_var(trim($_POST['remember']), FILTER_SANITIZE_FULL_SPECIAL_CHARS) : ''
            ];

            $authResult = $this->authenticateUser($data);

            if ($authResult === true) {
                $response = ['status' => 'success', 'message' => '¡Bienvenido de nuevo! <br>' . '<b>' . $data['username'] . '</b>'];
            } else {
                $response = ['status' => 'error', 'message' => $authResult];
            }

            // FIX: Set header for JSON
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($response);
            exit;
        } else {
            $data = [
                'username' => '',
                'password' => ''
            ];

            $this->view('/login/login', $data);
        }
    }

    public function authenticateUser($data)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Authenticate the user
            $authResult = $this->modelUser->authentication($data);

            if ($authResult === true) {
                // Authentication succeeded, handle session management, and redirection
                $_SESSION["loggedin"] = true;

                // Retrieve the user's ID if needed
                $userId = $this->modelUser->getUserId($data['username']);

                // Retrieve the user's charge value from the model
                $chargeValue = $this->modelUser->getChargeValue($userId);

                // Store the user's ID and charge value in the session
                $_SESSION["id"] = $userId;
                $_SESSION["username"] = $data['username'];
                $_SESSION["charge"] = $chargeValue;

                // Update the user's status and last activity timestamp when the user logs in
                $_SESSION['status'] = "Online";
                $_SESSION['last_acvitity'] = time();
            }

            return $authResult;
        } else {
            $this->errorPage();
        }
    }

    public function updateLastActivityTimeInSession()
    {
        if (isset($_SESSION['id'])) {
            // Update last activity time in the session
            $_SESSION['last_activity'] = time();
        }
    }

    public function authStudent()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is already logged in
        if (isset($_SESSION["stud_loggedin"]) && $_SESSION["stud_loggedin"] === true) {
            // User is logged in, redirect to the homepage
            header("Location: " . BASE_URL . '/student/student');
            exit;
        }

        // Check if the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Create an array for the values to be submitted
            $data = [
                'usernameStud' => filter_var(trim($_POST['usernameStud']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'passwordStud' => filter_var(trim($_POST['passwordStud']), FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            ];

            // Call the authentication function to handle user authentication
            $authResultStud = $this->authenticateStud($data);

            if ($authResultStud === true) {
                // Authentication success
                $response = [
                    'status' => 'success',
                    'message' => '¡Bienvenido!<br>Estudiante: ' . '<b>' . $data['usernameStud'] . '</b>'
                ];
            } else {
                // Authentication failed
                $response = ['status' => 'error', 'message' => $authResultStud];
            }
            // FIX: Set header for JSON
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($response);
            exit;
        } else {
            $data = [
                'usernameStud' => '',
                'passwordStud' => ''
            ];

            $this->view('login/authStudent', $data);
        }
    }

    public function authenticateStud($data)
    {


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Authenticate the user
            $authResult = $this->modelUser->authenticationStud($data);

            if ($authResult === true) {
                // Authentication succeeded, handle session management, and redirection
                $_SESSION["stud_loggedin"] = true;

                // Retrieve the user's ID if needed
                $userId = $this->modelUser->getStudId($data['usernameStud']);
                // Now store the user's ID in the session or perform any other necessary actions
                $_SESSION["stud_id"] = $userId;
                $_SESSION["usernameStud"] = $data['usernameStud'];
            }

            return $authResult;
        } else {
            $this->errorPage();
        }
    }

    public function student()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["stud_loggedin"]) || $_SESSION["stud_loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        if (isset($_POST['submitFDC'])) {
            $this->createFDC();
        } else {
            $stud_fdc = $this->modelUser->getStudFDCInfo($_SESSION['usernameStud']);

            $fdcData = [
                'nControlA' => '',
                'nombreA' => '',
                'aPaternoA' => '',
                'aMaternoA' => '',
                'carreraA' => '',
                'asuntoA' => '',
                'peticionA' => '',
                'fechaFDC' => '',
                'motivosAcaA' => '',
                'motivosPerA' => '',
                'otrosMA' => '',
                'anexosA' => '',
                'firmaA' => '',
                'telefonoA' => '',
                'correoA' => '',
                'stud_fdc' => $stud_fdc
            ];

            $this->view('home/student', $fdcData);
        }
    }

    public function sendFDCStud()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["stud_loggedin"]) || $_SESSION["stud_loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        if (isset($_REQUEST['usernameStud'])) {
            $usernameStud = $_REQUEST['usernameStud'];
            $fdc_status = "Enviado";

            // Fetch id of student from the model
            $resultMessageStud = $this->modelUser->setFDCStatus($usernameStud, $fdc_status);

            if ($resultMessageStud === true) {
                // Return a JSON success response
                echo json_encode(array("status" => "success", "message" => "Solicitud enviada"));
                exit;
            } else {
                // Return a JSON error response
                echo json_encode(array("status" => "error", "message" => "Error al enviar la solicitud, intenta de nuevo"));
                exit;
            }
        } else {
            // If it's not a POST request
            $this->errorPage();
        }
    }

    public function sendFDCNotification()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        if (!isset($_SESSION["stud_loggedin"]) || $_SESSION["stud_loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        if (isset($_REQUEST['usernameStud'])) {
            $usernameStud = $_REQUEST['usernameStud'];
            $stud_career = $this->modelUser->getStudCareerByNCtrl($usernameStud);

            $data = [
                'nControl_stud' => $usernameStud,
                'stud_career' => $stud_career,
                'message' => 'Nuevo F-DC-15 del alumno'
            ];

            $resultN = $this->modelUser->sendFDCNotif($data);

            if ($resultN === true) {
                echo json_encode(array("status" => "success", "message" => "Se ha notificado tu solicitud"));
                exit;
            } else {
                echo json_encode(array("status" => "error", "message" => "Error al notificar tu solicitud, intenta de nuevo"));
                exit;
            }
        } else {
            $this->errorPage();
        }
    }

    public function getFDCNotifications()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is not logged in
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            $user_career = $this->modelUser->getUserCareerByName($username);

            $notifications = $this->modelUser->getFDCNotifs($user_career);

            header('Content-Type: application/json');

            if ($notifications !== null && $notifications !== false) {
                echo json_encode(array("status" => "success", "notifications" => $notifications));
                exit;
            } else {
                echo json_encode(array("status" => "error", "message" => "Error fetching notifications. Please try again."));
                exit;
            }
        } else {
            echo json_encode(array("status" => "error", "message" => "Username not provided."));
            exit;
        }
    }

    public function removeFDCNotifications()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is not logged in
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }
    }

    public function logout()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true || isset($_SESSION['stud_loggedin']) && $_SESSION['stud_loggedin'] === true) {
            // Call the model method to update last activity time in the database
            $userId = $_SESSION['id'] ?? null;
            $status = 'Offline';
            if ($userId !== null) {
                $this->modelUser->updateLastActivityTime($userId);
                $this->modelUser->updateUserStatus($userId, $status);
            }

            // Call the controller method to update last activity time in the session
            $this->updateLastActivityTimeInSession();

            // Check if the user was remembered (has a remember_token in the session)
            if (isset($_SESSION['remember_token'])) {
                // Remove the remember_token from the session
                unset($_SESSION['remember_token']);
                // Remove the remember_token from the database
                $this->modelUser->clearRememberToken($_SESSION['id']);
            }

            // Clear all session variables
            session_unset();

            // Destroy the session
            session_destroy();
        }

        $this->view('logout/logout');
    }

    public function homepage()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        if (isset($_GET['nControl'])) {
            $this->download_fdc();
        } else {
            $user_career = $this->modelUser->getUserCareerByName($_SESSION['username']);
            $fdc = $this->modelUser->getAllFDCByStatus($user_career);
            $users = $this->modelUser->getUsersById($_SESSION['id']);

            $fdcData = [
                'nControlA' => '',
                'nombreA' => '',
                'aPaternoA' => '',
                'aMaternoA' => '',
                'carreraA' => '',
                'asuntoA' => '',
                'peticionA' => '',
                'fechaFDC' => '',
                'motivosAcaA' => '',
                'motivosPerA' => '',
                'otrosMA' => '',
                'anexosA' => '',
                'firmaA' => '',
                'telefonoA' => '',
                'correoA' => '',
                'fdc' => $fdc,
                'users' => $users
            ];

            $this->view('home/dashboard', $fdcData);
        }
    }

    public function fetchCountFDCData()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        $data = $this->modelUser->fetchFDCData();

        // Return the new data as JSON
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function fetchFDCData()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        // Get the selected career from the AJAX request
        $selected_career = $_POST['user_career'] ?? null;

        // Call the new model function to get new data
        $newData = $this->modelUser->getSentFDCData($selected_career);

        // Return the new data as JSON
        header('Content-Type: application/json');
        echo json_encode($newData);
        exit;
    }

    public function fetchFDCDataByCareer()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        // Get the username from the session
        $username = $_SESSION['username'];

        // Call the new model function to get new data
        $user_career = $this->modelUser->getUserCareerByName($username);
        $newData = $this->modelUser->getSentFDCData($user_career);

        // Return the new data as JSON
        header('Content-Type: application/json');
        echo json_encode($newData);
        exit;
    }

    public function sendCheckedFDCObs()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        // Check if the POST request contains the 'id' and 'observation' parameters
        if (isset($_POST['id']) && is_array($_POST['id']) && isset($_POST['observation'])) {

            $data = [
                // Access the array of 'nControl' values
                'selectedIds' => array_map('trim', $_POST['id']),
                // Access the observation value
                'observation' => filter_var(trim($_POST['observation']), FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            ];

            // Decode HTML entities
            $data['observation'] = html_entity_decode($data['observation'], ENT_QUOTES, 'UTF-8');

            // Send the selected data and observation to model
            $result = $this->modelUser->sendFDCObs($data);

            if ($result === true) {
                // Success
                echo json_encode(array("status" => "success", "message" => "Observación enviada"));
            } else {
                // Error
                echo json_encode(array("status" => "error", "message" => "Error sending data: " . $result));
            }
        } else {
            // If it's not a POST request
            $this->errorPage();
        }
    }

    public function createFDC()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["stud_loggedin"]) || $_SESSION["stud_loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        // Check if it's an AJAX request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Retrieve the original nControlA value from the session
            $originalNControlA = $_SESSION['usernameStud'];

            // Create an array for the values to be submitted
            $fdcData = [
                'nControlA' => filter_var(trim($_POST['nControlA']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'nombreA' => filter_var(trim($_POST['nombreA']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'aPaternoA' => filter_var(trim($_POST['aPaternoA']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'aMaternoA' => filter_var(trim($_POST['aMaternoA']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'carreraA' => filter_var(trim($_POST['carreraA']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'asuntoA' => filter_var(trim($_POST['asuntoA']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'peticionA' => filter_var(trim($_POST['peticionA']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'fechaFDC' => filter_var(trim($_POST['fechaFDC']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'motivosAcaA' => filter_var(trim($_POST['motivosAcaA']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'motivosPerA' => filter_var(trim($_POST['motivosPerA']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'otrosMA' => filter_var(trim($_POST['otrosMA']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'anexosA' => json_encode($_POST['anexosA']),
                'telefonoA' => filter_var(trim($_POST['telefonoA']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'correoA' => filter_var(trim($_POST['correoA']), FILTER_SANITIZE_EMAIL),
                'estadoFDC' => filter_var(trim('No enviado'), FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            ];

            $fdcData['carreraA'] = html_entity_decode($fdcData['carreraA'], ENT_QUOTES, 'UTF-8');
            $fdcData['motivosPerA'] = html_entity_decode($fdcData['motivosPerA'], ENT_QUOTES, 'UTF-8');

            // Check if the submitted nControlA matches the one stored in the session
            if ($fdcData['nControlA'] !== $originalNControlA) {
                // The submitted nControlA has been tampered with, handle accordingly
                echo json_encode(array("status" => "error", "message" => "Error: el número de control es inválido, intenta de nuevo"));
                return;
            }

            // Handle signature image upload
            $signaturePath = $this->modelUser->uploadSignatureImage();

            if ($signaturePath) {

                // Check for file uploads
                if (!empty($_FILES['anexosA']) && is_array($_FILES['anexosA'])) {
                    $uploadedFiles = $_FILES['anexosA'];
                    $uploadedFilePaths = [];

                    foreach ($uploadedFiles['tmp_name'] as $index => $tempFilePath) {
                        $fileInfo = [
                            'name' => $uploadedFiles['name'][$index],
                            'type' => $uploadedFiles['type'][$index],
                            'tmp_name' => $tempFilePath,
                            'error' => $uploadedFiles['error'][$index],
                            'size' => $uploadedFiles['size'][$index],
                        ];

                        $uploadedFilePath = $this->modelUser->uploadFilesFDC($fileInfo, $fdcData['nControlA']);

                        if ($uploadedFilePath) {
                            $uploadedFilePaths[] = $uploadedFilePath;
                        }
                    }

                    $fdcData['anexosA'] = $uploadedFilePaths;
                } else {
                    $fdcData['anexosA'] = null; // Set anexosA to null when $_FILES is empty
                }

                // Add the signature file path to the $fdcData array
                $fdcData['firmaA'] = $signaturePath;

                // Insert the data into the database
                $fdcResult = $this->modelUser->addFDC($fdcData);

                // Check if document was created
                if ($fdcResult === true) {
                    // Success
                    echo json_encode(array("status" => "success", "message" => "F-DC-15 creado correctamente"));
                } else {
                    // Error
                    echo json_encode(array("status" => "error", "message" => "Algo salió mal, inténtalo de nuevo"));
                }
            } else {
                // Error
                echo json_encode(array("status" => "error", "message" => "Error: se necesita una firma"));
            }
        } else {
            // If it's not a POST request
            $this->errorPage();
        }
    }

    public function editFDC()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["stud_loggedin"]) || $_SESSION["stud_loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        // Check if it's an AJAX request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Retrieve the original nControlA value from the session
            $originalNControlA = $_SESSION['usernameStud'];

            // Create an array for the values to be submitted
            $fdcData = [
                'UpnControlA' => filter_var(trim($_POST['EditnControlA']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'UpnombreA' => filter_var(trim($_POST['EditnombreA']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'UpaPaternoA' => filter_var(trim($_POST['EditaPaternoA']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'UpaMaternoA' => filter_var(trim($_POST['EditaMaternoA']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'UpcarreraA' => filter_var(trim($_POST['EditcarreraA']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'UpasuntoA' => filter_var(trim($_POST['EditasuntoA']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'UppeticionA' => filter_var(trim($_POST['EditpeticionA']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'UpfechaFDC' => filter_var(trim($_POST['EditfechaFDC']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'UpmotivosAcaA' => filter_var(trim($_POST['EditmotivosAcaA']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'UpmotivosPerA' => filter_var(trim($_POST['EditmotivosPerA']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'UpotrosMA' => filter_var(trim($_POST['EditotrosMA']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'UpanexosA' => json_encode($_POST['EditanexosA']),
                'UptelefonoA' => filter_var(trim($_POST['EdittelefonoA']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'UpcorreoA' => filter_var(trim($_POST['EditcorreoA']), FILTER_SANITIZE_EMAIL)
            ];

            // Check if the submitted nControlA matches the one stored in the session
            if ($fdcData['UpnControlA'] !== $originalNControlA) {
                // The submitted nControlA has been tampered with, handle accordingly
                echo json_encode(array("status" => "error", "message" => "Error: el número de control es inválido, intenta de nuevo"));
                return;
            }

            // Handle signature image upload
            $signaturePath = $this->modelUser->ReuploadSignatureImage();

            if ($signaturePath) {

                // Check for file uploads
                if (!empty($_FILES['EditanexosA']) && is_array($_FILES['EditanexosA'])) {
                    $uploadedFiles = $_FILES['EditanexosA'];
                    $uploadedFilePaths = [];

                    foreach ($uploadedFiles['tmp_name'] as $index => $tempFilePath) {
                        $fileInfo = [
                            'name' => $uploadedFiles['name'][$index],
                            'type' => $uploadedFiles['type'][$index],
                            'tmp_name' => $tempFilePath,
                            'error' => $uploadedFiles['error'][$index],
                            'size' => $uploadedFiles['size'][$index],
                        ];

                        $uploadedFilePath = $this->modelUser->uploadFilesFDC($fileInfo, $fdcData['UpnControlA']);

                        if ($uploadedFilePath) {
                            $uploadedFilePaths[] = $uploadedFilePath;
                        }
                    }

                    $fdcData['UpanexosA'] = $uploadedFilePaths;
                } else {
                    $fdcData['UpanexosA'] = null; // Set anexosA to null when $_FILES is empty
                }

                // Add the signature file path to the $fdcData array
                $fdcData['EditfirmaA'] = $signaturePath;

                // Insert the data into the database
                $fdcResult = $this->modelUser->editFDC($fdcData);

                // Check if document was created
                if ($fdcResult === true) {
                    // Success
                    echo json_encode(array("status" => "success", "message" => "F-DC-15 actualizado correctamente"));
                } else {
                    // Error
                    echo json_encode(array("status" => "error", "message" => "Algo salió mal, inténtalo de nuevo"));
                }
            } else {
                // Error
                echo json_encode(array("status" => "error", "message" => "Error: se necesita una firma"));
            }
        } else {
            // If it's not a POST request
            $this->errorPage();
        }
    }

    public function infoActa()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $initData = [
                'nameSesActa' => filter_var(trim($_POST['nameSesActa']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'celebrated_at' => filter_var(trim($_POST['celebrated_at']), FILTER_SANITIZE_SPECIAL_CHARS),
                'timeActa' => filter_var(trim($_POST['acta_time']), FILTER_SANITIZE_SPECIAL_CHARS),
                'dateActa' => filter_var(trim($_POST['acta_date']), FILTER_SANITIZE_SPECIAL_CHARS),
                'noMembers' => filter_var(trim($_POST['NoMembers']), FILTER_SANITIZE_NUMBER_INT)
            ];

            $rquestsData = [
                'folio' => filter_var(trim($_POST['folio']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'asunto' => filter_var(trim($_POST['asunto']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'resolucion' => filter_var(trim($_POST['resolucion']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'full_name' => filter_var(trim($_POST['full_name']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'nCtrlAlum' => filter_var(trim($_POST['nCtrlAlum']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'recomendacion' => filter_var(trim($_POST['recomendacion']), FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            ];

            $gral_requestsData = [
                'resolucionAG' => filter_var(trim($_POST['resolucionAG']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'nomAlumAG' => filter_var(trim($_POST['nomAlumAG']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'nCtrlAlumAG' => filter_var(trim($_POST['nCtrlAlumAG']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'careerSelAG' => filter_var(trim($_POST['careerSelAG']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'responsableAG' => filter_var(trim($_POST['responsableAG']), FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            ];

            // Decode data to insert correctly and not to alter string format
            $initData['nameSesActa'] = html_entity_decode($initData['nameSesActa'], ENT_QUOTES, 'UTF-8');
            //$rquestsData['recomendacion'] = html_entity_decode($initData['recomendacion'], ENT_QUOTES, 'UTF-8');

            $resInitData = $this->modelUser->InitDataActa($initData);
            $resrquestData = $this->modelUser->rquestData($rquestsData);
            $resgralrquestData = $this->modelUser->gralReqData($gral_requestsData);

            if ($resInitData === true && $resrquestData === true) {
                echo json_encode(array("status" => "success", "message" => "Cambios guardados"));
            } else {
                echo json_encode(array("status" => "error", "message" => "Error al guardar cambios, intenta de nuevo"));
            }
        } else {
            // If it's not a POST request
            $this->errorPage();
        }
    }

    public function generate_acta()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        if (isset($_REQUEST['generate'])) {
            $noActa = 1;

            // Fetch all Acta data
            $ActaData = $this->modelUser->getActaData($noActa);

            if ($ActaData) {
                // Remote URL with the local path where the file is stored
                $localFilePath = ACTA_TEMPLATE;

                // Create a new PhpWord object
                $templateWord = new TemplateProcessor($localFilePath);

                // Populate the template with retrieved data
                $templateWord->setValue("nameSesActa", $ActaData->nameSesActa);
                $templateWord->setValue("celebrated_at", $ActaData->celebrated_at);
                $templateWord->setValue("acta_time", $ActaData->timeActa);
                $templateWord->setValue("dateActa", $ActaData->dateActa);
                $templateWord->setValue("nameSesActa2", $ActaData->nameSesActa);
                $templateWord->setValue("noMembers", $ActaData->noMembersActa);
                $templateWord->setValue("nameSesActa3", $ActaData->nameSesActa);

                // Check and set the values for motivosA
                /*if (!empty($ActaData->motivosA)) {
                    $templateWord->setValue("academic_reason", $ActaData->motivosA);
                } else {
                    $templateWord->setValue("academic_reason", "Ninguno.");
                }

                // Check and set the values for motivosP
                if (!empty($ActaData->motivosP)) {
                    $templateWord->setValue("personal_reason", $ActaData->motivosP);
                } else {
                    $templateWord->setValue("personal_reason", "Ninguno.");
                }*/

                // Image signature insertion
                //$templateWord->setImageValue('sign_image', array('path' => $ActaData->firma_alumno, 'width' => '200%', 'height' => '200%'));

                // Save the document to a file
                $filename = sprintf("ACTA DE LA " . $ActaData->nameSesActa);
                $templateWord->saveAs($filename);

                // Optionally, you can send the file for download
                header("Content-Disposition: attachment; filename=" . $filename);
                header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
                header("Content-Length: " . filesize($filename));

                readfile($filename);

                // Clean up - remove the generated file
                unlink($filename);
            } else {
                // Handle the case where no data was found for the given nControl value
                echo 'No data found';
            }
        } else {
            // If it's not a POST request
            $this->errorPage();
        }
    }

    public function fetchActaData()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        // Call the new model function to get new data
        $newData = $this->modelUser->getActaInfo();

        // Return the new data as JSON
        header('Content-Type: application/json');
        echo json_encode($newData);
        exit;
    }

    public function fetchActaGralReqData()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        // Call the new model function to get new data
        $newData = $this->modelUser->getGralReqActaInfo();

        // Return the new data as JSON
        header('Content-Type: application/json');
        echo json_encode($newData);
        exit;
    }

    public function deleteActaData()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        // no_solicitud ID parameter in the POST request
        $rowId = $_POST['no_solicitud'];

        // Call the model function to delete data
        $success = $this->modelUser->deleteActaInfo($rowId);

        // Return the deletion status as JSON
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
        exit;
    }

    public function deleteGralReqData()
    {
        // Start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        // Get the selected row data from the POST request
        $rowId = $_POST['AG_Act'];
        $table = 'asuntos_gen';
        $column = 'AG_Act';

        // Call the model function to delete data
        $success = $this->modelUser->deleteRecord($table, $column, $rowId);

        // Return the deletion status as JSON
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
        exit;
    }

    public function sendComment()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $firstname = $this->modelUser->getUserNameForSession();

            $data = [
                'firstname' => filter_var($firstname),
                FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                'comment' => filter_var(trim($_POST['comment']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            ];

            $result_comment = $this->modelUser->sendComment($data);

            if ($result_comment === true) {
                echo json_encode(array("status" => "success", "message" => "Enviado"));
            } else {
                echo json_encode(array("status" => "error", "message" => "Error al enviar, intenta de nuevo"));
            }
        } else {
            // If it's not a POST request
            $this->errorPage();
        }
    }

    public function fetchComments()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Call the new model function to get comments
            $comments = $this->modelUser->fetchComments();

            // Return the fetched comments as JSON
            header('Content-Type: application/json');
            echo json_encode($comments);
            exit;
        } else {
            // If it's not a POST request
            $this->errorPage();
        }
    }

    public function account()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["stud_loggedin"]) || $_SESSION["stud_loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'stud_username' => filter_var(trim($_SESSION['usernameStud']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'stud_firstname' => filter_var(trim($_POST['stud_firstname']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'stud_flastname' => filter_var(trim($_POST['stud_flastname']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'stud_slastname' => filter_var(trim($_POST['stud_slastname']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'stud_current_passwd' => filter_var(trim($_POST['stud_current_passwd']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'stud_new_passwd' => filter_var(trim($_POST['stud_new_passwd']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'stud_gender' => filter_var(trim($_POST['stud_gender']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'image_data' => filter_var(trim(isset($_POST['image_data']) ? $_POST['image_data'] : ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'file_name' => filter_var(trim(isset($_POST['filename']) ? $_POST['filename'] : ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'file_type' => filter_var(trim(isset($_POST['file_type']) ? $_POST['file_type'] : ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            ];

            $data['stud_flastname'] = html_entity_decode($data['stud_flastname'], ENT_QUOTES, 'UTF-8');

            // Save the base64-encoded image to the server
            $originalFileName = $data['file_name'];
            $imageResult = $this->saveBase64Image($data['image_data'], $data['stud_username'], $originalFileName);

            if (!empty($imageResult)) {
                // Add file information to the data array
                $data['profile_picture'] = $imageResult['file_path'];
            }

            // Get the current password from the model
            $checkPasswdStud = $this->modelUser->getCurrentPasswordStud($data['stud_username']);

            // Check if the current password is correct
            if (password_verify($data['stud_current_passwd'], $checkPasswdStud)) {
                // Create an array of fields to update
                $fieldsToUpdate = [];

                if (!empty($data['stud_firstname'])) {
                    $fieldsToUpdate[] = 'stud_firstname';
                }

                if (!empty($data['stud_flastname'])) {
                    $fieldsToUpdate[] = 'stud_flastname';
                }

                if (!empty($data['stud_slastname'])) {
                    $fieldsToUpdate[] = 'stud_slastname';
                }

                if (!empty($data['stud_new_passwd'])) {
                    $fieldsToUpdate[] = 'stud_current_passwd';
                }

                if (!empty($data['stud_gender'])) {
                    $fieldsToUpdate[] = 'stud_gender';
                }

                if (!empty($data['image_data'])) {
                    $fieldsToUpdate[] = 'image_data';
                    $fieldsToUpdate[] = 'profile_picture';
                    $fieldsToUpdate[] = 'file_name';
                    $fieldsToUpdate[] = 'file_type';
                }

                // Iterate through fieldsToUpdate and update each field
                foreach ($fieldsToUpdate as $field) {
                    if ($field === 'image_data') {
                        // File path is already added to $data in the previous step
                        $result = $this->modelUser->updateUserFieldStud($data['stud_username'], $field, $data[$field]);
                    } elseif ($field === 'stud_current_passwd') {
                        $result = $this->modelUser->updateUserFieldStud($data['stud_username'], $field, password_hash($data['stud_new_passwd'], PASSWORD_DEFAULT));
                    } else {
                        $result = $this->modelUser->updateUserFieldStud($data['stud_username'], $field, $data[$field]);
                    }

                    if ($result !== "Update successful") {
                        echo json_encode(array("status" => "error", "message" => $result));
                        return;
                    }
                }

                echo json_encode(array("status" => "success", "message" => "Datos actualizados correctamente"));
            } else {
                echo json_encode(array("status" => "error", "message" => "La contraseña actual es incorrecta"));
            }
        } else {
            // Get actual student's info
            $student_info = $this->modelUser->getStudInfo($_SESSION['usernameStud']);

            $data = [
                'stud_firstname' => '',
                'stud_flastname' => '',
                'stud_slastname' => '',
                'stud_password' => '',
                'stud_gender' => '',
                'student' => $student_info
            ];

            $this->view('profile/student_profile', $data);
        }
    }

    public function users()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        // Call the model method to update last activity time in the database
        $userId = $_SESSION['id'] ?? null;
        if ($userId !== null) {
            $this->modelUser->updateLastActivityTime($userId);
        }

        // Call the controller method to update last activity time in the session
        $this->updateLastActivityTimeInSession();

        if (isset($_POST['addUser'])) {
            $this->addNewUser();
        } elseif (isset($_POST['updateUser'])) {
            $this->updateUserInfo();
        } elseif (isset($_GET['id'])) {
            $this->delete();
        } else {
            // Get users from model
            $users = $this->modelUser->getUsers();

            $data = [
                'users' => $users
            ];

            $this->view('users/users', $data);
        }
    }

    public function profile()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        // Call the model method to update last activity time in the database
        $userId = $_SESSION['id'] ?? null;
        if ($userId !== null) {
            $this->modelUser->updateLastActivityTime($userId);
        }

        // Call the controller method to update last activity time in the session
        $this->updateLastActivityTimeInSession();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Include file information in the data array
            $data = [
                'username' => filter_var(trim($_SESSION['username']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'firstname' => filter_var(trim(isset($_POST['firstname']) ? $_POST['firstname'] : ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'flastname' => filter_var(trim(isset($_POST['flastname']) ? $_POST['flastname'] : ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'slastname' => filter_var(trim(isset($_POST['slastname']) ? $_POST['slastname'] : ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'email' => filter_var(trim(isset($_POST['email']) ? $_POST['email'] : ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'current_passwd' => filter_var(trim(isset($_POST['current_passwd']) ? $_POST['current_passwd'] : ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'new_passwd' => filter_var(trim(isset($_POST['new_passwd']) ? $_POST['new_passwd'] : ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'gender' => filter_var(trim(isset($_POST['gender']) ? $_POST['gender'] : ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'career' => filter_var(trim(isset($_POST['career']) ? $_POST['career'] : ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'image_data' => filter_var(trim(isset($_POST['image_data']) ? $_POST['image_data'] : ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'file_name' => filter_var(trim(isset($_POST['filename']) ? $_POST['filename'] : ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'file_type' => filter_var(trim(isset($_POST['file_type']) ? $_POST['file_type'] : ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            ];

            // Decode HTML entities
            $data['firstname'] = html_entity_decode($data['firstname'], ENT_QUOTES, 'UTF-8');
            $data['flastname'] = html_entity_decode($data['flastname'], ENT_QUOTES, 'UTF-8');
            $data['slastname'] = html_entity_decode($data['slastname'], ENT_QUOTES, 'UTF-8');
            $data['career'] = html_entity_decode($data['career'], ENT_QUOTES, 'UTF-8');

            // Save the base64-encoded image to the server
            $originalFileName = $data['file_name'];
            $imageResult = $this->saveBase64Image($data['image_data'], $data['username'], $originalFileName);

            if (!empty($imageResult)) {
                // Add file information to the data array
                $data['profile_image'] = $imageResult['file_path'];
            }

            // Get the current password from the model for the given user id
            $checkPasswdUser = $this->modelUser->getCurrentUserPasswd($data['username']);

            // Check if the current password is correct before making changes
            if (password_verify($data['current_passwd'], $checkPasswdUser)) {
                // Create an array of fields to update
                $fieldsToUpdate = [];

                if (!empty($data['firstname'])) {
                    $fieldsToUpdate[] = 'firstname';
                }

                if (!empty($data['flastname'])) {
                    $fieldsToUpdate[] = 'flastname';
                }

                if (!empty($data['slastname'])) {
                    $fieldsToUpdate[] = 'slastname';
                }

                if (!empty($data['email'])) {
                    $fieldsToUpdate[] = 'email';
                }

                if (!empty($data['new_passwd'])) {
                    $fieldsToUpdate[] = 'password';
                }

                if (!empty($data['gender'])) {
                    $fieldsToUpdate[] = 'gender';
                }

                if (!empty($data['career'])) {
                    $fieldsToUpdate[] = 'career';
                }

                if (!empty($data['image_data'])) {
                    $fieldsToUpdate[] = 'image_data';
                    $fieldsToUpdate[] = 'profile_image';
                    $fieldsToUpdate[] = 'file_name';
                    $fieldsToUpdate[] = 'file_type';
                }

                // Iterate through fieldsToUpdate and update each field
                foreach ($fieldsToUpdate as $field) {
                    if ($field === 'image_data') {
                        $result = $this->modelUser->updateFieldsByUsername($data['username'], $field, $data[$field]);
                    } else if ($field === 'password') {
                        $result = $this->modelUser->updateFieldsByUsername($data['username'], $field, password_hash($data['new_passwd'], PASSWORD_DEFAULT));
                    } else {
                        // Pass the file information to the updateFieldsByUsername function
                        $result = $this->modelUser->updateFieldsByUsername($data['username'], $field, $data[$field]);
                    }

                    if ($result !== "Update successful") {
                        echo json_encode(["status" => "error", "message" => $result]);
                        return;
                    }
                }

                echo json_encode(["status" => "success", "message" => "Datos actualizados correctamente"]);
            } else {
                echo json_encode(["status" => "error", "message" => "La contraseña actual es incorrecta"]);
            }
        } else {
            // Get actual user's info
            $user_info = $this->modelUser->getUserById($_SESSION['id']);

            $data = [
                'firstname' => '',
                'flastname' => '',
                'slastname' => '',
                'email' => '',
                'password' => '',
                'gender' => '',
                'career' => '',
                'user_info' => $user_info
            ];

            $this->view('profile/profile', $data);
        }
    }

    // Function to save base64-encoded image to the server
    private function saveBase64Image($rawImg, $username, $originalFileName)
    {
        // Check if the base64 image is not empty
        if (!empty($rawImg)) {
            // Ensure it is valid base64 data
            $decodedImage = base64_decode($rawImg);
            if ($decodedImage === false) {
                return ["status" => "error", "message" => "Datos de imagen base64 no válidos"];
            }

            // Sanitize and validate the original file name
            $originalFileName = pathinfo($originalFileName, PATHINFO_FILENAME);

            // Save the file to the server
            $targetDirectory = '../public/img/uploads/' . $username . '/';

            // Create the target directory if it doesn't exist
            if (!file_exists($targetDirectory)) {
                mkdir($targetDirectory, 0777, true);
            }

            // Log the file extension
            $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);

            // Check if a file with the same name already exists
            $existingFiles = glob($targetDirectory . $originalFileName . '.*', GLOB_NOSORT);
            foreach ($existingFiles as $file) {
                unlink($file);
            }

            $imageFilePath = $targetDirectory . $originalFileName . '.' . $fileExtension;

            // Check if image_data is provided before updating image-related fields
            if (!empty($rawImg)) {
                // Decode the base64 image data and save it to a file
                if (file_put_contents($imageFilePath, $decodedImage)) {
                    // Update image-related fields only if image_data is provided
                    return [
                        "status" => "success",
                        "message" => "Imagen de perfil actualizada",
                        "file_path" => $imageFilePath,
                        "file_name" => $originalFileName . '.' . $fileExtension
                    ];
                } else {
                    return [
                        "status" => "error",
                        "message" => "Error al guardar la imagen, intenta de nuevo"
                    ];
                }
            } else {
                // If image_data is not provided, do not update image-related fields
                return [
                    "status" => "success",
                    "message" => "Imagen de perfil actualizada"
                ];
            }
        }
    }

    /* 
        Add new user functions 
    */
    public function addNewUser()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        // Check if it's an AJAX request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Create an array for the values to be submitted
            $data = [
                'firstname' => filter_var(trim($_POST['firstname']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'email' => filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL),
                'username' => filter_var(trim($_POST['username']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'charge' => filter_var(trim($_POST['charge']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'career' => filter_var($_POST['career'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'gender' => filter_var(trim($_POST['gender']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            ];

            // Check if a user with the provided username exists
            if ($this->modelUser->usernameExists($data['username'])) {
                echo json_encode(["status" => "error", "message" => "Ya existe este nombre de usuario"]);
                return; // Stop further execution
            }

            // Check if a user with the provided email exists
            if ($this->modelUser->userEmailExists($data['email'])) {
                echo json_encode(["status" => "error", "message" => "El usuario ya existe con ese correo electrónico"]);
                return; // Stop further execution
            }

            // Decode HTML entities
            $data['career'] = html_entity_decode($data['career'], ENT_QUOTES, 'UTF-8');

            // If no username or email conflict, insert user data into the database
            $dataResult = $this->modelUser->addUser($data);

            if ($dataResult === true) {
                echo json_encode(["status" => "success", "message" => "Usuario añadido correctamente"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Algo salió mal, intenta de nuevo"]);
            }
        } else {
            // If it's not a POST request
            $this->errorPage();
        }
    }

    public function updateUserInfo()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        // Check if it's an AJAX request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Create an array for the values to be submitted
            $userInfoUp = [
                $userId = $_POST['user_id'],
                'firstname' => filter_var(trim($_POST['UpdateName']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'email' => filter_var(trim($_POST['UpdateEmail']), FILTER_SANITIZE_EMAIL),
                'username' => filter_var(trim($_POST['UpdateUsername']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'currentPassword' => filter_var(trim($_POST['currentPassword']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'NewPassword' => filter_var(trim($_POST['NewPassword']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'charge' => filter_var(trim($_POST['Updatecharge']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'career' => filter_var(trim($_POST['Updatecareer']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'gender' => filter_var(trim($_POST['Updategender']), FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            ];

            // Decode HTML entities for the "charge and career" values
            $userInfoUp['charge'] = html_entity_decode($userInfoUp['charge'], ENT_QUOTES, 'UTF-8');
            $userInfoUp['career'] = html_entity_decode($userInfoUp['career'], ENT_QUOTES, 'UTF-8');

            // Get the current password from the model
            $current_passwd = trim($userInfoUp['currentPassword']);
            $checkPassword = $this->modelUser->getCurrentPassword($userId);

            // Check if the current password is correct
            if (password_verify($current_passwd, $checkPassword)) {
                // Password is correct, proceed with updates

                // Create an array of fields to update
                $fieldsToUpdate = [];

                if (!empty($userInfoUp['firstname'])) {
                    $fieldsToUpdate[] = 'firstname';
                }

                if (!empty($userInfoUp['email'])) {
                    $fieldsToUpdate[] = 'email';
                }

                if (!empty($userInfoUp['username'])) {
                    $fieldsToUpdate[] = 'username';
                }

                if (!empty($userInfoUp['NewPassword'])) {
                    $fieldsToUpdate[] = 'password';
                }

                if (!empty($userInfoUp['charge'])) {
                    $fieldsToUpdate[] = 'charge';
                }

                // Check if charge is "Director académico" or "Secretario técnico"
                if ($userInfoUp['charge'] !== 'Director académico' && $userInfoUp['charge'] !== 'Secretario técnico') {
                    // Add 'career' field to fieldsToUpdate
                    if (!empty($userInfoUp['career'])) {
                        $fieldsToUpdate[] = 'career';
                    } else {
                        // 'career' is empty, set a manual value
                        $userInfoUp['career'] = 'No aplica';
                        // You may still want to add 'career' to fieldsToUpdate
                        $fieldsToUpdate[] = 'career';
                    }
                }

                if (!empty($userInfoUp['gender'])) {
                    $fieldsToUpdate[] = 'gender';
                }

                // Iterate through fieldsToUpdate and update each field
                foreach ($fieldsToUpdate as $field) {
                    if ($field === 'password') {
                        $result = $this->modelUser->updateUserField($userId, $field, password_hash($userInfoUp['NewPassword'], PASSWORD_DEFAULT));
                    } else {
                        // Handle the new fields
                        $result = $this->modelUser->updateUserField($userId, $field, $userInfoUp[$field]);
                    }

                    if ($result !== "Update successful") {
                        echo json_encode(array("status" => "error", "message" => $result));
                        exit; // Exit after sending the JSON response
                    }
                }

                echo json_encode(array("status" => "success", "message" => "Información del usuario actualizada correctamente"));
                exit; // Exit after sending the JSON response
            } else {
                echo json_encode(array("status" => "error", "message" => "La contraseña actual es incorrecta"));
            }
        } else {
            // If it's not a POST request
            $this->errorPage();
        }
    }

    public function delete()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        if (isset($_REQUEST['id'])) {
            $user_id = $_REQUEST['id'];

            // Fetch id data from the model
            $resultMessage = $this->modelUser->deleteUserDataById($user_id);

            if ($resultMessage === true) {
                // Return a JSON success response for record and file deleted
                echo json_encode(array("status" => "success", "message" => "Usuario eliminado correctamente"));
            } elseif ($resultMessage === false) {
                // Return a JSON error response for record deletion failure
                echo json_encode(array("status" => "error", "message" => "Error al eliminar el usuario, intenta de nuevo"));
            } else {
                // Return a JSON error response for record not found or file not found
                echo json_encode(array("status" => "not_found", "message" => "El usuario no fue encontrado o el archivo no existe"));
            }
        } else {
            // If it's not a POST request
            $this->errorPage();
        }
    }

    /* ************************************************************************************************************************ */

    /* Student functions */
    public function students()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        // Call the model method to update last activity time in the database
        $userId = $_SESSION['id'] ?? null;
        if ($userId !== null) {
            $this->modelUser->updateLastActivityTime($userId);
        }

        // Call the controller method to update last activity time in the session
        $this->updateLastActivityTimeInSession();

        if (isset($_POST['addStudent'])) {
            $this->addNewStud();
        } elseif (isset($_POST['updateStudent'])) {
            $this->updateStudInfo();
        } elseif (isset($_GET['stud_id'])) {
            $this->deleteStud();
        } else {
            // Get users
            $students = $this->modelUser->getStudents();

            $data = [
                'stud_username' => '',
                'stud_password' => '',
                'students' => $students
            ];

            $this->view('users/students', $data);
        }
    }

    public function addNewStud()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        // Check if it's an AJAX request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Create an array for the values to be submitted
            $data = [
                'nControl_stud' => filter_var(trim($_POST['nControl_stud']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'password_stud' => password_hash($_POST['password_stud'], PASSWORD_DEFAULT),
                'stud_career' => filter_var(trim($_POST['stud_career']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'stud_charge' => filter_var(trim($_POST['stud_charge']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'stud_gender' => filter_var(trim($_POST['stud_gender']), FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            ];

            // Check if a user with the provided username (nControl_Stud) exists
            $usernameExistsError = $this->modelUser->usernameStudentExists($data['nControl_stud']);

            if ($usernameExistsError) {
                echo json_encode(array("status" => "error", "message" => $usernameExistsError));
            } else {
                // If no username conflict, insert user data into the database
                $dataResult = $this->modelUser->addStudent($data);

                if ($dataResult === true) {
                    echo json_encode(array("status" => "success", "message" => "Estudiante añadido correctamente"));
                } else {
                    echo json_encode(array("status" => "error", "message" => "Algo salió mal, intenta de nuevo"));
                }
            }
        } else {
            // If it's not a POST request
            $this->errorPage();
        }
    }

    public function updateStudInfo()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        // Check if it's an AJAX request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Create an array for the values to be submitted
            $StudInfoUp = [
                'stud_id' => filter_var(trim($_POST['stud_id']), FILTER_SANITIZE_NUMBER_INT),
                'stud_username' => filter_var(trim($_POST['UpdateNctrStud']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'stud_password' => filter_var(trim($_POST['UpdatePasswdStud']), FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            ];

            // Check if there's already a user registered with No. Control
            if ($this->modelUser->usernameStudentExists($StudInfoUp['stud_username'])) {
                echo json_encode(array("status" => "error", "message" => "¡Ya hay un estudiante con ese número de control!"));
            }

            // Create an array of fields to update
            $fieldsToUpdate = [];

            if (!empty($StudInfoUp['stud_username'])) {
                $fieldsToUpdate[] = 'stud_username';
            }

            if (!empty($StudInfoUp['stud_password'])) {
                $fieldsToUpdate[] = 'stud_password';
            }

            // Iterate through fieldsToUpdate and update each field
            foreach ($fieldsToUpdate as $field) {
                if ($field === 'stud_password') {
                    $result = $this->modelUser->updateUserFieldStud($StudInfoUp['stud_id'], $field, password_hash($StudInfoUp['stud_password'], PASSWORD_DEFAULT));
                } else {
                    $result = $this->modelUser->updateUserFieldStud($StudInfoUp['stud_id'], $field, $StudInfoUp[$field]);
                }

                if ($result !== "Update successful") {
                    echo json_encode(array("status" => "error", "message" => $result));
                }
            }

            echo json_encode(array("status" => "success", "message" => "Información del estudiante actualizada correctamente"));
        } else {
            // If it's not a POST request
            $this->errorPage();
        }
    }

    public function deleteStud()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        if (isset($_REQUEST['stud_id'])) {
            $stud_id = $_REQUEST['stud_id'];

            // Fetch id data from the model
            $resultMessage = $this->modelUser->deleteStudDataById($stud_id);

            if ($resultMessage === true) {
                // Return a JSON success response
                echo json_encode(array("status" => "success", "message" => "Estudiante eliminado correctamente"));
            } elseif ($resultMessage === false) {
                // Return a JSON error response for record deletion failure
                echo json_encode(array("status" => "error", "message" => "Error al eliminar el estudiante, intenta de nuevo"));
            } else {
                // Return a JSON error response for record not found or file not found
                echo json_encode(array("status" => "not_found", "message" => "El estudiante no fue encontrado o el archivo no existe"));
            }
        } else {
            // If it's not a POST request
            $this->errorPage();
        }
    }
    /* ******************************************************************************************************************************************* */

    public function recovery()
    {
        // Check if it's an AJAX request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Get the token from the form data
            $data = [
                'new_password' => filter_var(trim($_POST['new_password']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'token' => filter_var(trim($_POST['token']), FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            ];

            // Get the current token from the model
            $verifyPasswdTokenResult = $this->modelUser->verifyPasswordResetToken($data['token']);

            // Verify the token
            if ($verifyPasswdTokenResult) {

                $email = $this->modelUser->getEmailByToken($data['token']);

                if ($this->modelUser->updatePasswordByEmail($email, $data['new_password'])) {
                    // After updating the password, invalidate the used token
                    $this->modelUser->invalidatePasswordResetToken($data['token']);

                    echo json_encode(array("status" => "success", "message" => "Contraseña actualizada con éxito"));
                } else {
                    echo json_encode(array("status" => "error", "message" => "Error al restablecer la contraseña. Por favor, vuelva a intentarlo más tarde"));
                }
            } else {
                echo json_encode(array("status" => "error", "message" => "Token inválido"));
            }
        } else {
            $token = $_GET['token'] ?? '';

            // Verify the token when displaying the password reset form
            if ($this->modelUser->verifyPasswordResetToken($token)) {
                $data = [
                    'token' => $token
                ];

                $this->view('recover/password', $data);
            }
        }
    }

    public function generatePasswordResetToken()
    {
        // Check if the request is a POST request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['recovery_email']; // Get the user's email from the POST data

            // Validate the email (you can add more validation if needed)
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo 'Formato de correo electrónico inválido';
                return;
            }

            // Check if the email exists in the database
            if (!$this->modelUser->userEmailExists($email)) {
                echo 'El correo electrónico proporcionado no corresponde a una cuenta';
                return;
            }

            // Load the email template
            $emailTemplate = file_get_contents(dirname(dirname(__FILE__)) . '/views/email/custom_email_template.php');

            // Generate a unique token
            $token = bin2hex(random_bytes(16));

            // Calculate token expiration time
            $expiration = time() + 3600; // 1 hour

            // Store the token and expiration time in the database
            if ($this->modelUser->storePasswordResetToken($email, $token, $expiration)) {
                // Construct a reset link with the token and timestamp
                $resetLink = BASE_URL . '/password/recovery?token=' . $token . '&expires=' . $expiration;

                $emailBody = str_replace('%%resetLink%%', $resetLink, $emailTemplate);

                // Using my email sending function to send the email
                $this->sendEmail($email, 'Restablecimiento de contraseña', $emailBody);

                echo 'Las instrucciones para restablecer su contraseña fueron enviadas a su correo';
            } else {
                echo 'Error al restablecer la contraseña, intenta de nuevo';
            }
        } else {
            // If it's not a POST request
            $this->errorPage();
        }
    }

    public function download_fdc()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["stud_loggedin"]) || $_SESSION["stud_loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        if (isset($_REQUEST['nControl'])) {
            $nControl = $_REQUEST['nControl'];

            // Fetch FDC data from the model based on nControl
            $fdcData = $this->modelUser->getFDCByNControl($nControl);

            if ($fdcData) {
                // Remote URL with the local path where the file is stored
                $localFilePath = WORD_TEMPLATE;

                // Create a new PhpWord object
                $templateWord = new TemplateProcessor($localFilePath);

                // Populate the template with retrieved data
                $templateWord->setValue("date", $fdcData->fecha);
                $templateWord->setValue("topic", $fdcData->asunto);
                $templateWord->setValue("full_name", implode(' ', [$fdcData->nombre, $fdcData->aPaterno, $fdcData->aMaterno]));
                $templateWord->setValue("career", $fdcData->carrera);
                $templateWord->setValue("nControl", $fdcData->nControl);
                $templateWord->setValue("matter", $fdcData->peticion);

                // Check and set the values for motivosA
                if (!empty($fdcData->motivosA)) {
                    $templateWord->setValue("academic_reason", $fdcData->motivosA);
                } else {
                    $templateWord->setValue("academic_reason", "Ninguno.");
                }

                // Check and set the values for motivosP
                if (!empty($fdcData->motivosP)) {
                    $templateWord->setValue("personal_reason", $fdcData->motivosP);
                } else {
                    $templateWord->setValue("personal_reason", "Ninguno.");
                }

                // Check and set the values for motivosP
                if (!empty($fdcData->otrosM)) {
                    $templateWord->setValue("other_reason", $fdcData->otrosM);
                } else {
                    $templateWord->setValue("other_reason", "No aplica.");
                }

                // Check and set the values for extra_docs
                if ($fdcData->anexos !== null && $fdcData->anexos !== 'null') {
                    $templateWord->setValue("extra_docs", $fdcData->anexos);
                } else {
                    $templateWord->setValue("extra_docs", "Ninguno otro");
                }

                // Concatenate variables with spaces in between
                $templateWord->setValue("corresp", implode(' ', [$fdcData->nombre, $fdcData->aPaterno, $fdcData->aMaterno]));

                // Image signature insertion
                $templateWord->setImageValue('sign_image', array('path' => $fdcData->firma_alumno, 'width' => '200%', 'height' => '200%'));

                $templateWord->setValue("phone", $fdcData->telefono);
                $templateWord->setValue("email", $fdcData->correo);

                // Save the document to a file
                $filename = sprintf('F-DC-15_ISC_%s %s %s %s', $fdcData->nControl, $fdcData->aPaterno, $fdcData->aMaterno, $fdcData->nombre);
                $templateWord->saveAs($filename);

                // Optionally, you can send the file for download
                header("Content-Disposition: attachment; filename=" . $filename);
                header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
                header("Content-Length: " . filesize($filename));

                readfile($filename);

                // Clean up - remove the generated file
                unlink($filename);
            } else {
                // Handle the case where no data was found for the given nControl value
                echo 'No data found for the specified nControl.';
            }
        } else {
            // If it's not a POST request
            $this->errorPage();
        }
    }

    public function fetchGraphData()
    {
        // Assuming $this->userModel is an instance of your User model
        $graphData = $this->modelUser->graficaData();

        // Check if there was an error fetching data
        if (is_string($graphData)) {
            // Handle the error, e.g., return an error response
            echo json_encode(['error' => $graphData]);
            return;
        }

        // Return the graph data as a JSON response
        echo json_encode($graphData);
    }

    public function errorPage()
    {
        // This method will handle the 404 error
        $this->view('error/error-404');
    }

    public function updateStatus()
    {
        // Call the function to start the session if not already started
        start_session_if_not_started();

        // Check if the user is logged in and if the session exists
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: " . BASE_URL . '/login');
            exit;
        }

        // Check if the status parameter is set in the AJAX request
        if (isset($_POST["status"])) {
            $newStatus = $_POST["status"];

            // Update the user status in the session or your database
            $_SESSION["status"] = $newStatus;

            // Return the updated status for display
            header('Content-Type: application/json');
            echo json_encode(["status" => ucfirst(htmlspecialchars($newStatus))]);
            exit;
        } else {
            // Return an error response if the status parameter is not set
            header('Content-Type: application/json');
            echo json_encode(["error" => "Status parameter not set"]);
            exit;
        }
    }
}
