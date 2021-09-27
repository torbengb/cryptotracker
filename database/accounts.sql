USE cryptotracker_local
;
CREATE TABLE IF NOT EXISTS accounts
( id         INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created    TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  modified   TIMESTAMP                      NULL     DEFAULT NULL,
  deleted    TIMESTAMP                      NULL     DEFAULT NULL COMMENT 'treat as deleted when value is not zero',
  active     BOOLEAN                                 DEFAULT TRUE COMMENT 'TRUE if this record is active, FALSE if kept for historical records',
  parent     INT(11) UNSIGNED               NOT NULL COMMENT 'owners.id',
  acctname VARCHAR(30) CHARACTER SET utf8 NOT NULL COMMENT 'screen name of user',
  CONSTRAINT fk_accounts_owners_parent FOREIGN KEY ( parent ) REFERENCES owners ( id )
)
;

CREATE INDEX index_accounts_id ON accounts ( id )
;

INSERT INTO accounts ( created, modified, deleted, active, parent, acctname )
VALUES
  ( SYSDATE(), NULL, NULL, TRUE, 1, 'personal' )
, ( SYSDATE(), NULL, NULL, TRUE, 2, 'family account' )
, ( SYSDATE(), NULL, NULL, TRUE, 2, 'inheritance' )
;
