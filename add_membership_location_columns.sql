-- Add location fields for existing AIDF membership databases.
-- Run this once if the memberships table was created before country, region, and district were added.

ALTER TABLE memberships
    ADD COLUMN country VARCHAR(100) AFTER address,
    ADD COLUMN region VARCHAR(100) AFTER country,
    ADD COLUMN district VARCHAR(100) AFTER region;
