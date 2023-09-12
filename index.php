<?php
// Defining database connection detail
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phprest";

// Creating database connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Set the content type to JSON for all responses
header('Content-Type: application/json');

// Function to send a JSON response
function sendResponse($code, $data) {
    http_response_code($code);
    echo json_encode($data);
    exit;
}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the HTTP request method
$method = $_SERVER["REQUEST_METHOD"];

switch ($method) {
    case "POST":
        // CREATE: Adding a new person
        $data = json_decode(file_get_contents("php://input"), true);

        // Validate input data 
        if (empty($data["name"]) || !is_string($data["name"])) {
            sendResponse(400,["message" => "Invalid input data"] );
        } else {
            $name = mysqli_real_escape_string($conn, $data["name"]);
            $sql = "INSERT INTO persons (name) VALUES ('$name')";
            if (mysqli_query($conn, $sql)) {
            sendResponse(201,["message" => "Person created successfully"] );
            } else {
            sendResponse(500,["message" => "Failed to create person"]);
            }
        }
        break;

    case "GET":
        if (isset($_GET["user_id"])) {
            $user_id = $_GET["user_id"];
    
            // Validate input data 
            if (!is_string($user_id)) {
                sendResponse(400, ["message" => "Name must be a string"]);
            }
    
            // Retrieve a person by id
            $sql = "SELECT * FROM persons WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                // Fetch the person's data
                $person = $result->fetch_assoc();
                echo json_encode($person);
            } else {
                sendResponse(404, ["message" => "Person not found"]);
            }
        } else {
            // Fetch all data when no parameters are provided
            $sql = "SELECT * FROM persons";
            $result = $conn->query($sql);
    
            if ($result->num_rows > 0) {
                // Fetch all persons' data
                $persons = $result->fetch_all(MYSQLI_ASSOC);
                echo json_encode($persons);
            } else {
                sendResponse(404, ["message" => "No Persons found"]);
            }
        }
        break;

    case "PUT":
        // UPDATE: Modifying details of an existing person
        $user_id = $_GET["user_id"];
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data["name"];

        // Validate input data
        if (!is_string($user_id) || empty($data["name"]) || !is_string($data["name"])) {
            sendResponse(400, ["message" => "Invalid input data"]);
        } else {
            $user_id = intval($user_id);
            // Prepare and execute the SQL query to update the person's name
            $sql = "UPDATE persons SET name = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si",$name, $user_id);

            if ($stmt->execute()) {
            sendResponse(200, ["message" => "Person updated successfully"]);
        } else {
                sendResponse(500, ["message" => "Failed to update person"]);
            }
        }
        break;

    case "DELETE":
        // DELETE: Removing a person
        $user_id = $_GET["user_id"];

        // Validate input data
        if (!is_string($user_id)) {
            sendResponse(400, ["message" => "Invalid input data"]);
        } else {
            $user_id = intval($user_id);
            $sql = "DELETE FROM persons WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
    
            if ($stmt->execute()) {
            sendResponse(204, ["message" => "Successfully deleted "]);
            } else {
            sendResponse(500, ["message" => "Failed to delete person"]);
            }
        }
        break;

    default:
        sendResponse(405, ["message" => "Method not allowed"]);
        break;
}

// Close the database connection
mysqli_close($conn);
?>
