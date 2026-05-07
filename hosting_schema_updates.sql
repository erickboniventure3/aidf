-- Hosting readiness schema updates for existing AIDF databases.
-- Run this once before going live if your tables were created from an older version.

ALTER TABLE memberships
    ADD COLUMN IF NOT EXISTS country VARCHAR(100) AFTER address,
    ADD COLUMN IF NOT EXISTS region VARCHAR(100) AFTER country,
    ADD COLUMN IF NOT EXISTS district VARCHAR(100) AFTER region,
    MODIFY COLUMN membership_type ENUM('ordinary', 'college_student', 'institutional', 'honorary') DEFAULT 'ordinary',
    MODIFY COLUMN terms_accepted TINYINT(1) NOT NULL DEFAULT 0,
    MODIFY COLUMN newsletter_subscribed TINYINT(1) NOT NULL DEFAULT 0;

ALTER TABLE volunteers
    ADD COLUMN IF NOT EXISTS country VARCHAR(100) AFTER address,
    ADD COLUMN IF NOT EXISTS region VARCHAR(100) AFTER country,
    ADD COLUMN IF NOT EXISTS district VARCHAR(100) AFTER region,
    ADD COLUMN IF NOT EXISTS hours_per_week VARCHAR(20) AFTER availability,
    ADD COLUMN IF NOT EXISTS previous_volunteer TEXT AFTER experience,
    ADD COLUMN IF NOT EXISTS emergency_contact VARCHAR(100) AFTER previous_volunteer,
    MODIFY COLUMN terms_accepted TINYINT(1) NOT NULL DEFAULT 0,
    MODIFY COLUMN background_check_consent TINYINT(1) NOT NULL DEFAULT 0;
