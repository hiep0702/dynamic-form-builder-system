# Dynamic Form Builder System

A scalable dynamic form builder system built with Laravel using Domain-Driven Design (DDD) architecture. Supports extensible field types, schema versioning, and asynchronous processing with queue system.

## Features

- **Dynamic Form Creation**: Create forms with various field types (text, number, date, select, checkbox, textarea, file)
- **Field Management**: Add, update, and remove fields from forms
- **Schema Versioning**: Automatic version tracking to maintain submission integrity
- **Asynchronous Processing**: Queue-based submission processing with status tracking
- **RESTful API**: Complete API for form management and submissions
- **DDD Architecture**: Clean separation of concerns with Domain, Application, and Infrastructure layers

## Architecture Overview

### Layered Architecture (DDD)

```
├── Domain Layer
│   ├── Entities (Form, Field, Submission)
│   ├── Value Objects (FormStatus, SubmissionStatus, FieldType)
│   ├── Repositories (Interfaces)
│   └── Services (Field Handlers)
├── Application Layer
│   ├── Use Cases (Business Logic)
│   ├── Commands (DTOs)
│   └── Factories
├── Infrastructure Layer
│   ├── Repositories (Eloquent Implementations)
│   ├── Models (Eloquent ORM)
│   └── External Services
└── Presentation Layer
    ├── Controllers (API)
    ├── Requests (Validation)
    └── Routes
```

### Key Components

- **Aggregate Root**: Form entity manages fields and versioning
- **Value Objects**: Immutable objects for status and types
- **Use Cases**: Application services handling business logic
- **Repository Pattern**: Abstraction over data persistence
- **Queue System**: Asynchronous job processing for submissions

## Installation

### Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js & NPM (for frontend assets)
- MySQL/PostgreSQL database

### Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd dynamic-form-builder-system
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   ```bash
   cp .env.example .env
   ```

   Update `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=dynamic_forms
   DB_USERNAME=your_username
   DB_PASSWORD=your_password

   QUEUE_CONNECTION=database
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

## Database Setup

1. **Create database**
   ```sql
   CREATE DATABASE dynamic_forms;
   ```

2. **Run migrations**
   ```bash
   php artisan migrate
   ```

3. **Seed database (optional)**
   ```bash
   php artisan db:seed
   ```

## Running the Project

### Development Server

1. **Start Laravel development server**
   ```bash
   php artisan serve
   ```

   Server will be available at `http://localhost:8000`

2. **Build frontend assets (if needed)**
   ```bash
   npm run dev
   ```

### Queue Worker

The system uses queues for asynchronous submission processing. Start the queue worker:

```bash
php artisan queue:work
```

For production, consider using a process manager like Supervisor to keep the worker running.

### Alternative: Using Docker

If you prefer Docker:

```bash
# Build and run with Docker Compose
docker-compose up -d

# Run migrations in container
docker-compose exec app php artisan migrate
```

## API Testing

### Available Endpoints

#### Form Management
- `GET /api/forms` - List all forms
- `POST /api/forms` - Create new form
- `GET /api/forms/{id}` - Get form details
- `PUT /api/forms/{id}` - Update form
- `DELETE /api/forms/{id}` - Delete form

#### Field Management
- `POST /api/forms/{id}/fields` - Add field to form
- `PUT /api/forms/{id}/fields/{fieldId}` - Update field
- `DELETE /api/forms/{id}/fields/{fieldId}` - Remove field

#### Public APIs
- `GET /api/forms/active` - List active forms
- `GET /api/forms/active/{id}` - Get active form schema
- `POST /api/forms/{id}/submit` - Submit form data
- `GET /api/submissions` - List submissions
- `GET /api/submissions/{id}` - Get submission details

### Testing with cURL

#### Create a Form
```bash
curl -X POST http://localhost:8000/api/forms \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Contact Form",
    "description": "A simple contact form",
    "status": "active",
    "fields": [
      {
        "type": "text",
        "label": "Name",
        "required": true
      },
      {
        "type": "email",
        "label": "Email",
        "required": true
      }
    ]
  }'
```

#### Submit Form Data
```bash
curl -X POST http://localhost:8000/api/forms/1/submit \
  -H "Content-Type: application/json" \
  -d '{
    "field_0": "John Doe",
    "field_1": "john@example.com"
  }'
```

#### Check Submission Status
```bash
curl http://localhost:8000/api/submissions/1
```

### Using Postman/Insomnia

Import the following collection structure:

```
Dynamic Form Builder API
├── Forms
│   ├── List Forms
│   ├── Create Form
│   ├── Get Form
│   ├── Update Form
│   └── Delete Form
├── Fields
│   ├── Add Field
│   ├── Update Field
│   └── Remove Field
├── Public
│   ├── List Active Forms
│   ├── Get Active Form Schema
│   └── Submit Form
└── Submissions
    ├── List Submissions
    └── Get Submission
```

## Trade-offs and Assumptions

### Architecture Decisions

1. **DDD Implementation**
   - **Trade-off**: More complex structure vs. maintainability
   - **Assumption**: Team has experience with DDD patterns

2. **Schema Versioning**
   - **Trade-off**: Storage overhead vs. data integrity
   - **Assumption**: Form schemas change frequently, submissions need historical context

3. **Queue Processing**
   - **Trade-off**: Delayed response vs. system scalability
   - **Assumption**: Submission processing may involve heavy operations (file uploads, integrations)

### Technical Assumptions

1. **Database Choice**: MySQL/PostgreSQL with JSON column support for flexible field properties
2. **Queue Driver**: Database queues for simplicity (can be changed to Redis for production)
3. **Field Types**: Extensible through FieldHandler pattern
4. **Validation**: Client-side validation assumed, server-side validation per field type
5. **Authentication**: Not implemented (can be added with Laravel Sanctum/Passport)
6. **File Uploads**: Basic support, no advanced file processing (resize, convert)

### Performance Considerations

- **Indexing**: Consider adding indexes on frequently queried columns (status, created_at)
- **Caching**: Form schemas can be cached for better performance
- **Pagination**: API responses should be paginated for large datasets
- **Rate Limiting**: Consider implementing rate limiting for submission endpoints

### Security Notes

- Input validation implemented per field type
- CSRF protection enabled by default
- Consider adding API authentication for production use
- File upload validation should be enhanced for security

## Development

### Running Tests

```bash
# Run PHP tests
php artisan test

# Run with coverage
php artisan test --coverage
```

### Code Quality

```bash
# Run PHPStan
./vendor/bin/phpstan analyse

# Run Laravel Pint
./vendor/bin/pint
```

### Contributing

1. Follow PSR-12 coding standards
2. Write tests for new features
3. Update documentation
4. Use meaningful commit messages

## License

This project is licensed under the MIT License.
