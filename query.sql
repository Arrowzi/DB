select title, raiting, price, fname, sname
from book
         join author a on a.sname like 'Pupkin';

select *
from book
where raiting = '18+';

select b.title as title, group_concat(g.title) as genre
from book_genre
         join book b on b.id_book = book_genre.book_id
         join genre g on g.id_genre = book_genre.genre_id
where b.title like 'Good work Oleg'
group by b.title;

select b.title, ob.amount, b.price
from book b
         join order_book ob on ob.book_id = b.id_book
         join orders o on o.id_orders = ob.order_id
where o.id_client = (select client_id from client where sname like 'Borisov');

select b.title,b.raiting,b.b_state,b.price,a.sname,a.fname,group_concat(g.title) as genre
from book b
        join author a on a.id = b.author_id
        join book_genre bg on b.id_book = bg.book_id
        join genre g on g.id_genre = bg.genre_id
where  b.title like 'Good work Oleg'
group by b.title, b.raiting, b.b_state, b.price, a.sname, a.fname;


SELECT * FROM orders join client c on c.id = orders.id_client;

select sum(b.price) from  order_book join book b on b.id = order_book.book_id where order_id = 3;