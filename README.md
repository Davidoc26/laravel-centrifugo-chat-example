## Installation

1. Use .env.example to create .env
2. Configure .env and database:
```
CENTRIFUGO_SECRET=token_hmac_secret_key-from-centrifugo-config
CENTRIFUGO_APIKEY=api_key-from-centrifugo-config
CENTRIFUGO_URL=http://localhost:6060 // frontend is configured for this port
```
3. Install [centrifugo server](https://centrifugal.github.io/centrifugo/server/install/)
4. Configure centrifugo server:
    1. create config file
    2. add the following to config file:
    ```json
    "allowed_origins": [
        "http://127.0.0.1:8000",
        "http://localhost:8000"
     ],
    "admin": true, // optional
    "port": "6060",
    "namespaces": [
        {
            "name": "dialogs",
            "anonymous": false
        }
    ]
    ```


5. Install node modules (npm i) and build resources (npm run dev)
6. Run migrations (php artisan migrate)
7. Create users (seeder will be added later)
8. Run centrifugo server using config (./centrifugo --config=config.json)
9. Run php server (php artisan serve or what you want)
10. Enjoy
