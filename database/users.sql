use cryptotracker_local
;
CREATE TABLE IF NOT EXISTS users
( id             INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created        TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  modified       TIMESTAMP                      NULL     DEFAULT NULL,
  deleted        TIMESTAMP                      NULL     DEFAULT NULL COMMENT 'treat as deleted when value is not zero',
  active         BOOLEAN                                 DEFAULT TRUE COMMENT 'TRUE if this record is active, FALSE if kept for historical records',
  username       VARCHAR(30) CHARACTER SET utf8 NOT NULL COMMENT 'screen name of user',
  hashedpassword VARCHAR(60) DEFAULT 'xyzzy'    NOT NULL COMMENT 'hashed password',
  email          VARCHAR(50)                    NOT NULL COMMENT 'email address of the user'
)
;

CREATE INDEX index_users_id ON users ( id )
;

INSERT INTO users ( created, modified, deleted, active, username, hashedpassword, email )
VALUES ( SYSDATE(), NULL, NULL, TRUE, 'torbengb', '$2y$10$gPZxo5h9q3RlDlReV6WJXuKXUjnYOStnsa71VRh4qp7S7vLV2ZCiK'
       , 'torben@g-b.dk' )
;
