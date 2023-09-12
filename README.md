# RESTAPI
To set up, run, and use the API you've created, follow these steps:

**Setting Up the API:**

1. **Web Server**: Ensure you have a web server environment set up on your local machine or a hosting service. Common choices include Apache, Nginx, or even a development server like XAMPP or WAMP for local testing.

2. **Database**: Make sure you have a MySQL database set up and running. The database should match the credentials you specified in the PHP script (`$servername`, `$username`, `$password`, `$dbname`).

3. **PHP**: PHP should also be installed and configured on your web server.

4. **Code Placement**: Place your PHP script (the one you provided earlier) in the appropriate directory on your web server. Ensure that PHP files are executable by the server.

**Running the API:**

1. **Start the Web Server**: If you're using a local development environment like XAMPP or WAMP, start the server. If you're hosting your API online, it should already be running.

2. **Access the API**: You can access your API by navigating to its URL in your web browser or by using an API testing tool like [Postman](https://www.postman.com/), [Insomnia](https://insomnia.rest/), or [curl](https://curl.se/).

**Using the API:**

Your API has several endpoints for performing CRUD operations. Here's how to use each of them:

1. **Create (POST)**:
   - To add a new person, send a POST request to your API's endpoint, e.g., `http://your-api-url.com/api/` with a JSON payload containing the person's name:
     ```json
     {
       "name": "John Doe"
     }
     ```
   - You will receive a response indicating whether the creation was successful or not.

2. **Read (GET)**:
   - To retrieve a specific person, send a GET request with the person's ID as a query parameter, e.g., `http://your-api-url.com/api?user_id=1`.
   - To retrieve all persons, send a GET request to `http://your-api-url.com/api`.

3. **Update (PUT)**:
   - To update a person's name, send a PUT request with the person's ID as a query parameter, e.g., `http://your-api-url.com/api?user_id=1`, and provide a JSON payload with the new name:
     ```json
     {
       "name": "Updated Name"
     }
     ```
   - You will receive a response indicating whether the update was successful or not.

4. **Delete (DELETE)**:
   - To delete a person, send a DELETE request with the person's ID as a query parameter, e.g., `http://your-api-url.com/api?user_id=1`.
   - You will receive a response indicating whether the deletion was successful or not.

**Handling Responses:**

- Your API will respond with appropriate HTTP status codes (e.g., 200 for success, 400 for bad request, 404 for not found, 500 for server errors).
- Successful responses will include JSON data in the format specified by your API.
