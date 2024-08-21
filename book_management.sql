CREATE DATABASE book_management;
USE book_management;

CREATE TABLE authors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author_name VARCHAR(255) NOT NULL,
    book_numbers INT DEFAULT 0
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255) NOT NULL
);

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author_id INT,
    category_id INT,
    publisher VARCHAR(255),
    publish_year YEAR,
    quantity INT DEFAULT 0,
    FOREIGN KEY (author_id) REFERENCES authors(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);


INSERT INTO authors (author_name, book_numbers) VALUES
('J.K. Rowling', 7),
('George R.R. Martin', 5),
('J.R.R. Tolkien', 4),
('Agatha Christie', 66),
('Stephen King', 63);
INSERT INTO categories (category_name) VALUES
('Fantasy'),
('Mystery'),
('Science Fiction'),
('Horror'),
('Adventure');
INSERT INTO books (title, author_id, category_id, publisher, publish_year, quantity) VALUES
('Harry Potter and the Sorcerer\'s Stone', 1, 1, 'Bloomsbury', 1997, 500),
('A Game of Thrones', 2, 1, 'Bantam Books', 1996, 300),
('The Fellowship of the Ring', 3, 1, 'George Allen & Unwin', 1954, 200),
('Murder on the Orient Express', 4, 2, 'Collins Crime Club', 1934, 150),
('The Shining', 5, 4, 'Doubleday', 1977, 250),
('The Hobbit', 3, 5, 'George Allen & Unwin', 1937, 180),
('And Then There Were None', 4, 2, 'Collins Crime Club', 1939, 220),
('IT', 5, 4, 'Viking Press', 1986, 400),
('A Clash of Kings', 2, 1, 'Bantam Books', 1998, 280);
