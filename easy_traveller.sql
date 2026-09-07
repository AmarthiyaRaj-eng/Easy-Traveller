CREATE TABLE users(
    id INT AUTO_INCREMENT PRIMARY KEY,

    fullname VARCHAR(100) NOT NULL,

    email VARCHAR(100) UNIQUE NOT NULL,

    password VARCHAR(255) NOT NULL,

    role ENUM('admin','user') DEFAULT 'user',

    profile_image VARCHAR(255) DEFAULT 'default.png',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===========================
-- DESTINATIONS
-- ===========================

CREATE TABLE destinations(
    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100) NOT NULL,

    state VARCHAR(100) NOT NULL,

    category VARCHAR(50),

    description TEXT,

    weather VARCHAR(100),

    image VARCHAR(255),

    created_by INT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(created_by)
    REFERENCES users(id)
    ON DELETE SET NULL
);

-- ===========================
-- REVIEWS
-- ===========================

CREATE TABLE reviews(
    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,

    destination_id INT NOT NULL,

    rating INT CHECK(rating BETWEEN 1 AND 5),

    review TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(user_id)
    REFERENCES users(id)
    ON DELETE CASCADE,

    FOREIGN KEY(destination_id)
    REFERENCES destinations(id)
    ON DELETE CASCADE
);

-- ===========================
-- FAVOURITES
-- ===========================

CREATE TABLE favourites(
    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,

    destination_id INT NOT NULL,

    FOREIGN KEY(user_id)
    REFERENCES users(id)
    ON DELETE CASCADE,

    FOREIGN KEY(destination_id)
    REFERENCES destinations(id)
    ON DELETE CASCADE
);