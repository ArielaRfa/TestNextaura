INSERT INTO testdevs.user (email, roles, password, name, surname, creation_date, updated_at, api_refresh_token, api_refresh_token_expiration)
VALUES ('user@test.com', '["ROLE_USER"]', '$2y$10$NvUo5Tfz9SEkpbTPoVW.kev8pXcJCLl/tWoGDvwSkLqxHRSqwo8SW', 'User',
        'Test', '2023-02-20 12:00:00', null, null, null);

INSERT INTO testdevs.user (email, roles, password, name, surname, creation_date, updated_at, api_refresh_token, api_refresh_token_expiration)
VALUES ('admin@test.com', '["ROLE_ADMIN"]', '$2y$10$RtbD.WCt4pnj1/aTTagi3.9lD3MO0Tz2/wCTwzTiNzNtj5Gf7W3EC',
        'Admin', 'Test', '2023-02-20 12:00:00', null, null, null);

INSERT INTO testdevs.user (email, roles, password, name, surname, creation_date, updated_at, api_refresh_token, api_refresh_token_expiration)
VALUES ('admin2@test.com', '["ROLE_ADMIN"]', '$2y$10$RtbD.WCt4pnj1/aTTagi3.9lD3MO0Tz2/wCTwzTiNzNtj5Gf7W3EC',
        'Admin2', 'Test', '2023-02-20 12:00:00', null, null, null);
