# Task Management API Documentation

## Install Dependencies
Run the following command to install the necessary dependencies using Composer:

```json
    composer install
```
This will install all the required PHP packages and libraries needed to run the Laravel application.

## Set Up Environment Configuration
copy the .env.example file and rename it to .env:

```json
    cp .env.example .env
```

Open the .env file and configure database to be sqlite (This comes default check it is sqlite).


## Run Migrations
If your application uses a database, you may need to run the migrations to set up your database schema:

```json
    php artisan migrate
```
This will set up the required tables.

## Serve the Application
Start the Laravel application server using the following command:

```json
    php artisan serve
```

This will start the server, and by default, it will be accessible at ```http://127.0.0.1:8000```. You can now access your Laravel backend locally ![Sample Result](/hmcts/public/images/runningApplication.png).

## Running Test Cases
Use the following command to run test cases: ![Sample Result](/public/images/testCases.png)

```json
    php artisan test --filter TaskControllerTest
```


## Endpoints

## Base URL

```http://127.0.0.1:8000/api```


### 1. **Create a New Task**

**URL:** `/tasks`  
**Method:** `POST`  
**Description:** Creates a new task.
**Status code:** 201

#### Sample URL:
```http://127.0.0.1:8000/api/tasks```

#### Sample Request:
```json
{
    "title": "Task Title",
    "description": "Task description (optional)",
    "status": "pending",
    "due_date": "2025/05/01"
}
```

#### Sample Response:

```json
{
    "id": 1,
    "title": "Complete report",
    "description": "Finish the monthly report",
    "status": "pending",
    "due_date": "2025-05-01T12:00:00",
    "created_at": "2025-04-27T00:00:00",
    "updated_at": "2025-04-27T00:00:00"
}
```

### Error Response (Validation Failed):

```json
{
    "message": "Validation failed",
    "errors": {
        "title": ["The title field is required."]
    },
    "missing_fields": ["title"]
}
```

### 2. **Get Task by ID**

**URL:** `/tasks/{id}`  
**Method:** `GET`  
**Description:** Retrieves a task by its ID.
**Status code:** 200

#### Sample URL:
```http://127.0.0.1:8000/api/tasks/1```

#### Sample Response:

```json
{
    "id": 1,
    "title": "Complete report",
    "description": "Finish the monthly report",
    "status": "pending",
    "due_date": "2025-05-01T12:00:00",
    "created_at": "2025-04-27T00:00:00",
    "updated_at": "2025-04-27T00:00:00"
}
```

### Error Response (Validation Failed):

```json
{
   "error": "Task not found"
}
```

### 3. **Get All Task**

**URL:** `/tasks/{id}`  
**Method:** `GET`  
**Description:** Retrieves a task by its ID.
**Status code:** 200

#### Sample URL:
```http://127.0.0.1:8000/api/tasks```

#### Sample Response:

```json
[
    {
        "id": 1,
        "title": "Complete report",
        "description": "Finish the monthly report",
        "status": "pending",
        "due_date": "2025-05-01T12:00:00",
        "created_at": "2025-04-27T00:00:00",
        "updated_at": "2025-04-27T00:00:00"
    },
    {
        "id": 2,
        "title": "Prepare presentation",
        "description": "Prepare slides for the team meeting",
        "status": "in progress",
        "due_date": "2025-05-02T09:00:00",
        "created_at": "2025-04-27T00:00:00",
        "updated_at": "2025-04-27T00:00:00"
    }
]
```

### Error Response (Validation Failed):

```json
{
   "error": "Task not found"
}
```

### 4. **Update Task Status by ID**

**URL:** `/tasks/{id}/status`  
**Method:** `PATCH`  
**Description:** Updates the status of an existing task.
**Status code:** 200

#### Sample URL:
```http://127.0.0.1:8000/api/tasks/1/status```

#### Sample Request:
```json
{
    "status": "completed"
}
```

#### Sample Response:

```json
{
    "id": 1,
    "title": "Complete report",
    "description": "Finish the monthly report",
    "status": "completed",
    "due_date": "2025-05-01T12:00:00",
    "created_at": "2025-04-27T00:00:00",
    "updated_at": "2025-04-27T00:00:00"
}
```

### 5. **Delete a Task by ID**

**URL:** `/tasks/{id}`  
**Method:** `DELETE`  
**Description:** Deletes an existing task by its ID
**Status code:** 204

#### Sample URL:
```http://127.0.0.1:8000/api/tasks/1```

#### Sample Response:

```json
{
   "message": "Task deleted successfully"
}
```

### Error Response (Validation Failed):

```json
{
   "error": "Task not found"
}
```

### Sample Images of Routes:
create - ![Sample Result](/hmcts/public/images/createTask.png)
Get task by id - ![Sample Result](/hmcts/public/images/getSingleTask.png)
Get all tasks - ![Sample Result](/hmcts/public/images/getAllTask.png)
Update task by status - ![Sample Result](/hmcts/public/images/updateTaskByStatus.png)
Delete - ![Sample Result](/hmcts/public/images/deleteTask.png)