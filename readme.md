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

## About this example

This example models the registration process using event sourcing. It shows
how EventSauce can be bound to the framework. It shows how to combine sync
and async message consumers. It shows how consumers can connect to not
eventsourced parts of the application.