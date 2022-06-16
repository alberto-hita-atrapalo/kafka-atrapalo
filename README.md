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
* node: nodejs enabled application
* graylog2: GrayLog2 application
* elasticsearch: GrayLog2 final storage
* mongo: GrayLog2 base persistence.

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
    root@dadada:/var/www# bin/console enqueue:produce --topic transport -vvv "hello world"

or 

    root@dadada:/var/www# bin/console k:s 10

## NodeJS
In the `nodeapp` folder there is a node application which is able to connect to kafka and send messages to graylog2.

    docker-compose run --rm node bash
    # node app.js

It sends one testing message and connects to kafka to retrieve messages and send them to graylog2.


The last command sends 10 messages using a developed symfony console command.

## Apache access logs and Syslog
The _php_ container has included the _syslog-ng_ binaries, and it is configured to read from
apache access log and syslog as well and send each entry to kafka.
> **TIP**: First of all: restart syslog to read the configuration.

    # service syslog-ng restart

> **TIP**: To test Apache's access log, please access [this](http://localhost:8090/) url. Apache is located at the _8090_ port.

> **TIP**: To test syslog, enter into the _php_ container command line and execute the following command:

    # logger -t <application_name> <message>

## Important configuration
There are several files that are important in order to configure the system properly:
* *docker/php/Dockerfile* Configures php container enabling kafka
* *docker/php/apache/sites-available/000-default.conf* Apache's default website configuration file
* *docker/php/syslog-ng/conf.d/kafka.conf* Syslog-ng kafka configuration (for Apache and syslog) 
* *docker/node/Dockerfile* Configures node container
* *docker-compose.yaml* configures containers
* *symapp/config/enqueue.yaml* configures the rdkafka library
* *symapp/config/messenger.yaml* configures the queues and routing for the messages.
* *.env* environment DSN configurations.


