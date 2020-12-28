CREATE DATABASE IF NOT EXISTS bookmarket;
USE bookmarket;
CREATE TABLE IF NOT EXISTS author (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(30) NOT NULL,
    sname VARCHAR(30) NOT NULL,
    dob DATE NOT NULL
);
CREATE TABLE IF NOT EXISTS book (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(80) NOT NULL,
    public_date DATE,
    raiting ENUM('0+','6+','12+','16+','18+'),
    b_state ENUM('available','n_available','pre_order'),
    amount INT DEFAULT 0,
    price INT NOT NULL,
    author_id INT,
    FOREIGN KEY (author_id) REFERENCES author(id) ON DELETE RESTRICT ON UPDATE CASCADE
);
CREATE TABLE IF NOT EXISTS genre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(80) NOT NULL
);
CREATE TABLE IF NOT EXISTS book_genre (
    book_id INT,
    FOREIGN KEY (book_id) REFERENCES book(id),
    genre_id INT,
    FOREIGN KEY (genre_id) REFERENCES genre(id) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE IF NOT EXISTS client (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(30) NOT NULL,
    sname VARCHAR(30) NOT NULL,
    phone_number VARCHAR(15) NOT NULL,
    email VARCHAR(80) NOT NULL,
    c_address VARCHAR(80) NOT NULL
);
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    create_date DATE NOT NULL,
    id_client INT,
    o_state ENUM('operating','canceled','paid','done'),
    FOREIGN KEY (id_client) REFERENCES client(id)  ON DELETE RESTRICT ON UPDATE CASCADE
);
CREATE TABLE IF NOT EXISTS order_book (
    book_id INT,
    amount INT DEFAULT 1,
    FOREIGN KEY (book_id) REFERENCES book(id) ON DELETE CASCADE ON UPDATE CASCADE,
    order_id INT,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE ON UPDATE CASCADE
);

select b.id as id, b.title as title, public_date, raiting, b_state, amount, price, fname, sname, group_concat(g.title) as genre_title from book b join author a on a.id = b.author_id join book_genre bg on b.id = bg.book_id join genre g on g.id = bg.genre_id where year(b.public_date) = ? group by b.id, b.title, public_date, raiting, b_state, amount, price, fname, sname;
