USE cryptotracker_local
;

CREATE TABLE IF NOT EXISTS txns
( id       INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created  TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  modified TIMESTAMP                      NULL     DEFAULT NULL,
  deleted  TIMESTAMP                      NULL     DEFAULT NULL COMMENT 'treat as deleted when value is not zero',
  active   BOOLEAN                                 DEFAULT TRUE COMMENT 'TRUE if this record is active, FALSE if kept for historical records',
  parent   INT(11) UNSIGNED               NOT NULL COMMENT 'accounts.id',
  detail VARCHAR(30) CHARACTER SET utf8   NOT NULL DEFAULT 'XYZZY' COMMENT 'details of txn',
  CONSTRAINT fk_txns_accounts_parent FOREIGN KEY ( parent ) REFERENCES accounts ( id )
)
;

CREATE INDEX index_txns_id ON txns ( id )
;

INSERT INTO txns ( created, modified, deleted, active, parent, detail )
VALUES
  ( SYSDATE(), NULL, NULL, TRUE, 1, 'xyzzy1' )
, ( SYSDATE(), NULL, NULL, TRUE, 2, 'xyzzy2' )
, ( SYSDATE(), NULL, NULL, TRUE, 2, 'xyzzy3' )
, ( SYSDATE(), NULL, NULL, TRUE, 3, 'xyzzy4' )
, ( SYSDATE(), NULL, NULL, TRUE, 3, 'xyzzy5' )
, ( SYSDATE(), NULL, NULL, TRUE, 1, 'xyzzy6' )
;
