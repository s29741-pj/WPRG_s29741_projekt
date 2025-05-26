CREATE TABLE Roles
(
    role_id INT PRIMARY KEY NOT NULL,
    role VARCHAR(50)
);


CREATE TABLE Accounts
(
    account_type INT PRIMARY KEY NOT NULL 
);

CREATE TABLE Users
(
    user_id      INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    account_type INT,
    FOREIGN KEY (account_type)
        REFERENCES Roles (role_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    name         VARCHAR(150),
    surname      VARCHAR(150),
    email        VARCHAR(100) CHECK (email REGEXP '^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,4}$'),
    password     VARCHAR(30)
);

CREATE TABLE Departments
(
    department_id   INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    user_id         INT,
    FOREIGN KEY (user_id)
        REFERENCES Users (user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    department_name VARCHAR(250)
);


CREATE TABLE Tickets
(
    ticket_id     INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    department_id INT,
    FOREIGN KEY (department_id)
        REFERENCES Departments (department_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    user_id       INT,
    FOREIGN KEY (user_id)
        REFERENCES Users (user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    title         VARCHAR(250),
    priority      VARCHAR(20),
    date_added    DATE,
    date_closed   DATE,
    date_deadline DATE
);

CREATE TABLE Attachments
(
    attachment_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    ticket_id INT NOT NULL,
    file_name VARCHAR(255),
    file_path VARCHAR(255),
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ticket_id) 
        REFERENCES Tickets(ticket_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Comments
(
    comment_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    ticket_id  INT,
    FOREIGN KEY (ticket_id)
        REFERENCES Tickets (ticket_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    added      DATE,
    modified   DATE,
    content    VARCHAR(1000)
);



