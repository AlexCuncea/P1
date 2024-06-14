CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    date DATE NOT NULL,
    description VARCHAR(255) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Tabel pentru a stoca programările șterse
CREATE TABLE IF NOT EXISTS deleted_appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    date DATE NOT NULL,
    description VARCHAR(255) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Procedura pentru adăugarea unei programări
DELIMITER //
CREATE PROCEDURE add_appointment(IN userId INT, IN appDate DATE, IN appDesc VARCHAR(255))
BEGIN
    INSERT INTO appointments (user_id, date, description) VALUES (userId, appDate, appDesc);
END //
DELIMITER ;

-- Procedura pentru editarea unei programări
DELIMITER //
CREATE PROCEDURE edit_appointment(IN appId INT, IN appDate DATE, IN appDesc VARCHAR(255))
BEGIN
    UPDATE appointments SET date = appDate, description = appDesc WHERE id = appId;
END //
DELIMITER ;

-- Procedura pentru ștergerea unei programări
DELIMITER //
CREATE PROCEDURE delete_appointment(IN appId INT)
BEGIN
    DELETE FROM appointments WHERE id = appId;
END //
DELIMITER ;

-- Trigger înainte de inserare
DELIMITER //
CREATE TRIGGER before_insert_appointment
BEFORE INSERT ON appointments
FOR EACH ROW
BEGIN
    SET NEW.description = CONCAT('[New] ', NEW.description);
END //
DELIMITER ;

-- Trigger înainte de actualizare
DELIMITER //
CREATE TRIGGER before_update_appointment
BEFORE UPDATE ON appointments
FOR EACH ROW
BEGIN
    SET NEW.description = CONCAT('[Updated] ', NEW.description);
END //
DELIMITER ;

-- Trigger înainte de ștergere
DELIMITER //
CREATE TRIGGER before_delete_appointment
BEFORE DELETE ON appointments
FOR EACH ROW
BEGIN
    INSERT INTO deleted_appointments (user_id, date, description) VALUES (OLD.user_id, OLD.date, OLD.description);
END //
DELIMITER ;
