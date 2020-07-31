# Coby API

This was an API I attempted to create for a project I was working on with some friends. 
The concept was a simple virtual wardrobe.

## Getting started

- Download this repo.

- Make sure you have composer installed. [composer link]

- Change into the directory
```sh
$ cd coby_api
```

- Create a .env file
```sh
$ mv .env.example .env
```

- Install the dependancies
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
    "data": []
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

```
{
	"title": "Shirts"
}
```

Response
200 
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

