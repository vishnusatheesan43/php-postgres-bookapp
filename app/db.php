<?php
function getDb() {
    static $db = null;

    if ($db === null) {
        $host = getenv('DB_HOST');
        $dbname = getenv('DB_NAME');
        $user = getenv('DB_USER');
        $pass = getenv('DB_PASS');

        $db = new PDO(
            "pgsql:host=$host;port=5432;dbname=$dbname",
            $user,
            $pass
        );
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Create the original table if it does not exist.
        $db->exec("
            CREATE TABLE IF NOT EXISTS books (
                id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                author VARCHAR(255) NOT NULL,
                year INT
            )
        ");

        // Phase 2: add the new fields without destroying existing data.
        $db->exec("ALTER TABLE books ADD COLUMN IF NOT EXISTS category VARCHAR(100) NOT NULL DEFAULT 'General'");
        $db->exec("ALTER TABLE books ADD COLUMN IF NOT EXISTS description TEXT");
        $db->exec("ALTER TABLE books ADD COLUMN IF NOT EXISTS rating NUMERIC(2,1) NOT NULL DEFAULT 0");
        $db->exec("ALTER TABLE books ADD COLUMN IF NOT EXISTS cover_url TEXT");

        // Keep existing/invalid values safe.
        $db->exec("UPDATE books SET category = 'General' WHERE category IS NULL OR TRIM(category) = ''");
        $db->exec("UPDATE books SET rating = 0 WHERE rating IS NULL");
    }

    return $db;
}
