# Coby API

This was an API I attempted to create for a project I was working on with some friends. 
The concept was a simple virtual wardrobe.

## Getting started

- Download this repo.

- This repo includes a submodule called Laradock, a PHP dev environment for docker.

- In the root directory, create a .env file
```sh
$ mv .env.example .env
```

- Change the DB_HOST
```sh
$ DB_HOST=mysql
```

- Change into the laradock directory
```sh
$ cd laradock
```

- Create a .env file
```sh
$ mv .env.example .env
```

- Create the containers
```sh
$ docker-compose up -d nginx mysql
```

Change to the workspace environment
```sh
$ docker-compose exec workspace bash
```

- Install the modules
```sh
$ composer install
```

- Generate a key
```sh
$ php artisan key:generate
```

- Migrate the database
```sh
$ php artisan migrate
```

- You may have to clear the cache at some point.
```sh
$ php artisan cache:clear
```

## Routes

The full list can be found in app/routes/api.php

## User

### Register a user
POST /api/register
```
{
	"username": "jamlam",
	"email": "example@gmail.com",
	"password": "passw0rd"
}
```
Responses

200
Success
```
{
    "data": {
        "username": "jamlam",
        "avatar": "https://www.gravatar.com/avatar/d6a48f034d797eba91f1fbdd641fb689?s=45&d=mm"
    }
}

```

422
Missing required fields
```
{
    "username": [
        "The username field is required."
    ],
    "email": [
        "The email field is required."
    ],
    "password": [
        "The password field is required."
    ]
}
```
Password not the correct length
```
{
    "password": [
        "The password must be at least 6 characters."
    ]
}
```
Email not unique
```
{
    "email": [
        "The email has already been taken."
    ]
}
```

### Logging in a user
POST /oauth/token
```
{
  "grant_type": "password",
  "client_id": "2",
  "client_secret": "get-from-oauth-clients-table",
  "username": "example@gmail.com",
  "password": "passw0rd",
  "scope": "*"
}
```

Responses

200
Successful log in
```
{
    "token_type": "Bearer",
    "expires_in": 31536000,
    "access_token": "very-long-token",
    "refresh_token": "also-very-long-token"
}
```

401
Incorrect client_id or client secret 
```
{
    "error": "invalid_client",
    "message": "Client authentication failed"
}
```

Incorrect email or password
```
{
    "error": "invalid_credentials",
    "message": "The user credentials were incorrect."
}
```

### Fetching a users details

GET /api/user

Authorization Header
```
{
    Authorization: "Bearer your-token"
}
```

Responses
200
Successful user fetch
```
{
    "id": 1,
    "username": "jamlam",
    "email": "jamie@gmail.com",
    "created_at": "2020-07-31 11:06:34",
    "updated_at": "2020-07-31 11:06:34"
}
```

401
Missing or incorrect bearer token
```
{
    "error": "Unauthenticated."
}
```

## Hangers

### Fetching the list of Hangers

GET /api/hangers

Authorization Header
```
{
    Authorization: "Bearer your-token"
}
```

Responses
200
Empty Hangers List
```
{
    "data": [],
    "meta": {
        "pagination": {
            "total": 0,
            "count": 0,
            "per_page": 3,
            "current_page": 1,
            "total_pages": 1,
            "links": {}
        }
    }
}
```

Hangers List
```
{
    "data": [
        {
            "id": 4,
            "title": "Trousers",
            "created_at": "2020-08-04 08:33:55",
            "created_at_human": "7 seconds ago",
            "user": {
                "data": {
                    "username": "jamlam",
                    "avatar": "https://www.gravatar.com/avatar/d6a48f034d797eba91f1fbdd641fb689?s=45&d=mm"
                }
            }
        },
        {
            "id": 3,
            "title": "Coats",
            "created_at": "2020-08-04 08:33:42",
            "created_at_human": "20 seconds ago",
            "user": {
                "data": {
                    "username": "jamlam",
                    "avatar": "https://www.gravatar.com/avatar/d6a48f034d797eba91f1fbdd641fb689?s=45&d=mm"
                }
            }
        },
        ...
    ],
    "meta": {
        "pagination": {
            "total": 3,
            "count": 3,
            "per_page": 3,
            "current_page": 1,
            "total_pages": 1,
            "links": {}
        }
    }
}
```

401
Missing or incorrect bearer token
```
{
    "error": "Unauthenticated."
}
```

### Storing a Hanger
POST /api/hangers

Authorization Header
```
{
    Authorization: "Bearer your-token"
}
```

Body
```
{
	"title": "Shirts"
}
```

Response
200 

```
{
    "data": {
        "id": 1,
        "title": "Shirts",
        "created_at": "2020-07-31 13:56:49",
        "created_at_human": "1 second ago",
        "user": {
            "data": {
                "username": "jamlam",
                "avatar": "https://www.gravatar.com/avatar/d6a48f034d797eba91f1fbdd641fb689?s=45&d=mm"
            }
        }
    }
}
```

401
Missing or incorrect bearer token
```
{
    "error": "Unauthenticated."
}
```

### Fetching a specifc Hanger
GET /api/hangers/{hangerId}

Authorization Header
```
{
    Authorization: "Bearer your-token"
}
```

Responses
200
```
{
    "data": {
        "id": 1,
        "title": "Shirts",
        "created_at": "2020-07-31 13:56:49",
        "created_at_human": "4 minutes ago",
        "user": {
            "data": {
                "username": "jamlam",
                "avatar": "https://www.gravatar.com/avatar/d6a48f034d797eba91f1fbdd641fb689?s=45&d=mm"
            }
        },
        "photos": {
            "data": []
        }
    }
}
```

401
Missing or incorrect bearer token
```
{
    "error": "Unauthenticated."
}
```

### Updating a Hanger
PATCH /api/hangers/{hangerId}

Authorization Header
```
{
    Authorization: "Bearer your-token"
}
```

Body
```
{
	"title": "A new hangers title"
}
```

Responses

200
Success
```
{
    "data": {
        "id": 2,
        "title": "A new hangers title",
        "created_at": "2020-08-04 08:29:45",
        "created_at_human": "35 minutes ago",
        "user": {
            "data": {
                "username": "jamlam",
                "avatar": "https://www.gravatar.com/avatar/d6a48f034d797eba91f1fbdd641fb689?s=45&d=mm"
            }
        }
    }
}
```

401
Missing or incorrect bearer token
```
{
    "error": "Unauthenticated."
}
```

### Deleting a Hanger
DELETE /api/hangers/{hangerId}

Authorization Header
```
{
    Authorization: "Bearer your-token"
}
```

Responses

204 No Content

401
Missing or incorrect bearer token
```
{
    "error": "Unauthenticated."
}
```

## Photos

### Amazon S3
All images are stored in S3. For it to work you need to add the following variables to your .env file.

```
    AWS_KEY=your-key
    AWS_SECRET=your-secret
    AWS_REGION=your-region
    AWS_BUCKET=your-bucket
```

### Storing a Photo
POST /api/hangers/{hangerId}/photos

Current implementation isn't complete.

Authorization Header
```
{
    Authorization: "Bearer your-token"
}
```

Body
```
    "title": "White Shirt",
    "file_photo": [file],
    "brand": "Uniqlo",
    "tag": "Top",
```

Reponses

401
Missing or incorrect bearer token
```
{
    "error": "Unauthenticated."
}
```

### Updating a Photo
PATCH /api/hangers/{hangersId}/photos/{photosId}

Currently not implemented.

### Deleting a Photo
DELETE /api/hangers/{hangersId}/photos/{photosId}

Currently not implemented.
