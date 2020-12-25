insert author(fname,sname,dob) values ('Vasilii','Pupkin','2020-12-1');
insert book(title,public_date,raiting,b_state,amount,price,author_id) values ('Good work Oleg','2020-12-1', '18+', 'available', 10, '', 1000, 1);
insert genre(title) values ('Детективы'),('Трилер'),('Комедия'),('Драма'),('Роман'),('Научная литература'),('Боевик'),('Приключение'),('Фэнтези'),('Мистика'),('Научная фантастика'),('Киберпанк'),('Ужасы'),('ЛитРПГ');
insert book_genre(book_id,genre_id) values(1,3);
insert book_genre(book_id,genre_id) values(1,4);
insert client(fname,sname,phone_number,email,c_address) values('Nikita','Borisov','88005553535','ol_dm@gmail.com','Pushkin st. 80/2');
insert orders(create_date,id_client) values ('2020-08-13',1);
insert order_book(book_id,order_id,amount) values (1,1,2);

UPDATE author SET fname=:new_author_fname, sname=:new_author_sname WHERE id=:id_author_selector;




