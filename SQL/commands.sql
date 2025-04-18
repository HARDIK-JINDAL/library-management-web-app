CREATE DATABASE LibraryManagement;
USE LibraryManagement;

-- Staff Table (also handles authentication)
CREATE TABLE Staff (
    staff_id INT PRIMARY KEY,
    name VARCHAR(100),
    salary DECIMAL(10,2),
    password VARCHAR(255)
);


-- Customer Table (includes branch_id for registration info)
CREATE TABLE Customer (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    address VARCHAR(255),
    reg_date DATE,
    book_issued INT
);

-- Book Table (include availability and location info)
CREATE TABLE Book (
    book_id INT PRIMARY KEY,
    title VARCHAR(255),
    retail_price DECIMAL(10,2),
    author_name VARCHAR(255),
    updated_by INT, -- staff_id who updated,
    availability VARCHAR(20) DEFAULT 'available',
    FOREIGN KEY (updated_by) REFERENCES Staff(staff_id)
);
CREATE TABLE IssuedBooks (
    customer_id INT,
    book_id INT,
    book_name VARCHAR(255),
    borrowed_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 
    PRIMARY KEY (customer_id, book_id),
    FOREIGN KEY (customer_id) REFERENCES Customer(customer_id),
    FOREIGN KEY (book_id) REFERENCES Book(book_id)
    );

   CREATE TABLE Log (
    log_id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT,
    activity_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    log_message TEXT,
    FOREIGN KEY (customer_id) REFERENCES Customer(customer_id)
); 

DELIMITER //

CREATE TRIGGER before_insert_issuedbooks
BEFORE INSERT ON IssuedBooks
FOR EACH ROW
BEGIN
    DECLARE current_count INT;

    -- Get current issued book count for the customer
    SELECT book_issued INTO current_count
    FROM Customer
    WHERE customer_id = NEW.customer_id;

    -- Block if customer already has 3 books
    IF current_count >= 3 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Borrowing limit exceeded: customer already has 3 books';
    ELSE
        -- Increase the customer's book issued count
        UPDATE Customer
        SET book_issued = book_issued + 1
        WHERE customer_id = NEW.customer_id;

        -- Mark the book as borrowed (update availability)
        UPDATE Book
        SET availability = 'borrowed'
        WHERE book_id = NEW.book_id;

        -- Log the borrowing action
        INSERT INTO Log (customer_id, log_message)
        VALUES (
            NEW.customer_id,
            CONCAT('Book "', NEW.book_name, '" (ID: ', NEW.book_id, ') was borrowed.')
        );
    END IF;
END;
//

DELIMITER ;

DELIMITER //

CREATE TRIGGER before_delete_issuedbooks
BEFORE DELETE ON IssuedBooks
FOR EACH ROW
BEGIN
    -- Decrease the customer's book issued count
    UPDATE Customer
    SET book_issued = book_issued - 1
    WHERE customer_id = OLD.customer_id;

    -- Mark the book as available
    UPDATE Book
    SET availability = 'available'
    WHERE book_id = OLD.book_id;

    -- Log the return action
    INSERT INTO Log (customer_id, log_message)
    VALUES (
        OLD.customer_id,
        CONCAT('Book "', OLD.book_name, '" (ID: ', OLD.book_id, ') was returned.')
    );
END;
//

DELIMITER ;
