insert into books values
(1, 'test title 1', 'author1', '1', '0'),
(2, 'test title 2', 'author2', '2', '0'),
(3, 'test title 3', 'author3', '3', '0'),
(4, 'test title 4', 'author4', '1', '1'),
(5, 'test title 5', 'author5', '2', '1'),
(6, 'test title 6', 'author6', '3', '1');

insert into code_types values
(1, 1, '歴史'),
(1, 2, '文学'),
(1, 3, '小説'),
(2, 0, '利用可'),
(2, 9, '利用不可'),
(3, 1, '男'),
(3, 2, '女'),
(4, 1, '1年'),
(4, 2, '2年'),
(4, 3, '3年');

insert into users(user_number, user_name, sex_type, school_year, use_type, password, user_type) values
(1, 'user1', '1', '1', '0', 'pass1', '0'),
(2, 'user2', '2', '2', '0', 'pass2', '0'),
(3, 'user3', '1', '3', '0', 'pass3', '0'),
(4, 'user4', '2', '1', '0', 'pass4', '1'),
(5, 'user5', '1', '2', '9', 'pass5', '0');

insert into reception_list(reception_number, book_number, lending_user_number, lending_date, return_date) values
(1, 1, 1, '2022-08-01', '2022-08-31'),
(2, 1, 2, '2022-09-01', '2022-09-12'),
(3, 1, 3, '2022-09-24', '2022-10-18'),
(4, 2, 4, '2022-10-03', '2022-10-05'),
(5, 2, 5, '2022-10-03', '2022-10-05');
