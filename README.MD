Вообще это должна быть реализация тестовой задачи. От избытка свободного времени я немного увлекся и получился целый микро-фреймворк ¯\_(ツ)_/¯ 

Здесь умышленно не использовались фреймворки и только самый минимум либ. Больше велосипедов богу велосипедов!

Задача звучит так:
>Сервис принимает GET запросы вида /?id=asd123&subid=qwe234 и ничего не отдает.
Запросы фиксируются в базе MongoDB (id, subid, datetime/timestamp).
>
>id и subid задаются на лету пользователем. subid может отсутствовать.
>
>В разделе статистики по запросу вида /stat.php?id=asd123 можно получить суммарную статистику по этому id с разбивкой по subid и с возможностью дополнительной разбивки по дням.

Роуты были немного изменены и теперь больше соответствуют REST:

Для размещения записи
>PUT /stats?id=asd123&subid=qwe234

И для получения статистики:
>GET /stats?id=asd123&by_days=1

Где `by_days` необязательный параметр, который добавляет разбивку по дням.

Роуты прописываются в `index.php`

Постараюсь допиливать по мере наличия времени и желания, просто just for fun. Цель: попытка написать свой "правильный" фреймворк с максимальным приближением к идеальному за счет применения всевозможных ООП, SOLID, PSR и прочие. 

TODO: 
* Сделать реализацию Request и Response в разумных пределах соответствующие PSR. Реализовать нормальную валидацию в контроллере
* Обработки ошибок и логирование
* Запилить какой-нибудь шаблонизатор (свой)
* Вынести роуты в более подходящее место
* Сделать свою реализацию чтения конфига .env
