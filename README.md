# Apple Store — оқу жобасы

PHP 8.2+, MySQL, PDO және PHP Sessions арқылы жасалған көп бетті демонстрациялық дүкен. Apple Inc.-тің ресми дүкені емес.

## Файл құрылымы

```text
apple-store/
├── index.php
├── products.php
├── product.php
├── login.php
├── register.php
├── profile.php
├── logout.php
├── cart.php
├── about.php
├── contact.php
├── config/database.php
├── includes/{header.php,footer.php,functions.php,auth.php}
├── assets/css/style.css
├── assets/js/script.js
├── database.sql
└── README.md
```

## Іске қосу

### MySQL-сыз уақытша іске қосу

Егер MySQL қызметі қосылмаған болса, жоба автоматты түрде SQLite-ке ауысады. PHP-де `pdo_sqlite` қосулы болуы керек. Өнімдер алғаш ашылғанда автоматты түрде енгізіледі; тіркелген аккаунттар мен хабарламалар сол компьютердегі SQLite файлына сақталады. macOS/Linux жүйесінде әдепкі жол: `~/.local/share/apple-store/apple-store.sqlite`; Windows-та `%APPDATA%/apple-store/apple-store.sqlite`. MySQL-ге кейін қайта қосылғанда деректер автоматты көшірілмейді: SQLite-та жасалған уақытша аккаунттар сол SQLite файлын пайдалануды жалғастырады (`DB_DRIVER=sqlite`), ал MySQL-ге өтсеңіз, MySQL ішінде бөлек тіркелу қажет.

Әдепкіде сайт MySQL-ді алдымен тексереді де, ол қолжетімсіз болғанда SQLite fallback қолданады. Тек SQLite пайдаланғыңыз келсе, серверді іске қосар алдында `DB_DRIVER=sqlite` орнатыңыз. Fallback-ты өшіру үшін `DB_FALLBACK_SQLITE=0` мәнін беріңіз.

### XAMPP (macOS / Windows) немесе OpenServer

1. PHP 8.2+ пен MySQL қызметін орнатыңыз және іске қосыңыз. PHP үшін `pdo_mysql` кеңейтімі қосулы болсын.
2. Осы жобаны веб-сервер түбіріне көшіріңіз: XAMPP-та `htdocs/apple-store`, OpenServer-де `domains/apple-store`.
3. phpMyAdmin арқылы `database.sql` файлын импорттаңыз. Файл `apple_store` базасын және кестелерді жасап, 10 өнімді енгізеді.
4. `config/database.php` әдепкіде `127.0.0.1`, `apple_store`, `root`, бос құпиясөз параметрлерін қолданады. Ортаңызда басқа мәндер болса, `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS` орта айнымалыларын баптаңыз.
5. Apache және MySQL іске қосылғаннан кейін браузерде `http://localhost/apple-store/` (немесе OpenServer доменін) ашыңыз.
6. «Тіркелу» арқылы пайдаланушы жасаңыз; содан кейін кіру, кабинет, шығу, каталог, себет және байланыс формасын тексеріңіз.

### PHP кіріктірілген сервері

MySQL не SQLite режимінде жоба түбірінде:

```sh
php -v
php -m | grep -i pdo_mysql
DB_DRIVER=sqlite php -S 127.0.0.1:8000
```

PowerShell-де `$env:DB_DRIVER='sqlite'` деп орнатып, `php -S 127.0.0.1:8000` іске қосыңыз. MySQL-ді қолдану үшін `DB_DRIVER` мәнін көрсетпеңіз немесе `mysql` деп қойыңыз, ал `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS` мәндерін орнатыңыз. SQLite режиміне `database.sql` импорттау қажет емес. Содан кейін `http://127.0.0.1:8000/` ашыңыз.

## Қауіпсіздік және шектеулер

- Құпиясөздер `password_hash()` арқылы сақталып, `password_verify()` арқылы тексеріледі.
- SQL сұраныстары PDO prepared statements қолданады; формадағы POST сұраулар CSRF токенімен қорғалған.
- HTML мәндері шығарылғанда `htmlspecialchars()` пайдаланылады. Авторизациядан кейін сессия ID жаңартылады.
- Себет ағымдағы браузер сессиясында сақталады. Төлем және нақты тапсырыс рәсімдеу жоқ; бағалар демонстрациялық.
- Суреттер жоба ішіне жүктелмейді: өнім жазбаларындағы `image` бағаны Apple және Unsplash сыртқы тікелей URL-дарын сақтайды. URL істемесе, интерфейс белгіше placeholder-ын көрсетеді.
- Дерекқор құпияларын репозиторийге қоспаңыз. Жергілікті құпиясөзді `config/database.php` ішіне жазудың орнына орта айнымалысын қолданыңыз.
# -Apple----
