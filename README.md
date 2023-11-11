# PHPenalva a lightweight PHP micro-framework 𓅓
![logomarca](public/assets/images/logomarca.png)
### Overview
PHPenalva is a lightweight PHP micro-framework designed on the Model-View-Controller (MVC) architecture.<br>
Built with simplicity in mind, PHPenalva empowers you to swiftly create APIs and web applications.<br>

<strong>Note</strong>: This project is currently under construction. Please bear with us as we work to make it even better.

### Requirements
PHP Version: PHP 7.4 or higher is required.<br>
Web Server: You'll need a web server with URL rewriting enabled.<br>
Supported Servers: PHPenalva plays nicely with Apache, Nginx, and IIS.<br>
Database Compatibility: PHPenalva is compatible with MySQL, MariaDB, PostgreSQL, and SQLite.<br>

Platform: PHPenalva can be used on Linux, Windows, and macOS.<br>


### Installation
Getting started with PHPenalva is a breeze. <br>
You can install it via Composer with the following command in your project directory:<br>
`composer require phpenalva/phpenalva`

### Routes Example
<p>Here are some example routes that you can define in your PHPenalva application:</p>

<strong>Route with views:</strong>

<strong>GET /posts:</strong> List all posts. Access it in your browser to view the posts.<br>
<strong>GET /post/{id}:</strong> View details of a specific post. Replace {id} with the desired post ID in the URL <br>
            
<strong>Route without views:</strong><br>

<strong>POST /post:</strong> Create a new post. Send a POST request to this route with the required parameters to create a new post.<br>
<strong>PUT /post/{id}:</strong> Update an existing post. Send a PUT request to this route with the required parameters to update an existing post. Replace {id} with the desired post ID in the URL.<br>
<strong>DELETE /post/{id}:</strong> Delete an existing post. Send a DELETE request to this


