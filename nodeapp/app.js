const { Kafka } = require('kafkajs')

const kafka = new Kafka({
    clientId: 'node-atrapalo-app',
    brokers: ['kafka:9092','kafka2:9092']
})

const producer = kafka.producer()
const consumer = kafka.consumer({ groupId: 'test-group' })

var graylog2 = require("graylog2");
var logger = new graylog2.graylog({
    servers: [
        { 'host': 'graylog', port: 12202 }
    ],
    hostname: 'server.name', // the name of this host
                             // (optional, default: os.hostname())
    facility: 'Node.js',     // the facility for these log messages
                             // (optional, default: "Node.js")
    bufferSize: 1350         // max UDP packet size, should never exceed the
                             // MTU of your system (optional, default: 1400)
});

const run = async () => {
    //Producing
    await producer.connect()
    await producer.send({
        topic: 'transport',
        messages: [
            { value: 'Hello KafkaJS user!' },
        ],
    })

    // Consuming
    await consumer.connect()
    await consumer.subscribe({ topic: 'transport', fromBeginning: true })

    await consumer.run({
        eachMessage: async ({ topic, partition, message }) => {
            console.log({
                partition,
                offset: message.offset,
                value: message.value.toString(),
            })
            logger.log(message.value.toString())
        },
    })


}

run().catch(console.error)
