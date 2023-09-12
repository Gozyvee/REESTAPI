<?php
// Define your database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phprest";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

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

        // Validate input data (e.g., name is required and is a string)
        if (empty($data["name"]) || !is_string($data["name"])) {
            http_response_code(400);
            echo json_encode(["message" => "Invalid input data"]);
        } else {
            $name = mysqli_real_escape_string($conn, $data["name"]);
            $sql = "INSERT INTO persons (name) VALUES ('$name')";
            if (mysqli_query($conn, $sql)) {
                http_response_code(201); // 201 Created
                echo json_encode(["message" => "Person created successfully"]);
            } else {
                http_response_code(500); // 500 Internal Server Error
                echo json_encode(["message" => "Failed to create person"]);
            }
        }
        break;

    case "GET":
        if (isset($_GET["user_id"])) {
            $user_id = $_GET["user_id"];
    
            // Perform validation: Ensure $name is a string
            if (!is_string($user_id)) {
                http_response_code(400);
                echo json_encode(["message" => "Name must be a string"]);
                exit;
            }
    
            // Prepare and execute the SQL query to retrieve a person by name
            $sql = "SELECT * FROM persons WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                // Fetch the person's data
                $person = $result->fetch_assoc();
    
                // Return the person's data as JSON
                header('Content-Type: application/json');
                echo json_encode($person);
            } else {
                // Person not found
                http_response_code(404);
                echo json_encode(["message" => "Person not found"]);
            }
        } else {
            // Fetch all data when no parameters are provided
            $sql = "SELECT * FROM persons";
            $result = $conn->query($sql);
    
            if ($result->num_rows > 0) {
                // Fetch all persons' data
                $persons = $result->fetch_all(MYSQLI_ASSOC);
    
                // Return all data as JSON
                header('Content-Type: application/json');
                echo json_encode($persons);
            } else {
                // No persons found
                http_response_code(404);
                echo json_encode(["message" => "No persons found"]);
            }
        }
        break;

    case "PUT":
        // UPDATE: Modifying details of an existing person
        $user_id = $_GET["user_id"];
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data["name"];

        // Validate input data (e.g., user_id is required and is an integer, name is required and is a string)
        if (!is_string($user_id) || empty($data["name"]) || !is_string($data["name"])) {
            http_response_code(400);
            echo json_encode(["message" => "Invalid input data"]);
        } else {
            $user_id = intval($user_id);
            // Prepare and execute the SQL query to update the person's name
            $sql = "UPDATE persons SET name = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si",$name, $user_id);

            if ($stmt->execute()) {
                http_response_code(200); // 200 OK
                echo json_encode(["message" => "Person updated successfully"]);
            } else {
                http_response_code(500); // 500 Internal Server Error
                echo json_encode(["message" => "Failed to update person"]);
            }
        }
        break;

    case "DELETE":
        // DELETE: Removing a person
        $user_id = $_GET["user_id"];

        // Validate input data (e.g., user_id is required and is an integer)
        if (!is_string($user_id)) {
            http_response_code(400);
            echo json_encode(["message" => "Invalid input data"]);
        } else {
            $user_id = intval($user_id);
            $sql = "DELETE FROM persons WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
    
            if ($stmt->execute()) {
                http_response_code(204); // 204 No Content
                echo json_encode(["message" => "Successfully deleted "]);
            } else {
                http_response_code(500); // 500 Internal Server Error
                echo json_encode(["message" => "Failed to delete person"]);
            }
        }
        break;

    default:
        http_response_code(405); // 405 Method Not Allowed
        echo json_encode(["message" => "Method not allowed"]);
        break;
}

// Close the database connection
mysqli_close($conn);
?>
