# Marketplace
## AnotaAi Backend Challenge

![PHP](https://img.shields.io/badge/php-%23ED8B00.svg?style=for-the-badge&logo=openjdk&logoColor=white)
![Laravel](https://img.shields.io/badge/laravel-%236DB33F.svg?style=for-the-badge&logo=spring&logoColor=white)
[![Licence](https://img.shields.io/github/license/Ileriayo/markdown-badges?style=for-the-badge)](./LICENSE)
![MySQL](https://img.shields.io/badge/mysql-%234ea94b.svg?style=for-the-badge&logo=mongodb&logoColor=white)
![AWS](https://img.shields.io/badge/AWS-%23FF9900.svg?style=for-the-badge&logo=amazon-aws&logoColor=white)

This project is an API built using **PHP, Laravel, AWS Simple Queue Service, MySQL, Docker and AWS Simple Storage Service.**

The Microservice was developed to demonstrate how to solve the [AnotaAi Backend Challenge](https://github.com/githubanotaai/new-test-backend-nodejs).

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [API Endpoints](#api-endpoints)
- [Database](#database)
- [Contributing](#contributing)

## Installation

1. Clone the repository:

```bash
git clone https://github.com/leonardomoraisf/anotaai_backend_test
```

2. Enter the project folder:

3. Run in terminal:

```bash
composer install && ./vendor/bin/sail up -d
```

4. Create the environment file:

```bash
cp .env.example .env
```

5. Generate Jwt Secret:

```bash
./vendor/bin/sail artisan jwt:secret
```

6. Modify the environment file:

**Config Values**

```.env
AWS_ACCESS_KEY_ID=VALUE
AWS_SECRET_ACCESS_KEY=VALUE2
AWS_DEFAULT_REGION=VALUE3
AWS_DEFAULT_VERSION=VALUE4
AWS_ARN_CATALOG_EMIT=VALUE5
```

## Database

1. Run the migrations:

```bash
./vendor/bin/sail artisan migrate
```

## Usage

1. Start the application with Laravel sail
2. The API will be accessible at http://localhost

## API Endpoints
The API provides the following endpoints:

**API PRODUCT**
```markdown
POST /api/products - Create a new product
GET /api/products - Retrieve all products
PUT /api/products/{id} - Updates a product
DELETE /api/products/{id} - Delete a product
```

**BODY**
```json
{
  "title": "Produto para postar no tópico",
  "price": 9.99,
  "description": "",
  "category_id": 1,
  "user_id": 1
}
```

**API CATEGORY**
```markdown
POST /api/categories - Create a new category
GET /api/categories - Retrieve all categories
PUT /api/categories/{id} - Updates a category
DELETE /api/categories/{id} - Delete a category
```

**BODY**
```json
{
  "id": 1,
  "title": "Teste",
  "description": "",
  "user_id": 1
}
```

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvements, please open an issue or submit a pull request to the repository.

When contributing to this project, please follow the existing code style, [commit conventions](https://www.conventionalcommits.org/en/v1.0.0/), and submit your changes in a separate branch.




