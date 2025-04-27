# Task Management API Documentation

## Base URL

```http://127.0.0.1:8000/api```

## Endpoints

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