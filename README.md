# Kafka as Intermediate Logs Buffer
This project aims to be the start point for any project that involves Kafka + PHP.

## Main Goal
To have a basic Symfony project connected with Kafka (local) in order to have an
example and a running configuration to build connected applications.

## Installation
> **TIP**: You have to have installed _docker_ and _make_ locally.

    $ make up

> **TIP**: See more commands available in the Makefile

## Docker Configuration
There are configured 6 containers:
* zookeeper: manages kafka brokers 
* kafka1: broker1
* kafka2: broker2
* kafdrop: GUI for kafka topics
* redis: Failover transport database
* php: symfony enabled application

> **TIP**: See docker-compose.yml file.

_Dockerfile_ has configuration about building PHP docker container. 
It installs librdkafka library and extension, redis extension and xdebug extension.

### Scale Kafka Container
There is a dependency between the volumes associated with the kafka containers so there is no possible
to scale them using _docker-compose_ scale function. The solution has been built using
multiple kafka containers.

## Sending messages
In order to send a message and verify it in the kafdrop application you have to
perform the following commands:

    $ make shell
    root@dadada:/var/www# symapp/bin/console enqueue:produce --topic transport -vvv "hello world"

or 

    root@dadada:/var/www# symapp/bin/console k:s 10

The last command sends 10 messages using a developed symfony console command.

## Important configuration
There are several files that are important in order to configure the system properly:
* Dockerfile: Configures php container enabling kafka
* docker-compose.yaml: configures containers
* symapp/config/enqueue.yaml: configures the rdkafka library
* symapp/config/messenger.yaml: configures the queues and routing for the messages.
* .env: environment DSN configurations.
