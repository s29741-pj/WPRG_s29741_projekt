CREATE TABLE Roles
(
    role_id INT PRIMARY KEY NOT NULL,
    role VARCHAR(50)
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
    name         VARCHAR(150),
    surname      VARCHAR(150),
    email        VARCHAR(100) CHECK (email REGEXP '^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,4}$'),
    password     VARCHAR(30),
    FOREIGN KEY (account_type)
        REFERENCES Roles (role_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);


CREATE TABLE Departments
(
    department_id   INT PRIMARY KEY NOT NULL,
    user_id         INT,
    department_name VARCHAR(250),
    FOREIGN KEY (user_id)
        REFERENCES Users (user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);


CREATE TABLE Tickets
(
    ticket_id     INT PRIMARY KEY NOT NULL,
    department_id INT,
    user_id       INT,
    attachment_id INT,
    title         VARCHAR(250),
    priority      VARCHAR(20),
    date_added    DATE,
    date_closed   DATE,
    date_deadline DATE,
    FOREIGN KEY (department_id)
        REFERENCES Departments (department_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (user_id)
        REFERENCES Users (user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (attachment_id)
        REFERENCES Attachments (attachment_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Comments
(
    comment_id INT PRIMARY KEY NOT NULL,
    ticket_id  INT,
    added      DATE,
    modified   DATE,
    content    VARCHAR(1000),
    FOREIGN KEY (ticket_id)
        REFERENCES Tickets (ticket_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);


-- =========================
-- DANE: Attachments
-- =========================

INSERT INTO Roles (role_id, role)
VALUES  (1, 'Admin'),
        (2, 'Department Head'),
        (3, 'User');



INSERT INTO Attachments (attachment_id, name, directory)
VALUES (1, 'logo.png', '/attachments/logo.png'),
       (2, 'report.pdf', '/attachments/report.pdf'),
       (3, 'invoice.docx', '/attachments/invoice.docx'),
       (4, 'photo.jpg', '/attachments/photo.jpg'),
       (5, 'archive.zip', '/attachments/archive.zip'),
       (6, 'presentation.pptx', '/attachments/presentation.pptx'),
       (7, 'diagram.svg', '/attachments/diagram.svg'),
       (8, 'notes.txt', '/attachments/notes.txt'),
       (9, 'manual.pdf', '/attachments/manual.pdf'),
       (10, 'ticket.xlsx', '/attachments/ticket.xlsx');

-- =========================
-- DANE: Users
-- =========================
INSERT INTO Users (user_id, account_type, name, surname, email, password)
VALUES (1, 1, 'Anna', 'Kowalska', 'anna.kowalska@example.com', 'test1234'),
       (2, 2, 'Jan', 'Nowak', 'jan.nowak@example.com', 'test1234'),
       (3, 3, 'Ewa', 'Wiśniewska', 'ewa.wisniewska@example.com', 'test1234'),
       (4, 2, 'Tomasz', 'Wójcik', 'tomasz.wojcik@example.com', 'test1234'),
       (5, 2, 'Karolina', 'Krawczyk', 'karolina.krawczyk@example.com', 'test1234'),
       (6, 2, 'Michał', 'Mazur', 'michal.mazur@example.com', 'test1234'),
       (7, 2, 'Zofia', 'Lewandowska', 'zofia.lewandowska@example.com', 'test1234'),
       (8, 3, 'Paweł', 'Zieliński', 'pawel.zielinski@example.com', 'test1234'),
       (9, 3, 'Natalia', 'Szymańska', 'natalia.szymanska@example.com', 'test1234'),
       (10, 3, 'Mateusz', 'Dąbrowski', 'mateusz.dabrowski@example.com', 'test1234');

-- =========================
-- DANE: Departments
-- =========================
INSERT INTO Departments (department_id, user_id, department_name)
VALUES (1, 1, 'IT'),
       (2, 2, 'HR'),
       (3, 3, 'Marketing'),
       (4, 4, 'Finance'),
       (5, 5, 'Sales'),
       (6, 6, 'Support'),
       (7, 7, 'Legal'),
       (8, 8, 'Logistics'),
       (9, 9, 'Operations'),
       (10, 10, 'R&D');

-- =========================
-- DANE: Tickets
-- =========================
INSERT INTO Tickets (ticket_id, department_id, user_id, attachment_id, title, priority, date_added, date_closed,
                     date_deadline)
VALUES (1, 1, 2, 1, 'System crash on login', 'High', '2025-04-01', NULL, '2025-04-10'),
       (2, 2, 3, 2, 'New employee onboarding', 'Medium', '2025-04-02', '2025-04-06', '2025-04-05'),
       (3, 3, 4, 3, 'Campaign performance report', "Low", '2025-04-03', NULL, '2025-04-12'),
       (4, 4, 5, 4, 'Missing financial data', 'High', '2025-04-04', NULL, '2025-04-10'),
       (5, 5, 6, 5, 'Quarterly sales forecast', 'Medium', '2025-04-05', NULL, '2025-04-15'),
       (6, 6, 7, 6, 'Customer complaint follow-up', 'Medium', '2025-04-06', '2025-04-08', '2025-04-07'),
       (7, 7, 8, 7, 'Contract review', 'Low', '2025-04-07', NULL, '2025-04-20'),
       (8, 8, 9, 8, 'Warehouse delay', 'High', '2025-04-08', NULL, '2025-04-18'),
       (9, 9, 10, 9, 'Process automation request', 'Low', '2025-04-09', NULL, '2025-04-30'),
       (10, 10, 1, 10, 'Prototype testing', 'Medium', '2025-04-10', NULL, '2025-04-25');

-- =========================
-- DANE: Comments
-- =========================
INSERT INTO Comments (comment_id, ticket_id, added, modified, content)
VALUES (1, 1, '2025-04-01', '2025-04-02', 'Issue confirmed.'),
       (2, 2, '2025-04-02', '2025-04-03', 'Welcome package sent.'),
       (3, 3, '2025-04-03', '2025-04-03', 'Awaiting final numbers.'),
       (4, 4, '2025-04-04', '2025-04-05', 'Finance team notified.'),
       (5, 5, '2025-04-05', '2025-04-06', 'Initial forecast ready.'),
       (6, 6, '2025-04-06', '2025-04-06', 'Complaint resolved.'),
       (7, 7, '2025-04-07', '2025-04-08', 'Legal reviewed the contract.'),
       (8, 8, '2025-04-08', '2025-04-08', 'Delivery delayed by 2 days.'),
       (9, 9, '2025-04-09', '2025-04-10', 'Automation tools evaluated.'),
       (10, 10, '2025-04-10', '2025-04-11', 'Testing phase ongoing.');



