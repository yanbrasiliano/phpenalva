# PHPenalva 𓅓
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
`composer create-project hiyan/phpenalva your_project_name`

### Routes Example
<p>Here are some example routes that you can define in your PHPenalva application:</p>

<strong>Route with views:</strong>

 <li><strong>GET /posts:</strong> List all posts. Access it in your browser to view the posts.</li>
 <li><strong>GET /post/{id}:</strong> View details of a specific post. Replace {id} with the desired post ID in the URL.</li>
 <br>
            
<strong>Route without views:</strong><br>

<li><strong>POST /post:</strong> Create a new post. Send a POST request to this route with the required parameters to create a new post.</li>
<li><strong>PUT /post/{id}:</strong> Update an existing post. Send a PUT request to this route with the required parameters to update an existing post. Replace {id} with the desired post ID in the URL.</li>
<li><strong>DELETE /post/{id}:</strong> Delete an existing post. Send a DELETE request to this

<strong>Authenticated Routes:</strong><br>
To use route authentication in PHPenalva, add 'auth' to your route definition. For example: $route[] = ['GET', '/posts', 'PostController@index', 'auth'];. To access an authenticated route, you must log in via the /api/login route. If you don't have an account, create one using /user/create. You can then log in to your account via /api/login. After logging in, you'll receive an access token. You can use this token to access authenticated routes. To do so, add the token to the Authorization header of your request. For example: Authorization: Bearer {token}. Replace {token} with the access token you received after logging in. You can also use the token as a query parameter. For example: /posts?token={token}. Replace {token} with the access token you received after logging in.

### Documentation
Our comprehensive documentation is readily available at {{TODO}}.<br>
We're continually working on enhancing it to help you make the most of PHPenalva's features.

### Contributing
PHPenalva is an open-source project, and we warmly welcome contributions from the community. <br>
Whether it's bug fixes, new features, or improvements, your input is valuable to us. <br>
Please see our [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines on how to contribute.

### License
PHPenalva is released under the MIT License. For more details, please refer to the LICENSE file.<br>
If you need any assistance or have questions, don't hesitate to reach out to us.

Thank you for choosing PHPenalva for your development needs! Enjoy coding with PHPenalva! 🚀🌐
