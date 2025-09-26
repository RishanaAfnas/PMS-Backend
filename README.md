# PMS Backend Project

## Description
This is the PHP Laravel Backend project for the assessment. It includes API endpoints for Users, Projects, Tasks, and Comments.

## Setup Instructions
1. Clone the repository
2. Run composer install
3. Configure .env file
4. Run php artisan migrate --seed
5. Run php artisan serve

## APIs
- User: /api/register, /api/login, /api/logout, /api/me
- Projects: /api/projects, /api/projects/{id} ...
- Tasks: /api/projects/{project_id}/tasks, /api/tasks/{id} ...
- Comments: /api/tasks/{task_id}/comments

## Testing
Run tests using:
```bash
php artisan test
