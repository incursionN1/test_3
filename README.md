Краткое руководство

1) Склонируйте приложение git clone https://github.com/incursionN1/test_3/tree/main

2) перейди в ресурсы  cd test_3/src

3) выполните команду composer install

4) Создайте копию .env.example.Отредактируйте .env, указав свои настройки

DB_CONNECTION=mysql
DB_HOST=db  
DB_PORT=3306  
DB_DATABASE=laravel  
DB_USERNAME=root  
DB_PASSWORD=rootpassword

SESSION_DRIVER=file

Эти данные для подключения к базе данных взяты из файла docker-compose.yml.

6) вернитесь в папку с проектом cd ../

7) запустите контейнеры docker-compose up -d

8) Для запускаа миграции используйте команду docker-compose exec app php artisan migrate

9) Для заполнения тестовыми данным используйте docker-compose exec app php artisan db:seed

10) docker-compose exec app php artisan key:generate
URL:  

базовый URL : http://localhost/

phpMyAdmin: http://localhost:8080/

API  

Склады  

Получить список складов

Метод: GET

Endpoint: /api/warehouses

Ответ:

[
  {
    "id": 1,
    "name": "hic"
  },
  {
    "id": 2,
    "name": "doloremque"
  }

]

Остатки  

Получить информацию о остатках

Метод: GET

Endpoint: /api/stocks

Ответ

[
  {
    "id": 1,
    "warehouse_name": "libero",
    "product_name": "adipisci",
    "stock": 860
  },
  {
    "id": 2,
    "warehouse_name": "id",
    "product_name": "voluptas",
    "stock": 883
  }

]

История изменений  

Возвращает историю изменений в таблице stocks.

Метод: GET

Endpoint: /api/stock_history

Параметры (опционально):

product_id - ID товара

warehouse_id - ID склада

date_from - начальная дата периода

date_to - конечная дата периода
per_page - количество записей на одной странице
page - номер страницы

Ответ

{
  "current_page": 1,
  "data": [
    {
      "id": 144,
      "created_at": "2025-05-05T09:04:30.000000Z",
      "actions": "UPDATE",
      "old_stock": 100,
      "new_stock": 110,
      "warehouse_id": 2,
      "stocks_id": 33,
      "product_id": 3,
      "warehouse": {
        "id": 2,
        "name": "doloremque"
      },
      "stock": {
        "id": 33,
        "warehouse_id": 2,
        "product_id": 3,
        "stock": 110
      }
    }
  ],
  "first_page_url": "http://localhost/api/stock_history?page=1",
  "from": 1,
  "last_page": 135,
  "last_page_url": "http://localhost/api/stock_history?page=135",
  "links": [
    {
      "url": null,
      "label": "« Previous",
      "active": false
    },
    {
      "url": "http://localhost/api/stock_history?page=1",
      "label": "1",
      "active": true
    },
    {
      "url": "http://localhost/api/stock_history?page=2",
      "label": "2",
      "active": false
    },
    {
      "url": "http://localhost/api/stock_history?page=3",
      "label": "3",
      "active": false
    },
    {
      "url": "http://localhost/api/stock_history?page=4",
      "label": "4",
      "active": false
    },
    {
      "url": "http://localhost/api/stock_history?page=5",
      "label": "5",
      "active": false
    },
    {
      "url": "http://localhost/api/stock_history?page=6",
      "label": "6",
      "active": false
    },
    {
      "url": "http://localhost/api/stock_history?page=7",
      "label": "7",
      "active": false
    },
    {
      "url": "http://localhost/api/stock_history?page=8",
      "label": "8",
      "active": false
    },
    {
      "url": "http://localhost/api/stock_history?page=9",
      "label": "9",
      "active": false
    },
    {
      "url": "http://localhost/api/stock_history?page=10",
      "label": "10",
      "active": false
    },
    {
      "url": null,
      "label": "...",
      "active": false
    },
    {
      "url": "http://localhost/api/stock_history?page=134",
      "label": "134",
      "active": false
    },
    {
      "url": "http://localhost/api/stock_history?page=135",
      "label": "135",
      "active": false
    },
    {
      "url": "http://localhost/api/stock_history?page=2",
      "label": "Next »",
      "active": false
    }
  ],
  "next_page_url": "http://localhost/api/stock_history?page=2",
  "path": "http://localhost/api/stock_history",
  "per_page": 1,
  "prev_page_url": null,
  "to": 1,
  "total": 135
}

Заказы  

Получить:
  - Метод: GET  
  - Endpoint: /api/orders  

Ответ

{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "created_at": "2025-05-05 08:08:41",
      "completed_at": null,
      "warehouse_id": 4,
      "customer": "Ms. Elnora Harris",
      "status": "canceled"
    }

}

Создать:
  - Метод: POST  
  - Endpoint: /api/orders  
  - Параметры запроса:  

{
       "customer_name": "Иван Иванов",
       "warehouse_id": "13",
       "items": [
           {
               "product_id": 1,
               "count": 2
           },
           {
               "product_id": 3,
               "count": 1
           }
       ]
   }

Обновить:
  - Метод: PATCH  
  - Endpoint:   
  - Параметры URL:  — ID заказа  
  - Параметры запроса: 

{
       "customer_name": "Иван Иванов",
       "warehouse_id": "13",
       "items": [
           {
               "product_id": 1,
               "count": 2
           },
           {
               "product_id": 3,
               "count": 1
           }
       ]
   }

Завершить
  - Метод: PATCH  
  - Endpoints: /api/{order}/complete 
  - Параметры URL:  — ID заказа

Отменить
  - Метод: PATCH  
  - Endpoints: /api/{order}/cancel
  - Параметры URL:  — ID заказа

Возобновить
  - Метод: PATCH  
  - Endpoints: /api/{order}/resume
  - Параметры URL:  — ID заказа
