## Laravel Example Project for EventSauce

To setup the project.

```bash
$ docker-compose -f ./docker-compose.yaml up -d
$ sleep 4 # or just wait a little for the containers to boot
php artisan migrate
```

Now start the server:

```bash
php artisan serve
```

and navigate to http://127.0.0.1:8000, and click on the registration link