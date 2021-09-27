USE cryptotracker_local
;

CREATE TABLE IF NOT EXISTS owners
( id         INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created    TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  modified   TIMESTAMP                      NULL     DEFAULT NULL,
  deleted    TIMESTAMP                      NULL     DEFAULT NULL COMMENT 'treat as deleted when value is not zero',
  active     BOOLEAN                                 DEFAULT TRUE COMMENT 'TRUE if this record is active, FALSE if kept for historical records',
  parent     INT(11) UNSIGNED               NOT NULL COMMENT 'users.id',
  acctholder VARCHAR(30) CHARACTER SET utf8 NOT NULL COMMENT 'screen name of user'
, CONSTRAINT owners_users_parent_fk FOREIGN KEY ( parent ) REFERENCES users ( id )
)
;

CREATE INDEX index_owners_id ON owners ( id )
;

INSERT INTO owners ( created, modified, deleted, active, parent, acctholder )
VALUES ( SYSDATE(), NULL, NULL, TRUE, 1, 'torben' )
,      ( SYSDATE(), NULL, NULL, TRUE, 1, 'family' )
;
