CREATE DATABASE if not exists library_test;

use library_test;

CREATE TABLE books
(   book_number            INT          NOT NULL COMMENT '書籍番号'
,   book_name              VARCHAR(100) NULL     COMMENT 'タイトル'
,   author                 VARCHAR(10)  NULL     COMMENT '著者'
,   category               VARCHAR(2)   NULL     COMMENT 'カテゴリ'
,   lending_type           VARCHAR(1)   NOT NULL COMMENT '貸出し可否フラグ'
,    PRIMARY KEY (book_number)
) COMMENT='書籍マスタ' ;

CREATE TABLE users
(   user_number            INT          NOT NULL COMMENT '利用者番号'
,   user_name              VARCHAR(30)  NULL     COMMENT '氏名'
,   sex_type               VARCHAR(1)   NULL     COMMENT '性別'
,   school_year            VARCHAR(1)   NULL     COMMENT '学年'
,   use_type               VARCHAR(2)   NULL     COMMENT '利用可否フラグ'
,   password               VARCHAR(30)  NULL     COMMENT 'パスワード'
,   user_type              VARCHAR(2)   NOT NULL COMMENT '区分'
,   PRIMARY KEY (user_number)
) COMMENT='利用者マスタ' ;

CREATE TABLE reception_list
(   reception_number       INT          NOT NULL COMMENT '窓口管理番号'
,   book_number            INT          NULL     COMMENT '書籍番号'
,   lending_user_number    INT          NULL     COMMENT '利用者番号'
,   lending_date           DATE         NULL     COMMENT '貸出日'
,   return_date            DATE         NULL     COMMENT '返却日'
,   PRIMARY KEY (reception_number)
) COMMENT='窓口' ;

CREATE TABLE code_types
(   code_type              INT          NOT NULL COMMENT '区分'
,   code                   INT          NOT NULL COMMENT 'コード'
,   code_name              VARCHAR(100) NULL     COMMENT '名称'
,   PRIMARY KEY (code_type,code)
) COMMENT='コード区分マスタ' ;
