# API Documentation
This documentation outlines the usage of the PHP REST API for managing persons in a MySQL database.

## Endpoints

### Create a New Person (POST)

- **Endpoint:** `/api`
- **Request Format:**
  - Method: POST
  - URL: `http://your-api-url.com/api`
  - Headers:
    - Content-Type: application/json
  - Request Body (JSON):
    ```json
    {
      "name": "John Doe"
    }
    ```
- **Response Format:**
  - Success (HTTP 201 Created):
    ```json
    {
      "message": "Person created successfully"
    }
    ```
  - Error (HTTP 500 Internal server error):
    ```json
    {
      "message": "Failed to creeate person"
    }
    ```

### Retrieve Persons (GET)

#### Retrieve a Specific Person

- **Endpoint:** `/api?user_id={id}`
- **Request Format:**
  - Method: GET
  - URL: `http://your-api-url.com/api?user_id=1` (Replace `1` with the desired person's ID)
- **Response Format:**
  - Success (HTTP 200 OK):
    ```json
    {
      "id": 1,
      "name": "John Doe"
    }
    ```
  - Error (HTTP 404 Not Found):
    ```json
    {
      "message": "Person not found"
    }
    ```

#### Retrieve All Persons

- **Endpoint:** `/api`
- **Request Format:**
  - Method: GET
  - URL: `http://your-api-url.com/api`
- **Response Format:**
  - Success (HTTP 200 OK):
    ```json
    [
      {
        "id": 1,
        "name": "John Doe"
      },
      {
        "id": 2,
        "name": "Jane Smith"
      }
    ]
    ```
  - Error (HTTP 404 Not Found):
    ```json
    {
      "message": "No persons found"
    }
    ```

### Update a Person (PUT)

- **Endpoint:** `/api?user_id={id}`
- **Request Format:**
  - Method: PUT
  - URL: `http://your-api-url.com/api?user_id=1` (Replace `1` with the desired person's ID)
  - Headers:
    - Content-Type: application/json
  - Request Body (JSON):
    ```json
    {
      "name": "Updated Name"
    }
    ```
- **Response Format:**
  - Success (HTTP 200 OK):
    ```json
    {
      "message": "Person updated successfully"
    }
    ```
  - Error (HTTP 500 Internal server error):
    ```json
    {
      "message": "Failed to update person" 
    }
    ```

### Delete a Person (DELETE)

- **Endpoint:** `/api?user_id={id}`
- **Request Format:**
  - Method: DELETE
  - URL: `http://your-api-url.com/api?user_id=1` (Replace `1` with the desired person's ID)
- **Response Format:**
  - Success (HTTP 204 No Content):
    ```json
    {
      "message": "Successfully deleted"
    }
    ```
  - Error (HTTP 500 Internal server error):
    ```json
    {
      "message": "Failed to delete person"
    }
    ```
### 2. Sample Usage of the API

#### Example 1: Creating a New Person (POST /api)

**Request:**

- **Method:** POST
- **Endpoint:** `/api`
- **Headers:**
  - Content-Type: application/json
- **Request Body (JSON):**
  ```json
  {
    "name": "John Doe"
  }
  ```

**Response:**

- **HTTP Status Code:** 201 Created
- **Response Body (JSON):**
  ```json
  {
    "message": "Person created successfully"
  }
  ```

#### Example 2: Fetching Details of a Person (GET /api/{user_id})

**Request:**

- **Method:** GET
- **Endpoint:** `/api?user_id={id}`

**Response:**

- **HTTP Status Code:** 200 OK
- **Response Body (JSON):**
  ```json
  {
    "id": 1,
    "name": "John Doe"
  }
  ```
#### Example 3: Updating Details of a Person (PUT /api/{user_id})

**Request:**

- **Method:** PUT
- **Endpoint:** `/api?user_id={id}`
- **Headers:**
  - Content-Type: application/json
- **Request Body (JSON):**
  ```json
  {
    "name": "Updated Name"
  }
  ```

**Response:**

- **HTTP Status Code:** 200 OK
- **Response Body (JSON):**
  ```json
  {
    "message": "Person updated successfully"
  }
  ```

#### Example 4: Deleting a Person (DELETE /api/{user_id})

**Request:**

- **Method:** DELETE
- **Endpoint:** `/api?user_id={id}` 

**Response:**

- **HTTP Status Code:** 204 No Content
- **Response Body (JSON):**
  ```json
  {
    "message": "Successfully deleted"
  }
  ```

## Known Limitations and Assumptions

- The API assumes that the MySQL database is properly set up and running with the specified credentials.
- Error handling and response formats are simplified for demonstration purposes and should be enhanced for production use.
- Security measures like authentication and authorization are not included in this basic example and should be added for real-world scenarios.

## Setting Up and Deploying the API

1. Set up a web server environment (e.g., Apache, Nginx).
2. Create a MySQL database and configure the credentials in the PHP script.
3. Place the PHP script in the appropriate directory accessible by your web server.
4. Start the web server.
5. Access the API via the provided endpoints using an HTTP client or browser.

---

This documentation provides an overview of how to use the API, the expected request and response formats, known limitations, and setup instructions. 