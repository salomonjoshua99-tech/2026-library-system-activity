# Library Management System

A refactored OOP PHP application for managing library books, borrow records,
and overdue fines. Built following PSR-12 coding standards.

## Author
- Joshua Salomon

## Requirements
- PHP 8.0 or higher
- MySQL 5.7 or higher
- Git

## Installation
1. Clone the repository
2. Import `database/schema.sql` into MySQL
3. Copy `.env.example` to `.env` and configure database credentials
4. Run `composer install` (if dependencies exist)

## File Structure
```
src/
├── Entity/          # Data models (Book, BorrowRecord, Student)
├── Repository/       # Database access layer
├── Service/          # Business logic
├── Config/           # Configuration and constants
└── View/             # HTML templates
public/                 # Web-accessible entry point
docs/                   # Generated PHPDoc output
```

## PSR-12 Compliance
All PHP files follow PSR-12 coding standards:
- 4-space indentation
- Unix LF line endings
- Strict typing enabled
- Descriptive naming conventions

## Usage Examples

### Adding a Book
```php
$connection = new DatabaseConnection($config);
$repository = new BookRepository($connection);

$book = new Book('The Great Gatsby', 'F. Scott Fitzgerald', 1925, 'Fiction');
$bookId = $repository->addBook($book);
```

### Borrowing a Book
```php
$service = new LibraryService($connection);
$service->borrowBook(101, 42, 14); // student 101 borrows book 42 for 14 days
```

## Features
- **Book Management** - Add, search, and list books
- **Borrowing System** - Track book loans and returns
- **Fine Calculation** - Automatic overdue fine calculation
- **Reporting** - Statistical reports for library management
- **Security** - Prepared statements preventing SQL injection
- **Error Handling** - Exception-based error management
- **Documentation** - Complete PHPDoc for all classes, methods, properties

## Database Schema
The system uses the following main tables:
- `books` - Book inventory with title, author, year, genre
- `borrow_records` - Borrow tracking with dates, fines, status
- `students` - Student information for borrowing system

## API Documentation
Complete PHPDoc documentation available in `docs/` directory generated from source code.

## Contributing
1. Follow PSR-12 coding standards
2. Add PHPDoc blocks to all new classes and methods
3. Use prepared statements for all database queries
4. Include proper error handling with exceptions