# PHP Challenge
This project uses Laravel for a PHP Challenge of creating an API to request stock quotes from Stooq.com, record the history of requests by user and send an email notification when a stock is requested.

### How Run the Project
To run the project, run in the terminal `sail up` to boot up the docker container. Then, run `sail artisan migrate` to create the database tables.

### Logs
To see what is being logged, run `sail artisan pail`

### Notification Queue
To run the queue, run `sail artisan queue:listen`

### Available Routes
```
POST localhost/api/user
{
  "name": "test",
  "email": "test@test.com",
  "password": "test12345"
}

GET localhost/api/stock?q=aapl.us
GET localhost/api/notification
GET localhost/api/user/history
GET localhost/api/user
```

### How to make requests
- create a user at POST /user
```
curl  -X POST \
  'localhost/api/users' \
  --header 'Accept: application/json' \
  --header 'Content-Type: application/json' \
  --data-raw '{
    "name": "test",
    "email": "test@test.com",
    "password": "test12345"
  }'
```
- get the token received at the user creation response
```
{
  "data": {
    "id": 10,
    "name": "test",
    "email": "test@test.com",
    "email_verified_at": null,
    "token": "{{token}}"
  }
}
```
- to request a quote, use the token as follows
```
curl  -X GET \
  'localhost/api/stock?q={{stock}}' \
  --header 'Accept: application/json' \
  --header 'Authorization: Bearer {{token}}'
```
- to check the user's history run
```
curl  -X GET \
  'localhost/api/user/history' \
  --header 'Accept: application/json' \
  --header 'Authorization: Bearer {{token}}'
```