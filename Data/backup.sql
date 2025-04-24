CREATE TABLE Accounts
(
    account_type INT PRIMARY KEY NOT NULL
);

CREATE TABLE Attachments
(
    attachment_id INT PRIMARY KEY NOT NULL,
    name          VARCHAR(250),
    directory     VARCHAR(500)
);

CREATE TABLE Users
(
    user_id      INT PRIMARY KEY NOT NULL,
    account_type INT,
    FOREIGN KEY (account_type)
        REFERENCES Accounts (account_type)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    name         VARCHAR(150),
    surname      VARCHAR(150),
    email        VARCHAR(100) CHECK (email REGEXP '^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,4}$')
);

CREATE TABLE Departments
(
    department_id   INT PRIMARY KEY NOT NULL,
    user_id         INT,
    FOREIGN KEY (user_id)
        REFERENCES Users (user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    department_name VARCHAR(250)
);

CREATE TABLE Tickets
(
    ticket_id     INT PRIMARY KEY NOT NULL,
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
    attachment_id INT,
    FOREIGN KEY (attachment_id)
        REFERENCES Attachments (attachment_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    title         VARCHAR(250),
    priority      SMALLINT,
    date_added    DATE,
    date_closed   DATE,
    date_deadline DATE
);

CREATE TABLE Comments
(
    comment_id INT PRIMARY KEY NOT NULL,
    ticket_id  INT,
    FOREIGN KEY (ticket_id)
        REFERENCES Tickets (ticket_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    added      DATE,
    modified   DATE,
    content    VARCHAR(1000)
);



