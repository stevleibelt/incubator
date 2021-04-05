# Message Broker

This repository is comparing different message brokers and libraries for the following requirements.

# Requirements

* disaster save (no single point of failure)
* multiple creator and multiple consumer
* creator can push a bunch/chunk of messages
* consumer can pull a bunch/chunk of messages
* ack on both sides if a message was processed
* nothing gets lost when there is a blackout (resilience functionality)
* transparent (see what is inside a queue)
* fetch the size of a queue
* usable with grafana
* easy to use
* fast, fucking fast
* load balanced

# List of Criteria

* Durability - messages in the memory, written to disk or published in a cluster?
* Security policies - who is allowed to read or write what?
* message purging policies - does a queue or message have a time to live?
* message filtering - filter by dedicated messages
* delivery policies - guaranteed that the message is delivered at least once (and acknowledge)?
* routing policies - (only in systems with multiple queue servers) who is getting what messages?
* batching policies - deliver one message asap or wait a bit to deliver a bunch of messages?
* queuing criteria - (only in systems with multiple queue servers) when is a message queued?
* receipt notification - inform the publisher when a subscriber got the message?

# Terms

* Broker/Queue Manager - The one who is receiving the message from the provider and sends it to the consumer
* Message queues - asynchronous communication protocol (typically to one consumer)
* [Publish/Subscriber-Pattern](https://en.wikipedia.org/wiki/Publish%E2%80%93subscribe_pattern) - separate copy of each message is delivered to each subscriber ([pub/sub via redis](https://redis.io/topics/pubsub))
* Fan out - single queue is pushing to all subscribers
* Multicast - pushing messages out without taking care of if one, multiple or non listener is listening

# Link

* [Message queue definition on wikipedia.org](https://en.wikipedia.org/wiki/Message_queue)
